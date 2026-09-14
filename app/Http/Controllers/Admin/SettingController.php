<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the site and promo settings page.
     */
    public function index(): View
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update site and promo settings in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // General & Hero
            'site_name' => ['nullable', 'string', 'max:100'],
            'hero_pill' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],
            'hero_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:5120'],
            'hero_image_url' => ['nullable', 'string', 'max:500'],
            'hero_cluster_name' => ['nullable', 'string', 'max:100'],
            'hero_stat_1_label' => ['nullable', 'string', 'max:50'],
            'hero_stat_1_value' => ['nullable', 'string', 'max:50'],
            'hero_stat_2_label' => ['nullable', 'string', 'max:50'],
            'hero_stat_2_value' => ['nullable', 'string', 'max:50'],
            'hero_stat_3_label' => ['nullable', 'string', 'max:50'],
            'hero_stat_3_value' => ['nullable', 'string', 'max:50'],
            'status_text' => ['nullable', 'string', 'max:255'],

            // Header Settings
            'header_announcement_badge' => ['nullable', 'string', 'max:50'],
            'header_announcement_text' => ['nullable', 'string', 'max:255'],
            'header_cta_text' => ['nullable', 'string', 'max:50'],
            'header_cta_link' => ['nullable', 'string', 'max:255'],
            'support_phone' => ['nullable', 'string', 'max:100'],
            'support_email' => ['nullable', 'string', 'email', 'max:150'],

            // Footer Settings
            'footer_company_desc' => ['nullable', 'string'],
            'footer_copyright' => ['nullable', 'string', 'max:255'],
            'footer_address' => ['nullable', 'string', 'max:255'],
            'footer_badge_text' => ['nullable', 'string', 'max:255'],
            'footer_facebook' => ['nullable', 'string', 'max:255'],
            'footer_twitter' => ['nullable', 'string', 'max:255'],
            'footer_linkedin' => ['nullable', 'string', 'max:255'],
            'footer_github' => ['nullable', 'string', 'max:255'],

            // Promo & Bundle
            'promo_code' => ['nullable', 'string', 'max:50'],
            'promo_title' => ['nullable', 'string', 'max:255'],
            'promo_discount' => ['nullable', 'string', 'max:50'],
            'bundle_title' => ['nullable', 'string', 'max:255'],
            'bundle_price' => ['nullable', 'string', 'max:50'],
            'bundle_savings' => ['nullable', 'string', 'max:50'],

            // Why Choose Us / Infrastructure
            'why_choose_title' => ['nullable', 'string', 'max:255'],
            'why_choose_subtitle' => ['nullable', 'string'],
            'why_choose_image' => ['nullable', 'string', 'max:500'],
            'why_choose_badge_1' => ['nullable', 'string', 'max:100'],
            'why_choose_badge_2' => ['nullable', 'string', 'max:100'],
            'why_choose_1_title' => ['nullable', 'string', 'max:150'],
            'why_choose_1_desc' => ['nullable', 'string', 'max:255'],
            'why_choose_2_title' => ['nullable', 'string', 'max:150'],
            'why_choose_2_desc' => ['nullable', 'string', 'max:255'],
            'why_choose_3_title' => ['nullable', 'string', 'max:150'],
            'why_choose_3_desc' => ['nullable', 'string', 'max:255'],
            'why_choose_4_title' => ['nullable', 'string', 'max:150'],
            'why_choose_4_desc' => ['nullable', 'string', 'max:255'],
            'why_choose_5_title' => ['nullable', 'string', 'max:150'],
            'why_choose_5_desc' => ['nullable', 'string', 'max:255'],
            'why_choose_6_title' => ['nullable', 'string', 'max:150'],
            'why_choose_6_desc' => ['nullable', 'string', 'max:255'],
        ]);

        // Handle Hero Image Upload
        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $filename = 'hero_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $dest = public_path('uploads/hero');

            if (! File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }

            $oldImg = SiteSetting::get('hero_image');
            if ($oldImg && File::exists(public_path($oldImg))) {
                File::delete(public_path($oldImg));
            }

            $file->move($dest, $filename);
            SiteSetting::set('hero_image', 'uploads/hero/'.$filename);
        } elseif ($request->input('remove_hero_image') === '1') {
            $oldImg = SiteSetting::get('hero_image');
            if ($oldImg && File::exists(public_path($oldImg))) {
                File::delete(public_path($oldImg));
            }
            SiteSetting::set('hero_image', '');
        }

        // Section toggles list
        $sectionToggles = [
            'header_announcement_enabled',
            'section_hero_enabled',
            'section_promo_bar_enabled',
            'section_domain_enabled',
            'section_plans_enabled',
            'section_features_enabled',
            'section_infrastructure_enabled',
            'section_bundle_enabled',
            'section_testimonials_enabled',
            'section_faq_enabled',
            'section_cta_enabled',
        ];

        // If section toggles are submitted in the form
        if ($request->has('has_section_toggles')) {
            foreach ($sectionToggles as $toggle) {
                SiteSetting::set($toggle, $request->has($toggle) ? '1' : '0');
            }
        }

        unset($validated['hero_image_file']);

        foreach ($validated as $key => $value) {
            SiteSetting::set($key, (string) ($value ?? ''));
        }

        Cache::forget('homepage_data');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Site settings, hero image, and configurations updated successfully.');
    }
}
