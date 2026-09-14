@extends('errors.layout')

@section('title', '503 — Service Maintenance Mode')
@section('meta_description', 'Scheduled infrastructure upgrade in progress. We will be back online shortly.')
@section('glow_color', 'bg-sky-500/10 dark:bg-sky-500/15')

@section('content')
<div class="space-y-8 text-center sm:text-left">
  
  <!-- Main Glassmorphism Error Card -->
  <div class="bg-white/80 dark:bg-[#0B1B33]/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 sm:p-10 shadow-2xl shadow-sky-900/10 dark:shadow-black/40 relative overflow-hidden">
    
    <!-- Top Decorative Line -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-sky-500 via-blue-500 to-emerald-500"></div>

    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-8">
      
      <!-- Big Glowing 503 Visual Badge -->
      <div class="shrink-0 flex flex-col items-center justify-center w-28 h-28 sm:w-36 sm:h-36 rounded-2xl bg-gradient-to-br from-sky-500/10 to-blue-500/10 dark:from-sky-600/20 dark:to-blue-600/10 border border-sky-300/40 dark:border-sky-500/30 text-sky-600 dark:text-sky-400 shadow-inner">
        <span class="text-4xl sm:text-5xl font-black font-mono-code tracking-tighter">503</span>
        <span class="text-[10px] font-mono-code uppercase tracking-widest text-slate-500 dark:text-slate-400 mt-1">MAINTENANCE</span>
      </div>

      <!-- Main Info & Headings -->
      <div class="flex-1 space-y-3 text-center sm:text-left">
        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-mono-code font-semibold bg-sky-500/10 text-sky-600 dark:text-sky-400 border border-sky-500/20">
          <i class="fa-solid fa-wrench text-[11px] animate-bounce"></i>
          <span>SCHEDULED CLUSTER MAINTENANCE</span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
          System Upgrades In Progress
        </h1>

        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl">
          We are currently deploying zero-downtime kernel optimizations and security patches across our cloud infrastructure. Normal services will resume momentarily.
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
          <span class="ml-2 text-slate-400">cluster_upgrade.log</span>
        </div>
        <button id="copyDiagBtn" type="button" onclick="copyDiagnostics('STATUS: 503_MAINTENANCE_MODE\nPROGRESS: 94%\nESTIMATED_DURATION: < 60s\nTIMESTAMP: {{ now()->toIso8601String() }}')" class="text-slate-400 hover:text-white transition-colors flex items-center gap-1 text-[10px] bg-slate-800 px-2 py-0.5 rounded">
          <i class="fa-regular fa-copy"></i> Copy Log
        </button>
      </div>
      <div class="space-y-1 text-slate-400">
        <p><span class="text-sky-400">nexus@cluster-orchestrator:~$</span> patch-apply --all --status</p>
        <p class="text-emerald-400">&gt; Node migration 94% complete [||||||||||||||||||||  ]</p>
        <p class="text-slate-400">&gt; estimated time to restoration: &lt; 60 seconds.</p>
      </div>
    </div>

    <!-- Primary Action Buttons -->
    <div class="mt-8 flex flex-wrap items-center gap-3">
      <button type="button" onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-0.5 cursor-pointer">
        <i class="fa-solid fa-rotate-right"></i>
        <span>Check If Ready (Reload)</span>
      </button>

      <a href="{{ route('contact.show') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 transition-all hover:-translate-y-0.5 border border-slate-200 dark:border-slate-700">
        <i class="fa-solid fa-headset text-blue-500"></i>
        <span>Contact Operations Team</span>
      </a>
    </div>

  </div>

</div>
@endsection

