@extends('admin.layouts.app')

@section('title', 'Admin Overview & Analytics')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="space-y-6">

  <!-- Header Banner -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-brand-card p-6 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
    <div>
      <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md text-[11px] font-mono font-semibold bg-brand-accent/10 text-brand-accent mb-2">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span>SYSTEM & TRAFFIC MONITOR ACTIVE</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
        Welcome, {{ Auth::user()->name ?? 'Administrator' }}
      </h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
        Overview of website traffic, real-time visitors, hosting packages, and system controls.
      </p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="flex items-center gap-2.5">
      <a href="{{ route('admin.visitors.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-xs font-semibold border border-indigo-500/20 transition-all">
        <i class="fa-solid fa-chart-line text-[11px]"></i>
        <span>Detailed Traffic</span>
      </a>
      <a href="{{ route('admin.plans.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-semibold shadow-md shadow-brand-accent/25 transition-all active:scale-[0.98]">
        <i class="fa-solid fa-plus text-[11px]"></i>
        <span>Add Package</span>
      </a>
      <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-brand-dark dark:hover:bg-brand-slate/60 text-slate-700 dark:text-slate-200 text-xs font-semibold transition-all">
        <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
        <span>Live Site</span>
      </a>
    </div>
  </div>

  <!-- Metric Counters Grid -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Today's Visits -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Today's Traffic</span>
        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-sm">
          <i class="fa-solid fa-bolt"></i>
        </div>
      </div>
      <div class="mt-3 flex items-baseline gap-2">
        <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ number_format($stats['today_visits']) }}</span>
        <span class="text-[11px] font-mono text-emerald-500 bg-emerald-500/10 px-1.5 py-0.5 rounded">
          hits today
        </span>
      </div>
      <a href="{{ route('admin.visitors.index') }}" class="mt-3 text-[11px] font-semibold text-emerald-500 hover:underline flex items-center gap-1">
        <span>View live traffic</span>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
      </a>
    </div>

    <!-- Unique Visitors -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Unique Visitors</span>
        <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-brand-accent flex items-center justify-center text-sm">
          <i class="fa-solid fa-users"></i>
        </div>
      </div>
      <div class="mt-3 flex items-baseline gap-2">
        <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ number_format($stats['unique_visitors']) }}</span>
        <span class="text-[11px] text-slate-400 font-mono">Distinct IPs</span>
      </div>
      <a href="{{ route('admin.visitors.index') }}" class="mt-3 text-[11px] font-semibold text-brand-accent hover:underline flex items-center gap-1">
        <span>Visitor analytics</span>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
      </a>
    </div>

    <!-- Total Pageviews -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Total Pageviews</span>
        <div class="w-8 h-8 rounded-lg bg-cyan-500/10 text-brand-cyan flex items-center justify-center text-sm">
          <i class="fa-solid fa-eye"></i>
        </div>
      </div>
      <div class="mt-3 flex items-baseline gap-2">
        <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ number_format($stats['total_pageviews']) }}</span>
        <span class="text-[11px] text-slate-400 font-mono">All-time</span>
      </div>
      <a href="{{ route('admin.visitors.index') }}" class="mt-3 text-[11px] font-semibold text-brand-cyan hover:underline flex items-center gap-1">
        <span>Path breakdown</span>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
      </a>
    </div>

    <!-- Total Hosting Plans -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Hosting Packages</span>
        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-sm">
          <i class="fa-solid fa-microchip"></i>
        </div>
      </div>
      <div class="mt-3 flex items-baseline gap-2">
        <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stats['total_plans'] }}</span>
        <span class="text-[11px] font-mono text-emerald-500 bg-emerald-500/10 px-1.5 py-0.5 rounded">
          {{ $stats['active_plans'] }} active
        </span>
      </div>
      <a href="{{ route('admin.plans.index') }}" class="mt-3 text-[11px] font-semibold text-indigo-400 hover:underline flex items-center gap-1">
        <span>Manage plans</span>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
      </a>
    </div>
  </div>

  <!-- VISITOR GRAPHS SECTION -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Chart 1: 7-Day Traffic Trend Graph -->
    <div class="lg:col-span-2 bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex flex-col justify-between">
      <div class="flex items-center justify-between mb-3">
        <div>
          <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-chart-area text-brand-accent"></i>
            <span>Traffic Trend (Last 7 Days)</span>
          </h2>
          <p class="text-[11px] text-slate-400 mt-0.5">Daily pageview hits recorded across public website</p>
        </div>
        <a href="{{ route('admin.visitors.index') }}" class="text-xs font-semibold text-brand-accent hover:underline flex items-center gap-1">
          <span>Full Report</span>
          <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
      </div>
      <div class="h-60 w-full">
        <canvas id="dashboardTrafficChart"></canvas>
      </div>
    </div>

    <!-- Chart 2: Device Breakdown Doughnut -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex flex-col justify-between">
      <div class="flex items-center justify-between mb-3">
        <div>
          <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-chart-pie text-brand-cyan"></i>
            <span>Device Distribution</span>
          </h2>
          <p class="text-[11px] text-slate-400 mt-0.5">Traffic share by platform</p>
        </div>
      </div>
      <div class="h-60 w-full flex items-center justify-center">
        <canvas id="dashboardDeviceChart"></canvas>
      </div>
    </div>

  </div>

  <!-- LATEST VISITORS & RECENT ACTIVITY SECTION -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left 2 Cols: Latest Visitors Table -->
    <div class="lg:col-span-2 bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-200 dark:border-brand-slate/40 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-tower-broadcast text-emerald-500 text-sm animate-pulse"></i>
          <h2 class="text-sm font-bold text-slate-900 dark:text-white">Latest Visitors & Real-Time Hits</h2>
        </div>
        <a href="{{ route('admin.visitors.index') }}" class="text-xs font-semibold text-brand-accent hover:underline flex items-center gap-1">
          <span>View all visitors</span>
          <i class="fa-solid fa-chevron-right text-[9px]"></i>
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-50 dark:bg-brand-dark/50 text-slate-500 dark:text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-200 dark:border-brand-slate/40">
            <tr>
              <th class="py-3 px-4">Visitor & Location</th>
              <th class="py-3 px-4">Device / Browser</th>
              <th class="py-3 px-4">Visited Path</th>
              <th class="py-3 px-4">Hits</th>
              <th class="py-3 px-4 text-right">Last Activity</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-slate-700 dark:text-slate-300">
            @forelse($latestVisitors as $visitor)
              <tr class="hover:bg-slate-50/70 dark:hover:bg-brand-dark/30 transition-colors">
                <!-- Visitor IP & Location -->
                <td class="py-3 px-4">
                  <div class="font-mono font-bold text-slate-900 dark:text-white text-xs">
                    {{ $visitor->ip_address }}
                  </div>
                  <div class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                    @if($visitor->country_code)
                      <span class="text-xs">{{ mb_convert_encoding('&#' . (127397 + ord(strtoupper($visitor->country_code[0]))) . ';', 'UTF-8', 'HTML-ENTITIES') }}{{ mb_convert_encoding('&#' . (127397 + ord(strtoupper($visitor->country_code[1]))) . ';', 'UTF-8', 'HTML-ENTITIES') }}</span>
                    @endif
                    <span>{{ $visitor->city ?? 'Unknown City' }}, {{ $visitor->country ?? 'Unknown' }}</span>
                  </div>
                </td>

                <!-- Device & Browser -->
                <td class="py-3 px-4">
                  <div class="flex items-center gap-1.5 font-medium text-slate-800 dark:text-slate-200">
                    @if($visitor->device_type === 'Mobile')
                      <i class="fa-solid fa-mobile-screen text-brand-accent text-xs"></i>
                    @elseif($visitor->device_type === 'Tablet')
                      <i class="fa-solid fa-tablet-screen-button text-purple-400 text-xs"></i>
                    @else
                      <i class="fa-solid fa-desktop text-slate-400 text-xs"></i>
                    @endif
                    <span>{{ $visitor->device_type ?? 'Desktop' }}</span>
                  </div>
                  <div class="text-[11px] text-slate-400 mt-0.5">
                    {{ $visitor->browser ?? 'Browser' }} · {{ $visitor->operating_system ?? 'OS' }}
                  </div>
                </td>

                <!-- Visited Path -->
                <td class="py-3 px-4">
                  <span class="px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-slate-100 dark:bg-brand-dark text-brand-accent">
                    {{ $visitor->visited_route ?? '/' }}
                  </span>
                  @if($visitor->screen_resolution)
                    <div class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $visitor->screen_resolution }}</div>
                  @endif
                </td>

                <!-- Hits -->
                <td class="py-3 px-4 font-mono font-bold text-emerald-500">
                  {{ $visitor->hits }}
                </td>

                <!-- Last Activity -->
                <td class="py-3 px-4 text-right font-mono text-[11px] text-slate-400">
                  {{ $visitor->last_activity_at ? $visitor->last_activity_at->diffForHumans() : 'Just now' }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="py-8 text-center text-slate-400">
                  <i class="fa-solid fa-globe text-2xl mb-2 text-slate-300 dark:text-slate-600 block"></i>
                  No visitor records captured yet.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Right 1 Col: Active Plans & Promo Snapshot -->
    <div class="space-y-6">

      <!-- Active Hosting Packages Snapshot -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-brand-slate/40">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-server text-brand-accent text-sm"></i>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Hosting Packages</h3>
          </div>
          <a href="{{ route('admin.plans.index') }}" class="text-[11px] text-brand-accent hover:underline font-semibold">
            Manage
          </a>
        </div>

        <div class="mt-3 divide-y divide-slate-100 dark:divide-brand-slate/30 text-xs">
          @forelse($recentPlans as $plan)
            <div class="py-2.5 flex items-center justify-between">
              <div>
                <div class="font-bold text-slate-900 dark:text-white">{{ $plan->name }}</div>
                <div class="text-[10px] text-slate-400 uppercase font-mono">{{ $plan->category }}</div>
              </div>
              <div class="text-right">
                <div class="font-mono font-bold text-brand-cyan">৳{{ number_format($plan->monthly_price) }}<span class="text-[10px] font-normal text-slate-400">/mo</span></div>
                <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-semibold {{ $plan->is_active ? 'text-emerald-500 bg-emerald-500/10' : 'text-slate-400 bg-slate-100' }}">
                  {{ $plan->is_active ? 'Active' : 'Inactive' }}
                </span>
              </div>
            </div>
          @empty
            <div class="py-4 text-center text-slate-400">No packages configured yet.</div>
          @endforelse
        </div>
      </div>

      <!-- Active Promo Snapshot -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-brand-slate/40">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-tag text-emerald-500 text-sm"></i>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Active Promotion</h3>
          </div>
          <a href="{{ route('admin.settings.index') }}#promo" class="text-[11px] text-brand-accent hover:underline font-semibold">
            Edit
          </a>
        </div>

        <div class="mt-4 space-y-2.5 text-xs">
          <div class="flex justify-between items-center py-1">
            <span class="text-slate-500 dark:text-slate-400">Promo Code:</span>
            <span class="font-mono font-bold px-2 py-0.5 rounded bg-brand-accent/10 text-brand-accent text-xs">
              {{ $promoCode }}
            </span>
          </div>
          <div class="flex justify-between items-center py-1">
            <span class="text-slate-500 dark:text-slate-400">Discount:</span>
            <span class="font-semibold text-emerald-500">{{ $promoDiscount }}</span>
          </div>
          <div class="flex justify-between items-center py-1">
            <span class="text-slate-500 dark:text-slate-400">Launch Bundle:</span>
            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $bundlePrice }}</span>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#94a3b8' : '#64748b';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

    // 1. Dashboard Traffic Trend Graph
    const trafficCtx = document.getElementById('dashboardTrafficChart')?.getContext('2d');
    if (trafficCtx) {
      new Chart(trafficCtx, {
        type: 'line',
        data: {
          labels: @json($dates),
          datasets: [{
            label: 'Page Views',
            data: @json($trendData),
            borderColor: '#3B82F6',
            backgroundColor: 'rgba(59, 130, 246, 0.12)',
            borderWidth: 2.5,
            fill: true,
            tension: 0.35,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: '#3B82F6',
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false }
          },
          scales: {
            x: {
              grid: { color: gridColor },
              ticks: { color: textColor, font: { size: 10 } }
            },
            y: {
              beginAtZero: true,
              grid: { color: gridColor },
              ticks: { color: textColor, font: { size: 10 }, precision: 0 }
            }
          }
        }
      });
    }

    // 2. Dashboard Device Distribution Doughnut
    const deviceCtx = document.getElementById('dashboardDeviceChart')?.getContext('2d');
    if (deviceCtx) {
      new Chart(deviceCtx, {
        type: 'doughnut',
        data: {
          labels: @json($deviceLabels),
          datasets: [{
            data: @json($deviceData),
            backgroundColor: ['#3B82F6', '#06B6D4', '#A855F7'],
            borderWidth: 0,
            hoverOffset: 4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: { color: textColor, font: { size: 11 }, boxWidth: 12 }
            }
          },
          cutout: '70%'
        }
      });
    }
  });
</script>
@endpush
@endsection


