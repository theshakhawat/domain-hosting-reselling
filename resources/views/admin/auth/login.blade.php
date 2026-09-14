<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — NEXUSHOST Control Center</title>

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
</head>
<body class="h-full bg-slate-50 dark:bg-brand-navy text-slate-800 dark:text-slate-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8 transition-colors duration-200">

  <!-- Ambient Glow Background -->
  <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[550px] bg-brand-accent/10 dark:bg-brand-accent/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-brand-cyan/10 dark:bg-brand-cyan/5 rounded-full blur-3xl"></div>
  </div>

  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <!-- Brand Logo -->
    <div class="flex justify-center items-center gap-3 mb-6">
      <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-none">
        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-brand-accent to-brand-cyan flex items-center justify-center text-white shadow-lg shadow-brand-accent/25 transition-transform group-hover:scale-105">
          <i class="fa-solid fa-server text-xl"></i>
        </div>
        <div class="text-left">
          <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-1.5">
            NEXUS<span class="text-brand-accent">HOST</span>
          </span>
          <span class="block text-[10px] font-mono uppercase tracking-widest text-slate-500 dark:text-slate-400">Admin Control Center</span>
        </div>
      </a>
    </div>

    <h2 class="text-center text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
      Sign in to Admin Portal
    </h2>
    <p class="mt-2 text-center text-xs text-slate-600 dark:text-slate-400">
      Authorized personnel only. All access attempts are logged.
    </p>
  </div>

  <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
    <div class="bg-white dark:bg-brand-card py-8 px-6 shadow-xl border border-slate-200 dark:border-brand-slate/40 rounded-2xl sm:px-10">

      <!-- Flash Notification -->
      @if (session('success'))
        <div class="mb-5 rounded-lg bg-emerald-500/10 border border-emerald-500/30 p-3.5 flex items-center gap-3 text-emerald-600 dark:text-emerald-400 text-xs font-medium">
          <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if (session('error'))
        <div class="mb-5 rounded-lg bg-rose-500/10 border border-rose-500/30 p-3.5 flex items-center gap-3 text-rose-600 dark:text-rose-400 text-xs font-medium">
          <i class="fa-solid fa-circle-exclamation text-rose-500 text-sm"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif

      <form class="space-y-5" action="{{ route('admin.login.submit') }}" method="POST">
        @csrf

        <!-- Email Field -->
        <div>
          <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
            Email Address
          </label>
          <div class="relative rounded-lg">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <i class="fa-regular fa-envelope text-sm"></i>
            </div>
            <input id="email" name="email" type="email" autocomplete="email" required
              value="{{ old('email') }}"
              placeholder="admin@nexus.com"
              class="block w-full pl-10 pr-3.5 py-2.5 text-sm rounded-lg border @error('email') border-rose-500 focus:ring-rose-500 @else border-slate-300 dark:border-brand-slate/60 focus:border-brand-accent focus:ring-brand-accent @enderror bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-1 transition-colors">
          </div>
          @error('email')
            <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
              <i class="fa-solid fa-triangle-exclamation text-[11px]"></i>
              {{ $message }}
            </p>
          @enderror
        </div>

        <!-- Password Field -->
        <div>
          <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
            Password
          </label>
          <div class="relative rounded-lg">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <i class="fa-solid fa-lock text-sm"></i>
            </div>
            <input id="password" name="password" type="password" autocomplete="current-password" required
              placeholder="••••••••"
              class="block w-full pl-10 pr-10 py-2.5 text-sm rounded-lg border @error('password') border-rose-500 focus:ring-rose-500 @else border-slate-300 dark:border-brand-slate/60 focus:border-brand-accent focus:ring-brand-accent @enderror bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-1 transition-colors">
            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-sm focus:outline-none">
              <i id="passwordToggleIcon" class="fa-regular fa-eye"></i>
            </button>
          </div>
          @error('password')
            <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
              <i class="fa-solid fa-triangle-exclamation text-[11px]"></i>
              {{ $message }}
            </p>
          @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between">
          <label class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400 cursor-pointer select-none">
            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 dark:border-brand-slate/70 text-brand-accent focus:ring-brand-accent bg-slate-50 dark:bg-brand-dark">
            <span>Keep me logged in for 30 days</span>
          </label>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg text-sm font-semibold text-white bg-brand-accent hover:bg-blue-600 active:scale-[0.99] transition-all shadow-md shadow-brand-accent/25 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-accent">
            <i class="fa-solid fa-arrow-right-to-bracket"></i>
            <span>Sign In to Dashboard</span>
          </button>
        </div>
      </form>

    </div>

    <!-- Back to Website & Theme Toggle -->
    <div class="mt-6 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 px-1">
      <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 hover:text-brand-accent transition-colors font-medium">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Back</span>
      </a>

      <button type="button" onclick="toggleTheme()" class="inline-flex items-center gap-1.5 hover:text-brand-accent transition-colors">
        <i id="themeIcon" class="fa-solid fa-moon"></i>
        <span id="themeText">Dark Mode</span>
      </button>
    </div>
  </div>

  <script>
    function togglePasswordVisibility() {
      const passInput = document.getElementById('password');
      const passIcon = document.getElementById('passwordToggleIcon');
      if (passInput.type === 'password') {
        passInput.type = 'text';
        passIcon.classList.remove('fa-eye');
        passIcon.classList.add('fa-eye-slash');
      } else {
        passInput.type = 'password';
        passIcon.classList.remove('fa-eye-slash');
        passIcon.classList.add('fa-eye');
      }
    }

    function toggleTheme() {
      const isDark = document.documentElement.classList.toggle('dark');
      localStorage.setItem('hosting_theme', isDark ? 'dark' : 'light');
      updateThemeUI(isDark);
    }

    function updateThemeUI(isDark) {
      const icon = document.getElementById('themeIcon');
      const text = document.getElementById('themeText');
      if (isDark) {
        icon.className = 'fa-solid fa-sun';
        text.textContent = 'Light Mode';
      } else {
        icon.className = 'fa-solid fa-moon';
        text.textContent = 'Dark Mode';
      }
    }

    // Init theme icon
    document.addEventListener('DOMContentLoaded', () => {
      updateThemeUI(document.documentElement.classList.contains('dark'));
    });
  </script>
</body>
</html>

