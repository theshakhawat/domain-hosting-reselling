@extends('errors.layout')

@section('title', '404 — Page Not Found')
@section('meta_description', 'The page you requested could not be located on our hosting cluster.')
@section('glow_color', 'bg-cyan-500/10 dark:bg-cyan-500/15')

@section('content')
<div class="space-y-8 text-center sm:text-left">
  
  <!-- Main Glassmorphism Error Card -->
  <div class="bg-white/80 dark:bg-[#0B1B33]/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 sm:p-10 shadow-2xl shadow-blue-900/10 dark:shadow-black/40 relative overflow-hidden">
    
    <!-- Top Decorative Line -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 via-cyan-400 to-indigo-600"></div>

    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-8">
      
      <!-- Big Glowing 404 Visual Badge -->
      <div class="shrink-0 flex flex-col items-center justify-center w-28 h-28 sm:w-36 sm:h-36 rounded-2xl bg-gradient-to-br from-blue-500/10 to-cyan-500/10 dark:from-blue-600/20 dark:to-cyan-600/10 border border-blue-200 dark:border-blue-500/30 text-blue-600 dark:text-cyan-400 shadow-inner">
        <span class="text-4xl sm:text-5xl font-black font-mono-code tracking-tighter">404</span>
        <span class="text-[10px] font-mono-code uppercase tracking-widest text-slate-500 dark:text-slate-400 mt-1">NOT_FOUND</span>
      </div>

      <!-- Main Info & Headings -->
      <div class="flex-1 space-y-3 text-center sm:text-left">
        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-mono-code font-semibold bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20">
          <span class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse"></span>
          <span>HTTP 404 ROUTE EXCEPTION</span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
          Cluster Node Or Page Not Found
        </h1>

        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl">
          The requested URL <code class="px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-blue-600 dark:text-cyan-400 font-mono text-xs">/{{ ltrim(request()->path(), '/') }}</code> could not be located across our active edge servers. It may have expired, changed location, or was entered incorrectly.
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
          <span class="ml-2 text-slate-400">system_diagnostic.log</span>
        </div>
        <button id="copyDiagBtn" type="button" onclick="copyDiagnostics('ERROR_CODE: 404_NOT_FOUND\nPATH: /{{ ltrim(request()->path(), '/') }}\nTIMESTAMP: {{ now()->toIso8601String() }}\nCLUSTER: nexus-cluster-01.bd')" class="text-slate-400 hover:text-white transition-colors flex items-center gap-1 text-[10px] bg-slate-800 px-2 py-0.5 rounded">
          <i class="fa-regular fa-copy"></i> Copy Log
        </button>
      </div>
      <div class="space-y-1 text-slate-400">
        <p><span class="text-emerald-400">nexus@edge-gateway:~$</span> curl -I https://{{ request()->getHost() }}/{{ ltrim(request()->path(), '/') }}</p>
        <p class="text-red-400">&gt; HTTP/2 404 NOT FOUND</p>
        <p class="text-slate-500">&gt; x-cluster-node: nexus-edge-dhaka-01 • time: {{ now()->format('H:i:s') }} UTC</p>
        <p class="text-slate-400">&gt; resolution: Check the address URL or return to dashboard.</p>
      </div>
    </div>

    <!-- Primary Action Buttons -->
    <div class="mt-8 flex flex-wrap items-center gap-3">
      <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-0.5">
        <i class="fa-solid fa-house"></i>
        <span>Return to Homepage</span>
      </a>

      <a href="{{ route('contact.show') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 transition-all hover:-translate-y-0.5 border border-slate-200 dark:border-slate-700">
        <i class="fa-solid fa-headset text-blue-500"></i>
        <span>Contact Technical Support</span>
      </a>

      <a href="{{ route('home') }}#hosting-plans" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-white transition-colors">
        <i class="fa-solid fa-server"></i>
        <span>Explore Hosting Plans</span>
      </a>
    </div>

  </div>

  <!-- Helpful Quick Links Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <a href="{{ route('home') }}#hosting-plans" class="p-4 rounded-xl bg-white/60 dark:bg-[#0B1B33]/60 border border-slate-200 dark:border-slate-800 hover:border-blue-500 dark:hover:border-blue-500 transition-all group flex items-center gap-3">
      <div class="w-10 h-10 rounded-lg bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-base group-hover:scale-110 transition-transform">
        <i class="fa-solid fa-rocket"></i>
      </div>
      <div class="text-left">
        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">NVMe Cloud Hosting</div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400">High-speed BDIX plans</div>
      </div>
    </a>

    <a href="{{ route('home') }}#domain-search" class="p-4 rounded-xl bg-white/60 dark:bg-[#0B1B33]/60 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 dark:hover:border-cyan-500 transition-all group flex items-center gap-3">
      <div class="w-10 h-10 rounded-lg bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-base group-hover:scale-110 transition-transform">
        <i class="fa-solid fa-magnifying-glass"></i>
      </div>
      <div class="text-left">
        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">Domain Registration</div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400">Instant DNS provisioning</div>
      </div>
    </a>

    <a href="{{ route('contact.show') }}" class="p-4 rounded-xl bg-white/60 dark:bg-[#0B1B33]/60 border border-slate-200 dark:border-slate-800 hover:border-emerald-500 dark:hover:border-emerald-500 transition-all group flex items-center gap-3">
      <div class="w-10 h-10 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base group-hover:scale-110 transition-transform">
        <i class="fa-solid fa-comments"></i>
      </div>
      <div class="text-left">
        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">Priority Helpdesk</div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400">24/7 Engineer assistance</div>
      </div>
    </a>
  </div>

</div>
@endsection

