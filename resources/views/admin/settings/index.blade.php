@extends('admin.layouts.app')

@section('title', 'Site & Section Settings')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
        <i class="fa-solid fa-sliders text-brand-accent"></i>
        <span>Site Configuration & Section Manager</span>
      </h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
        Manage Header, Footer, Section Visibility, Hero Text, and Promotional Campaigns from one central place.
      </p>
    </div>
  </div>

  <!-- Settings Navigation Tabs -->
  <div class="flex items-center gap-1.5 p-1.5 bg-white dark:bg-brand-card border border-slate-200 dark:border-brand-slate/40 rounded-xl overflow-x-auto shadow-sm text-xs font-semibold">
    <button type="button" onclick="switchTab('tab-sections')" id="btn-tab-sections"
      class="tab-btn px-4 py-2 rounded-lg transition-colors flex items-center gap-2 shrink-0 bg-brand-accent text-white shadow-sm shadow-brand-accent/25">
      <i class="fa-solid fa-toggle-on text-xs"></i>
      <span>Section Visibility</span>
    </button>
    <button type="button" onclick="switchTab('tab-header')" id="btn-tab-header"
      class="tab-btn px-4 py-2 rounded-lg transition-colors flex items-center gap-2 shrink-0 text-slate-600 dark:text-slate-300 hover:text-brand-accent hover:bg-slate-50 dark:hover:bg-brand-dark/40">
      <i class="fa-solid fa-heading text-xs"></i>
      <span>Header Settings</span>
    </button>
    <button type="button" onclick="switchTab('tab-footer')" id="btn-tab-footer"
      class="tab-btn px-4 py-2 rounded-lg transition-colors flex items-center gap-2 shrink-0 text-slate-600 dark:text-slate-300 hover:text-brand-accent hover:bg-slate-50 dark:hover:bg-brand-dark/40">
      <i class="fa-solid fa-shoe-prints text-xs"></i>
      <span>Footer Settings</span>
    </button>
    <button type="button" onclick="switchTab('tab-hero')" id="btn-tab-hero"
      class="tab-btn px-4 py-2 rounded-lg transition-colors flex items-center gap-2 shrink-0 text-slate-600 dark:text-slate-300 hover:text-brand-accent hover:bg-slate-50 dark:hover:bg-brand-dark/40">
      <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
      <span>Hero & Branding</span>
    </button>
    <button type="button" onclick="switchTab('tab-whyus')" id="btn-tab-whyus"
      class="tab-btn px-4 py-2 rounded-lg transition-colors flex items-center gap-2 shrink-0 text-slate-600 dark:text-slate-300 hover:text-brand-accent hover:bg-slate-50 dark:hover:bg-brand-dark/40">
      <i class="fa-solid fa-server text-xs"></i>
      <span>Why Choose Us</span>
    </button>
    <button type="button" onclick="switchTab('tab-promo')" id="btn-tab-promo"
      class="tab-btn px-4 py-2 rounded-lg transition-colors flex items-center gap-2 shrink-0 text-slate-600 dark:text-slate-300 hover:text-brand-accent hover:bg-slate-50 dark:hover:bg-brand-dark/40">
      <i class="fa-solid fa-tag text-xs"></i>
      <span>Promo & Bundle</span>
    </button>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    <input type="hidden" name="has_section_toggles" value="1">

    <!-- ============================================================== -->
    <!-- TAB 1: SECTION VISIBILITY MANAGER -->
    <!-- ============================================================== -->
    <div id="tab-sections" class="tab-pane space-y-6">
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-6 sm:p-8">
        <div class="border-b border-slate-200 dark:border-brand-slate/40 pb-3 mb-6">
          <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-layer-group text-brand-accent"></i>
            <span>Homepage Section Visibility Controls</span>
          </h2>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            Turn any section On or Off with one click. When toggled Off, that entire section will be cleanly omitted from the homepage.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <!-- 1. Hero Section -->
          <label class="flex items-start justify-between p-4 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 hover:border-brand-accent/50 cursor-pointer transition-all">
            <div class="flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-display text-sm"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-900 dark:text-white">Hero & Headline Section</div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Main headline, intro copy, CTA buttons & trust metrics</p>
              </div>
            </div>
            <input type="checkbox" name="section_hero_enabled" value="1" {{ ($settings['section_hero_enabled'] ?? '1') === '1' ? 'checked' : '' }}
              class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60 mt-1 cursor-pointer">
          </label>

          <!-- 2. Promo Banner -->
          <label class="flex items-start justify-between p-4 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 hover:border-brand-accent/50 cursor-pointer transition-all">
            <div class="flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-bullhorn text-sm"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-900 dark:text-white">Promotional Bar & Banner</div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Voucher code banner with countdown copy</p>
              </div>
            </div>
            <input type="checkbox" name="section_promo_bar_enabled" value="1" {{ ($settings['section_promo_bar_enabled'] ?? '1') === '1' ? 'checked' : '' }}
              class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60 mt-1 cursor-pointer">
          </label>

          <!-- 3. Domain Search -->
          <label class="flex items-start justify-between p-4 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 hover:border-brand-accent/50 cursor-pointer transition-all">
            <div class="flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-900 dark:text-white">Domain Search & TLD Table</div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Domain search bar, TLD pricing badges & results simulation</p>
              </div>
            </div>
            <input type="checkbox" name="section_domain_enabled" value="1" {{ ($settings['section_domain_enabled'] ?? '1') === '1' ? 'checked' : '' }}
              class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60 mt-1 cursor-pointer">
          </label>

          <!-- 4. Hosting Plans -->
          <label class="flex items-start justify-between p-4 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 hover:border-brand-accent/50 cursor-pointer transition-all">
            <div class="flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-server text-sm"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-900 dark:text-white">Hosting Plans & Pricing</div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Dynamic hosting categories, package cards, monthly/yearly switch</p>
              </div>
            </div>
            <input type="checkbox" name="section_plans_enabled" value="1" {{ ($settings['section_plans_enabled'] ?? '1') === '1' ? 'checked' : '' }}
              class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60 mt-1 cursor-pointer">
          </label>

          <!-- 5. Core Features -->
          <label class="flex items-start justify-between p-4 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 hover:border-brand-accent/50 cursor-pointer transition-all">
            <div class="flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-bolt text-sm"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-900 dark:text-white">Core Technology & Features</div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">LiteSpeed, NVMe Gen-4, Free SSL, Anti-DDoS feature cards</p>
              </div>
            </div>
            <input type="checkbox" name="section_features_enabled" value="1" {{ ($settings['section_features_enabled'] ?? '1') === '1' ? 'checked' : '' }}
              class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60 mt-1 cursor-pointer">
          </label>

          <!-- 6. Infrastructure -->
          <label class="flex items-start justify-between p-4 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 hover:border-brand-accent/50 cursor-pointer transition-all">
            <div class="flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-network-wired text-sm"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-900 dark:text-white">Datacenters & Infrastructure</div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Low latency routing, BDIX nodes, Tier-IV facility status</p>
              </div>
            </div>
            <input type="checkbox" name="section_infrastructure_enabled" value="1" {{ ($settings['section_infrastructure_enabled'] ?? '1') === '1' ? 'checked' : '' }}
              class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60 mt-1 cursor-pointer">
          </label>

          <!-- 7. Launch Bundle Offer -->
          <label class="flex items-start justify-between p-4 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 hover:border-brand-accent/50 cursor-pointer transition-all">
            <div class="flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-pink-500/10 text-pink-600 dark:text-pink-400 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-box-open text-sm"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-900 dark:text-white">Launch Bundle Package</div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Discount package bundle box (Hosting + Domain + SSL)</p>
              </div>
            </div>
            <input type="checkbox" name="section_bundle_enabled" value="1" {{ ($settings['section_bundle_enabled'] ?? '1') === '1' ? 'checked' : '' }}
              class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60 mt-1 cursor-pointer">
          </label>

          <!-- 8. Client Reviews -->
          <label class="flex items-start justify-between p-4 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 hover:border-brand-accent/50 cursor-pointer transition-all">
            <div class="flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-quote-left text-sm"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-900 dark:text-white">Client Reviews & Testimonials</div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Verified client reviews, ratings and social proof</p>
              </div>
            </div>
            <input type="checkbox" name="section_testimonials_enabled" value="1" {{ ($settings['section_testimonials_enabled'] ?? '1') === '1' ? 'checked' : '' }}
              class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60 mt-1 cursor-pointer">
          </label>

          <!-- 9. FAQ Accordion -->
          <label class="flex items-start justify-between p-4 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 hover:border-brand-accent/50 cursor-pointer transition-all">
            <div class="flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-sky-500/10 text-sky-600 dark:text-sky-400 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-circle-question text-sm"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-900 dark:text-white">Frequently Asked Questions (FAQ)</div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Interactive accordion with answers to common queries</p>
              </div>
            </div>
            <input type="checkbox" name="section_faq_enabled" value="1" {{ ($settings['section_faq_enabled'] ?? '1') === '1' ? 'checked' : '' }}
              class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60 mt-1 cursor-pointer">
          </label>

          <!-- 10. Footer CTA Banner -->
          <label class="flex items-start justify-between p-4 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 hover:border-brand-accent/50 cursor-pointer transition-all">
            <div class="flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-rocket text-sm"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-900 dark:text-white">Footer Conversion CTA Banner</div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Full-width bottom launch banner with direct checkout</p>
              </div>
            </div>
            <input type="checkbox" name="section_cta_enabled" value="1" {{ ($settings['section_cta_enabled'] ?? '1') === '1' ? 'checked' : '' }}
              class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60 mt-1 cursor-pointer">
          </label>

        </div>
      </div>
    </div>

    <!-- ============================================================== -->
    <!-- TAB 2: HEADER SETTINGS -->
    <!-- ============================================================== -->
    <div id="tab-header" class="tab-pane hidden space-y-6">
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-200 dark:border-brand-slate/40 pb-3">
          <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-heading text-brand-accent"></i>
            <span>Header & Navigation Bar Configuration</span>
          </h2>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            Customize the header logo brand text, announcement top bar, contact details, and CTA button.
          </p>
        </div>

        <div class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30">
          <input type="checkbox" name="header_announcement_enabled" id="header_announcement_enabled" value="1"
            {{ ($settings['header_announcement_enabled'] ?? '1') === '1' ? 'checked' : '' }}
            class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60 cursor-pointer">
          <label for="header_announcement_enabled" class="text-xs font-semibold text-slate-800 dark:text-slate-200 cursor-pointer">
            Enable Top Announcement Bar on Public Website
          </label>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Announcement Badge Tag
            </label>
            <input type="text" name="header_announcement_badge" value="{{ old('header_announcement_badge', $settings['header_announcement_badge'] ?? 'BDIX 8ms') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>

          <div class="sm:col-span-2">
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Announcement Text
            </label>
            <input type="text" name="header_announcement_text" value="{{ old('header_announcement_text', $settings['header_announcement_text'] ?? 'Tier-IV Infrastructure · High-Speed BDIX Routing · 99.99% Guaranteed Uptime') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100 dark:border-brand-slate/30">
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Support Phone (Header & Mobile)
            </label>
            <input type="text" name="support_phone" value="{{ old('support_phone', $settings['support_phone'] ?? '+880 9610-NEXUS') }}"
              class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Support Email Address
            </label>
            <input type="email" name="support_email" value="{{ old('support_email', $settings['support_email'] ?? 'support@nexus.com') }}"
              class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100 dark:border-brand-slate/30">
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Header CTA Button Text
            </label>
            <input type="text" name="header_cta_text" value="{{ old('header_cta_text', $settings['header_cta_text'] ?? 'Get Started') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Header CTA Target URL
            </label>
            <input type="text" name="header_cta_link" value="{{ old('header_cta_link', $settings['header_cta_link'] ?? '#hosting-plans') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================== -->
    <!-- TAB 3: FOOTER SETTINGS -->
    <!-- ============================================================== -->
    <div id="tab-footer" class="tab-pane hidden space-y-6">
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-200 dark:border-brand-slate/40 pb-3">
          <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-shoe-prints text-brand-accent"></i>
            <span>Footer & Legal Information</span>
          </h2>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            Configure company branding, operational status badge, office address, and social links.
          </p>
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Footer Company Bio / Description
          </label>
          <textarea name="footer_company_desc" rows="2"
            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">{{ old('footer_company_desc', $settings['footer_company_desc'] ?? 'Enterprise cloud hosting, high-performance NVMe shared servers, and accredited domain registration.') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Operational Status Text
            </label>
            <input type="text" name="status_text" value="{{ old('status_text', $settings['status_text'] ?? 'All Global Datacenters Operational') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Footer Security / Accreditation Badge
            </label>
            <input type="text" name="footer_badge_text" value="{{ old('footer_badge_text', $settings['footer_badge_text'] ?? 'ISO 27001 Certified · PCI-DSS Compliant') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Corporate Office Address
            </label>
            <input type="text" name="footer_address" value="{{ old('footer_address', $settings['footer_address'] ?? 'Level 8, Motijheel C/A, Dhaka 1000, Bangladesh') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Copyright Notice Text
            </label>
            <input type="text" name="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '© 2026 NEXUSHOST Ltd. All rights reserved.') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>
        </div>

        <!-- Social Media Links -->
        <div class="pt-4 border-t border-slate-100 dark:border-brand-slate/30">
          <h3 class="text-xs font-bold text-slate-800 dark:text-slate-200 mb-3">Social Media URLs</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-[11px] text-slate-500 mb-1"><i class="fa-brands fa-facebook text-blue-500 mr-1"></i> Facebook URL</label>
              <input type="text" name="footer_facebook" value="{{ old('footer_facebook', $settings['footer_facebook'] ?? '') }}" placeholder="https://facebook.com/yourpage"
                class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
            </div>
            <div>
              <label class="block text-[11px] text-slate-500 mb-1"><i class="fa-brands fa-x-twitter text-slate-700 dark:text-slate-300 mr-1"></i> Twitter / X URL</label>
              <input type="text" name="footer_twitter" value="{{ old('footer_twitter', $settings['footer_twitter'] ?? '') }}" placeholder="https://x.com/yourhandle"
                class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
            </div>
            <div>
              <label class="block text-[11px] text-slate-500 mb-1"><i class="fa-brands fa-linkedin text-blue-600 mr-1"></i> LinkedIn URL</label>
              <input type="text" name="footer_linkedin" value="{{ old('footer_linkedin', $settings['footer_linkedin'] ?? '') }}" placeholder="https://linkedin.com/company/yourpage"
                class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
            </div>
            <div>
              <label class="block text-[11px] text-slate-500 mb-1"><i class="fa-brands fa-github mr-1"></i> GitHub URL</label>
              <input type="text" name="footer_github" value="{{ old('footer_github', $settings['footer_github'] ?? '') }}" placeholder="https://github.com/yourorg"
                class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================== -->
    <!-- TAB 4: HERO & BRANDING -->
    <!-- ============================================================== -->
    <div id="tab-hero" class="tab-pane hidden space-y-6">
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-200 dark:border-brand-slate/40 pb-3">
          <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-wand-magic-sparkles text-brand-accent"></i>
            <span>Hero Section & Brand Identity</span>
          </h2>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            Control the website brand name, primary hero headline, value proposition copy, hero image graphic, and datacenter stats.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Website Brand Name / Logo Text
            </label>
            <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'NEXUSHOST') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Hero Pill Badge (Latency / Certification)
            </label>
            <input type="text" name="hero_pill" value="{{ old('hero_pill', $settings['hero_pill'] ?? 'Tier-IV Certified · BDIX 8ms Latency') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Hero Main Headline
          </label>
          <input type="text" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? 'Build Faster. Host Smarter.') }}"
            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Hero Sub-Headline / Description Copy
          </label>
          <textarea name="hero_description" rows="3"
            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">{{ old('hero_description', $settings['hero_description'] ?? 'Engineered cloud hosting for modern web applications, agencies, and businesses. NVMe Gen-4 storage, automated failover, and sub-millisecond database queries.') }}</textarea>
        </div>

        <!-- Hero Server Graphic & Image Uploader Section -->
        <div class="pt-6 border-t border-slate-100 dark:border-brand-slate/30 space-y-4">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-image text-brand-accent"></i>
                <span>Hero Section Server Graphic & Console Image</span>
              </h3>
              <p class="text-[11px] text-slate-400 mt-0.5">Upload a custom datacenter image from your device or specify an image URL.</p>
            </div>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left: Upload / URL inputs (8 cols) -->
            <div class="lg:col-span-8 space-y-4">
              <!-- Upload Image Input -->
              <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                  Upload Datacenter Server Image (PNG, JPG, WEBP, SVG)
                </label>
                <div class="flex flex-wrap items-center gap-3">
                  <label class="cursor-pointer inline-flex items-center gap-2 px-3.5 py-2 rounded-lg border border-dashed border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-600 dark:text-slate-300 hover:border-brand-accent hover:text-brand-accent transition-colors text-xs">
                    <i class="fa-solid fa-cloud-arrow-up text-brand-accent"></i>
                    <span id="heroImageFileLabel">Choose Image File (Max 5MB)</span>
                    <input type="file" name="hero_image_file" id="heroImageInput" accept="image/*" class="hidden" onchange="previewHeroUpload(this)">
                  </label>
                  @if(!empty($settings['hero_image']))
                    <label class="inline-flex items-center gap-1.5 text-xs text-rose-500 hover:underline cursor-pointer">
                      <input type="checkbox" name="remove_hero_image" value="1" class="w-3.5 h-3.5 rounded text-rose-500">
                      <span>Remove uploaded image (Reset to default)</span>
                    </label>
                  @endif
                </div>
              </div>

              <!-- OR Image URL Fallback -->
              <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                  OR Image Web URL (External Link)
                </label>
                <input type="text" name="hero_image_url" id="heroImageUrlInput" oninput="previewHeroUrl(this.value)" value="{{ old('hero_image_url', $settings['hero_image_url'] ?? '') }}" placeholder="https://images.unsplash.com/... or https://yourdomain.com/hero.jpg"
                  class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
                <p class="text-[10px] text-slate-400 mt-1">If a file is uploaded above, the uploaded file takes priority over the URL.</p>
              </div>

              <!-- Console Header Text -->
              <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                  Server Console Tag / Title
                </label>
                <input type="text" name="hero_cluster_name" value="{{ old('hero_cluster_name', $settings['hero_cluster_name'] ?? 'nexus-cluster-01.bd') }}"
                  class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
            </div>

            <!-- Right: Current Image Preview Thumbnail (4 cols) -->
            <div class="lg:col-span-4 p-3 rounded-xl border border-slate-200 dark:border-brand-slate/50 bg-slate-50 dark:bg-brand-dark/40 text-center">
              <span class="text-[10px] font-mono text-slate-400 uppercase block mb-1.5 font-semibold">Live Preview</span>
              <div class="rounded-lg overflow-hidden border border-slate-200 dark:border-brand-slate/60 bg-slate-900 relative aspect-video flex items-center justify-center">
                @php
                  $currentHeroSrc = 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=800&q=80';
                  if (!empty($settings['hero_image']) && file_exists(public_path($settings['hero_image']))) {
                      $currentHeroSrc = asset($settings['hero_image']);
                  } elseif (!empty($settings['hero_image_url'])) {
                      $currentHeroSrc = $settings['hero_image_url'];
                  }
                @endphp
                <img id="heroImagePreview" src="{{ $currentHeroSrc }}" alt="Hero Image Preview" class="w-full h-full object-cover">
              </div>
              <p class="text-[10px] text-slate-400 mt-1.5 font-mono">Hero preview frame</p>
            </div>

          </div>

          <!-- Hero Server Overlay Badges (3 stats) -->
          <div class="pt-4 border-t border-slate-100 dark:border-brand-slate/30">
            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 mb-2.5 flex items-center gap-1.5">
              <i class="fa-solid fa-chart-simple text-cyan-500"></i>
              <span>Console Bottom Live Stat Badges</span>
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
              <!-- Stat 1 -->
              <div class="p-3 rounded-lg border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 space-y-1.5">
                <span class="text-[10px] font-mono text-slate-400 uppercase font-bold">Stat Badge 1 (Left)</span>
                <input type="text" name="hero_stat_1_label" value="{{ old('hero_stat_1_label', $settings['hero_stat_1_label'] ?? 'Throughput') }}" placeholder="Label (e.g. Throughput)"
                  class="w-full px-2 py-1 text-xs rounded border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white">
                <input type="text" name="hero_stat_1_value" value="{{ old('hero_stat_1_value', $settings['hero_stat_1_value'] ?? '7,450 MB/s') }}" placeholder="Value (e.g. 7,450 MB/s)"
                  class="w-full px-2 py-1 text-xs font-bold rounded border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white">
              </div>

              <!-- Stat 2 -->
              <div class="p-3 rounded-lg border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 space-y-1.5">
                <span class="text-[10px] font-mono text-cyan-500 uppercase font-bold">Stat Badge 2 (Center)</span>
                <input type="text" name="hero_stat_2_label" value="{{ old('hero_stat_2_label', $settings['hero_stat_2_label'] ?? 'Dhaka BDIX') }}" placeholder="Label (e.g. Dhaka BDIX)"
                  class="w-full px-2 py-1 text-xs rounded border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white">
                <input type="text" name="hero_stat_2_value" value="{{ old('hero_stat_2_value', $settings['hero_stat_2_value'] ?? '8ms Ping') }}" placeholder="Value (e.g. 8ms Ping)"
                  class="w-full px-2 py-1 text-xs font-bold text-cyan-500 rounded border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card">
              </div>

              <!-- Stat 3 -->
              <div class="p-3 rounded-lg border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 space-y-1.5">
                <span class="text-[10px] font-mono text-emerald-500 uppercase font-bold">Stat Badge 3 (Right)</span>
                <input type="text" name="hero_stat_3_label" value="{{ old('hero_stat_3_label', $settings['hero_stat_3_label'] ?? 'Load') }}" placeholder="Label (e.g. Load)"
                  class="w-full px-2 py-1 text-xs rounded border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white">
                <input type="text" name="hero_stat_3_value" value="{{ old('hero_stat_3_value', $settings['hero_stat_3_value'] ?? '14.2%') }}" placeholder="Value (e.g. 14.2%)"
                  class="w-full px-2 py-1 text-xs font-bold text-emerald-500 rounded border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card">
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>

    <!-- ============================================================== -->
    <!-- TAB 5: WHY CHOOSE US (INFRASTRUCTURE & ARCHITECTURE) -->
    <!-- ============================================================== -->
    <div id="tab-whyus" class="tab-pane hidden space-y-6">
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-200 dark:border-brand-slate/40 pb-3">
          <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-server text-brand-accent"></i>
            <span>Why Builders Choose Us Configuration</span>
          </h2>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            Customize the section headline, architectural narrative, server facility image, live SLA badges, and 6 benefit cards.
          </p>
        </div>

        <!-- Headline & Subtitle -->
        <div class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Section Main Headline
            </label>
            <input type="text" name="why_choose_title" value="{{ old('why_choose_title', $settings['why_choose_title'] ?? 'Why builders choose NEXUSHOST.') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Architectural Difference / Intro Narrative
            </label>
            <textarea name="why_choose_subtitle" rows="2"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">{{ old('why_choose_subtitle', $settings['why_choose_subtitle'] ?? 'We reject the budget host model of cramming thousands of sites onto slow disks. Here is our architectural difference:') }}</textarea>
          </div>
        </div>

        <!-- Datacenter Graphic & Badges -->
        <div class="pt-4 border-t border-slate-100 dark:border-brand-slate/30">
          <h3 class="text-xs font-bold text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-1.5">
            <i class="fa-solid fa-image text-blue-500"></i>
            <span>Server Facility Image & Live Badges</span>
          </h3>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
              <label class="block text-[11px] text-slate-500 mb-1">Datacenter Photo URL</label>
              <input type="text" name="why_choose_image" value="{{ old('why_choose_image', $settings['why_choose_image'] ?? 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=800&q=80') }}"
                class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
            </div>
            <div>
              <label class="block text-[11px] text-slate-500 mb-1">Badge 1 Text (Left)</label>
              <input type="text" name="why_choose_badge_1" value="{{ old('why_choose_badge_1', $settings['why_choose_badge_1'] ?? '99.99% Verified SLA') }}"
                class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
            </div>
            <div>
              <label class="block text-[11px] text-slate-500 mb-1">Badge 2 Text (Right)</label>
              <input type="text" name="why_choose_badge_2" value="{{ old('why_choose_badge_2', $settings['why_choose_badge_2'] ?? '100 Gbps Core') }}"
                class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
            </div>
          </div>
        </div>

        <!-- 6 Core Value Proposition Cards -->
        <div class="pt-4 border-t border-slate-100 dark:border-brand-slate/30">
          <h3 class="text-xs font-bold text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-1.5">
            <i class="fa-solid fa-list-check text-emerald-500"></i>
            <span>6 Core Reasons / Feature Benefit Cards</span>
          </h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <!-- Card 1 -->
            <div class="p-3.5 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 space-y-2">
              <span class="text-[10px] font-mono text-blue-500 font-bold uppercase">Card 1</span>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Title</label>
                <input type="text" name="why_choose_1_title" value="{{ old('why_choose_1_title', $settings['why_choose_1_title'] ?? 'Fast Infrastructure') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Description</label>
                <input type="text" name="why_choose_1_desc" value="{{ old('why_choose_1_desc', $settings['why_choose_1_desc'] ?? 'Tier-IV facilities with dual redundant feeds.') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
            </div>

            <!-- Card 2 -->
            <div class="p-3.5 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 space-y-2">
              <span class="text-[10px] font-mono text-cyan-500 font-bold uppercase">Card 2</span>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Title</label>
                <input type="text" name="why_choose_2_title" value="{{ old('why_choose_2_title', $settings['why_choose_2_title'] ?? 'Transparent Pricing') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Description</label>
                <input type="text" name="why_choose_2_desc" value="{{ old('why_choose_2_desc', $settings['why_choose_2_desc'] ?? 'No surprise price spikes or hidden renewal fees.') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
            </div>

            <!-- Card 3 -->
            <div class="p-3.5 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 space-y-2">
              <span class="text-[10px] font-mono text-indigo-500 font-bold uppercase">Card 3</span>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Title</label>
                <input type="text" name="why_choose_3_title" value="{{ old('why_choose_3_title', $settings['why_choose_3_title'] ?? 'Guaranteed Uptime') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Description</label>
                <input type="text" name="why_choose_3_desc" value="{{ old('why_choose_3_desc', $settings['why_choose_3_desc'] ?? 'Hardware tenant isolation prevents neighbor lag.') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
            </div>

            <!-- Card 4 -->
            <div class="p-3.5 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 space-y-2">
              <span class="text-[10px] font-mono text-emerald-500 font-bold uppercase">Card 4</span>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Title</label>
                <input type="text" name="why_choose_4_title" value="{{ old('why_choose_4_title', $settings['why_choose_4_title'] ?? 'Human Support') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Description</label>
                <input type="text" name="why_choose_4_desc" value="{{ old('why_choose_4_desc', $settings['why_choose_4_desc'] ?? 'Direct chat with engineers who review error logs.') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
            </div>

            <!-- Card 5 -->
            <div class="p-3.5 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 space-y-2">
              <span class="text-[10px] font-mono text-amber-500 font-bold uppercase">Card 5</span>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Title</label>
                <input type="text" name="why_choose_5_title" value="{{ old('why_choose_5_title', $settings['why_choose_5_title'] ?? 'Easy Management') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Description</label>
                <input type="text" name="why_choose_5_desc" value="{{ old('why_choose_5_desc', $settings['why_choose_5_desc'] ?? 'Official cPanel control with 1-click staging.') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
            </div>

            <!-- Card 6 -->
            <div class="p-3.5 rounded-xl border border-slate-200 dark:border-brand-slate/40 bg-slate-50/50 dark:bg-brand-dark/30 space-y-2">
              <span class="text-[10px] font-mono text-rose-500 font-bold uppercase">Card 6</span>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Title</label>
                <input type="text" name="why_choose_6_title" value="{{ old('why_choose_6_title', $settings['why_choose_6_title'] ?? 'Secure Hosting') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
              <div>
                <label class="block text-[11px] text-slate-500 mb-0.5">Description</label>
                <input type="text" name="why_choose_6_desc" value="{{ old('why_choose_6_desc', $settings['why_choose_6_desc'] ?? 'Imunify360 machine learning virus neutralization.') }}"
                  class="w-full px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

    <!-- ============================================================== -->
    <!-- TAB 6: PROMO & BUNDLE -->
    <!-- ============================================================== -->
    <div id="tab-promo" class="tab-pane hidden space-y-6">
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-200 dark:border-brand-slate/40 pb-3">
          <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-tag text-emerald-500"></i>
            <span>Promotional Campaign & Launch Bundle</span>
          </h2>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            Manage global voucher codes, discount banners, and the homepage bundle package.
          </p>
        </div>

        <!-- Promo Banner Fields -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Active Promo Voucher Code
            </label>
            <input type="text" name="promo_code" value="{{ old('promo_code', $settings['promo_code'] ?? 'WELCOME20') }}"
              class="w-full px-3 py-2 text-xs font-mono font-bold uppercase rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-brand-accent focus:outline-none focus:border-brand-accent">
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Discount Percentage / Text
            </label>
            <input type="text" name="promo_discount" value="{{ old('promo_discount', $settings['promo_discount'] ?? '20') }}" placeholder="20"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Promo Header Title
            </label>
            <input type="text" name="promo_title" value="{{ old('promo_title', $settings['promo_title'] ?? '20% OFF your first year of hosting.') }}"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          </div>
        </div>

        <!-- Bundle Card Fields -->
        <div class="pt-4 border-t border-slate-100 dark:border-brand-slate/30">
          <h3 class="text-xs font-bold text-slate-800 dark:text-slate-200 mb-3">Launch Bundle Section Settings</h3>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                Bundle Package Title
              </label>
              <input type="text" name="bundle_title" value="{{ old('bundle_title', $settings['bundle_title'] ?? 'All-In-One Launch Stack') }}"
                class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                Bundle Price (BDT / Mo)
              </label>
              <input type="text" name="bundle_price" value="{{ old('bundle_price', $settings['bundle_price'] ?? '999') }}"
                class="w-full px-3 py-2 text-xs font-mono font-bold rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-brand-cyan focus:outline-none focus:border-brand-accent">
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                Bundle Savings Badge Text
              </label>
              <input type="text" name="bundle_savings" value="{{ old('bundle_savings', $settings['bundle_savings'] ?? 'Save ৳4,500/yr') }}"
                class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Floating / Sticky Save Action Bar -->
    <div class="sticky bottom-6 z-20 flex items-center justify-between p-4 rounded-xl bg-white/95 dark:bg-brand-card/95 backdrop-blur-md border border-slate-200 dark:border-brand-slate/60 shadow-xl">
      <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
        <i class="fa-solid fa-cloud-arrow-up text-brand-accent text-sm"></i>
        <span>Changes will immediately update the live public website and cached assets.</span>
      </div>
      <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-bold shadow-md shadow-brand-accent/25 transition-all">
        <i class="fa-solid fa-check"></i>
        <span>Save All Settings</span>
      </button>
    </div>

  </form>

