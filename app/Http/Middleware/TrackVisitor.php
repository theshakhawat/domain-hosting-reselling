<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     * Handle an incoming request and track visitor details.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip non-GET requests or asset/api routes from bloating logs
        if (! $request->isMethod('GET')) {
            return $response;
        }

        $path = $request->path();
        if (
            $request->is('api/*') ||
            $request->is('_debugbar*') ||
            $request->is('up') ||
            str_contains($path, '.') // static files
        ) {
            return $response;
        }

        try {
            $this->track($request);
        } catch (\Throwable $e) {
            // Silently catch tracking errors so visitor experience is never broken
        }

        return $response;
    }

    /**
     * Parse and record the visitor information.
     */
    protected function track(Request $request): void
    {
        $ip = $request->ip() ?? '127.0.0.1';
        $userAgent = $request->userAgent() ?? '';
        $route = '/'.ltrim($request->path(), '/');

        [$deviceType, $os, $browser] = $this->parseUserAgent($userAgent);
        [$country, $countryCode, $city, $isp] = $this->resolveLocationAndIsp($ip, $request);

        $sessionId = $request->hasSession() ? $request->session()->getId() : null;

        // Group visits by IP and route in the last 15 minutes to keep DB clean and fast
        $recentVisitor = Visitor::where('ip_address', $ip)
            ->where('visited_route', $route)
            ->where('last_activity_at', '>=', now()->subMinutes(15))
            ->latest('id')
            ->first();

        if ($recentVisitor) {
            $recentVisitor->increment('hits');
            $recentVisitor->update([
                'last_activity_at' => now(),
                'referrer' => $request->header('referer') ?? $recentVisitor->referrer,
            ]);
        } else {
            Visitor::create([
                'ip_address' => $ip,
                'session_id' => $sessionId,
                'country' => $country,
                'country_code' => $countryCode,
                'city' => $city,
                'isp' => $isp,
                'device_type' => $deviceType,
                'operating_system' => $os,
                'browser' => $browser,
                'screen_resolution' => 'Unknown',
                'visited_route' => $route,
                'method' => $request->method(),
                'referrer' => $request->header('referer'),
                'hits' => 1,
                'last_activity_at' => now(),
            ]);
        }
    }

    /**
     * Parse User-Agent string to determine device type, OS, and browser.
     *
     * @return array{0: string, 1: string, 2: string}
     */
    protected function parseUserAgent(string $ua): array
    {
        $device = 'Desktop';
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            $device = 'Tablet';
        } elseif (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile|iphone|ipod)/i', $ua)) {
            $device = 'Mobile';
        }

        // Operating System
        $os = 'Unknown OS';
        if (preg_match('/windows nt 10/i', $ua)) {
            $os = 'Windows 10/11';
        } elseif (preg_match('/windows nt 6.3/i', $ua)) {
            $os = 'Windows 8.1';
        } elseif (preg_match('/windows nt 6.1/i', $ua)) {
            $os = 'Windows 7';
        } elseif (preg_match('/macintosh|mac os x/i', $ua)) {
            $os = 'macOS';
        } elseif (preg_match('/android/i', $ua)) {
            $os = 'Android';
        } elseif (preg_match('/iphone|ipad|ipod/i', $ua)) {
            $os = 'iOS';
        } elseif (preg_match('/linux/i', $ua)) {
            $os = 'Linux';
        }

        // Browser
        $browser = 'Unknown Browser';
        if (preg_match('/edg/i', $ua)) {
            $browser = 'Microsoft Edge';
        } elseif (preg_match('/chrome/i', $ua) && ! preg_match('/edg/i', $ua)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/safari/i', $ua) && ! preg_match('/chrome/i', $ua)) {
            $browser = 'Apple Safari';
        } elseif (preg_match('/firefox/i', $ua)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/opera|opr/i', $ua)) {
            $browser = 'Opera';
        }

        return [$device, $os, $browser];
    }

    /**
     * Resolve IP to Location and ISP.
     *
     * @return array{0: string, 1: string, 2: string, 3: string}
     */
    protected function resolveLocationAndIsp(string $ip, Request $request): array
    {
        // Check Cloudflare headers if present
        if ($request->hasHeader('CF-IPCountry')) {
            $countryCode = strtoupper((string) $request->header('CF-IPCountry'));
            $country = $countryCode === 'BD' ? 'Bangladesh' : $countryCode;
            $city = (string) ($request->header('CF-IPCity') ?? 'Dhaka');

            return [$country, $countryCode, $city, 'Cloudflare Routed'];
        }

        // Handle private / localhost addresses
        if ($ip === '127.0.0.1' || $ip === '::1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return ['Bangladesh', 'BD', 'Dhaka', 'Localhost Network'];
        }

        // Default fallback for external IP
        return ['Bangladesh', 'BD', 'Dhaka', 'High-Speed Broadband'];
    }
}
