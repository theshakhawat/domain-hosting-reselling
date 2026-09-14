<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VisitorController extends Controller
{
    //
    /**
     * Display the visitor analytics and real-time activity log.
     */
    public function index(Request $request): View
    {
        $query = Visitor::query();

        // Optional filtering
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('visited_route', 'like', "%{$search}%")
                    ->orWhere('isp', 'like', "%{$search}%")
                    ->orWhere('browser', 'like', "%{$search}%");
            });
        }

        if ($device = $request->input('device')) {
            $query->where('device_type', $device);
        }

        $visitors = $query->orderBy('last_activity_at', 'desc')->paginate(20)->withQueryString();

        // Overview metrics
        $totalPageviews = Visitor::sum('hits');
        $uniqueVisitors = Visitor::distinct('ip_address')->count('ip_address');
        $totalSessions = Visitor::count();
        $todayVisits = Visitor::whereDate('last_activity_at', Carbon::today())->sum('hits');

        $mobileCount = Visitor::where('device_type', 'Mobile')->count();
        $mobileShare = $totalSessions > 0 ? round(($mobileCount / $totalSessions) * 100, 1) : 0;

        // Chart 1: 7-day Traffic Trend
        $dates = collect();
        $trendData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dates->push($date->format('M d'));
            $hits = Visitor::whereDate('last_activity_at', $date)->sum('hits');
            $trendData->push($hits);
        }

        // Chart 2: Device Breakdown
        $devices = Visitor::select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->pluck('count', 'device_type')
            ->toArray();

        $deviceLabels = ['Desktop', 'Mobile', 'Tablet'];
        $deviceData = [
            $devices['Desktop'] ?? 0,
            $devices['Mobile'] ?? 0,
            $devices['Tablet'] ?? 0,
        ];

        // Chart 3: Top Countries
        $topCountries = Visitor::select('country', DB::raw('count(*) as total'))
            ->groupBy('country')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Chart 4: Top Visited Routes
        $topRoutes = Visitor::select('visited_route', DB::raw('sum(hits) as total_hits'))
            ->groupBy('visited_route')
            ->orderByDesc('total_hits')
            ->limit(5)
            ->get();

        return view('admin.visitors.index', compact(
            'visitors',
            'totalPageviews',
            'uniqueVisitors',
            'todayVisits',
            'mobileShare',
            'dates',
            'trendData',
            'deviceLabels',
            'deviceData',
            'topCountries',
            'topRoutes'
        ));
    }

    /**
     * Endpoint for client-side beacon to record screen resolution and viewport details.
     */
    public function beacon(Request $request): JsonResponse
    {
        $ip = $request->ip() ?? '127.0.0.1';
        $resolution = $request->input('screen_resolution');

        if ($resolution && is_string($resolution) && strlen($resolution) < 30) {
            $visitor = Visitor::where('ip_address', $ip)
                ->where('last_activity_at', '>=', now()->subMinutes(15))
                ->latest('id')
                ->first();

            if ($visitor) {
                $visitor->update(['screen_resolution' => $resolution]);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Delete a single visitor record.
     */
    public function destroy(Visitor $visitor): RedirectResponse
    {
        $ip = $visitor->ip_address;
        $visitor->delete();

        return redirect()->back()->with('success', "Visitor record for IP '{$ip}' deleted successfully.");
    }

    /**
     * Clear all visitor tracking records.
     */
    public function clearAll(): RedirectResponse
    {
        Visitor::truncate();

        return redirect()->back()->with('success', 'All visitor traffic logs and analytics history have been cleared.');
    }
}
