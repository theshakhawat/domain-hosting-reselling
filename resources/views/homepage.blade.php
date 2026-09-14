<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NEXUSHOST — High-Performance Cloud & NVMe Web Hosting</title>
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
  <div class="bg-slate-900 border-b border-slate-800 text-slate-300 py-1.5 px-4 text-xs font-medium">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <div class="flex items-center gap-2">
        <span class="px-1.5 py-0.5 rounded bg-blue-600 text-white font-mono text-[10px] font-bold uppercase">
          {{ $settings['header_announcement_badge'] ?? 'BDIX 8ms' }}
        </span>
        <span class="truncate">{{ $settings['header_announcement_text'] ?? 'Tier-IV Infrastructure · High-Speed BDIX Routing · 99.99% Guaranteed Uptime' }}</span>
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
        <a href="#hero" class="flex items-center gap-2.5 focus:outline-none focus:ring-1 focus:ring-blue-500 rounded p-1">
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
          <a href="#hero" class="px-3 py-1.5 rounded-md hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors">
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
                @foreach($categories as $cat)
                  @php
                    $catName = is_object($cat) ? $cat->name : ($cat['name'] ?? 'Shared');
                    $catSlug = is_object($cat) ? $cat->slug : ($cat['slug'] ?? 'shared');
                  @endphp
                  <a href="#hosting-plans" class="flex items-center gap-2.5 px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800/80 text-xs text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-white transition-colors">
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
                <a href="#domain-search" class="flex items-center gap-2.5 px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800/80 text-xs text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-white transition-colors">
                  <i class="fa-solid fa-magnifying-glass text-blue-500 w-4"></i>
                  <span>Domain Search</span>
                </a>
                <a href="#domain-search" class="flex items-center gap-2.5 px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800/80 text-xs text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-white transition-colors">
                  <i class="fa-solid fa-tags text-cyan-500 w-4"></i>
                  <span>Domain Pricing</span>
                </a>
                <a href="#domain-search" class="flex items-center gap-2.5 px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800/80 text-xs text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-white transition-colors">
                  <i class="fa-solid fa-arrow-right-arrow-left text-amber-500 w-4"></i>
                  <span>Domain Transfer</span>
                </a>
                <a href="#domain-search" class="flex items-center gap-2.5 px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800/80 text-xs text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-white transition-colors">
                  <i class="fa-solid fa-id-card text-emerald-500 w-4"></i>
                  <span>WHOIS Lookup</span>
                </a>
              </div>
            </div>
          </div>
          @endif

          @if(($settings['section_features_enabled'] ?? '1') === '1')
          <a href="#features" class="px-3 py-1.5 rounded-md hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors">
            Features
          </a>
          @endif

          @if(($settings['section_bundle_enabled'] ?? '1') === '1')
          <a href="#bundle" class="px-3 py-1.5 rounded-md hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors">
            Launch Bundle
          </a>
          @endif

          @if(($settings['section_testimonials_enabled'] ?? '1') === '1')
          <a href="#testimonials" class="px-3 py-1.5 rounded-md hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors">
            Reviews
          </a>
          @endif

          @if(($settings['section_faq_enabled'] ?? '1') === '1')
          <a href="#faq" class="px-3 py-1.5 rounded-md hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors">
            FAQ
          </a>
          @endif
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
          <a href="#hero" class="mobile-nav-link block px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
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
              @foreach($categories as $cat)
                @php
                  $catName = is_object($cat) ? $cat->name : ($cat['name'] ?? 'Shared');
                @endphp
                <a href="#hosting-plans" class="mobile-nav-link block px-2 py-1.5 text-slate-600 dark:text-slate-300 hover:text-blue-500">{{ $catName }}</a>
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
              <a href="#domain-search" class="mobile-nav-link block px-2 py-1.5 text-slate-600 dark:text-slate-300 hover:text-blue-500">Domain Search</a>
              <a href="#domain-search" class="mobile-nav-link block px-2 py-1.5 text-slate-600 dark:text-slate-300 hover:text-cyan-500">Domain Pricing</a>
              <a href="#domain-search" class="mobile-nav-link block px-2 py-1.5 text-slate-600 dark:text-slate-300 hover:text-amber-500">Domain Transfer</a>
            </div>
          </div>
          @endif

          @if(($settings['section_features_enabled'] ?? '1') === '1')
          <a href="#features" class="mobile-nav-link block px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
            Features
          </a>
          @endif

          @if(($settings['section_bundle_enabled'] ?? '1') === '1')
          <a href="#bundle" class="mobile-nav-link block px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
            Launch Bundle
          </a>
          @endif

          @if(($settings['section_testimonials_enabled'] ?? '1') === '1')
          <a href="#testimonials" class="mobile-nav-link block px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
            Reviews
          </a>
          @endif

          @if(($settings['section_faq_enabled'] ?? '1') === '1')
          <a href="#faq" class="mobile-nav-link block px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
            FAQ
          </a>
          @endif
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
        <a href="#hosting-plans" class="mobile-nav-link w-full py-2.5 px-4 rounded-lg font-semibold text-xs text-center bg-blue-600 text-white shadow-sm block">
          Get Started Now
        </a>
      </div>

    </div>
  </div>

  @if(($settings['section_hero_enabled'] ?? '1') === '1')
  <!-- =========================================================================
       SECTION 1: HERO BANNER (Minimalist Technical Architecture)
       ========================================================================= -->
  <section id="hero" class="relative pt-12 pb-16 md:py-20 overflow-hidden border-b border-slate-200 dark:border-slate-800/80 tech-grid-light dark:tech-grid-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">
        
        <!-- Hero Left Column: Sleek Typography & Clean CTAs -->
        <div class="lg:col-span-7 space-y-5 text-left">
          
          <!-- Minimal Inline Pill -->
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-mono-code font-medium bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 pulse-glow"></span>
            <span>{{ $settings['hero_pill'] ?? 'Tier-IV Certified · BDIX 8ms Latency' }}</span>
          </div>

          <!-- Hero Headline -->
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
            {{ $settings['hero_title'] ?? 'Build Faster. Host Smarter.' }}
          </h1>

          <!-- Value Proposition -->
          <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-xl leading-relaxed">
            {{ $settings['hero_description'] ?? 'Engineered cloud hosting for modern web applications, agencies, and businesses. NVMe Gen-4 storage, automated failover, and sub-millisecond database queries.' }}
          </p>

          <!-- CTAs -->
          <div class="flex flex-wrap items-center gap-3 pt-1">
            <a href="#hosting-plans" class="px-5 py-2.5 rounded-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 text-xs shadow-sm transition-colors">
              Explore Hosting
            </a>
            <a href="#domain-search" class="px-5 py-2.5 rounded-lg font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800/80 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs border border-slate-200 dark:border-slate-700 transition-colors">
              Find Your Domain
            </a>
          </div>

          <!-- Minimal Trust Metrics -->
          <div class="pt-5 border-t border-slate-200 dark:border-slate-800/80 grid grid-cols-2 sm:grid-cols-4 gap-4 text-left">
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
          <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-900 overflow-hidden shadow-lg">
            
            <!-- Window Bar -->
            <div class="px-3.5 py-2 bg-slate-950 border-b border-slate-800 flex items-center justify-between text-[11px] font-mono-code text-slate-400">
              <div class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-slate-700"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-slate-700"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-slate-700"></span>
                <span class="ml-2 text-slate-300 font-medium">nexus-cluster-01.bd</span>
              </div>
              <span class="text-emerald-400 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Online
              </span>
            </div>

            <!-- Server Photo with Subtle Filter -->
            <div class="relative h-64 sm:h-72">
              <img 
                src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=800&q=80" 
                alt="Datacenter server hardware" 
                class="w-full h-full object-cover opacity-75"
                loading="eager"
              >
              <div class="absolute inset-0 bg-gradient-to-t from-[#07111F] via-transparent to-transparent"></div>

              <!-- Sleek Bottom Stats Row -->
              <div class="absolute bottom-3 inset-x-3 bg-slate-950/85 backdrop-blur-md border border-slate-800/80 rounded-lg px-3 py-2 flex items-center justify-between text-xs font-mono-code">
                <div>
                  <div class="text-[10px] text-slate-400">Throughput</div>
                  <div class="font-bold text-white">7,450 MB/s</div>
                </div>
                <div>
                  <div class="text-[10px] text-slate-400">Dhaka BDIX</div>
                  <div class="font-bold text-cyan-400">8ms Ping</div>
                </div>
                <div>
                  <div class="text-[10px] text-slate-400">Load</div>
                  <div class="font-bold text-emerald-400">14.2%</div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>
  @endif

  @if(($settings['section_domain_enabled'] ?? '1') === '1')
  <!-- =========================================================================
       SECTION 2: DOMAIN SEARCH (Sleek, Streamlined Layout)
       ========================================================================= -->
  <section id="domain-search" class="py-12 bg-slate-50 dark:bg-[#091526] border-b border-slate-200 dark:border-slate-800/80">
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
      <div class="bg-white dark:bg-[#07111F] border border-slate-200 dark:border-slate-800 rounded-xl p-2 sm:p-2.5 shadow-sm">
        <form id="domain-search-form" class="flex flex-col sm:flex-row gap-2">
          <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <i class="fa-solid fa-globe text-sm"></i>
            </div>
            <input 
              type="text" 
              id="domain-search-input" 
              placeholder="Enter your domain name (e.g. mycompany.com)" 
              class="w-full pl-9 pr-3 py-2.5 bg-transparent border-0 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none text-xs sm:text-sm"
              autocomplete="off"
            >
          </div>
          <button 
            type="submit" 
            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-xs flex items-center justify-center gap-1.5 shrink-0 transition-colors"
          >
            <i class="fa-solid fa-magnifying-glass"></i> Search Domain
          </button>
        </form>

        <p id="domain-validation-msg" class="hidden text-xs text-rose-500 mt-1 pl-2" role="alert"></p>

        <!-- Compact TLD Badges -->
        <div class="mt-2 pt-2 border-t border-slate-100 dark:border-slate-800/80 flex flex-wrap items-center gap-1.5 text-xs">
          <span class="text-slate-400 text-[11px] mr-1">Popular:</span>
          @foreach($domains as $dom)
            @php
              $tldVal = is_object($dom) ? ($dom->tld ?? '') : (is_array($dom) ? ($dom['tld'] ?? '') : (string)$dom);
              $priceVal = is_object($dom) ? ($dom->price ?? 0) : (is_array($dom) ? ($dom['price'] ?? 0) : 0);
            @endphp
            @if(!empty($tldVal) && str_starts_with($tldVal, '.'))
            <button type="button" class="tld-pill px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:text-blue-500 text-[11px] transition-colors" data-tld="{{ $tldVal }}">
              <strong>{{ $tldVal }}</strong> <span class="text-slate-400">৳{{ number_format((float)$priceVal) }}</span>
            </button>
            @endif
          @endforeach
        </div>
      </div>

      <!-- Domain Simulation Results Container -->
      <div id="domain-results" class="hidden mt-4 bg-white dark:bg-[#07111F] border border-slate-200 dark:border-slate-800 rounded-xl p-4 shadow-sm animate-fadeIn">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 text-xs">
          <span class="font-semibold text-slate-900 dark:text-white">Domain Search Results</span>
          <span class="font-mono-code text-slate-400">Currency: BDT (৳)</span>
        </div>

        <div class="divide-y divide-slate-100 dark:divide-slate-800/80">
          @foreach($domains as $index => $dom)
            @php
              $tldVal = is_object($dom) ? ($dom->tld ?? '') : (is_array($dom) ? ($dom['tld'] ?? '') : (string)$dom);
              $priceVal = is_object($dom) ? ($dom->price ?? 0) : (is_array($dom) ? ($dom['price'] ?? 0) : 0);
            @endphp
            @if(!empty($tldVal) && str_starts_with($tldVal, '.'))
            <div class="py-2.5 flex items-center justify-between gap-3 text-xs {{ $index === 2 ? 'opacity-70' : '' }}">
              <div>
                <div class="font-bold text-slate-900 dark:text-white text-sm">
                  <span class="searched-domain-base">yourbrand</span>{{ $tldVal }}
                </div>
                @if($index === 2)
                  <span class="text-rose-500 font-medium">✕ Unavailable</span>
                @else
                  <span class="text-emerald-500 font-medium">✓ Available</span>
                @endif
              </div>
              <div class="flex items-center gap-3">
                @if($index === 2)
                  <span class="font-mono-code text-slate-400">Registered</span>
                @else
                  <span class="font-bold text-slate-900 dark:text-white">৳{{ number_format((float)$priceVal) }}/yr</span>
                  <button type="button" class="domain-cart-btn px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold transition-colors">
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

  @if(($settings['section_plans_enabled'] ?? '1') === '1')
  <!-- =========================================================================
       SECTION 3: HOSTING PLANS (Dynamic Categories)
       ========================================================================= -->
  <section id="hosting-plans" class="py-16 md:py-20 bg-white dark:bg-[#07111F] border-b border-slate-200 dark:border-slate-800/80">
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
        <div class="mt-6 inline-flex flex-wrap items-center justify-center p-1 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg gap-1" role="tablist">
          @foreach($categories as $index => $cat)
            @php
              $catSlug = is_object($cat) ? $cat->slug : ($cat['slug'] ?? 'shared');
              $catName = is_object($cat) ? $cat->name : ($cat['name'] ?? 'Shared');
            @endphp
            <button type="button" 
              class="hosting-tab-btn {{ $index === 0 ? 'active-tab bg-blue-600 text-white shadow-sm border-blue-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white border-transparent' }} px-3.5 py-1.5 rounded-md font-semibold text-xs border transition-colors" 
              data-category="{{ $catSlug }}" 
              role="tab" 
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
            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-700 peer-checked:bg-blue-600"></div>
          </label>
          <span class="billing-yearly-label text-slate-500 font-normal">Yearly <strong class="text-emerald-500 font-semibold">(Save 25%)</strong></span>
        </div>
      </div>

      <!-- Dynamic Category Panels -->
      @foreach($categories as $index => $cat)
        @php
          $catSlug = is_object($cat) ? $cat->slug : ($cat['slug'] ?? 'shared');
          $catName = is_object($cat) ? $cat->name : ($cat['name'] ?? 'Shared');
          $catPlans = $plans[$catSlug] ?? [];
        @endphp
        <div id="panel-{{ $catSlug }}" class="hosting-tab-panel {{ $index === 0 ? '' : 'hidden' }} grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
          @forelse($catPlans as $plan)
            <div class="minimal-card {{ $plan->is_popular ? 'relative bg-white dark:bg-[#0B1B33] border-2 border-blue-600 shadow-sm' : 'bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800' }} rounded-xl p-5 flex flex-col justify-between">
              @if($plan->badge)
                <div class="absolute -top-2.5 right-4 bg-blue-600 text-white font-mono-code text-[10px] font-bold uppercase py-0.5 px-2.5 rounded shadow-sm">
                  ★ {{ $plan->badge }}
                </div>
              @endif
              <div>
                <div class="text-[11px] font-mono-code {{ $plan->is_popular ? 'text-blue-600 dark:text-blue-400' : 'text-slate-400' }} uppercase">
                  {{ $plan->is_popular ? 'Featured Tier' : ($catName . ' Tier') }}
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-0.5">{{ $plan->name }}</h3>
                <p class="text-xs text-slate-500 mt-1">{{ $plan->tagline }}</p>

                <div class="my-4 py-3 border-y border-slate-100 dark:border-slate-800/80">
                  <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">
                      <span class="price-monthly">৳{{ number_format($plan->monthly_price) }}</span>
                      <span class="price-yearly hidden">৳{{ number_format($plan->yearly_price) }}</span>
                    </span>
                    <span class="price-period text-xs text-slate-400">/mo</span>
                  </div>
                </div>

                <ul class="space-y-2 text-xs {{ $plan->is_popular ? 'text-slate-700 dark:text-slate-200' : 'text-slate-600 dark:text-slate-300' }}">
                  @foreach($plan->features ?? [] as $featItem)
                    <li class="flex items-center gap-2">
                      <i class="fa-solid fa-check {{ $plan->is_popular ? 'text-blue-500' : 'text-emerald-500' }} text-[11px]"></i>
                      <span><strong>{{ $featItem }}</strong></span>
                    </li>
                  @endforeach
                </ul>
              </div>

              <div class="mt-6 pt-3 border-t border-slate-100 dark:border-slate-800/80 space-y-2">
                <a href="#checkout" class="w-full py-2 {{ $plan->is_popular ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-900 dark:text-white' }} font-semibold text-xs rounded-lg flex items-center justify-center transition-colors">
                  Deploy {{ $plan->name }}
                </a>
                <button type="button" class="view-plan-details-btn w-full text-center text-[11px] text-blue-600 dark:text-blue-400 hover:underline font-medium" data-plan-name="{{ $plan->name }}">
                  View Technical Specs
                </button>
              </div>
            </div>
          @empty
            <div class="col-span-3 text-center py-10 text-slate-400 text-xs">No {{ $catName }} packages available.</div>
          @endforelse
        </div>
      @endforeach

    </div>
  </section>
  @endif

  <!-- =========================================================================
       SECTION 4: TECHNICAL SPECIFICATIONS MODAL (Clean Minimal Table)
       ========================================================================= -->
  <div id="spec-modal" class="modal-closed fixed inset-0 z-50 bg-slate-950/75 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-plan-title">
    <div id="spec-modal-container" class="bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800 rounded-xl w-full max-w-3xl max-h-[85vh] flex flex-col shadow-2xl overflow-hidden text-xs">
      
      <!-- Modal Header -->
      <div class="px-5 py-3.5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-[#07111F]">
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-microchip text-blue-600"></i>
          <h3 id="modal-plan-title" class="font-bold text-sm text-slate-900 dark:text-white">
            Hosting Plan Specifications
          </h3>
        </div>
        <button type="button" id="spec-modal-close" class="text-slate-400 hover:text-slate-700 dark:hover:text-white focus:outline-none" aria-label="Close modal">
          <i class="fa-solid fa-xmark text-sm"></i>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="p-5 overflow-y-auto space-y-4">
        
        <div>
          <h4 class="font-mono-code font-bold uppercase text-[11px] text-blue-600 dark:text-blue-400 mb-2">Hardware & Compute Quotas</h4>
          <div class="table-responsive-wrapper border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
            <table class="w-full text-left">
              <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-600 dark:text-slate-300">
                <tr><td class="py-2 px-3 font-semibold text-slate-900 dark:text-white w-1/3">Processor</td><td class="py-2 px-3 font-mono-code">AMD EPYC™ 7763 / Intel Xeon Gold (3.4 GHz+)</td></tr>
                <tr><td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Storage</td><td class="py-2 px-3 font-mono-code">Enterprise NVMe Gen-4 U.2 RAID 10 (7,450 MB/s)</td></tr>
                <tr><td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Inodes Limit</td><td class="py-2 px-3 font-mono-code">500,000 to 1,500,000 Inodes</td></tr>
                <tr><td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">I/O Speed</td><td class="py-2 px-3 font-mono-code">100 MB/s Dedicated / 10,000 IOPS</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div>
          <h4 class="font-mono-code font-bold uppercase text-[11px] text-cyan-500 mb-2">Software Environment</h4>
          <div class="table-responsive-wrapper border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
            <table class="w-full text-left">
              <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-600 dark:text-slate-300">
                <tr><td class="py-2 px-3 font-semibold text-slate-900 dark:text-white w-1/3">Web Server</td><td class="py-2 px-3 font-mono-code">LiteSpeed Enterprise + HTTP/3 (QUIC)</td></tr>
                <tr><td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">PHP Engine</td><td class="py-2 px-3 font-mono-code">PHP 7.4 through 8.3 with OPcache</td></tr>
                <tr><td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Operating System</td><td class="py-2 px-3 font-mono-code">CloudLinux OS + CageFS Virtual Isolation</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div>
          <h4 class="font-mono-code font-bold uppercase text-[11px] text-emerald-500 mb-2">Security & Reliability</h4>
          <div class="table-responsive-wrapper border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
            <table class="w-full text-left">
              <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-600 dark:text-slate-300">
                <tr><td class="py-2 px-3 font-semibold text-slate-900 dark:text-white w-1/3">DDoS Protection</td><td class="py-2 px-3">100 Gbps real-time volumetric defense</td></tr>
                <tr><td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Malware Scanner</td><td class="py-2 px-3">Imunify360 AI proactive disinfection & WAF</td></tr>
                <tr><td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Backups</td><td class="py-2 px-3">Acronis Cyber Backup: Daily snapshots, 30-day retention</td></tr>
                <tr><td class="py-2 px-3 font-semibold text-slate-900 dark:text-white">Uptime Guarantee</td><td class="py-2 px-3 font-bold text-emerald-500">99.99% Hardware & Power Uptime SLA</td></tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="px-5 py-3 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#07111F] flex items-center justify-end gap-2">
        <button type="button" onclick="document.getElementById('spec-modal-close').click()" class="px-3 py-1.5 font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-md transition-colors">
          Close
        </button>
        <a href="#hosting-plans" onclick="document.getElementById('spec-modal-close').click()" class="px-3.5 py-1.5 font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors">
          Select Plan
        </a>
      </div>

    </div>
  </div>

  @if(($settings['section_features_enabled'] ?? '1') === '1')
  <!-- =========================================================================
       SECTION 5: FEATURES ("Everything your website needs" - Clean Bento Grid)
       ========================================================================= -->
  <section id="features" class="py-16 md:py-20 bg-slate-50 dark:bg-[#091526] border-b border-slate-200 dark:border-slate-800/80">
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
        @foreach($features as $feat)
          <div class="bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800 rounded-xl p-4 minimal-card">
            <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/80 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm mb-3">
              <i class="{{ $feat->icon }}"></i>
            </div>
            <div class="flex items-center justify-between gap-1.5">
              <h3 class="font-bold text-slate-900 dark:text-white text-sm">{{ $feat->title }}</h3>
              @if($feat->badge)
                <span class="text-[9px] font-mono uppercase px-1.5 py-0.2 rounded bg-blue-500/10 text-blue-500 shrink-0 font-bold">{{ $feat->badge }}</span>
              @endif
            </div>
            <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $feat->description }}</p>
            @if($feat->highlight_metric)
              <div class="mt-2.5 pt-2 border-t border-slate-100 dark:border-slate-800 text-[11px] font-mono text-cyan-500 font-semibold">
                {{ $feat->highlight_metric }}
              </div>
            @endif
          </div>
        @endforeach
      </div>

    </div>
  </section>
  @endif

  @if(($settings['section_infrastructure_enabled'] ?? '1') === '1')
  <!-- =========================================================================
       SECTION 6: WHY CHOOSE US (Sleek Split Layout)
       ========================================================================= -->
  <section id="why-us" class="py-16 md:py-20 bg-white dark:bg-[#07111F] border-b border-slate-200 dark:border-slate-800/80">
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
            <div class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
              <strong class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_1_title'] ?? 'Fast Infrastructure' }}</strong>
              <span class="text-slate-500">{{ $settings['why_choose_1_desc'] ?? 'Tier-IV facilities with dual redundant feeds.' }}</span>
            </div>
            <div class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
              <strong class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_2_title'] ?? 'Transparent Pricing' }}</strong>
              <span class="text-slate-500">{{ $settings['why_choose_2_desc'] ?? 'No surprise price spikes or hidden renewal fees.' }}</span>
            </div>
            <div class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
              <strong class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_3_title'] ?? 'Guaranteed Uptime' }}</strong>
              <span class="text-slate-500">{{ $settings['why_choose_3_desc'] ?? 'Hardware tenant isolation prevents neighbor lag.' }}</span>
            </div>
            <div class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
              <strong class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_4_title'] ?? 'Human Support' }}</strong>
              <span class="text-slate-500">{{ $settings['why_choose_4_desc'] ?? 'Direct chat with engineers who review error logs.' }}</span>
            </div>
            <div class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
              <strong class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_5_title'] ?? 'Easy Management' }}</strong>
              <span class="text-slate-500">{{ $settings['why_choose_5_desc'] ?? 'Official cPanel control with 1-click staging.' }}</span>
            </div>
            <div class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0B1B33]">
              <strong class="text-slate-900 dark:text-white block font-semibold">{{ $settings['why_choose_6_title'] ?? 'Secure Hosting' }}</strong>
              <span class="text-slate-500">{{ $settings['why_choose_6_desc'] ?? 'Imunify360 machine learning virus neutralization.' }}</span>
            </div>
          </div>
        </div>

        <!-- Right Column: Framed Datacenter Photo -->
        <div class="lg:col-span-6">
          <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-900 overflow-hidden relative shadow-md">
            <img 
              src="{{ $settings['why_choose_image'] ?? 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=800&q=80' }}" 
              alt="Engineers working in server facility" 
              class="w-full h-64 sm:h-72 object-cover opacity-80"
              loading="lazy"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-[#07111F] via-transparent to-transparent"></div>
            
            <div class="absolute bottom-3 inset-x-3 bg-slate-950/80 backdrop-blur-sm border border-slate-800 rounded-lg p-2.5 flex items-center justify-between text-xs font-mono-code text-white">
              <span><i class="fa-solid fa-circle-check text-emerald-400 mr-1"></i> {{ $settings['why_choose_badge_1'] ?? '99.99% Verified SLA' }}</span>
              <span><i class="fa-solid fa-network-wired text-blue-400 mr-1"></i> {{ $settings['why_choose_badge_2'] ?? '100 Gbps Core' }}</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
  @endif

  @if(($settings['section_promo_bar_enabled'] ?? '1') === '1')
  <!-- =========================================================================
       SECTION 7: OFFERS & PROMOTIONS (Minimalist Inline Promo Card)
       ========================================================================= -->
  <section id="offers" class="py-12 bg-slate-50 dark:bg-[#091526] border-b border-slate-200 dark:border-slate-800/80">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800 rounded-xl p-5 sm:p-6 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
        
        <div class="space-y-1.5 text-left">
          <div class="inline-flex items-center gap-1.5 text-[11px] font-mono-code text-amber-500 font-bold">
            <i class="fa-solid fa-tag"></i> LAUNCH PROMOTION
          </div>
          <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">
            {{ $settings['promo_title'] ?? '20% OFF your first year of hosting.' }}
          </h3>
          <p class="text-xs text-slate-500 dark:text-slate-400">
            Use promo code <code id="promo-code-val" class="font-mono font-bold text-blue-600 dark:text-blue-400">{{ $settings['promo_code'] ?? 'WELCOME20' }}</code> during checkout.
          </p>
        </div>

        <div class="flex items-center gap-3">
          <!-- Minimal Countdown Timer -->
          <div class="flex items-center gap-1.5 font-mono-code text-xs">
            <div class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-center">
              <span id="countdown-days" class="font-bold text-slate-900 dark:text-white">04</span><span class="text-[9px] text-slate-400 ml-0.5">d</span>
            </div>
            <div class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-center">
              <span id="countdown-hours" class="font-bold text-slate-900 dark:text-white">18</span><span class="text-[9px] text-slate-400 ml-0.5">h</span>
            </div>
            <div class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-center">
              <span id="countdown-mins" class="font-bold text-slate-900 dark:text-white">35</span><span class="text-[9px] text-slate-400 ml-0.5">m</span>
            </div>
            <div class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-center">
              <span id="countdown-secs" class="font-bold text-amber-500">52</span><span class="text-[9px] text-slate-400 ml-0.5">s</span>
            </div>
          </div>

          <button type="button" id="copy-promo-btn" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shrink-0 transition-colors">
            <i class="fa-regular fa-copy mr-1"></i> Copy Code
          </button>
        </div>

      </div>

    </div>
  </section>
  @endif

  @if(($settings['section_bundle_enabled'] ?? '1') === '1')
  <!-- =========================================================================
       SECTION 8: LAUNCH BUNDLE (Sleek All-In-One Stack)
       ========================================================================= -->
  <section id="bundle" class="py-16 md:py-20 bg-white dark:bg-[#07111F] border-b border-slate-200 dark:border-slate-800/80">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="border border-slate-200 dark:border-slate-800 rounded-xl p-6 sm:p-8 bg-slate-50 dark:bg-[#0B1B33]">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200 dark:border-slate-800">
          <div>
            <span class="text-[11px] font-mono-code font-bold uppercase text-blue-600 dark:text-blue-400">All-In-One Launch Stack</span>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white mt-0.5">
              {{ $settings['bundle_title'] ?? 'Everything you need to launch.' }}
            </h2>
          </div>
          <div class="text-left sm:text-right">
            <div class="text-xl font-extrabold text-slate-900 dark:text-white">৳{{ number_format((float) ($settings['bundle_price'] ?? 4990)) }}<span class="text-xs font-normal text-slate-500">/year</span></div>
            <span class="text-[11px] text-emerald-500 font-medium">Saves ৳{{ number_format((float) ($settings['bundle_savings'] ?? 2400)) }} bundled</span>
          </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-6 text-xs">
          <div class="space-y-1">
            <div class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5"><i class="fa-solid fa-globe text-blue-500"></i> 1 Domain</div>
            <p class="text-slate-500">.COM included with free privacy protection.</p>
          </div>
          <div class="space-y-1">
            <div class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5"><i class="fa-solid fa-server text-cyan-500"></i> 1 Year Hosting</div>
            <p class="text-slate-500">40 GB NVMe Gen-4 with LiteSpeed & cPanel.</p>
          </div>
          <div class="space-y-1">
            <div class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-emerald-500"></i> Free SSL</div>
            <p class="text-slate-500">Automated 256-bit wildcard encryption.</p>
          </div>
          <div class="space-y-1">
            <div class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5"><i class="fa-solid fa-envelope text-indigo-500"></i> Business Email</div>
            <p class="text-slate-500">Custom branded email inboxes with anti-spam.</p>
          </div>
        </div>

        <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex justify-end">
          <a href="#hosting-plans" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg transition-colors">
            Start Your Website <i class="fa-solid fa-arrow-right ml-1"></i>
          </a>
        </div>
      </div>

    </div>
  </section>
  @endif

  @if(($settings['section_testimonials_enabled'] ?? '1') === '1')
  <!-- =========================================================================
       SECTION 9: REVIEWS / TESTIMONIALS (Minimalist Hard-Coded Slider)
       ========================================================================= -->
  <section id="testimonials" class="py-16 md:py-20 bg-slate-50 dark:bg-[#091526] border-b border-slate-200 dark:border-slate-800/80">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
          Client Reviews
        </h2>
      </div>

      <div id="testimonial-slider-wrapper" class="bg-white dark:bg-[#0B1B33] border border-slate-200 dark:border-slate-800 rounded-xl p-6 shadow-sm min-h-[220px] flex flex-col justify-between">
        
        <div id="testimonial-track">
          @foreach($testimonials as $rev)
            <div class="testimonial-slide {{ $loop->first ? '' : 'hidden opacity-0' }}">
              <div class="flex items-center gap-1 text-amber-400 text-xs mb-3">
                @for($i = 1; $i <= 5; $i++)
                  <i class="fa-solid fa-star {{ $i <= $rev->rating ? 'text-amber-400' : 'text-slate-300 dark:text-slate-700' }}"></i>
                @endfor
              </div>
              <blockquote class="text-sm sm:text-base font-medium text-slate-800 dark:text-slate-200 leading-relaxed italic">
                "{{ $rev->review_text }}"
              </blockquote>
              <div class="mt-4 flex items-center gap-3">
                <img src="{{ $rev->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" alt="{{ $rev->client_name }}" class="w-9 h-9 rounded-full object-cover">
                <div>
                  <div class="font-bold text-xs text-slate-900 dark:text-white">{{ $rev->client_name }}</div>
                  <div class="text-[11px] text-slate-400">{{ $rev->role }} @if($rev->company) · {{ $rev->company }} @endif</div>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="mt-5 pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
          <div id="testimonial-dots" class="flex items-center gap-1.5"></div>
          <div class="flex items-center gap-1.5">
            <button type="button" id="testimonial-prev" class="w-7 h-7 rounded border border-slate-200 dark:border-slate-800 text-slate-500 hover:text-blue-500 flex items-center justify-center text-xs" aria-label="Previous review">
              <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button type="button" id="testimonial-next" class="w-7 h-7 rounded border border-slate-200 dark:border-slate-800 text-slate-500 hover:text-blue-500 flex items-center justify-center text-xs" aria-label="Next review">
              <i class="fa-solid fa-chevron-right"></i>
            </button>
          </div>
        </div>

      </div>

    </div>
  </section>
  @endif

  @if(($settings['section_faq_enabled'] ?? '1') === '1')
  <!-- =========================================================================
       SECTION 10: FAQ ACCORDION (12 Questions, Single Item Open, Minimal Styling)
       ========================================================================= -->
  <section id="faq" class="py-16 md:py-20 bg-white dark:bg-[#07111F] border-b border-slate-200 dark:border-slate-800/80">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
          Frequently Asked Questions
        </h2>
      </div>

      <div class="space-y-2 text-xs sm:text-sm">
        
        @forelse($faqs as $faq)
          <div class="accordion-item {{ $loop->first ? 'active' : '' }} border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden bg-white dark:bg-[#0B1B33]">
            <button type="button" class="accordion-trigger w-full px-4 py-3 text-left flex items-center justify-between gap-3 focus:outline-none font-semibold text-slate-900 dark:text-white" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
              <span>{{ $faq->question }}</span>
              <i class="accordion-icon fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"></i>
            </button>
            <div class="accordion-content px-4 pb-3 text-slate-600 dark:text-slate-300 leading-relaxed text-xs">
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

  @if(($settings['section_cta_enabled'] ?? '1') === '1')
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
        <a href="#hosting-plans" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg transition-colors">
          View Hosting Plans
        </a>
        <a href="#domain-search" class="px-5 py-2 bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 font-semibold text-xs rounded-lg transition-colors">
          Search Domain
        </a>
      </div>
    </div>
  </section>
  @endif

  <!-- =========================================================================
       SECTION 13: PAYMENT METHODS ("We Accept")
       ========================================================================= -->


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
            @foreach($categories as $cat)
              @php
                $catName = is_object($cat) ? $cat->name : ($cat['name'] ?? 'Shared');
              @endphp
              <li><a href="#hosting-plans" class="hover:text-blue-500">{{ $catName }}</a></li>
            @endforeach
          </ul>
        </div>
        @endif

        @if(($settings['section_domain_enabled'] ?? '1') === '1')
        <div class="space-y-2 text-left">
          <h4 class="font-semibold text-slate-900 dark:text-white text-xs">Domains</h4>
          <ul class="space-y-1.5 text-[11px]">
            <li><a href="#domain-search" class="hover:text-blue-500">Search Domain</a></li>
            <li><a href="#domain-search" class="hover:text-blue-500">Domain Pricing</a></li>
            <li><a href="#domain-search" class="hover:text-blue-500">Domain Transfer</a></li>
            <li><a href="#domain-search" class="hover:text-blue-500">WHOIS Lookup</a></li>
          </ul>
        </div>
        @endif

        <div class="space-y-2 text-left">
          <h4 class="font-semibold text-slate-900 dark:text-white text-xs">Support</h4>
          <ul class="space-y-1.5 text-[11px]">
            @if(($settings['section_faq_enabled'] ?? '1') === '1')
            <li><a href="#faq" class="hover:text-blue-500">Help Center</a></li>
            <li><a href="#faq" class="hover:text-blue-500">FAQ</a></li>
            @endif
            @if(($settings['section_hero_enabled'] ?? '1') === '1')
            <li><a href="#hero" class="hover:text-blue-500">Server Status</a></li>
            @endif
            @if(($settings['section_features_enabled'] ?? '1') === '1')
            <li><a href="#features" class="hover:text-blue-500">Free Migration</a></li>
            @endif
          </ul>
        </div>

        <div class="space-y-2 text-left">
          <h4 class="font-semibold text-slate-900 dark:text-white text-xs">Legal</h4>
          <ul class="space-y-1.5 text-[11px]">
            <li><a href="#legal" class="hover:text-blue-500">Terms of Service</a></li>
            <li><a href="#legal" class="hover:text-blue-500">Privacy Policy</a></li>
            <li><a href="#legal" class="hover:text-blue-500">Refund Policy</a></li>
            <li><a href="#legal" class="hover:text-blue-500">Acceptable Use</a></li>
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
</body>
</html>
