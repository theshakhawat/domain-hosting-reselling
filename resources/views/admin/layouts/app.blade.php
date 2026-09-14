<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard') — NEXUSHOST Control Center</title>

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
          }
        }
      }
    }
  </script>

  <!-- Font Awesome Icons CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

  <!-- Alpine.js CDN -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    /* Custom scrollbar for clean dashboard look */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: transparent;
    }
    ::-webkit-scrollbar-thumb {
      background: rgba(100, 116, 139, 0.25);
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: rgba(100, 116, 139, 0.45);
    }
  </style>
  @stack('styles')
</head>
<body class="h-full bg-slate-100 dark:bg-brand-navy text-slate-800 dark:text-slate-100 flex overflow-hidden transition-colors duration-200">

  <!-- Mobile Sidebar Backdrop -->
  <div id="sidebarBackdrop" onclick="toggleSidebar(false)" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

  <!-- Left Sidebar Navigation -->
  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-brand-dark border-r border-slate-200 dark:border-brand-slate/40 flex flex-col transition-transform duration-200 -translate-x-full md:translate-x-0 md:static md:z-auto">
    <!-- Brand Logo -->
    <div class="h-16 px-6 flex items-center justify-between border-b border-slate-200 dark:border-brand-slate/40">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-brand-accent to-brand-cyan flex items-center justify-center text-white shadow-md shadow-brand-accent/20">
          <i class="fa-solid fa-server text-sm"></i>
        </div>
        <div>
          <span class="text-base font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-1">
            NEXUS<span class="text-brand-accent">HOST</span>
          </span>
          <span class="block text-[9px] font-mono uppercase tracking-widest text-slate-500 dark:text-slate-400">Admin Control</span>
        </div>
      </a>
      <button onclick="toggleSidebar(false)" class="md:hidden text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
        <i class="fa-solid fa-xmark text-lg"></i>
      </button>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
      <div class="px-3 py-1.5 text-[10px] font-mono uppercase tracking-wider text-slate-400 dark:text-slate-500 font-semibold">
        Management
      </div>

      <!-- Dashboard -->
      <a href="{{ route('admin.dashboard') }}"
        class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand-accent text-white shadow-sm shadow-brand-accent/30' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-card hover:text-brand-accent dark:hover:text-white' }}">
        <i class="fa-solid fa-gauge-high w-4 text-center"></i>
        <span>Dashboard</span>
      </a>

      <!-- Hosting Plans -->
      <a href="{{ route('admin.plans.index') }}"
        class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.plans.*') ? 'bg-brand-accent text-white shadow-sm shadow-brand-accent/30' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-card hover:text-brand-accent dark:hover:text-white' }}">
        <i class="fa-solid fa-microchip w-4 text-center"></i>
        <span>Hosting Plans</span>
      </a>

      <!-- Domain Pricing -->
      <a href="{{ route('admin.domains.index') }}"
        class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.domains.*') ? 'bg-brand-accent text-white shadow-sm shadow-brand-accent/30' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-card hover:text-brand-accent dark:hover:text-white' }}">
        <i class="fa-solid fa-globe w-4 text-center"></i>
        <span>Domain TLDs</span>
      </a>

      <!-- Core Features -->
      <a href="{{ route('admin.features.index') }}"
        class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.features.*') ? 'bg-brand-accent text-white shadow-sm shadow-brand-accent/30' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-card hover:text-brand-accent dark:hover:text-white' }}">
        <i class="fa-solid fa-bolt w-4 text-center"></i>
        <span>Core Features</span>
      </a>

      <!-- Testimonials -->
      <a href="{{ route('admin.testimonials.index') }}"
        class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.testimonials.*') ? 'bg-brand-accent text-white shadow-sm shadow-brand-accent/30' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-card hover:text-brand-accent dark:hover:text-white' }}">
        <i class="fa-solid fa-comments w-4 text-center"></i>
        <span>Client Reviews</span>
      </a>

      <!-- FAQs -->
      <a href="{{ route('admin.faqs.index') }}"
        class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.faqs.*') ? 'bg-brand-accent text-white shadow-sm shadow-brand-accent/30' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-card hover:text-brand-accent dark:hover:text-white' }}">
        <i class="fa-solid fa-circle-question w-4 text-center"></i>
        <span>FAQ Accordion</span>
      </a>

      <!-- Support Inquiries & Tickets -->
      <a href="{{ route('admin.contacts.index') }}"
        class="flex items-center justify-between px-3 py-2 text-xs font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.contacts.*') ? 'bg-brand-accent text-white shadow-sm shadow-brand-accent/30' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-card hover:text-brand-accent dark:hover:text-white' }}">
        <div class="flex items-center gap-3">
          <i class="fa-solid fa-headset w-4 text-center"></i>
          <span>Support Inquiries</span>
        </div>
        @if(($unreadContactsCount ?? 0) > 0)
          <span class="px-1.5 py-0.2 rounded-full text-[10px] font-mono font-bold bg-rose-500 text-white">
            {{ $unreadContactsCount }}
          </span>
        @endif
      </a>

      <div class="pt-4 px-3 py-1.5 text-[10px] font-mono uppercase tracking-wider text-slate-400 dark:text-slate-500 font-semibold">
        Configuration
      </div>

      <!-- Site Settings -->
      <a href="{{ route('admin.settings.index') }}"
        class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-brand-accent text-white shadow-sm shadow-brand-accent/30' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-card hover:text-brand-accent dark:hover:text-white' }}">
        <i class="fa-solid fa-sliders w-4 text-center"></i>
        <span>Site & Promo Settings</span>
      </a>

      <!-- Visitors & Analytics -->
      <a href="{{ route('admin.visitors.index') }}"
        class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.visitors.*') ? 'bg-brand-accent text-white shadow-sm shadow-brand-accent/30' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-card hover:text-brand-accent dark:hover:text-white' }}">
        <i class="fa-solid fa-chart-line w-4 text-center"></i>
        <span>Visitors & Analytics</span>
      </a>

      <!-- Notifications -->
      <a href="{{ route('admin.notifications.index') }}"
        class="flex items-center justify-between px-3 py-2 text-xs font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.notifications.*') ? 'bg-brand-accent text-white shadow-sm shadow-brand-accent/30' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-card hover:text-brand-accent dark:hover:text-white' }}">
        <div class="flex items-center gap-3">
          <i class="fa-regular fa-bell w-4 text-center"></i>
          <span>Notifications</span>
        </div>
        @if(($unreadNotificationsCount ?? 0) > 0)
          <span class="px-1.5 py-0.2 rounded-full text-[10px] font-mono font-bold bg-amber-500 text-white">
            {{ $unreadNotificationsCount }}
          </span>
        @endif
      </a>

      <!-- Admin Profile -->
      <a href="{{ route('admin.profile.edit') }}"
        class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-brand-accent text-white shadow-sm shadow-brand-accent/30' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-card hover:text-brand-accent dark:hover:text-white' }}">
        <i class="fa-solid fa-user-gear w-4 text-center"></i>
        <span>Admin Profile</span>
      </a>
    </div>

    <!-- Live Website Link & Version Footer -->
    <div class="p-3 border-t border-slate-200 dark:border-brand-slate/40 bg-slate-50 dark:bg-brand-card/40">
      <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium text-slate-600 dark:text-slate-300 hover:text-brand-accent dark:hover:text-brand-cyan hover:bg-white dark:hover:bg-brand-card transition-all group">
        <span class="flex items-center gap-2">
          <i class="fa-solid fa-arrow-up-right-from-square text-xs text-brand-accent"></i>
          <span>View Live Website</span>
        </span>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 group-hover:translate-x-0.5 transition-transform"></i>
      </a>
      <div class="mt-2 px-3 flex items-center justify-between text-[10px] font-mono text-slate-400 dark:text-slate-500">
        <span>Laravel v13.x</span>
        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> PHP 8.5</span>
      </div>
    </div>
  </aside>

  <!-- Main Container -->
  <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

    <!-- Top Navigation Bar -->
    <header class="h-16 bg-white dark:bg-brand-dark border-b border-slate-200 dark:border-brand-slate/40 flex items-center justify-between px-4 sm:px-6 z-30 transition-colors">
      <div class="flex items-center gap-4 flex-1">
        <!-- Mobile Sidebar Toggle -->
        <button type="button" onclick="toggleSidebar(true)" class="md:hidden text-slate-500 hover:text-slate-700 dark:text-slate-300 dark:hover:text-white focus:outline-none">
          <i class="fa-solid fa-bars-staggered text-lg"></i>
        </button>

        <!-- Global Quick Search with Command Palette Suggestions -->
        <div class="relative w-72 max-w-md hidden sm:block">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
            <i class="fa-solid fa-magnifying-glass text-xs"></i>
          </div>
          <input type="text" id="globalSearchInput" placeholder="Search settings, footer, header, plans..." 
            onfocus="showSearchSuggestions(true)"
            oninput="handleSearchInput(this.value); if(typeof filterAdminContent === 'function') filterAdminContent(this.value);"
            autocomplete="off"
            class="block w-full pl-9 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 dark:border-brand-slate/50 bg-slate-50 dark:bg-brand-card text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-colors">

          <!-- Spotlight Search Suggestions Dropdown -->
          <div id="searchSuggestionsDropdown" class="hidden absolute left-0 right-0 mt-2 w-96 rounded-xl bg-white dark:bg-brand-card border border-slate-200 dark:border-brand-slate/60 shadow-2xl py-2 z-50 animate-fadeIn max-h-96 overflow-y-auto">
            <div class="px-3 py-1.5 text-[10px] font-mono uppercase tracking-wider text-slate-400 dark:text-slate-500 font-semibold border-b border-slate-100 dark:border-brand-slate/40 flex items-center justify-between">
              <span>Quick Navigation & Settings</span>
              <span class="text-[9px]">ESC to close</span>
            </div>
            <div id="suggestionsList" class="p-1 space-y-0.5 text-xs">
              <!-- Links dynamically filtered via JS -->
            </div>
          </div>
        </div>
      </div>

      <!-- Right Header Actions -->
      <div class="flex items-center gap-2 sm:gap-3">

        <!-- Theme Switcher Button -->
        <button type="button" onclick="toggleTheme()" class="w-9 h-9 rounded-lg border border-slate-200 dark:border-brand-slate/50 bg-slate-50 dark:bg-brand-card text-slate-500 dark:text-slate-400 hover:text-brand-accent dark:hover:text-brand-cyan flex items-center justify-center transition-colors focus:outline-none" title="Toggle Dark/Light Mode">
          <i id="themeToggleIcon" class="fa-solid fa-moon text-xs"></i>
        </button>

        <!-- System Quick Refresh (View, Cache, Storage) -->
        <form action="{{ route('admin.system.refresh') }}" method="POST" class="inline m-0 p-0">
          @csrf
          <button type="submit" class="w-9 h-9 rounded-lg border border-slate-200 dark:border-brand-slate/50 bg-slate-50 dark:bg-brand-card text-slate-500 dark:text-slate-400 hover:text-emerald-500 dark:hover:text-emerald-400 hover:border-emerald-500/50 flex items-center justify-center transition-all group focus:outline-none" title="Clear View, Cache, Optimize & Link Storage">
            <i class="fa-solid fa-arrows-rotate text-xs group-hover:rotate-180 transition-transform duration-500"></i>
          </button>
        </form>

        <!-- Notification Bell with Dropdown -->
        <div class="relative">
          <button type="button" onclick="toggleDropdown('notificationDropdown')" class="w-9 h-9 rounded-lg border border-slate-200 dark:border-brand-slate/50 bg-slate-50 dark:bg-brand-card text-slate-500 dark:text-slate-400 hover:text-brand-accent dark:hover:text-brand-cyan flex items-center justify-center transition-colors focus:outline-none relative" title="Notifications">
            <i class="fa-regular fa-bell text-xs"></i>
            @if(($unreadNotificationsCount ?? 0) > 0)
              <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white dark:ring-brand-dark animate-pulse"></span>
            @endif
          </button>

          <!-- Notification Dropdown Menu -->
          <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 rounded-xl bg-white dark:bg-brand-card border border-slate-200 dark:border-brand-slate/50 shadow-2xl py-2 z-50 animate-fadeIn">
            <div class="px-4 py-2 border-b border-slate-100 dark:border-brand-slate/40 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-900 dark:text-white">Notifications</span>
                @if(($unreadNotificationsCount ?? 0) > 0)
                  <span class="text-[10px] font-mono text-rose-500 bg-rose-500/10 px-1.5 py-0.5 rounded font-semibold">{{ $unreadNotificationsCount }} New</span>
                @else
                  <span class="text-[10px] font-mono text-emerald-500 bg-emerald-500/10 px-1.5 py-0.5 rounded">All Clear</span>
                @endif
              </div>
              @if(($unreadNotificationsCount ?? 0) > 0)
                <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="inline m-0 p-0">
                  @csrf
                  <button type="submit" class="text-[10px] text-brand-accent hover:underline font-semibold">Mark read</button>
                </form>
              @endif
            </div>

            <div class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-xs max-h-72 overflow-y-auto">
              @forelse($recentAdminNotifications ?? [] as $notif)
                <a href="{{ $notif->link ? route('admin.notifications.read', $notif) : route('admin.notifications.index') }}" class="block px-4 py-2.5 hover:bg-slate-50 dark:hover:bg-brand-dark/40 transition-colors {{ $notif->is_read ? 'opacity-70' : 'bg-blue-500/5' }}">
                <a href="{{ route('admin.notifications.read', $notif) }}" class="block px-4 py-2.5 hover:bg-slate-50 dark:hover:bg-brand-dark/40 transition-colors {{ $notif->is_read ? 'opacity-70' : 'bg-blue-500/5' }}">
                  <div class="flex items-start justify-between gap-2">
                    <p class="font-semibold text-slate-800 dark:text-slate-200 truncate">{{ $notif->title }}</p>
                    <span class="text-[10px] text-slate-400 font-mono shrink-0">{{ $notif->created_at->diffForHumans(null, true) }}</span>
                  </div>
                  <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2 mt-0.5">{{ $notif->message }}</p>
                </a>
              @empty
                <div class="px-4 py-6 text-center text-slate-400 text-xs">
                  <i class="fa-regular fa-bell-slash text-base mb-1 block opacity-50"></i>
                  No new notifications.
                </div>
              @endforelse
            </div>

            <div class="px-4 pt-2 pb-1 border-t border-slate-100 dark:border-brand-slate/40 text-center">
              <a href="{{ route('admin.notifications.index') }}" class="text-[11px] text-brand-accent hover:underline font-semibold flex items-center justify-center gap-1">
                <span>View All Notifications</span>
                <i class="fa-solid fa-arrow-right text-[9px]"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Vertical Divider -->
        <div class="h-6 w-px bg-slate-200 dark:bg-brand-slate/40 mx-1"></div>

        <!-- User Profile Dropdown -->
        <div class="relative">
          <button type="button" onclick="toggleDropdown('userMenuDropdown')" class="flex items-center gap-2.5 p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-brand-card transition-colors focus:outline-none">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-sm overflow-hidden shrink-0">
              @if(Auth::user()->profile_picture && \Illuminate\Support\Facades\Storage::disk('public')->exists(Auth::user()->profile_picture))
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
              @else
                {{ strtoupper(substr(Auth::user()->name ?? 'Admin', 0, 1)) }}
              @endif
            </div>
            <div class="hidden sm:block text-left">
              <span class="block text-xs font-semibold text-slate-800 dark:text-slate-200 leading-tight">{{ Auth::user()->name ?? 'System Admin' }}</span>
              <span class="block text-[10px] text-slate-400 font-mono leading-none">Super Administrator</span>
            </div>
            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
          </button>

          <!-- Dropdown Menu -->
          <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-52 rounded-xl bg-white dark:bg-brand-card border border-slate-200 dark:border-brand-slate/50 shadow-xl py-1.5 z-50 animate-fadeIn">
            <div class="px-4 py-2 border-b border-slate-100 dark:border-brand-slate/40">
              <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
              <p class="text-[11px] text-slate-500 dark:text-slate-400 font-mono truncate">{{ Auth::user()->email ?? 'admin@nexus.com' }}</p>
            </div>

            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-brand-dark/50 hover:text-brand-accent transition-colors">
              <i class="fa-solid fa-user-gear text-xs w-4"></i>
              <span>My Profile & Security</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-brand-dark/50 hover:text-brand-accent transition-colors">
              <i class="fa-solid fa-sliders text-xs w-4"></i>
              <span>System Settings</span>
            </a>

            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-brand-dark/50 hover:text-brand-accent transition-colors">
              <i class="fa-solid fa-globe text-xs w-4"></i>
              <span>Open Website</span>
            </a>

            <div class="my-1 border-t border-slate-100 dark:border-brand-slate/40"></div>

            <form action="{{ route('admin.logout') }}" method="POST">
              @csrf
              <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors text-left font-medium">
                <i class="fa-solid fa-arrow-right-from-bracket text-xs w-4"></i>
                <span>Log Out</span>
              </button>
            </form>
          </div>
        </div>

      </div>
    </header>

    <!-- Main Body Area -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6">

      <!-- Flash Notifications -->
      @if (session('success'))
        <div class="rounded-xl bg-emerald-500/10 border border-emerald-500/30 p-4 flex items-center justify-between text-emerald-600 dark:text-emerald-400 text-xs font-medium animate-fadeIn">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
            <span>{{ session('success') }}</span>
          </div>
          <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 focus:outline-none">
            <i class="fa-solid fa-xmark text-sm"></i>
          </button>
        </div>
      @endif

      @if (session('error'))
        <div class="rounded-xl bg-rose-500/10 border border-rose-500/30 p-4 flex items-center justify-between text-rose-600 dark:text-rose-400 text-xs font-medium animate-fadeIn">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation text-rose-500 text-base"></i>
            <span>{{ session('error') }}</span>
          </div>
          <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600 focus:outline-none">
            <i class="fa-solid fa-xmark text-sm"></i>
          </button>
        </div>
      @endif

      <!-- Page Content Slot -->
      @yield('content')
    </main>

  </div>

  <!-- Shared Global JS for Layout -->
  <script>
    // Sidebar Mobile Toggle
    function toggleSidebar(open) {
      const sidebar = document.getElementById('sidebar');
      const backdrop = document.getElementById('sidebarBackdrop');
      if (open) {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
      } else {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
      }
    }

    // Dropdowns
    function toggleDropdown(id) {
      const dropdown = document.getElementById(id);
      const isHidden = dropdown.classList.contains('hidden');
      // close other dropdowns first
      document.querySelectorAll('#notificationDropdown, #userMenuDropdown').forEach(el => el.classList.add('hidden'));
      if (isHidden) {
        dropdown.classList.remove('hidden');
      }
    }

    // Close dropdowns on outside click
    document.addEventListener('click', (e) => {
      if (!e.target.closest('#notificationDropdown') && !e.target.closest('button[onclick*="notificationDropdown"]')) {
        document.getElementById('notificationDropdown')?.classList.add('hidden');
      }
      if (!e.target.closest('#userMenuDropdown') && !e.target.closest('button[onclick*="userMenuDropdown"]')) {
        document.getElementById('userMenuDropdown')?.classList.add('hidden');
      }
    });

    // Theme Toggle
    function toggleTheme() {
      const isDark = document.documentElement.classList.toggle('dark');
      localStorage.setItem('hosting_theme', isDark ? 'dark' : 'light');
      updateThemeIcon(isDark);
    }

    function updateThemeIcon(isDark) {
      const icon = document.getElementById('themeToggleIcon');
      if (icon) {
        icon.className = isDark ? 'fa-solid fa-sun text-xs text-amber-400' : 'fa-solid fa-moon text-xs text-slate-600';
      }
    }

    // Filter content on page if table or cards present
    function filterAdminContent(query) {
      const filter = query.toLowerCase();
      const rows = document.querySelectorAll('tbody tr, .filterable-card');
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
      });
    }

    // Search Suggestions Navigation Items
    const searchNavItems = [
      { title: 'Footer Settings', subtitle: 'Company bio, address, copyright, social icons & certification', url: '{{ route('admin.settings.index') }}#footer', category: 'Settings', icon: 'fa-solid fa-shoe-prints' },
      { title: 'Header Settings', subtitle: 'Announcement bar, support phone/email, header CTA button', url: '{{ route('admin.settings.index') }}#header', category: 'Settings', icon: 'fa-solid fa-heading' },
      { title: 'Section Visibility Manager', subtitle: 'Activate or deactivate any of the 10 homepage sections', url: '{{ route('admin.settings.index') }}#sections', category: 'Settings', icon: 'fa-solid fa-toggle-on' },
      { title: 'Site Branding & Hero', subtitle: 'Site name, hero headline, subtitle, service status indicator', url: '{{ route('admin.settings.index') }}#general', category: 'Settings', icon: 'fa-solid fa-wand-magic-sparkles' },
      { title: 'Why Choose Us / Infrastructure', subtitle: 'Headline, datacenter image, badges, and 6 benefit cards', url: '{{ route('admin.settings.index') }}#whyus', category: 'Settings', icon: 'fa-solid fa-server' },
      { title: 'Promo & Launch Bundle', subtitle: 'Coupon code, discount %, promotional banner & bundle pack', url: '{{ route('admin.settings.index') }}#promo', category: 'Settings', icon: 'fa-solid fa-tag' },
      { title: 'Hosting Plans', subtitle: 'Manage Shared, Cloud, VPS & BDIX packages, specs & pricing', url: '{{ route('admin.plans.index') }}', category: 'Management', icon: 'fa-solid fa-microchip' },
      { title: 'Add New Hosting Plan', subtitle: 'Create a new hosting package with pricing and features', url: '{{ route('admin.plans.create') }}', category: 'Management', icon: 'fa-solid fa-plus-circle' },
      { title: 'Domain TLD Pricing', subtitle: 'Configure domain extension prices, renewals and offer badges', url: '{{ route('admin.domains.index') }}', category: 'Management', icon: 'fa-solid fa-globe' },
      { title: 'Core Features & Specs', subtitle: 'Update infrastructure features, hardware specs and turbo badges', url: '{{ route('admin.features.index') }}', category: 'Management', icon: 'fa-solid fa-bolt' },
      { title: 'Client Reviews & Testimonials', subtitle: 'Manage client feedback, ratings, companies and display status', url: '{{ route('admin.testimonials.index') }}', category: 'Management', icon: 'fa-solid fa-comments' },
      { title: 'Support Inquiries & Tickets', subtitle: 'View client contact submissions, problem descriptions & screenshots', url: '{{ route('admin.contacts.index') }}', category: 'Support', icon: 'fa-solid fa-headset' },
      { title: 'System & Admin Notifications', subtitle: 'Event alerts, contact inquiries & unread system notices', url: '{{ route('admin.notifications.index') }}', category: 'Support', icon: 'fa-solid fa-bell' },
      { title: 'Visitors & Analytics', subtitle: 'Real-time IP, ISP, country, device, screen resolution & charts', url: '{{ route('admin.visitors.index') }}', category: 'Analytics', icon: 'fa-solid fa-chart-line' },
      { title: 'Admin Profile & Security', subtitle: 'Change name, email, contact phone, avatar & password', url: '{{ route('admin.profile.edit') }}', category: 'Account', icon: 'fa-solid fa-user-gear' },
    ];

    function showSearchSuggestions(show) {
      const dropdown = document.getElementById('searchSuggestionsDropdown');
      if (!dropdown) return;
      if (show) {
        dropdown.classList.remove('hidden');
        renderSuggestions(document.getElementById('globalSearchInput')?.value || '');
      } else {
        dropdown.classList.add('hidden');
      }
    }

    function handleSearchInput(query) {
      showSearchSuggestions(true);
      renderSuggestions(query);
      filterAdminContent(query);
    }

    function renderSuggestions(query) {
      const list = document.getElementById('suggestionsList');
      if (!list) return;
      const clean = query.trim().toLowerCase();
      const filtered = clean === '' 
        ? searchNavItems 
        : searchNavItems.filter(item => 
            item.title.toLowerCase().includes(clean) || 
            item.subtitle.toLowerCase().includes(clean) || 
            item.category.toLowerCase().includes(clean)
          );

      if (filtered.length === 0) {
        list.innerHTML = `<div class="px-3 py-4 text-center text-slate-400 text-xs">No settings found matching "${query}".</div>`;
        return;
      }

      list.innerHTML = filtered.map(item => `
        <a href="${item.url}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-brand-dark/70 text-slate-700 dark:text-slate-200 transition-colors group">
          <div class="flex items-center gap-3 min-w-0">
            <div class="w-7 h-7 rounded-md bg-slate-100 dark:bg-brand-dark flex items-center justify-center text-brand-accent group-hover:bg-brand-accent group-hover:text-white transition-colors shrink-0">
              <i class="${item.icon} text-xs"></i>
            </div>
            <div class="truncate">
              <div class="font-semibold text-xs text-slate-900 dark:text-white group-hover:text-brand-accent transition-colors flex items-center gap-2">
                <span>${item.title}</span>
                <span class="text-[9px] font-mono uppercase px-1.5 py-0.2 rounded bg-slate-200/60 dark:bg-brand-dark text-slate-500 dark:text-slate-400">${item.category}</span>
              </div>
              <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate">${item.subtitle}</div>
            </div>
          </div>
          <i class="fa-solid fa-arrow-right text-[10px] text-slate-400 group-hover:text-brand-accent group-hover:translate-x-0.5 transition-all shrink-0 ml-2"></i>
        </a>
      `).join('');
    }

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        showSearchSuggestions(false);
      }
    });

    document.addEventListener('click', (e) => {
      if (!e.target.closest('#globalSearchInput') && !e.target.closest('#searchSuggestionsDropdown')) {
        showSearchSuggestions(false);
      }
    });

    document.addEventListener('DOMContentLoaded', () => {
      updateThemeIcon(document.documentElement.classList.contains('dark'));
    });
  </script>
  @stack('scripts')
</body>
</html>

