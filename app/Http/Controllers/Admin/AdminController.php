<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DomainPricing;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\HostingPlan;
use App\Models\SiteSetting;
use App\Models\Testimonial;
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
        ];

        $recentPlans = HostingPlan::orderBy('updated_at', 'desc')->take(5)->get();
        $promoCode = SiteSetting::get('promo_code', 'WELCOME20');
        $promoDiscount = SiteSetting::get('promo_discount', '20% OFF');
        $bundlePrice = SiteSetting::get('bundle_price', '৳3,999');

        return view('admin.dashboard', compact('stats', 'recentPlans', 'promoCode', 'promoDiscount', 'bundlePrice'));
    }
}
