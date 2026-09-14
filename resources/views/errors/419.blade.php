@extends('errors.layout')

@section('title', '419 — Page Session Expired')
@section('meta_description', 'Your secure session has expired due to inactivity. Please refresh and try again.')
@section('glow_color', 'bg-indigo-500/10 dark:bg-indigo-500/15')

@section('content')
<div class="space-y-8 text-center sm:text-left">
  
  <!-- Main Glassmorphism Error Card -->
  <div class="bg-white/80 dark:bg-[#0B1B33]/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 sm:p-10 shadow-2xl shadow-indigo-900/10 dark:shadow-black/40 relative overflow-hidden">
    
    <!-- Top Decorative Line -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-blue-500 to-cyan-500"></div>

    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-8">
      
      <!-- Big Glowing 419 Visual Badge -->
      <div class="shrink-0 flex flex-col items-center justify-center w-28 h-28 sm:w-36 sm:h-36 rounded-2xl bg-gradient-to-br from-indigo-500/10 to-blue-500/10 dark:from-indigo-600/20 dark:to-blue-600/10 border border-indigo-300/40 dark:border-indigo-500/30 text-indigo-600 dark:text-indigo-400 shadow-inner">
        <span class="text-4xl sm:text-5xl font-black font-mono-code tracking-tighter">419</span>
        <span class="text-[10px] font-mono-code uppercase tracking-widest text-slate-500 dark:text-slate-400 mt-1">EXPIRED</span>
      </div>

      <!-- Main Info & Headings -->
      <div class="flex-1 space-y-3 text-center sm:text-left">
        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-mono-code font-semibold bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20">
          <i class="fa-solid fa-clock-rotate-left text-[11px]"></i>
          <span>SECURITY TOKEN TIMEOUT</span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
          Page Session Has Expired
        </h1>

        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl">
          The security CSRF token for this form or page has timed out due to prolonged inactivity. Refreshing the session token will restore full functionality.
        </p>
      </div>

    </div>

    <!-- Live Diagnostic Terminal Box -->
    <div class="mt-8 bg-slate-900 dark:bg-[#07111F] rounded-xl p-4 border border-slate-800 text-left font-mono-code text-xs text-slate-300 shadow-inner">
      <div class="flex items-center justify-between pb-2.5 mb-2.5 border-b border-slate-800 text-slate-500 text-[11px]">
        <div class="flex items-center gap-2">
          <span class="w-2.5 h-2.5 rounded-full bg-red-500/80"></span>
          <span class="w-2.5 h-2.5 rounded-full bg-amber-500/80"></span>
          <span class="w-2.5 h-2.5 rounded-full bg-emerald-500/80"></span>
          <span class="ml-2 text-slate-400">session_guard.log</span>
        </div>
        <button id="copyDiagBtn" type="button" onclick="copyDiagnostics('ERROR_CODE: 419_PAGE_EXPIRED\nPATH: /{{ ltrim(request()->path(), '/') }}\nTIMESTAMP: {{ now()->toIso8601String() }}')" class="text-slate-400 hover:text-white transition-colors flex items-center gap-1 text-[10px] bg-slate-800 px-2 py-0.5 rounded">
          <i class="fa-regular fa-copy"></i> Copy Log
        </button>
      </div>
      <div class="space-y-1 text-slate-400">
        <p><span class="text-indigo-400">nexus@auth-session:~$</span> verify-csrf-token --status</p>
        <p class="text-indigo-400">&gt; CSRF Token Lifetime Exceeded (Max 120min inactivity)</p>
        <p class="text-slate-400">&gt; action: Refresh page to generate a new cryptographic session token.</p>
      </div>
    </div>

    <!-- Primary Action Buttons -->
    <div class="mt-8 flex flex-wrap items-center gap-3">
      <button type="button" onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-0.5 cursor-pointer">
        <i class="fa-solid fa-rotate-right"></i>
        <span>Refresh &amp; Re-authenticate</span>
      </button>

      <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 transition-all hover:-translate-y-0.5 border border-slate-200 dark:border-slate-700">
        <i class="fa-solid fa-house text-blue-500"></i>
        <span>Return to Homepage</span>
      </a>
    </div>

  </div>

</div>
@endsection

