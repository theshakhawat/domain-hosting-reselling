<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\ContactMessage;
use App\Models\DomainPricing;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\HostingPlan;
use App\Models\PlanCategory;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display comprehensive admin overview dashboard.
     */
    public function dashboard(): View
    {
        // 1. Core Platform Statistics
        $stats = [
            'total_plans' => HostingPlan::count(),
            'active_plans' => HostingPlan::where('is_active', true)->count(),
            'total_categories' => PlanCategory::count(),
            'total_domains' => DomainPricing::count(),
            'lowest_domain_price' => DomainPricing::min('price') ?: 0,
            'total_features' => Feature::count(),
            'active_features' => Feature::where('is_active', true)->count(),
            'total_testimonials' => Testimonial::count(),
            'avg_rating' => round(Testimonial::avg('rating') ?: 5.0, 1),
            'total_faqs' => Faq::count(),
            'active_faqs' => Faq::where('is_active', true)->count(),
            'total_contacts' => ContactMessage::count(),
            'unread_contacts' => ContactMessage::where('status', 'new')->count(),
            'fixed_contacts' => ContactMessage::where('status', 'fixed')->count(),
            'total_notifications' => AdminNotification::count(),
            'unread_notifications' => AdminNotification::where('is_read', false)->count(),
            'total_pageviews' => Visitor::sum('hits') ?: 0,
            'unique_visitors' => Visitor::distinct('ip_address')->count('ip_address') ?: 0,
            'today_visits' => Visitor::whereDate('last_activity_at', Carbon::today())->sum('hits') ?: 0,
        ];

        // 2. Recent Support Messages / Inquiries
        $recentContacts = ContactMessage::orderBy('created_at', 'desc')->take(6)->get();

        // 3. Recent Admin Notifications
        $recentNotifications = AdminNotification::orderBy('created_at', 'desc')->take(5)->get();

        // 4. Hosting Plans & Categories Snapshot
        $recentPlans = HostingPlan::orderBy('updated_at', 'desc')->take(5)->get();
        $planCategories = PlanCategory::withCount('plans')->orderBy('sort_order')->take(4)->get();

        // 5. Domain TLDs Snapshot
        $recentDomains = DomainPricing::orderBy('is_popular', 'desc')->orderBy('price', 'asc')->take(5)->get();

        // 6. Latest Testimonials
        $latestTestimonials = Testimonial::orderBy('created_at', 'desc')->take(2)->get();

        // 7. 7-Day Traffic Trend for Graph
        $dates = collect();
        $trendData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dates->push($date->format('M d'));
            $hits = Visitor::whereDate('last_activity_at', $date)->sum('hits') ?: 0;
            $trendData->push($hits);
        }

        // 8. Device Breakdown
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

        // 9. Latest Real-Time Visitors
        $latestVisitors = Visitor::orderBy('last_activity_at', 'desc')->take(5)->get();

        // 10. Promotional & System Settings
        $promoCode = SiteSetting::get('promo_code', 'WELCOME20');
        $promoDiscount = SiteSetting::get('promo_discount', '20% OFF');
        $bundlePrice = SiteSetting::get('bundle_price', '৳3,999');

        // 11. System Environment Snapshot
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_ip' => request()->server('SERVER_ADDR', '127.0.0.1'),
            'db_driver' => config('database.default'),
            'uptime' => '99.99%',
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recentContacts',
            'recentNotifications',
            'recentPlans',
            'planCategories',
            'recentDomains',
            'latestTestimonials',
            'promoCode',
            'promoDiscount',
            'bundlePrice',
            'dates',
            'trendData',
            'deviceLabels',
            'deviceData',
            'latestVisitors',
            'systemInfo'
        ));
    }
}
