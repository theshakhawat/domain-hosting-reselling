@extends('layout.website')
@section('title', 'Nexus - Home')
@section('content')

    @if (($settings['section_hero_enabled'] ?? '1') === '1')
        <!-- =========================================================================
           SECTION 1: HERO BANNER (Minimalist Technical Architecture)
           ========================================================================= -->
        <section id="hero"
            class="relative pt-12 pb-16 md:py-20 overflow-hidden border-b border-slate-200 dark:border-slate-800/80 tech-grid-light dark:tech-grid-dark">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">

                    <!-- Hero Left Column: Sleek Typography & Clean CTAs -->
                    <div class="lg:col-span-7 space-y-5 text-left">

                        <!-- Minimal Inline Pill -->
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-mono-code font-medium bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 pulse-glow"></span>
                            <span>{{ $settings['hero_pill'] ?? 'Tier-IV Certified · BDIX 8ms Latency' }}</span>
                        </div>

                        <!-- Hero Headline -->
                        <h1
                            class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
                            {{ $settings['hero_title'] ?? 'Build Faster. Host Smarter.' }}
                        </h1>

                        <!-- Value Proposition -->
                        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-xl leading-relaxed">
                            {{ $settings['hero_description'] ?? 'Engineered cloud hosting for modern web applications, agencies, and businesses. NVMe Gen-4 storage, automated failover, and sub-millisecond database queries.' }}
                        </p>

                        <!-- CTAs -->
                        <div class="flex flex-wrap items-center gap-3 pt-1">
                            <a href="#hosting-plans"
                                class="px-5 py-2.5 rounded-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 text-xs shadow-sm transition-colors">
                                Explore Hosting
                            </a>
                            <a href="#domain-search"
                                class="px-5 py-2.5 rounded-lg font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800/80 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs border border-slate-200 dark:border-slate-700 transition-colors">
                                Find Your Domain
                            </a>
                        </div>

                        <!-- Minimal Trust Metrics -->
                        <div
                            class="pt-5 border-t border-slate-200 dark:border-slate-800/80 grid grid-cols-2 sm:grid-cols-4 gap-4 text-left">
                            <div>
                                <div class="font-bold text-sm text-slate-900 dark:text-white">99.99%</div>
                                <div class="text-[11px] text-slate-500">Uptime SLA</div>
                            </div>
                            <div>
                                <div class="font-bold text-sm text-slate-900 dark:text-white">Free SSL</div>
                                <div class="text-[11px] text-slate-500">Wildcard Auto</div>
                            </div>
                            <div>
                                <div class="font-bold text-sm text-slate-900 dark:text-white">24/7/365</div>
                                <div class="text-[11px] text-slate-500">Engineer Support</div>
                            </div>
                            <div>
                                <div class="font-bold text-sm text-slate-900 dark:text-white">Gen-4 NVMe</div>
                                <div class="text-[11px] text-slate-500">Sub-1ms Read</div>
                            </div>
                        </div>

                    </div>

                    <!-- Hero Right Column: Sleek Server Console Preview (Clean Minimal Frame) -->
                    <div class="lg:col-span-5">
                        <div
                            class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-900 overflow-hidden shadow-lg">

                            <!-- Window Bar -->
                            <div
                                class="px-3.5 py-2 bg-slate-950 border-b border-slate-800 flex items-center justify-between text-[11px] font-mono-code text-slate-400">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-700"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-700"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-700"></span>
                                    <span
                                        class="ml-2 text-slate-300 font-medium">{{ $settings['hero_cluster_name'] ?? 'nexus-cluster-01.bd' }}</span>
                                </div>
                                <span class="text-emerald-400 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Online
                                </span>
                            </div>

                            <!-- Server Photo with Subtle Filter -->
                            <div class="relative h-64 sm:h-72">
                                @php
                                    $heroImgSrc =
                                        'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=800&q=80';
                                    if (
                                        !empty($settings['hero_image']) &&
                                        file_exists(public_path($settings['hero_image']))
                                    ) {
                                        $heroImgSrc = asset($settings['hero_image']);
                                    } elseif (!empty($settings['hero_image_url'])) {
                                        $heroImgSrc = $settings['hero_image_url'];
                                    }
                                @endphp
                                <img src="{{ $heroImgSrc }}" alt="Datacenter server hardware"
                                    class="w-full h-full object-cover opacity-75" loading="eager">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-[#07111F] via-transparent to-transparent">
                                </div>

                                <!-- Sleek Bottom Stats Row -->
                                <div
                                    class="absolute bottom-3 inset-x-3 bg-slate-950/85 backdrop-blur-md border border-slate-800/80 rounded-lg px-3 py-2 flex items-center justify-between text-xs font-mono-code">
                                    <div>
                                        <div class="text-[10px] text-slate-400">
                                            {{ $settings['hero_stat_1_label'] ?? 'Throughput' }}</div>
                                        <div class="font-bold text-white">
                                            {{ $settings['hero_stat_1_value'] ?? '7,450 MB/s' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-slate-400">
                                            {{ $settings['hero_stat_2_label'] ?? 'Dhaka BDIX' }}</div>
                                        <div class="font-bold text-cyan-400">
                                            {{ $settings['hero_stat_2_value'] ?? '8ms Ping' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-slate-400">
                                            {{ $settings['hero_stat_3_label'] ?? 'Load' }}</div>
                                        <div class="font-bold text-emerald-400">
                                            {{ $settings['hero_stat_3_value'] ?? '14.2%' }}</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    @if (($settings['section_domain_enabled'] ?? '1') === '1')
        <!-- =========================================================================
           SECTION 2: DOMAIN SEARCH (Sleek, Streamlined Layout)
           ========================================================================= -->
        <section id="domain-search"
            class="py-12 bg-slate-50 dark:bg-[#091526] border-b border-slate-200 dark:border-slate-800/80">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center max-w-xl mx-auto mb-6">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                        Your next domain starts here.
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Instant activation with free DNS management and WHOIS privacy protection.
                    </p>
                </div>

                <!-- Domain Search Input -->
                <div
                    class="bg-white dark:bg-[#07111F] border border-slate-200 dark:border-slate-800 rounded-xl p-2 sm:p-2.5 shadow-sm">
                    <form id="domain-search-form" class="flex flex-col sm:flex-row gap-2">
                        <div class="relative flex-1">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-globe text-sm"></i>
                            </div>
                            <input type="text" id="domain-search-input"
                                placeholder="Enter your domain name (e.g. mycompany.com)"
                                class="w-full pl-9 pr-3 py-2.5 bg-transparent border-0 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none text-xs sm:text-sm"
                                autocomplete="off">
                        </div>
                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-xs flex items-center justify-center gap-1.5 shrink-0 transition-colors">
                            <i class="fa-solid fa-magnifying-glass"></i> Search Domain
                        </button>
                    </form>

                    <p id="domain-validation-msg" class="hidden text-xs text-rose-500 mt-1 pl-2" role="alert"></p>

                    <!-- Compact TLD Badges -->
                    <div
                        class="mt-2 pt-2 border-t border-slate-100 dark:border-slate-800/80 flex flex-wrap items-center gap-1.5 text-xs">
                        <span class="text-slate-400 text-[11px] mr-1">Popular:</span>
                        @foreach ($domains as $dom)
                            @php
                                $tldVal = is_object($dom)
                                    ? $dom->tld ?? ''
                                    : (is_array($dom)
                                        ? $dom['tld'] ?? ''
                                        : (string) $dom);
                                $priceVal = is_object($dom)
                                    ? $dom->price ?? 0
                                    : (is_array($dom)
                                        ? $dom['price'] ?? 0
                                        : 0);
                            @endphp
                            @if (!empty($tldVal) && str_starts_with($tldVal, '.'))
                                <button type="button"
                                    class="tld-pill px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:text-blue-500 text-[11px] transition-colors"
                                    data-tld="{{ $tldVal }}">
                                    <strong>{{ $tldVal }}</strong> <span
                                        class="text-slate-400">৳{{ number_format((float) $priceVal) }}</span>
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Domain Simulation Results Container -->
                <div id="domain-results"
                    class="hidden mt-4 bg-white dark:bg-[#07111F] border border-slate-200 dark:border-slate-800 rounded-xl p-4 shadow-sm animate-fadeIn">
                    <div
                        class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 text-xs">
                        <span class="font-semibold text-slate-900 dark:text-white">Domain Search Results</span>
                        <span class="font-mono-code text-slate-400">Currency: BDT (৳)</span>
                    </div>

                    <div class="divide-y divide-slate-100 dark:divide-slate-800/80">
                        @foreach ($domains as $index => $dom)
                            @php
                                $tldVal = is_object($dom)
                                    ? $dom->tld ?? ''
                                    : (is_array($dom)
                                        ? $dom['tld'] ?? ''
                                        : (string) $dom);
                                $priceVal = is_object($dom)
                                    ? $dom->price ?? 0
                                    : (is_array($dom)
                                        ? $dom['price'] ?? 0
                                        : 0);
                            @endphp
                            @if (!empty($tldVal) && str_starts_with($tldVal, '.'))
                                <div
                                    class="py-2.5 flex items-center justify-between gap-3 text-xs {{ $index === 2 ? 'opacity-70' : '' }}">
                                    <div>
                                        <div class="font-bold text-slate-900 dark:text-white text-sm">
                                            <span class="searched-domain-base">yourbrand</span>{{ $tldVal }}
                                        </div>
                                        @if ($index === 2)
                                            <span class="text-rose-500 font-medium">✕ Unavailable</span>
                                        @else
                                            <span class="text-emerald-500 font-medium">✓ Available</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3">
                                        @if ($index === 2)
                                            <span class="font-mono-code text-slate-400">Registered</span>
                                        @else
                                            <span
                                                class="font-bold text-slate-900 dark:text-white">৳{{ number_format((float) $priceVal) }}/yr</span>
                                            <button type="button"
                                                class="domain-cart-btn px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold transition-colors">
                                                Select
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </section>
    @endif

    @if (($settings['section_plans_enabled'] ?? '1') === '1')
        <!-- =========================================================================
           SECTION 3: HOSTING PLANS (Dynamic Categories)
           ========================================================================= -->
        <section id="hosting-plans"
            class="py-16 md:py-20 bg-white dark:bg-[#07111F] border-b border-slate-200 dark:border-slate-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Section Header -->
                <div class="text-center max-w-2xl mx-auto mb-10">
                    <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        Transparent, High-Power Hosting Plans.
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2">
                        Enterprise NVMe storage with isolated CloudLinux resources, cPanel, and daily backups.
                    </p>

                    <!-- Segmented Tab Bar -->
                    <div class="mt-6 inline-flex flex-wrap items-center justify-center p-1 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg gap-1"
                        role="tablist">
                        @foreach ($categories as $index => $cat)
                            @php
                                $catSlug = is_object($cat) ? $cat->slug : $cat['slug'] ?? 'shared';
                                $catName = is_object($cat) ? $cat->name : $cat['name'] ?? 'Shared';
                            @endphp
                            <button type="button"
                                class="hosting-tab-btn {{ $index === 0 ? 'active-tab bg-blue-600 text-white shadow-sm border-blue-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white border-transparent' }} px-3.5 py-1.5 rounded-md font-semibold text-xs border transition-colors"
                                data-category="{{ $catSlug }}" role="tab"
                                aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                {{ $catName }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Monthly / Yearly Billing Toggle -->
                    <div class="mt-4 flex items-center justify-center gap-2.5 text-xs">
                        <span class="billing-monthly-label text-blue-600 dark:text-blue-400 font-semibold">Monthly</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="billing-toggle" class="sr-only peer">
                            <div
                                class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-700 peer-checked:bg-blue-600">
                            </div>
                        </label>
                        <span class="billing-yearly-label text-slate-500 font-normal">Yearly <strong
                                class="text-emerald-500 font-semibold">(Save 25%)</strong></span>
                    </div>
                </div>

                <!-- Dynamic Category Panels -->
                @foreach ($categories as $index => $cat)
                    @php
                        $catSlug = is_object($cat) ? $cat->slug : $cat['slug'] ?? 'shared';
                        $catName = is_object($cat) ? $cat->name : $cat['name'] ?? 'Shared';
                        $catPlans = $plans[$catSlug] ?? [];
                    @endphp
                    <div id="panel-{{ $catSlug }}"
                        class="hosting-tab-panel {{ $index === 0 ? '' : 'hidden' }} grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
                        @forelse($catPlans as $plan)
                            <div
                                class="minimal-card {{ $plan->is_popular ? 'relative bg-white dark:bg-[#0B1B33] border-2 border-blue-600 shadow-sm' : 'bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800' }} rounded-xl p-5 flex flex-col justify-between">
                                @if ($plan->badge)
                                    <div
                                        class="absolute -top-2.5 right-4 bg-blue-600 text-white font-mono-code text-[10px] font-bold uppercase py-0.5 px-2.5 rounded shadow-sm">
                                        ★ {{ $plan->badge }}
                                    </div>
                                @endif
                                <div>
                                    <div
                                        class="text-[11px] font-mono-code {{ $plan->is_popular ? 'text-blue-600 dark:text-blue-400' : 'text-slate-400' }} uppercase">
                                        {{ $plan->is_popular ? 'Featured Tier' : $catName . ' Tier' }}
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-0.5">
                                        {{ $plan->name }}</h3>
                                    <p class="text-xs text-slate-500 mt-1">{{ $plan->tagline }}</p>

                                    <div class="my-4 py-3 border-y border-slate-100 dark:border-slate-800/80">
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-2xl font-extrabold text-slate-900 dark:text-white">
                                                <span
                                                    class="price-monthly">৳{{ number_format($plan->monthly_price) }}</span>
                                                <span
                                                    class="price-yearly hidden">৳{{ number_format($plan->yearly_price) }}</span>
                                            </span>
                                            <span class="price-period text-xs text-slate-400">/mo</span>
                                        </div>
                                    </div>

                                    <ul
                                        class="space-y-2 text-xs {{ $plan->is_popular ? 'text-slate-700 dark:text-slate-200' : 'text-slate-600 dark:text-slate-300' }}">
                                        @foreach ($plan->features ?? [] as $featItem)
                                            <li class="flex items-center gap-2">
                                                <i
                                                    class="fa-solid fa-check {{ $plan->is_popular ? 'text-blue-500' : 'text-emerald-500' }} text-[11px]"></i>
                                                <span><strong>{{ $featItem }}</strong></span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="mt-6 pt-3 border-t border-slate-100 dark:border-slate-800/80 space-y-2">
                                    <a href="#checkout"
                                        class="w-full py-2 {{ $plan->is_popular ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-900 dark:text-white' }} font-semibold text-xs rounded-lg flex items-center justify-center transition-colors">
                                        Deploy {{ $plan->name }}
                                    </a>
                                    <button type="button"
                                        class="view-plan-details-btn w-full text-center text-[11px] text-blue-600 dark:text-blue-400 hover:underline font-medium"
                                        data-plan-name="{{ $plan->name }}">
                                        View Technical Specs
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-10 text-slate-400 text-xs">No {{ $catName }}
                                packages available.</div>
                        @endforelse
                    </div>
                @endforeach

            </div>
        </section>
    @endif

    <!-- =========================================================================
           SECTION 4: TECHNICAL SPECIFICATIONS MODAL (Clean Minimal Table)
           ========================================================================= -->
    <div id="spec-modal"
        class="modal-closed fixed inset-0 z-50 bg-slate-950/75 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
        role="dialog" aria-modal="true" aria-labelledby="modal-plan-title">
        <div id="spec-modal-container"
            class="bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800 rounded-xl w-full max-w-3xl max-h-[85vh] flex flex-col shadow-2xl overflow-hidden text-xs">

            <!-- Modal Header -->
            <div
                class="px-5 py-3.5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-[#07111F]">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-microchip text-blue-600"></i>
                    <h3 id="modal-plan-title" class="font-bold text-sm text-slate-900 dark:text-white">
                        Hosting Plan Specifications
                    </h3>
                </div>
                <button type="button" id="spec-modal-close"
                    class="text-slate-400 hover:text-slate-700 dark:hover:text-white focus:outline-none"
                    aria-label="Close modal">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-5 overflow-y-auto space-y-4">

                <div>
                    <h4 class="font-mono-code font-bold uppercase text-[11px] text-blue-600 dark:text-blue-400 mb-2">
                        Hardware & Compute Quotas</h4>
                    <div
                        class="table-responsive-wrapper border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
                        <table class="w-full text-left">
                            <tbody
                                class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-600 dark:text-slate-300">
                                <tr>
                                    <td class="py-2 px-3 font-semibold text-slate-900 dark:text-white w-1/3">Processor</td>
                                    <td class="py-2 px-3 font-mono-code">AMD EPYC™ 7763 / Intel Xeon Gold (3.4 GHz+)</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Storage</td>
                                    <td class="py-2 px-3 font-mono-code">Enterprise NVMe Gen-4 U.2 RAID 10 (7,450 MB/s)
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Inodes Limit</td>
                                    <td class="py-2 px-3 font-mono-code">500,000 to 1,500,000 Inodes</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">I/O Speed</td>
                                    <td class="py-2 px-3 font-mono-code">100 MB/s Dedicated / 10,000 IOPS</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <h4 class="font-mono-code font-bold uppercase text-[11px] text-cyan-500 mb-2">Software Environment</h4>
                    <div
                        class="table-responsive-wrapper border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
                        <table class="w-full text-left">
                            <tbody
                                class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-600 dark:text-slate-300">
                                <tr>
                                    <td class="py-2 px-3 font-semibold text-slate-900 dark:text-white w-1/3">Web Server
                                    </td>
                                    <td class="py-2 px-3 font-mono-code">LiteSpeed Enterprise + HTTP/3 (QUIC)</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">PHP Engine</td>
                                    <td class="py-2 px-3 font-mono-code">PHP 7.4 through 8.3 with OPcache</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Operating System
                                    </td>
                                    <td class="py-2 px-3 font-mono-code">CloudLinux OS + CageFS Virtual Isolation</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <h4 class="font-mono-code font-bold uppercase text-[11px] text-emerald-500 mb-2">Security & Reliability
                    </h4>
                    <div
                        class="table-responsive-wrapper border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
                        <table class="w-full text-left">
                            <tbody
                                class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-600 dark:text-slate-300">
                                <tr>
                                    <td class="py-2 px-3 font-semibold text-slate-900 dark:text-white w-1/3">DDoS
                                        Protection</td>
                                    <td class="py-2 px-3">100 Gbps real-time volumetric defense</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Malware Scanner</td>
                                    <td class="py-2 px-3">Imunify360 AI proactive disinfection & WAF</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Backups</td>
                                    <td class="py-2 px-3">Acronis Cyber Backup: Daily snapshots, 30-day retention</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Uptime Guarantee
                                    </td>
                                    <td class="py-2 px-3 font-bold text-emerald-500">99.99% Hardware & Power Uptime SLA
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div
                class="px-5 py-3 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#07111F] flex items-center justify-end gap-2">
                <button type="button" onclick="document.getElementById('spec-modal-close').click()"
                    class="px-3 py-1.5 font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-md transition-colors">
                    Close
                </button>
                <a href="#hosting-plans" onclick="document.getElementById('spec-modal-close').click()"
                    class="px-3.5 py-1.5 font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors">
                    Select Plan
                </a>
            </div>

        </div>
    </div>

    @if (($settings['section_features_enabled'] ?? '1') === '1')
        <!-- =========================================================================
           SECTION 5: FEATURES ("Everything your website needs" - Clean Bento Grid)
           ========================================================================= -->
        <section id="features"
            class="py-16 md:py-20 bg-slate-50 dark:bg-[#091526] border-b border-slate-200 dark:border-slate-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center max-w-xl mx-auto mb-10">
                    <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        Everything your website needs.
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Complete hardware-level caching, multi-tier security, and human sysadmin support.
                    </p>
                </div>

                <!-- Clean Feature Grid (Loaded Dynamically) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($features as $feat)
                        <div
                            class="bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800 rounded-xl p-4 minimal-card">
                            <div
                                class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/80 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm mb-3">
                                <i class="{{ $feat->icon }}"></i>
                            </div>
                            <div class="flex items-center justify-between gap-1.5">
                                <h3 class="font-bold text-slate-900 dark:text-white text-sm">{{ $feat->title }}</h3>
                                @if ($feat->badge)
                                    <span
                                        class="text-[9px] font-mono uppercase px-1.5 py-0.2 rounded bg-blue-500/10 text-blue-500 shrink-0 font-bold">{{ $feat->badge }}</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $feat->description }}</p>
                            @if ($feat->highlight_metric)
                                <div
                                    class="mt-2.5 pt-2 border-t border-slate-100 dark:border-slate-800 text-[11px] font-mono text-cyan-500 font-semibold">
                                    {{ $feat->highlight_metric }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    @if (($settings['section_infrastructure_enabled'] ?? '1') === '1')
        <!-- =========================================================================
           SECTION 6: WHY CHOOSE US (Sleek Split Layout)
           ========================================================================= -->
        <section id="why-us"
            class="py-16 md:py-20 bg-white dark:bg-[#07111F] border-b border-slate-200 dark:border-slate-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

                    <!-- Left Column: Reasons Narrative -->
                    <div class="lg:col-span-6 space-y-4 text-left">
                        <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                            {{ $settings['why_choose_title'] ?? 'Why builders choose NEXUSHOST.' }}
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                            {{ $settings['why_choose_subtitle'] ?? 'We reject the budget host model of cramming thousands of sites onto slow disks. Here is our architectural difference:' }}
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-2 text-xs">
                            <div
                                class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
                                <strong
                                    class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_1_title'] ?? 'Fast Infrastructure' }}</strong>
                                <span
                                    class="text-slate-500">{{ $settings['why_choose_1_desc'] ?? 'Tier-IV facilities with dual redundant feeds.' }}</span>
                            </div>
                            <div
                                class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
                                <strong
                                    class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_2_title'] ?? 'Transparent Pricing' }}</strong>
                                <span
                                    class="text-slate-500">{{ $settings['why_choose_2_desc'] ?? 'No surprise price spikes or hidden renewal fees.' }}</span>
                            </div>
                            <div
                                class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
                                <strong
                                    class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_3_title'] ?? 'Guaranteed Uptime' }}</strong>
                                <span
                                    class="text-slate-500">{{ $settings['why_choose_3_desc'] ?? 'Hardware tenant isolation prevents neighbor lag.' }}</span>
                            </div>
                            <div
                                class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
                                <strong
                                    class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_4_title'] ?? 'Human Support' }}</strong>
                                <span
                                    class="text-slate-500">{{ $settings['why_choose_4_desc'] ?? 'Direct chat with engineers who review error logs.' }}</span>
                            </div>
                            <div
                                class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
                                <strong
                                    class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_5_title'] ?? 'Easy Management' }}</strong>
                                <span
                                    class="text-slate-500">{{ $settings['why_choose_5_desc'] ?? 'Official cPanel control with 1-click staging.' }}</span>
                            </div>
                            <div
                                class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
                                <strong
                                    class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_6_title'] ?? 'Secure Hosting' }}</strong>
                                <span
                                    class="text-slate-500">{{ $settings['why_choose_6_desc'] ?? 'Imunify360 machine learning virus neutralization.' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Framed Datacenter Photo -->
                    <div class="lg:col-span-6">
                        <div
                            class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-900 overflow-hidden relative shadow-md">
                            <img src="{{ $settings['why_choose_image'] ?? 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=800&q=80' }}"
                                alt="Engineers working in server facility"
                                class="w-full h-64 sm:h-72 object-cover opacity-80" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#07111F] via-transparent to-transparent">
                            </div>

                            <div
                                class="absolute bottom-3 inset-x-3 bg-slate-950/80 backdrop-blur-sm border border-slate-800 rounded-lg p-2.5 flex items-center justify-between text-xs font-mono-code text-white">
                                <span><i class="fa-solid fa-circle-check text-emerald-400 mr-1"></i>
                                    {{ $settings['why_choose_badge_1'] ?? '99.99% Verified SLA' }}</span>
                                <span><i class="fa-solid fa-network-wired text-blue-400 mr-1"></i>
                                    {{ $settings['why_choose_badge_2'] ?? '100 Gbps Core' }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    @if (($settings['section_promo_bar_enabled'] ?? '1') === '1')
        <!-- =========================================================================
           SECTION 7: OFFERS & PROMOTIONS (Minimalist Inline Promo Card)
           ========================================================================= -->
        <section id="offers"
            class="py-12 bg-slate-50 dark:bg-[#091526] border-b border-slate-200 dark:border-slate-800/80">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                <div
                    class="bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800 rounded-xl p-5 sm:p-6 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">

                    <div class="space-y-1.5 text-left">
                        <div class="inline-flex items-center gap-1.5 text-[11px] font-mono-code text-amber-500 font-bold">
                            <i class="fa-solid fa-tag"></i> LAUNCH PROMOTION
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">
                            {{ $settings['promo_title'] ?? '20% OFF your first year of hosting.' }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Use promo code <code id="promo-code-val"
                                class="font-mono font-bold text-blue-600 dark:text-blue-400">{{ $settings['promo_code'] ?? 'WELCOME20' }}</code>
                            during checkout.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- Minimal Countdown Timer -->
                        <div class="flex items-center gap-1.5 font-mono-code text-xs">
                            <div class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-center">
                                <span id="countdown-days" class="font-bold text-slate-900 dark:text-white">04</span><span
                                    class="text-[9px] text-slate-400 ml-0.5">d</span>
                            </div>
                            <div class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-center">
                                <span id="countdown-hours" class="font-bold text-slate-900 dark:text-white">18</span><span
                                    class="text-[9px] text-slate-400 ml-0.5">h</span>
                            </div>
                            <div class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-center">
                                <span id="countdown-mins" class="font-bold text-slate-900 dark:text-white">35</span><span
                                    class="text-[9px] text-slate-400 ml-0.5">m</span>
                            </div>
                            <div class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-center">
                                <span id="countdown-secs" class="font-bold text-amber-500">52</span><span
                                    class="text-[9px] text-slate-400 ml-0.5">s</span>
                            </div>
                        </div>

                        <button type="button" id="copy-promo-btn"
                            class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shrink-0 transition-colors">
                            <i class="fa-regular fa-copy mr-1"></i> Copy Code
                        </button>
                    </div>

                </div>

            </div>
        </section>
    @endif

    @if (($settings['section_bundle_enabled'] ?? '1') === '1')
        <!-- =========================================================================
           SECTION 8: LAUNCH BUNDLE (Sleek All-In-One Stack)
           ========================================================================= -->
        <section id="bundle"
            class="py-16 md:py-20 bg-white dark:bg-[#07111F] border-b border-slate-200 dark:border-slate-800/80">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                <div
                    class="border border-slate-200 dark:border-slate-800 rounded-xl p-6 sm:p-8 bg-slate-50 dark:bg-[#0B1B33]">
                    <div
                        class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200 dark:border-slate-800">
                        <div>
                            <span
                                class="text-[11px] font-mono-code font-bold uppercase text-blue-600 dark:text-blue-400">All-In-One
                                Launch Stack</span>
                            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white mt-0.5">
                                {{ $settings['bundle_title'] ?? 'Everything you need to launch.' }}
                            </h2>
                        </div>
                        <div class="text-left sm:text-right">
                            <div class="text-xl font-extrabold text-slate-900 dark:text-white">
                                ৳{{ number_format((float) ($settings['bundle_price'] ?? 4990)) }}<span
                                    class="text-xs font-normal text-slate-500">/year</span></div>
                            <span class="text-[11px] text-emerald-500 font-medium">Saves
                                ৳{{ number_format((float) ($settings['bundle_savings'] ?? 2400)) }} bundled</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-6 text-xs">
                        <div class="space-y-1">
                            <div class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5"><i
                                    class="fa-solid fa-globe text-blue-500"></i> 1 Domain</div>
                            <p class="text-slate-500">.COM included with free privacy protection.</p>
                        </div>
                        <div class="space-y-1">
                            <div class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5"><i
                                    class="fa-solid fa-server text-cyan-500"></i> 1 Year Hosting</div>
                            <p class="text-slate-500">40 GB NVMe Gen-4 with LiteSpeed & cPanel.</p>
                        </div>
                        <div class="space-y-1">
                            <div class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5"><i
                                    class="fa-solid fa-shield-halved text-emerald-500"></i> Free SSL</div>
                            <p class="text-slate-500">Automated 256-bit wildcard encryption.</p>
                        </div>
                        <div class="space-y-1">
                            <div class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5"><i
                                    class="fa-solid fa-envelope text-indigo-500"></i> Business Email</div>
                            <p class="text-slate-500">Custom branded email inboxes with anti-spam.</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex justify-end">
                        <a href="#hosting-plans"
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg transition-colors">
                            Start Your Website <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

            </div>
        </section>
    @endif

    @if (($settings['section_testimonials_enabled'] ?? '1') === '1')
        <!-- =========================================================================
           SECTION 9: REVIEWS / TESTIMONIALS (Minimalist Hard-Coded Slider)
           ========================================================================= -->
        <section id="testimonials"
            class="py-16 md:py-20 bg-slate-50 dark:bg-[#091526] border-b border-slate-200 dark:border-slate-800/80">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-8">
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        Client Reviews
                    </h2>
                </div>

                <div id="testimonial-slider-wrapper"
                    class="bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800 rounded-xl p-6 shadow-sm min-h-[220px] flex flex-col justify-between">

                    <div id="testimonial-track">
                        @foreach ($testimonials as $rev)
                            <div class="testimonial-slide {{ $loop->first ? '' : 'hidden opacity-0' }}">
                                <div class="flex items-center gap-1 text-amber-400 text-xs mb-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fa-solid fa-star {{ $i <= $rev->rating ? 'text-amber-400' : 'text-slate-300 dark:text-slate-700' }}"></i>
                                    @endfor
                                </div>
                                <blockquote
                                    class="text-sm sm:text-base font-medium text-slate-800 dark:text-slate-200 leading-relaxed italic">
                                    "{{ $rev->review_text }}"
                                </blockquote>
                                <div class="mt-4 flex items-center gap-3">
                                    <img src="{{ $rev->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}"
                                        alt="{{ $rev->client_name }}" class="w-9 h-9 rounded-full object-cover">
                                    <div>
                                        <div class="font-bold text-xs text-slate-900 dark:text-white">
                                            {{ $rev->client_name }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $rev->role }} @if ($rev->company)
                                                · {{ $rev->company }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div
                        class="mt-5 pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                        <div id="testimonial-dots" class="flex items-center gap-1.5"></div>
                        <div class="flex items-center gap-1.5">
                            <button type="button" id="testimonial-prev"
                                class="w-7 h-7 rounded border border-slate-200 dark:border-slate-800 text-slate-500 hover:text-blue-500 flex items-center justify-center text-xs"
                                aria-label="Previous review">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <button type="button" id="testimonial-next"
                                class="w-7 h-7 rounded border border-slate-200 dark:border-slate-800 text-slate-500 hover:text-blue-500 flex items-center justify-center text-xs"
                                aria-label="Next review">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    @endif

    @if (($settings['section_faq_enabled'] ?? '1') === '1')
        <!-- =========================================================================
           SECTION 10: FAQ ACCORDION (12 Questions, Single Item Open, Minimal Styling)
           ========================================================================= -->
        <section id="faq"
            class="py-16 md:py-20 bg-white dark:bg-[#07111F] border-b border-slate-200 dark:border-slate-800/80">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-8">
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        Frequently Asked Questions
                    </h2>
                </div>

                <div class="space-y-2 text-xs sm:text-sm">

                    @forelse($faqs as $faq)
                        <div
                            class="accordion-item {{ $loop->first ? 'active' : '' }} border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden bg-white dark:bg-[#0B1B33]">
                            <button type="button"
                                class="accordion-trigger w-full px-4 py-3 text-left flex items-center justify-between gap-3 focus:outline-none font-semibold text-slate-900 dark:text-white"
                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                <span>{{ $faq->question }}</span>
                                <i
                                    class="accordion-icon fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"></i>
                            </button>
                            <div
                                class="accordion-content px-4 pb-3 text-slate-600 dark:text-slate-300 leading-relaxed text-xs">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs">No questions currently available.</div>
                    @endforelse

                </div>

            </div>
        </section>
    @endif

    @if (($settings['section_cta_enabled'] ?? '1') === '1')
        <!-- =========================================================================
           SECTION 11: MINIMAL FINAL CTA
           ========================================================================= -->
        <section id="cta" class="py-14 md:py-16 bg-[#07111F] text-white border-b border-slate-800 tech-grid-dark">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Ready to put your website online?
                </h2>
                <p class="text-xs sm:text-sm text-slate-400 mt-2 max-w-md mx-auto">
                    Choose your hosting, register your domain, and deploy in minutes with automated provisioning.
                </p>

                <div class="flex items-center justify-center gap-3 mt-6">
                    <a href="#hosting-plans"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg transition-colors">
                        View Hosting Plans
                    </a>
                    <a href="#domain-search"
                        class="px-5 py-2 bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 font-semibold text-xs rounded-lg transition-colors">
                        Search Domain
                    </a>
                </div>
            </div>
        </section>
    @endif
@endsection
