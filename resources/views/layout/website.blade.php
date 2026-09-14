<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'NEXUSHOST — High-Performance Cloud & NVMe Web Hosting')</title>
  <meta name="description" content="Next-generation NVMe Web Hosting, Cloud Infrastructure, and Domain Reselling. Blazing fast LiteSpeed servers, 99.99% uptime SLA, and 24/7 expert support.">

  <!-- Anti-Flash Dark/Light Mode Preloader -->
  <script>
    (function() {
      const savedTheme = localStorage.getItem('hosting_theme');
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    })();
  </script>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
            mono: ['JetBrains Mono', 'monospace']
          },
          colors: {
            brand: {
              navy: '#07111F',
              dark: '#0B1B33',
              card: '#0F223D',
              slate: '#16365F',
              blue: '#2563EB',
              accent: '#3B82F6',
              cyan: '#06B6D4'
            }
          },
          animation: {
            fadeIn: 'fadeIn 0.25s ease-in-out'
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0', transform: 'translateY(4px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            }
          }
        }
      }
    }
  </script>

  <!-- Font Awesome Icons CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="bg-white text-slate-800 dark:bg-[#07111F] dark:text-slate-100 antialiased selection:bg-blue-600 selection:text-white font-sans text-sm">

  @if(($settings['header_announcement_enabled'] ?? '1') === '1')
  <!-- Top Announcement Bar -->
  <div class="bg-slate-900 border-b  hidden lg:block border-slate-800 text-slate-300 py-1.5 px-4 text-xs font-medium">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <div class="flex items-center gap-2">
        <span class="px-1.5 py-0.5 rounded bg-blue-600 text-white font-mono text-[10px] font-bold uppercase">
          {{ $settings['header_announcement_badge'] ?? 'BDIX 8ms' }}
        </span>
        <span class="truncate ">{{ $settings['header_announcement_text'] ?? 'Tier-IV Infrastructure · High-Speed BDIX Routing · 99.99% Guaranteed Uptime' }}</span>
      </div>
      <div class="hidden sm:flex items-center gap-4 text-[11px]">
        @if(!empty($settings['support_phone']))
          <a href="tel:{{ $settings['support_phone'] }}" class="hover:text-white flex items-center gap-1.5 text-slate-300">
            <i class="fa-solid fa-phone text-[10px] text-blue-400"></i> {{ $settings['support_phone'] }}
          </a>
        @endif
        @if(!empty($settings['support_email']))
          <a href="mailto:{{ $settings['support_email'] }}" class="hover:text-white flex items-center gap-1.5 text-slate-300">
            <i class="fa-solid fa-envelope text-[10px] text-cyan-400"></i> {{ $settings['support_email'] }}
          </a>
        @endif
      </div>
    </div>
  </div>
  @endif

  <!-- =========================================================================
       MINIMALIST STICKY NAVBAR (No Client Login, High Contrast Links)
       ========================================================================= -->
  <header id="main-navbar" class="sticky top-0 z-40 w-full transition-all duration-200 border-b border-slate-200 dark:border-slate-800/80 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 focus:outline-none focus:ring-1 focus:ring-blue-500 rounded p-1">
          <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white text-sm shadow-sm">
            <i class="fa-solid fa-server"></i>
          </div>
          <span class="text-lg font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-0.5">
            @if(!empty($settings['site_name']))
              {{ $settings['site_name'] }}
            @else
              NEXUS<span class="text-blue-600 dark:text-blue-400">HOST</span>
            @endif
          </span>
        </a>

        <!-- Desktop Navigation Links with Clear High Contrast -->
        <nav class="hidden lg:flex items-center gap-1 text-xs font-semibold text-slate-700 dark:text-gray-200" dark:bg-dark-900 aria-label="Main Navigation">
          @if(($settings['section_hero_enabled'] ?? '1') === '1')
          <a href="{{ route('home') }}#hero" class="px-3 py-1.5 rounded-md hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : '' }}">
            Home
          </a>
          @endif

          <!-- Hosting Dropdown -->
          @if(($settings['section_plans_enabled'] ?? '1') === '1')
          <div class="relative group">
            <button type="button" class="px-3 py-1.5 rounded-md inline-flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors focus:outline-none" aria-haspopup="true">
              <span>Hosting</span>
              <i class="fa-solid fa-chevron-down text-[10px] opacity-70 transition-transform duration-200 group-hover:rotate-180"></i>
            </button>
            <div class="absolute left-0 top-full pt-2 w-60 opacity-0 translate-y-1 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-150 ease-out z-50">
              <div class="bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800 rounded-lg shadow-xl p-1.5 space-y-0.5">
                @foreach($categories ?? [] as $cat)
                  @php
                    $catName = is_object($cat) ? $cat->name : ($cat['name'] ?? 'Shared');
                    $catSlug = is_object($cat) ? $cat->slug : ($cat['slug'] ?? 'shared');
                  @endphp
                  <a href="{{ route('home') }}#hosting-plans" class="flex items-center gap-2.5 px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800/80 text-xs text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-layer-group text-blue-500 w-4"></i>
                    <span>{{ $catName }}</span>
                  </a>
                @endforeach
              </div>
            </div>
          </div>
          @endif

          <!-- Domains Dropdown -->
          @if(($settings['section_domain_enabled'] ?? '1') === '1')
          <div class="relative group">
            <button type="button" class="px-3 py-1.5 rounded-md inline-flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors focus:outline-none" aria-haspopup="true">
              <span>Domains</span>
              <i class="fa-solid fa-chevron-down text-[10px] opacity-70 transition-transform duration-200 group-hover:rotate-180"></i>
            </button>
            <div class="absolute left-0 top-full pt-2 w-56 opacity-0 translate-y-1 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-150 ease-out z-50">
              <div class="bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800 rounded-lg shadow-xl p-1.5 space-y-0.5">
                <a href="{{ route('home') }}#domain-search" class="flex items-center gap-2.5 px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800/80 text-xs text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-white transition-colors">
                  <i class="fa-solid fa-magnifying-glass text-blue-500 w-4"></i>
                  <span>Domain Search</span>
                </a>
                <a href="{{ route('home') }}#domain-search" class="flex items-center gap-2.5 px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800/80 text-xs text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-white transition-colors">
                  <i class="fa-solid fa-tags text-cyan-500 w-4"></i>
                  <span>Domain Pricing</span>
                </a>
                <a href="{{ route('home') }}#domain-search" class="flex items-center gap-2.5 px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800/80 text-xs text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-white transition-colors">
                  <i class="fa-solid fa-arrow-right-arrow-left text-amber-500 w-4"></i>
                  <span>Domain Transfer</span>
                </a>
                <a href="{{ route('home') }}#domain-search" class="flex items-center gap-2.5 px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800/80 text-xs text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-white transition-colors">
                  <i class="fa-solid fa-id-card text-emerald-500 w-4"></i>
                  <span>WHOIS Lookup</span>
                </a>
              </div>
            </div>
          </div>
          @endif

          @if(($settings['section_features_enabled'] ?? '1') === '1')
          <a href="{{ route('home') }}#features" class="px-3 py-1.5 rounded-md hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors">
            Features
          </a>
          @endif

          @if(($settings['section_bundle_enabled'] ?? '1') === '1')
          <a href="{{ route('home') }}#bundle" class="px-3 py-1.5 rounded-md hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors">
            Launch Bundle
          </a>
          @endif

          @if(($settings['section_testimonials_enabled'] ?? '1') === '1')
          <a href="{{ route('home') }}#testimonials" class="px-3 py-1.5 rounded-md hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors">
            Reviews
          </a>
          @endif

          @if(($settings['section_faq_enabled'] ?? '1') === '1')
          <a href="{{ route('home') }}#faq" class="px-3 py-1.5 rounded-md hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors">
            FAQ
          </a>
          @endif

          <a href="{{ route('contact.show') }}" class="px-3 py-1.5 rounded-md hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors {{ request()->routeIs('contact.*') ? 'text-blue-600 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800' : '' }}">
            Contact Support
          </a>
        </nav>

        <!-- Right Side: Dark/Light toggle + Minimal Get Started CTA (Client Area Removed) -->
        <div class="flex items-center gap-2.5">
          <!-- Admin Dashboard Link if logged in -->
          @auth
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white rounded-lg transition-colors border border-blue-200 dark:border-blue-800">
              <i class="fa-solid fa-gauge-high text-[11px]"></i>
              <span class="hidden sm:inline">Admin Panel</span>
            </a>
          @endauth

          <!-- Theme Toggle Button -->
          <button type="button" class="theme-toggle-btn w-8 h-8 rounded-lg flex items-center justify-center text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none" aria-label="Toggle Color Theme">
            <i class="theme-toggle-icon fa-solid fa-moon text-xs"></i>
          </button>

          <!-- Minimal CTA -->
          <a href="{{ $settings['header_cta_link'] ?? '#hosting-plans' }}" class="hidden sm:inline-flex items-center justify-center px-3.5 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors">
            {{ $settings['header_cta_text'] ?? 'Get Started' }}
          </a>

          <!-- Mobile Hamburger Toggle -->
          <button type="button" id="mobile-menu-toggle" class="lg:hidden w-9 h-9 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none" aria-label="Open mobile menu" aria-expanded="false">
            <i class="fa-solid fa-bars text-sm"></i>
          </button>
        </div>

      </div>
    </div>
  </header>

  <!-- =========================================================================
       RELIABLE MOBILE DRAWER (Direct Child of Body, Immune to Backdrop Trap)
       ========================================================================= -->
  <div id="mobile-drawer-overlay" class="drawer-closed fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-sm flex justify-end" role="dialog" aria-modal="true">
    <div id="mobile-drawer-panel" class="w-full max-w-xs sm:max-w-sm h-full bg-white dark:bg-[#07111F] border-l border-slate-200 dark:border-slate-800 shadow-2xl p-6 flex flex-col justify-between overflow-y-auto">
      
      <div>
        <!-- Drawer Top Row -->
        <div class="flex items-center justify-between pb-5 border-b border-slate-200 dark:border-slate-800">
          <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-md bg-blue-600 flex items-center justify-center text-white text-xs">
              <i class="fa-solid fa-server"></i>
            </div>
            <span class="font-bold text-slate-900 dark:text-white text-base">NEXUS<span class="text-blue-600 dark:text-blue-400">HOST</span></span>
          </div>
          <button type="button" id="mobile-drawer-close" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none" aria-label="Close mobile menu">
            <i class="fa-solid fa-xmark text-base"></i>
          </button>
        </div>

        <!-- Drawer Links -->
        <div class="py-4 space-y-1">
          @if(($settings['section_hero_enabled'] ?? '1') === '1')
          <a href="{{ route('home') }}#hero" class="mobile-nav-link block px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
            Home
          </a>
          @endif

          <!-- Expandable Hosting Submenu -->
          @if(($settings['section_plans_enabled'] ?? '1') === '1')
          <div>
            <button type="button" class="mobile-submenu-trigger w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none" data-target="mobile-hosting-submenu">
              <span>Hosting Solutions</span>
              <i class="submenu-arrow-icon fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
            </button>
            <div id="mobile-hosting-submenu" class="hidden pl-4 pr-2 py-1.5 space-y-1 bg-slate-50 dark:bg-slate-900/60 rounded-md mt-1 border border-slate-200 dark:border-slate-800 text-xs">
              @foreach($categories ?? [] as $cat)
                @php
                  $catName = is_object($cat) ? $cat->name : ($cat['name'] ?? 'Shared');
                @endphp
                <a href="{{ route('home') }}#hosting-plans" class="mobile-nav-link block px-2 py-1.5 text-slate-600 dark:text-slate-300 hover:text-blue-500">{{ $catName }}</a>
              @endforeach
            </div>
          </div>
          @endif

          <!-- Expandable Domains Submenu -->
          @if(($settings['section_domain_enabled'] ?? '1') === '1')
          <div>
            <button type="button" class="mobile-submenu-trigger w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none" data-target="mobile-domains-submenu">
              <span>Domains</span>
              <i class="submenu-arrow-icon fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
            </button>
            <div id="mobile-domains-submenu" class="hidden pl-4 pr-2 py-1.5 space-y-1 bg-slate-50 dark:bg-slate-900/60 rounded-md mt-1 border border-slate-200 dark:border-slate-800 text-xs">
              <a href="{{ route('home') }}#domain-search" class="mobile-nav-link block px-2 py-1.5 text-slate-600 dark:text-slate-300 hover:text-blue-500">Domain Search</a>
              <a href="{{ route('home') }}#domain-search" class="mobile-nav-link block px-2 py-1.5 text-slate-600 dark:text-slate-300 hover:text-cyan-500">Domain Pricing</a>
              <a href="{{ route('home') }}#domain-search" class="mobile-nav-link block px-2 py-1.5 text-slate-600 dark:text-slate-300 hover:text-amber-500">Domain Transfer</a>
            </div>
          </div>
          @endif

          @if(($settings['section_features_enabled'] ?? '1') === '1')
          <a href="{{ route('home') }}#features" class="mobile-nav-link block px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
            Features
          </a>
          @endif

          @if(($settings['section_bundle_enabled'] ?? '1') === '1')
          <a href="{{ route('home') }}#bundle" class="mobile-nav-link block px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
            Launch Bundle
          </a>
          @endif

          @if(($settings['section_testimonials_enabled'] ?? '1') === '1')
          <a href="{{ route('home') }}#testimonials" class="mobile-nav-link block px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
            Reviews
          </a>
          @endif

          @if(($settings['section_faq_enabled'] ?? '1') === '1')
          <a href="{{ route('home') }}#faq" class="mobile-nav-link block px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
            FAQ
          </a>
          @endif

          <a href="{{ route('contact.show') }}" class="mobile-nav-link block px-3 py-2 text-sm font-semibold text-blue-600 dark:text-blue-400 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
            Contact Support
          </a>
        </div>
      </div>

      <!-- Drawer Bottom Actions -->
      <div class="pt-5 border-t border-slate-200 dark:border-slate-800 space-y-3">
        <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
          <span>Appearance</span>
          <button type="button" class="theme-toggle-btn px-2.5 py-1 rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-medium flex items-center gap-1.5">
            <i class="theme-toggle-icon fa-solid fa-moon text-xs"></i>
            <span>Theme Toggle</span>
          </button>
        </div>
        <a href="{{ route('home') }}#hosting-plans" class="mobile-nav-link w-full py-2.5 px-4 rounded-lg font-semibold text-xs text-center bg-blue-600 text-white shadow-sm block">
          Get Started Now
        </a>
      </div>

    </div>
  </div>


