@extends('errors.layout')

@section('title', '500 — Internal Server Error')
@section('meta_description', 'A temporary internal cluster anomaly occurred. Our engineers and auto-healing services have been alerted.')
@section('glow_color', 'bg-rose-500/10 dark:bg-rose-500/15')

@section('content')
<div class="space-y-8 text-center sm:text-left">
  
  <!-- Main Glassmorphism Error Card -->
  <div class="bg-white/80 dark:bg-[#0B1B33]/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 sm:p-10 shadow-2xl shadow-rose-900/10 dark:shadow-black/40 relative overflow-hidden">
    
    <!-- Top Decorative Line -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-600 via-purple-500 to-rose-600"></div>

    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-8">
      
      <!-- Big Glowing 500 Visual Badge -->
      <div class="shrink-0 flex flex-col items-center justify-center w-28 h-28 sm:w-36 sm:h-36 rounded-2xl bg-gradient-to-br from-rose-500/10 to-purple-500/10 dark:from-rose-600/20 dark:to-purple-600/10 border border-rose-300/40 dark:border-rose-500/30 text-rose-600 dark:text-rose-400 shadow-inner">
        <span class="text-4xl sm:text-5xl font-black font-mono-code tracking-tighter">500</span>
        <span class="text-[10px] font-mono-code uppercase tracking-widest text-slate-500 dark:text-slate-400 mt-1">SERVER_ERROR</span>
      </div>

      <!-- Main Info & Headings -->
      <div class="flex-1 space-y-3 text-center sm:text-left">
        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-mono-code font-semibold bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
          <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
          <span>INTERNAL CLUSTER EXCEPTION</span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
          Server Encountered An Anomaly
        </h1>

        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl">
          Something unexpected happened while computing your request on <code class="px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-rose-600 dark:text-rose-400 font-mono text-xs">nexus-node-primary</code>. Our automated watchdog monitors have captured the stack trace and notified our on-call sysadmins.
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
          <span class="ml-2 text-slate-400">kernel_crash_report.log</span>
        </div>
        <button id="copyDiagBtn" type="button" onclick="copyDiagnostics('ERROR_CODE: 500_INTERNAL_SERVER_ERROR\nPATH: /{{ ltrim(request()->path(), '/') }}\nINCIDENT_REF: #NX-{{ strtoupper(substr(md5(now()), 0, 8)) }}\nTIMESTAMP: {{ now()->toIso8601String() }}')" class="text-slate-400 hover:text-white transition-colors flex items-center gap-1 text-[10px] bg-slate-800 px-2 py-0.5 rounded">
          <i class="fa-regular fa-copy"></i> Copy Incident Log
        </button>
      </div>
      <div class="space-y-1 text-slate-400">
        <p><span class="text-rose-400">nexus@cluster-worker:~$</span> systemctl status nexus-php-fpm.service</p>
        <p class="text-rose-400">&gt; STATUS: Uncaught Exception during pipeline execution</p>
        <p class="text-slate-500">&gt; incident_id: #NX-{{ strtoupper(substr(md5(now()), 0, 8)) }} • auto_failover: standing_by</p>
        <p class="text-slate-400">&gt; action: Try reloading or check back in a few moments.</p>
      </div>
    </div>

    <!-- Primary Action Buttons -->
    <div class="mt-8 flex flex-wrap items-center gap-3">
      <button type="button" onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-0.5 cursor-pointer">
        <i class="fa-solid fa-rotate-right"></i>
        <span>Reload Page &amp; Retry</span>
      </button>

      <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 transition-all hover:-translate-y-0.5 border border-slate-200 dark:border-slate-700">
        <i class="fa-solid fa-house text-blue-500"></i>
        <span>Return to Homepage</span>
      </a>

      <a href="{{ route('contact.show') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-white transition-colors">
        <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
        <span>Report Outage to Engineers</span>
      </a>
    </div>

  </div>

  <!-- Help & Status Section -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="p-4 rounded-xl bg-white/60 dark:bg-[#0B1B33]/60 border border-slate-200 dark:border-slate-800 flex items-start gap-3">
      <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-sm shrink-0">
        <i class="fa-solid fa-shield-halved"></i>
      </div>
      <div>
        <div class="text-xs font-bold text-slate-900 dark:text-white">Data Preserved</div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Your stored files and databases are securely isolated and unaffected.</div>
      </div>
    </div>

    <div class="p-4 rounded-xl bg-white/60 dark:bg-[#0B1B33]/60 border border-slate-200 dark:border-slate-800 flex items-start gap-3">
      <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm shrink-0">
        <i class="fa-solid fa-server"></i>
      </div>
      <div>
        <div class="text-xs font-bold text-slate-900 dark:text-white">Auto Recovery</div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Node workers automatically restart in under 30 seconds upon failure.</div>
      </div>
    </div>

    <div class="p-4 rounded-xl bg-white/60 dark:bg-[#0B1B33]/60 border border-slate-200 dark:border-slate-800 flex items-start gap-3">
      <div class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-sm shrink-0">
        <i class="fa-solid fa-satellite-dish"></i>
      </div>
      <div>
        <div class="text-xs font-bold text-slate-900 dark:text-white">24/7 Monitoring</div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Network operations center is live 24/7/365 to resolve incidents.</div>
      </div>
    </div>
  </div>

</div>
@endsection

