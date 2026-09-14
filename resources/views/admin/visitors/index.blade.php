@extends('admin.layouts.app')

@section('title', 'Visitors & Traffic Analytics')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
        <i class="fa-solid fa-chart-line text-brand-accent"></i>
        <span>Visitor Traffic & Device Analytics</span>
      </h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
        Real-time insights on visitor IP addresses, ISPs, geographical locations, devices, screen resolutions, and visited routes.
      </p>
    </div>
    <div class="flex items-center gap-2">
      <form action="{{ route('admin.system.refresh') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg border border-slate-200 dark:border-brand-slate/50 bg-white dark:bg-brand-card text-xs font-semibold text-slate-700 dark:text-slate-200 hover:text-brand-accent hover:border-brand-accent/50 transition-colors">
          <i class="fa-solid fa-arrows-rotate text-xs"></i>
          <span>Sync & Refresh Data</span>
        </button>
      </form>
      @if($visitors->total() > 0)
        <form action="{{ route('admin.visitors.clear') }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete ALL visitor traffic logs? This action cannot be undone.');">
          @csrf
          @method('DELETE')
          <button type="submit" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg border border-rose-200 dark:border-rose-900/50 bg-rose-50 dark:bg-rose-950/40 text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/60 transition-colors">
            <i class="fa-solid fa-trash-can text-xs"></i>
            <span>Clear All Logs</span>
          </button>
        </form>
      @endif
    </div>
  </div>

  <!-- Metric Highlights Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Pageviews -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex items-center justify-between">
      <div>
        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider font-mono">Total Pageviews</span>
        <div class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ number_format($totalPageviews) }}</div>
        <span class="text-[11px] text-emerald-500 font-medium flex items-center gap-1 mt-0.5">
          <i class="fa-solid fa-arrow-trend-up"></i> Total interaction hits
        </span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-brand-accent flex items-center justify-center text-lg shadow-sm">
        <i class="fa-solid fa-eye"></i>
      </div>
    </div>

    <!-- Unique Visitors -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex items-center justify-between">
      <div>
        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider font-mono">Unique Visitors</span>
        <div class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ number_format($uniqueVisitors) }}</div>
        <span class="text-[11px] text-blue-500 font-medium flex items-center gap-1 mt-0.5">
          <i class="fa-solid fa-user-check"></i> Distinct IP addresses
        </span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-lg shadow-sm">
        <i class="fa-solid fa-users"></i>
      </div>
    </div>

    <!-- Today's Visits -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex items-center justify-between">
      <div>
        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider font-mono">Today's Activity</span>
        <div class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ number_format($todayVisits) }}</div>
        <span class="text-[11px] text-emerald-500 font-medium flex items-center gap-1 mt-0.5">
          <i class="fa-solid fa-clock"></i> Hits recorded today
        </span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-lg shadow-sm">
        <i class="fa-solid fa-bolt"></i>
      </div>
    </div>

    <!-- Mobile Device Ratio -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex items-center justify-between">
      <div>
        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider font-mono">Mobile Ratio</span>
        <div class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $mobileShare }}%</div>
        <span class="text-[11px] text-cyan-500 font-medium flex items-center gap-1 mt-0.5">
          <i class="fa-solid fa-mobile-screen"></i> Mobile phone visitors
        </span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-cyan-500/10 text-cyan-500 flex items-center justify-center text-lg shadow-sm">
        <i class="fa-solid fa-mobile-screen-button"></i>
      </div>
    </div>
  </div>

  <!-- Analytics Charts Section -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Chart 1: 7-Day Traffic Trend -->
    <div class="lg:col-span-2 bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-chart-area text-brand-accent"></i>
            <span>Traffic Volume Trend (Last 7 Days)</span>
          </h2>
          <p class="text-[11px] text-slate-400 mt-0.5">Daily pageview hits recorded on public and administrative routes</p>
        </div>
      </div>
      <div class="h-64">
        <canvas id="trafficChart"></canvas>
      </div>
    </div>

    <!-- Chart 2: Device Breakdown -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-chart-pie text-cyan-500"></i>
            <span>Device Distribution</span>
          </h2>
          <p class="text-[11px] text-slate-400 mt-0.5">Visitor platform breakdown</p>
        </div>
      </div>
      <div class="h-64 flex items-center justify-center">
        <canvas id="deviceChart"></canvas>
      </div>
    </div>

  </div>

  <!-- Route & Country Rankings Summary -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Top Visited Routes -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-3 flex items-center gap-2">
        <i class="fa-solid fa-route text-brand-accent"></i>
        <span>Top Visited Routes</span>
      </h2>
      <div class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-xs">
        @forelse($topRoutes as $r)
          <div class="py-2.5 flex items-center justify-between">
            <span class="font-mono text-slate-800 dark:text-slate-200 font-semibold truncate">{{ $r->visited_route }}</span>
            <span class="px-2.5 py-0.5 rounded-full bg-blue-500/10 text-brand-accent font-bold font-mono text-[11px]">
              {{ number_format($r->total_hits) }} hits
            </span>
          </div>
        @empty
          <div class="py-4 text-center text-slate-400">No route activity recorded yet.</div>
        @endforelse
      </div>
    </div>

    <!-- Top Countries -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-3 flex items-center gap-2">
        <i class="fa-solid fa-earth-americas text-emerald-500"></i>
        <span>Top Geographic Locations</span>
      </h2>
      <div class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-xs">
        @forelse($topCountries as $c)
          <div class="py-2.5 flex items-center justify-between">
            <span class="text-slate-800 dark:text-slate-200 font-semibold flex items-center gap-2">
              <i class="fa-solid fa-location-dot text-emerald-500"></i>
              <span>{{ $c->country }}</span>
            </span>
            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-500 font-bold font-mono text-[11px]">
              {{ number_format($c->total) }} sessions
            </span>
          </div>
        @empty
          <div class="py-4 text-center text-slate-400">No geo records available yet.</div>
        @endforelse
      </div>
    </div>

  </div>

  <!-- Detailed Visitors Data Table -->
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden">
    
    <!-- Table Toolbar -->
    <div class="p-4 sm:p-5 border-b border-slate-200 dark:border-brand-slate/40 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div>
        <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
          <i class="fa-solid fa-list text-brand-accent"></i>
          <span>Recent Visitor Activity Log</span>
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
          Detailed breakdown of each visitor's IP, ISP, location, device model, screen size, and timestamps.
        </p>
      </div>

      <!-- Filters Form -->
      <form action="{{ route('admin.visitors.index') }}" method="GET" class="flex items-center gap-2">
        <div class="relative">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search IP, ISP, country..."
            class="pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 dark:border-brand-slate/50 bg-slate-50 dark:bg-brand-dark text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-brand-accent">
          <i class="fa-solid fa-magnifying-glass text-slate-400 text-[11px] absolute left-2.5 top-2.5"></i>
        </div>

        <select name="device" onchange="this.form.submit()"
          class="px-3 py-1.5 text-xs rounded-lg border border-slate-200 dark:border-brand-slate/50 bg-slate-50 dark:bg-brand-dark text-slate-800 dark:text-slate-200 focus:outline-none focus:border-brand-accent">
          <option value="">All Devices</option>
          <option value="Desktop" {{ request('device') === 'Desktop' ? 'selected' : '' }}>Desktop</option>
          <option value="Mobile" {{ request('device') === 'Mobile' ? 'selected' : '' }}>Mobile</option>
          <option value="Tablet" {{ request('device') === 'Tablet' ? 'selected' : '' }}>Tablet</option>
        </select>

        @if(request('search') || request('device'))
          <a href="{{ route('admin.visitors.index') }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-brand-dark text-slate-500 hover:text-slate-700 text-xs">
            Clear
          </a>
        @endif
      </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
        <thead class="bg-slate-50/75 dark:bg-brand-dark/40 font-mono text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-brand-slate/40">
          <tr>
            <th class="px-4 py-3">Visitor IP & ISP</th>
            <th class="px-4 py-3">Location</th>
            <th class="px-4 py-3">Device & Browser</th>
            <th class="px-4 py-3">Screen Size</th>
            <th class="px-4 py-3">Visited Route</th>
            <th class="px-4 py-3 text-center">Hits</th>
            <th class="px-4 py-3 text-right">Last Activity</th>
            <th class="px-4 py-3 text-center">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-brand-slate/20">
          @forelse($visitors as $v)
            <tr class="hover:bg-slate-50/50 dark:hover:bg-brand-dark/30 transition-colors">
              
              <!-- IP & ISP -->
              <td class="px-4 py-3 font-mono">
                <div class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                  <i class="fa-solid fa-network-wired text-brand-accent text-xs"></i>
                  <span>{{ $v->ip_address }}</span>
                </div>
                <div class="text-[11px] text-slate-400 truncate max-w-xs">{{ $v->isp }}</div>
              </td>

              <!-- Location -->
              <td class="px-4 py-3">
                <div class="font-semibold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                  <span class="text-xs">📍</span>
                  <span>{{ $v->city }}, {{ $v->country }}</span>
                </div>
                <span class="text-[10px] font-mono text-slate-400 uppercase">Code: {{ $v->country_code }}</span>
              </td>

              <!-- Device & Browser -->
              <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                  <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase font-mono {{ $v->device_type === 'Mobile' ? 'bg-cyan-500/10 text-cyan-500' : ($v->device_type === 'Tablet' ? 'bg-purple-500/10 text-purple-500' : 'bg-blue-500/10 text-blue-500') }}">
                    <i class="fa-solid {{ $v->device_type === 'Mobile' ? 'fa-mobile-screen' : ($v->device_type === 'Tablet' ? 'fa-tablet-screen-button' : 'fa-laptop') }} mr-1"></i>
                    {{ $v->device_type }}
                  </span>
                  <span class="font-medium text-slate-900 dark:text-white">{{ $v->browser }}</span>
                </div>
                <div class="text-[11px] text-slate-400 mt-0.5">{{ $v->operating_system }}</div>
              </td>

              <!-- Screen Size -->
              <td class="px-4 py-3 font-mono text-slate-700 dark:text-slate-300">
                @if($v->screen_resolution && $v->screen_resolution !== 'Unknown')
                  <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-brand-dark border border-slate-200 dark:border-brand-slate/50 text-[11px]">
                    {{ $v->screen_resolution }}
                  </span>
                @else
                  <span class="text-slate-400 text-[11px]">Auto / Responsive</span>
                @endif
              </td>

              <!-- Visited Route -->
              <td class="px-4 py-3">
                <span class="font-mono text-xs px-2 py-0.5 rounded bg-slate-100 dark:bg-brand-dark text-slate-800 dark:text-slate-200 font-semibold">
                  {{ $v->visited_route }}
                </span>
                @if($v->referrer)
                  <div class="text-[10px] text-slate-400 truncate max-w-xs mt-0.5" title="{{ $v->referrer }}">
                    Ref: {{ parse_url($v->referrer, PHP_URL_HOST) ?? $v->referrer }}
                  </div>
                @endif
              </td>

              <!-- Hits -->
              <td class="px-4 py-3 text-center">
                <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-brand-dark text-slate-700 dark:text-slate-300 font-bold font-mono text-[11px]">
                  {{ $v->hits }}
                </span>
              </td>

              <!-- Last Seen -->
              <td class="px-4 py-3 text-right">
                <div class="text-slate-900 dark:text-white font-medium">
                  {{ $v->last_activity_at ? $v->last_activity_at->diffForHumans() : 'Just now' }}
                </div>
                <div class="text-[10px] text-slate-400 font-mono">
                  {{ $v->last_activity_at ? $v->last_activity_at->format('H:i:s') : '' }}
                </div>
              </td>

              <!-- Action -->
              <td class="px-4 py-3 text-center">
                <form action="{{ route('admin.visitors.destroy', $v) }}" method="POST" class="inline" onsubmit="return confirm('Delete this visitor entry?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors" title="Delete record">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                  </button>
                </form>
              </td>

            </tr>
          @empty
            <tr>
              <td colspan="8" class="px-4 py-8 text-center text-slate-400">
                <div class="flex flex-col items-center justify-center">
                  <i class="fa-solid fa-users-slash text-2xl text-slate-300 dark:text-slate-600 mb-2"></i>
                  <span>No visitor records match your filter criteria.</span>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($visitors->hasPages())
      <div class="p-4 border-t border-slate-200 dark:border-brand-slate/40">
        {{ $visitors->links() }}
      </div>
    @endif

  </div>

</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#94a3b8' : '#64748b';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

    // 1. Traffic Trend Line/Area Chart
    const trafficCtx = document.getElementById('trafficChart')?.getContext('2d');
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

    // 2. Device Breakdown Doughnut Chart
    const deviceCtx = document.getElementById('deviceChart')?.getContext('2d');
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

