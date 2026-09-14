@php
    try {
        $siteName = \App\Models\SiteSetting::get('site_name', 'NEXUSHOST');
        $footerCopyright = \App\Models\SiteSetting::get('footer_copyright', '© ' . date('Y') . ' NEXUSHOST Cloud Infrastructure Ltd. All rights reserved.');
    } catch (\Throwable $e) {
        $siteName = 'NEXUSHOST';
        $footerCopyright = '© ' . date('Y') . ' NEXUSHOST Cloud Infrastructure Ltd. All rights reserved.';
    }
@endphp
<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Error') — {{ $siteName }}</title>
  <meta name="description" content="@yield('meta_description', 'An error occurred while processing your request.')">

  <!-- Anti-Flash Dark/Light Mode Script -->
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
            mono: ['JetBrains Mono', 'Fira Code', 'monospace']
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

  <!-- Font Awesome & Google Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Inter', sans-serif; }
    .font-mono-code { font-family: 'JetBrains Mono', monospace; }
    .bg-grid-pattern {
      background-size: 32px 32px;
      background-image: 
        linear-gradient(to right, rgba(148, 163, 184, 0.05) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(148, 163, 184, 0.05) 1px, transparent 1px);
    }
    .dark .bg-grid-pattern {
      background-image: 
        linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
    }
    .glow-blob {
      filter: blur(80px);
      pointer-events: none;
    }
  </style>
</head>
<body class="bg-[#F8FAFC] dark:bg-[#07111F] text-slate-800 dark:text-slate-100 min-h-full flex flex-col antialiased transition-colors duration-200 relative overflow-x-hidden selection:bg-blue-500 selection:text-white">

  <!-- Ambient Glow Backgrounds -->
  <div class="fixed inset-0 bg-grid-pattern pointer-events-none z-0"></div>
  <div class="fixed top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[350px] @yield('glow_color', 'bg-blue-600/10 dark:bg-blue-500/10') rounded-full glow-blob z-0"></div>

  <!-- Header Navigation -->
  <header class="sticky top-0 z-40 bg-white/85 dark:bg-[#07111F]/85 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-14 sm:h-16">
        
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
          <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white text-sm shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform">
            <i class="fa-solid fa-server"></i>
          </div>
          <span class="font-bold text-slate-900 dark:text-white text-base tracking-tight">
            {{ $siteName }}
          </span>
        </a>

        <!-- Middle Quick Navigation -->
        <nav class="hidden md:flex items-center gap-1.5 text-xs font-semibold text-slate-600 dark:text-slate-300">
          <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-house-chimney mr-1 text-slate-400"></i> Home
          </a>
          <a href="{{ route('home') }}#hosting-plans" class="px-3 py-1.5 rounded-lg hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-layer-group mr-1 text-slate-400"></i> Plans
          </a>
          <a href="{{ route('home') }}#domain-search" class="px-3 py-1.5 rounded-lg hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-globe mr-1 text-slate-400"></i> Domains
          </a>
          <a href="{{ route('contact.show') }}" class="px-3 py-1.5 rounded-lg hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-headset mr-1 text-slate-400"></i> Support
          </a>
        </nav>

        <!-- Right Side: Dark Toggle & Home Button -->
        <div class="flex items-center gap-2.5">
          <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white rounded-lg transition-colors border border-blue-200 dark:border-blue-800">
            <i class="fa-solid fa-arrow-left text-[11px]"></i>
            <span>Return Home</span>
          </a>

          <button type="button" onclick="toggleTheme()" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none" aria-label="Toggle Theme">
            <i id="themeToggleIcon" class="fa-solid fa-moon text-xs"></i>
          </button>
        </div>

      </div>
    </div>
  </header>

  <!-- Main Content Area -->
  <main class="flex-1 flex items-center justify-center py-12 sm:py-20 px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="max-w-3xl w-full mx-auto">
      @yield('content')
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white/70 dark:bg-[#07111F]/70 backdrop-blur-md text-slate-500 dark:text-slate-400 text-xs py-6 border-t border-slate-200 dark:border-slate-800 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
      <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
        <span>Infrastructure Cluster Status: <strong class="text-emerald-600 dark:text-emerald-400">Operational (99.99%)</strong></span>
      </div>
      <p>{{ $footerCopyright }}</p>
      <div class="flex items-center gap-4 text-slate-400">
        <a href="{{ route('home') }}" class="hover:text-blue-500 transition-colors">Home</a>
        <a href="{{ route('contact.show') }}" class="hover:text-blue-500 transition-colors">Technical Support</a>
      </div>
    </div>
  </footer>

  <!-- Theme Toggle Script -->
  <script>
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

    document.addEventListener('DOMContentLoaded', () => {
      updateThemeIcon(document.documentElement.classList.contains('dark'));
    });

    function copyDiagnostics(text) {
      navigator.clipboard.writeText(text).then(() => {
        const btn = document.getElementById('copyDiagBtn');
        if (btn) {
          const original = btn.innerHTML;
          btn.innerHTML = '<i class="fa-solid fa-check text-emerald-400 mr-1"></i> Copied!';
          setTimeout(() => { btn.innerHTML = original; }, 2000);
        }
      });
    }
  </script>
</body>
</html>