</div>

@push('scripts')
<script>
  function switchTab(targetTabId) {
    // Hide all tab panes
    document.querySelectorAll('.tab-pane').forEach(function(el) {
      el.classList.add('hidden');
    });

    // Reset all tab button styles
    document.querySelectorAll('.tab-btn').forEach(function(btn) {
      btn.className = 'tab-btn px-4 py-2 rounded-lg transition-colors flex items-center gap-2 shrink-0 text-slate-600 dark:text-slate-300 hover:text-brand-accent hover:bg-slate-50 dark:hover:bg-brand-dark/40';
    });

    // Show target tab pane
    const targetEl = document.getElementById(targetTabId);
    if (targetEl) {
      targetEl.classList.remove('hidden');
    }

    // Set active style on clicked button
    const activeBtn = document.getElementById('btn-' + targetTabId);
    if (activeBtn) {
      activeBtn.className = 'tab-btn px-4 py-2 rounded-lg transition-colors flex items-center gap-2 shrink-0 bg-brand-accent text-white shadow-sm shadow-brand-accent/25';
    }

    // Remember active tab across reloads
    try {
      localStorage.setItem('admin_active_settings_tab', targetTabId);
    } catch(e) {}
  }

  function previewHeroUpload(input) {
    const file = input.files[0];
    const label = document.getElementById('heroImageFileLabel');
    const preview = document.getElementById('heroImagePreview');
    if (file) {
      label.textContent = file.name;
      const reader = new FileReader();
      reader.onload = function(e) {
        if (preview) {
          preview.src = e.target.result;
        }
      };
      reader.readAsDataURL(file);
    }
  }

  function previewHeroUrl(url) {
    const preview = document.getElementById('heroImagePreview');
    if (preview && url.trim() !== '') {
      preview.src = url.trim();
    }
  }

  // Restore saved tab on load
  document.addEventListener('DOMContentLoaded', function() {
    try {
      const savedTab = localStorage.getItem('admin_active_settings_tab');
      if (savedTab && document.getElementById(savedTab)) {
        switchTab(savedTab);
      }
    } catch(e) {}
  });
</script>
@endpush
@endsection
