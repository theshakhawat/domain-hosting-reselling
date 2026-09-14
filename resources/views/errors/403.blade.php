@extends('errors.layout')

@section('title', '403 — Access Forbidden')
@section('meta_description', 'You do not have permission or security clearance to access this resource.')
@section('glow_color', 'bg-amber-500/10 dark:bg-amber-500/15')

@section('content')
<div class="space-y-8 text-center sm:text-left">
  
  <!-- Main Glassmorphism Error Card -->
  <div class="bg-white/80 dark:bg-[#0B1B33]/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 sm:p-10 shadow-2xl shadow-amber-900/10 dark:shadow-black/40 relative overflow-hidden">
    
    <!-- Top Decorative Line -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 via-rose-500 to-amber-600"></div>

    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-8">
      
      <!-- Big Glowing 403 Visual Badge -->
      <div class="shrink-0 flex flex-col items-center justify-center w-28 h-28 sm:w-36 sm:h-36 rounded-2xl bg-gradient-to-br from-amber-500/10 to-rose-500/10 dark:from-amber-600/20 dark:to-rose-600/10 border border-amber-300/40 dark:border-amber-500/30 text-amber-600 dark:text-amber-400 shadow-inner">
        <span class="text-4xl sm:text-5xl font-black font-mono-code tracking-tighter">403</span>
        <span class="text-[10px] font-mono-code uppercase tracking-widest text-slate-500 dark:text-slate-400 mt-1">FORBIDDEN</span>
      </div>

      <!-- Main Info & Headings -->
      <div class="flex-1 space-y-3 text-center sm:text-left">
        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-mono-code font-semibold bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20">
          <i class="fa-solid fa-shield-halved text-[11px]"></i>
          <span>SECURITY FIREWALL RESTRICTION</span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
          Access Denied / Clearance Required
        </h1>

        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl">
          You do not have the necessary authentication credentials or permission tier to access <code class="px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-amber-600 dark:text-amber-400 font-mono text-xs">/{{ ltrim(request()->path(), '/') }}</code>. Access to this sector is strictly restricted.
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
          <span class="ml-2 text-slate-400">firewall_guard.log</span>
        </div>
        <button id="copyDiagBtn" type="button" onclick="copyDiagnostics('ERROR_CODE: 403_FORBIDDEN\nPATH: /{{ ltrim(request()->path(), '/') }}\nCLIENT_IP: {{ request()->ip() }}\nTIMESTAMP: {{ now()->toIso8601String() }}\nGATEWAY: nexus-waf-guard-01')" class="text-slate-400 hover:text-white transition-colors flex items-center gap-1 text-[10px] bg-slate-800 px-2 py-0.5 rounded">
          <i class="fa-regular fa-copy"></i> Copy Log
        </button>
      </div>
      <div class="space-y-1 text-slate-400">
        <p><span class="text-amber-400">nexus@waf-gateway:~$</span> verify-acl --target=/{{ ltrim(request()->path(), '/') }} --client={{ request()->ip() }}</p>
        <p class="text-amber-400">&gt; HTTP/2 403 FORBIDDEN: Insufficient permissions for user scope.</p>
        <p class="text-slate-500">&gt; rule: acl_rule_protected_zone • action: block_and_drop</p>
        <p class="text-slate-400">&gt; recommendation: Authenticate with administrative credentials or contact root admin.</p>
      </div>
    </div>

    <!-- Primary Action Buttons -->
    <div class="mt-8 flex flex-wrap items-center gap-3">
      <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-0.5">
        <i class="fa-solid fa-house"></i>
        <span>Return to Homepage</span>
      </a>

      @auth
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 transition-all hover:-translate-y-0.5 border border-slate-200 dark:border-slate-700">
          <i class="fa-solid fa-gauge-high text-amber-500"></i>
          <span>Admin Dashboard</span>
        </a>
      @else
        <a href="{{ route('admin.login') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 transition-all hover:-translate-y-0.5 border border-slate-200 dark:border-slate-700">
          <i class="fa-solid fa-lock text-amber-500"></i>
          <span>Admin Sign In</span>
        </a>
      @endauth

      <a href="{{ route('contact.show') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-white transition-colors">
        <i class="fa-solid fa-headset"></i>
        <span>Request Clearance</span>
      </a>
    </div>

  </div>

  <!-- Helpful Quick Links Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="p-4 rounded-xl bg-white/60 dark:bg-[#0B1B33]/60 border border-slate-200 dark:border-slate-800 flex items-start gap-3">
      <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-sm shrink-0">
        <i class="fa-solid fa-key"></i>
      </div>
      <div>
        <div class="text-xs font-bold text-slate-900 dark:text-white">Valid Session</div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Ensure you are signed in with an authorized administrator account.</div>
      </div>
    </div>

    <div class="p-4 rounded-xl bg-white/60 dark:bg-[#0B1B33]/60 border border-slate-200 dark:border-slate-800 flex items-start gap-3">
      <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm shrink-0">
        <i class="fa-solid fa-cookie-bite"></i>
      </div>
      <div>
        <div class="text-xs font-bold text-slate-900 dark:text-white">Session Refresh</div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Try clearing browser cache and cookies then logging back in.</div>
      </div>
    </div>

    <div class="p-4 rounded-xl bg-white/60 dark:bg-[#0B1B33]/60 border border-slate-200 dark:border-slate-800 flex items-start gap-3">
      <div class="w-8 h-8 rounded-lg bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center text-sm shrink-0">
        <i class="fa-solid fa-shield-virus"></i>
      </div>
      <div>
        <div class="text-xs font-bold text-slate-900 dark:text-white">IP Whitelisting</div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">If you require fixed access, request IP whitelisting from support.</div>
      </div>
    </div>
  </div>

</div>
@endsection