@yield('content')

  <!-- =========================================================================
       SECTION 12: GLOBAL FOOTER (Minimalist & Clean)
       ========================================================================= -->
  <footer class="bg-white dark:bg-[#07111F] text-slate-500 dark:text-slate-400 text-xs py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="grid grid-cols-2 md:grid-cols-6 gap-8 pb-8 border-b border-slate-200 dark:border-slate-800">
        
        <div class="col-span-2 space-y-2.5 text-left">
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded bg-blue-600 flex items-center justify-center text-white text-xs">
              <i class="fa-solid fa-server"></i>
            </div>
            <span class="font-bold text-slate-900 dark:text-white text-sm">
              @if(!empty($settings['site_name']))
                {{ $settings['site_name'] }}
              @else
                NEXUS<span class="text-blue-500">HOST</span>
              @endif
            </span>
          </div>
          <p class="text-xs text-slate-500 leading-relaxed max-w-xs">
            {{ $settings['footer_company_desc'] ?? 'Enterprise cloud hosting, high-performance NVMe shared servers, and accredited domain registration.' }}
          </p>
          @if(!empty($settings['footer_address']))
            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 flex items-start gap-1.5">
              <i class="fa-solid fa-location-dot mt-0.5 text-blue-500 shrink-0"></i>
              <span>{{ $settings['footer_address'] }}</span>
            </div>
          @endif
          @if(!empty($settings['footer_badge_text']))
            <div class="text-[10px] text-slate-500 dark:text-slate-400 flex items-center gap-1.5 mt-1">
              <i class="fa-solid fa-shield-halved text-blue-500"></i>
              <span>{{ $settings['footer_badge_text'] }}</span>
            </div>
          @endif
          <div class="flex items-center gap-1.5 text-slate-500 dark:text-slate-400 text-[11px] pt-1">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 pulse-glow"></span>
            <span>{{ $settings['status_text'] ?? 'All Global Datacenters Operational' }}</span>
          </div>
        </div>

        @if(($settings['section_plans_enabled'] ?? '1') === '1')
        <div class="space-y-2 text-left">
          <h4 class="font-semibold text-slate-900 dark:text-white text-xs">Hosting</h4>
          <ul class="space-y-1.5 text-[11px]">
            @foreach($categories ?? [] as $cat)
              @php
                $catName = is_object($cat) ? $cat->name : ($cat['name'] ?? 'Shared');
              @endphp
              <li><a href="{{ route('home') }}#hosting-plans" class="hover:text-blue-500">{{ $catName }}</a></li>
            @endforeach
          </ul>
        </div>
        @endif

        @if(($settings['section_domain_enabled'] ?? '1') === '1')
        <div class="space-y-2 text-left">
          <h4 class="font-semibold text-slate-900 dark:text-white text-xs">Domains</h4>
          <ul class="space-y-1.5 text-[11px]">
            <li><a href="{{ route('home') }}#domain-search" class="hover:text-blue-500">Search Domain</a></li>
            <li><a href="{{ route('home') }}#domain-search" class="hover:text-blue-500">Domain Pricing</a></li>
            <li><a href="{{ route('home') }}#domain-search" class="hover:text-blue-500">Domain Transfer</a></li>
            <li><a href="{{ route('home') }}#domain-search" class="hover:text-blue-500">WHOIS Lookup</a></li>
          </ul>
        </div>
        @endif

        <div class="space-y-2 text-left">
          <h4 class="font-semibold text-slate-900 dark:text-white text-xs">Support</h4>
          <ul class="space-y-1.5 text-[11px]">
            <li><a href="{{ route('contact.show') }}" class="hover:text-blue-500 font-semibold text-blue-600 dark:text-blue-400">Contact & Support</a></li>
            @if(($settings['section_faq_enabled'] ?? '1') === '1')
            <li><a href="{{ route('home') }}#faq" class="hover:text-blue-500">Help Center</a></li>
            <li><a href="{{ route('home') }}#faq" class="hover:text-blue-500">FAQ</a></li>
            @endif
            @if(($settings['section_hero_enabled'] ?? '1') === '1')
            <li><a href="{{ route('home') }}#hero" class="hover:text-blue-500">Server Status</a></li>
            @endif
            @if(($settings['section_features_enabled'] ?? '1') === '1')
            <li><a href="{{ route('home') }}#features" class="hover:text-blue-500">Free Migration</a></li>
            @endif
          </ul>
        </div>

        <div class="space-y-2 text-left">
          <h4 class="font-semibold text-slate-900 dark:text-white text-xs">Legal</h4>
          <ul class="space-y-1.5 text-[11px]">
            <li><a href="{{ route('home') }}#legal" class="hover:text-blue-500">Terms of Service</a></li>
            <li><a href="{{ route('home') }}#legal" class="hover:text-blue-500">Privacy Policy</a></li>
            <li><a href="{{ route('home') }}#legal" class="hover:text-blue-500">Refund Policy</a></li>
            <li><a href="{{ route('home') }}#legal" class="hover:text-blue-500">Acceptable Use</a></li>
          </ul>
        </div>

      </div>


      <img src="{{ asset('assets/img/accepted-payment-methods.avif') }}" alt="Secure Hosting Badge" class=" mt-6 mx-auto h-auto">



      <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px]">
        <p>{{ $settings['footer_copyright'] ?? '© 2026 NEXUSHOST Cloud Infrastructure Ltd. All rights reserved.' }}</p>
        <div class="flex items-center gap-3 text-slate-400">
          <a href="{{ !empty($settings['footer_facebook']) ? $settings['footer_facebook'] : 'https://facebook.com' }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-500 transition-colors" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
          <a href="{{ !empty($settings['footer_twitter']) ? $settings['footer_twitter'] : 'https://x.com' }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-400 transition-colors" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
          <a href="{{ !empty($settings['footer_linkedin']) ? $settings['footer_linkedin'] : 'https://linkedin.com' }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600 transition-colors" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
          <a href="{{ !empty($settings['footer_github']) ? $settings['footer_github'] : 'https://github.com' }}" target="_blank" rel="noopener noreferrer" class="hover:text-slate-900 dark:hover:text-white transition-colors" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
        </div>
      </div>

    </div>
  </footer>

  <!-- =========================================================================
       FLOATING BACK TO TOP BUTTON
       ========================================================================= -->
  <button 
    type="button" 
    id="back-to-top" 
    class="hidden-btn fixed bottom-5 right-5 z-40 w-9 h-9 rounded-lg bg-blue-600 hover:bg-blue-700 text-white shadow-md flex items-center justify-center transition-all focus:outline-none" 
    aria-label="Back to top"
  >
    <i class="fa-solid fa-arrow-up text-xs"></i>
  </button>

  <!-- Production Vanilla JavaScript -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <!-- Client-Side Analytics Beacon (Screen Resolution & Viewport Capture) -->
  <script>
    (function() {
      try {
        const screenRes = window.screen.width + 'x' + window.screen.height;
        const payload = JSON.stringify({ screen_resolution: screenRes });
        if (navigator.sendBeacon) {
          const blob = new Blob([payload], { type: 'application/json' });
          navigator.sendBeacon('{{ route('api.track-visitor') }}', blob);
        } else {
          fetch('{{ route('api.track-visitor') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: payload,
            keepalive: true
          }).catch(function() {});
        }
      } catch(e) {}
    })();
  </script>

  @stack('scripts')
</body>
</html>
