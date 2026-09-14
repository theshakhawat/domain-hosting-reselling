<?php

namespace App\Http\Controllers;

use App\Models\DomainPricing;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\HostingPlan;
use App\Models\PlanCategory;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the dynamic homepage with clean, optimized Eloquent queries.
     */
    public function index(): View
    {
        $categories = PlanCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        if ($categories->isEmpty()) {
            $categories = collect([
                (object) ['name' => 'Shared NVMe', 'slug' => 'shared', 'badge' => 'Recommended'],
                (object) ['name' => 'Cloud Hosting', 'slug' => 'cloud', 'badge' => 'High Traffic'],
                (object) ['name' => 'NVMe VPS', 'slug' => 'vps', 'badge' => 'Root Access'],
                (object) ['name' => 'BDIX Connected', 'slug' => 'bdix', 'badge' => '8ms Latency'],
            ]);
        }

        $plans = HostingPlan::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        $domains = DomainPricing::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $features = Feature::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $faqs = Faq::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        return view('homepage', compact(
            'plans',
            'categories',
            'domains',
            'features',
            'testimonials',
            'faqs',
            'settings'
        ));
    }
}
