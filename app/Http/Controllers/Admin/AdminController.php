<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DomainPricing;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\HostingPlan;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display admin overview dashboard.
     */
    public function dashboard(): View
    {
        $stats = [
            'total_plans' => HostingPlan::count(),
            'active_plans' => HostingPlan::where('is_active', true)->count(),
            'total_domains' => DomainPricing::count(),
            'total_features' => Feature::count(),
            'total_testimonials' => Testimonial::count(),
            'total_faqs' => Faq::count(),
            'total_pageviews' => Visitor::sum('hits') ?: 0,
            'unique_visitors' => Visitor::distinct('ip_address')->count('ip_address') ?: 0,
            'today_visits' => Visitor::whereDate('last_activity_at', Carbon::today())->sum('hits') ?: 0,
        ];

        // 7-day Traffic Trend for Graph
        $dates = collect();
        $trendData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dates->push($date->format('M d'));
            $hits = Visitor::whereDate('last_activity_at', $date)->sum('hits') ?: 0;
            $trendData->push($hits);
        }

        // Device Breakdown
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

        // Latest Visitors
        $latestVisitors = Visitor::orderBy('last_activity_at', 'desc')->take(6)->get();

        $recentPlans = HostingPlan::orderBy('updated_at', 'desc')->take(5)->get();
        $promoCode = SiteSetting::get('promo_code', 'WELCOME20');
        $promoDiscount = SiteSetting::get('promo_discount', '20% OFF');
        $bundlePrice = SiteSetting::get('bundle_price', '৳3,999');

        return view('admin.dashboard', compact(
            'stats',
            'recentPlans',
            'promoCode',
            'promoDiscount',
            'bundlePrice',
            'dates',
            'trendData',
            'deviceLabels',
            'deviceData',
            'latestVisitors'
        ));
    }
}
