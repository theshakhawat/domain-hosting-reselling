@extends('admin.layouts.app')

@section('title', 'Admin Overview Dashboard')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="space-y-6">

  <!-- Header Banner & Quick Management Toolbar -->
  <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-white dark:bg-brand-card p-6 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
    <div>
      <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md text-[11px] font-mono font-semibold bg-brand-accent/10 text-brand-accent mb-2">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span>CENTRAL COMMAND & CLUSTER MONITOR</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
        Welcome, {{ Auth::user()->name ?? 'Administrator' }}
      </h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
        Comprehensive platform overview: customer support tickets, hosting packages, domain registrations, reviews, and traffic analytics.
      </p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 text-xs font-semibold border border-rose-500/20 transition-all">
        <i class="fa-solid fa-headset text-[11px]"></i>
        <span>Support Inbox</span>
        @if(($stats['unread_contacts'] ?? 0) > 0)
          <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] font-mono font-bold bg-rose-500 text-white animate-pulse">
            {{ $stats['unread_contacts'] }}
          </span>
        @endif
      </a>

      <a href="{{ route('admin.plans.create') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-semibold shadow-md shadow-brand-accent/25 transition-all active:scale-[0.98]">
        <i class="fa-solid fa-plus text-[11px]"></i>
        <span>Add Package</span>
      </a>

      <a href="{{ route('admin.domains.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-cyan-500/10 hover:bg-cyan-500/20 text-brand-cyan text-xs font-semibold border border-cyan-500/20 transition-all">
        <i class="fa-solid fa-globe text-[11px]"></i>
        <span>Domains</span>
      </a>

      <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-brand-dark dark:hover:bg-brand-slate/60 text-slate-700 dark:text-slate-200 text-xs font-semibold transition-all">
        <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
        <span class="hidden sm:inline">Live Site</span>
      </a>
    </div>
  </div>

  <!-- 6-Metric Stat KPI Cards Grid (Full Website Scope) -->
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3.5 sm:gap-4">
    
    <!-- 1. Support Inquiries -->
    <div class="bg-white dark:bg-brand-card p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex flex-col justify-between group hover:border-rose-500/40 transition-colors">
      <div class="flex items-center justify-between">
        <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400">Support Tickets</span>
        <div class="w-7 h-7 rounded-lg bg-rose-500/10 text-rose-500 flex items-center justify-center text-xs">
          <i class="fa-solid fa-headset"></i>
        </div>
      </div>
      <div class="mt-2.5">
        <div class="flex items-baseline gap-1.5">
          <span class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stats['total_contacts'] }}</span>
          @if($stats['unread_contacts'] > 0)
            <span class="text-[10px] font-mono font-bold text-rose-500 bg-rose-500/10 px-1 py-0.5 rounded animate-pulse">
              {{ $stats['unread_contacts'] }} new
            </span>
          @endif
        </div>
        <a href="{{ route('admin.contacts.index') }}" class="mt-2 text-[11px] font-semibold text-rose-500 hover:underline flex items-center gap-1">
          <span>Manage tickets</span>
          <i class="fa-solid fa-chevron-right text-[8px]"></i>
        </a>
      </div>
    </div>

    <!-- 2. Hosting Packages -->
    <div class="bg-white dark:bg-brand-card p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex flex-col justify-between group hover:border-blue-500/40 transition-colors">
      <div class="flex items-center justify-between">
        <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400">Hosting Plans</span>
        <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-brand-accent flex items-center justify-center text-xs">
          <i class="fa-solid fa-microchip"></i>
        </div>
      </div>
      <div class="mt-2.5">
        <div class="flex items-baseline gap-1.5">
          <span class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stats['total_plans'] }}</span>
          <span class="text-[10px] font-mono text-emerald-500 bg-emerald-500/10 px-1 py-0.5 rounded font-semibold">
            {{ $stats['active_plans'] }} live
          </span>
        </div>
        <a href="{{ route('admin.plans.index') }}" class="mt-2 text-[11px] font-semibold text-brand-accent hover:underline flex items-center gap-1">
          <span>Manage plans</span>
          <i class="fa-solid fa-chevron-right text-[8px]"></i>
        </a>
      </div>
    </div>

    <!-- 3. Domain TLDs -->
    <div class="bg-white dark:bg-brand-card p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex flex-col justify-between group hover:border-cyan-500/40 transition-colors">
      <div class="flex items-center justify-between">
        <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400">Domain TLDs</span>
        <div class="w-7 h-7 rounded-lg bg-cyan-500/10 text-brand-cyan flex items-center justify-center text-xs">
          <i class="fa-solid fa-globe"></i>
        </div>
      </div>
      <div class="mt-2.5">
        <div class="flex items-baseline gap-1.5">
          <span class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stats['total_domains'] }}</span>
          <span class="text-[10px] font-mono text-slate-400">
            from ৳{{ number_format($stats['lowest_domain_price']) }}
          </span>
        </div>
        <a href="{{ route('admin.domains.index') }}" class="mt-2 text-[11px] font-semibold text-brand-cyan hover:underline flex items-center gap-1">
          <span>Domain pricing</span>
          <i class="fa-solid fa-chevron-right text-[8px]"></i>
        </a>
      </div>
    </div>

    <!-- 4. Client Testimonials -->
    <div class="bg-white dark:bg-brand-card p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex flex-col justify-between group hover:border-amber-500/40 transition-colors">
      <div class="flex items-center justify-between">
        <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400">Client Reviews</span>
        <div class="w-7 h-7 rounded-lg bg-amber-500/10 text-amber-500 flex items-center justify-center text-xs">
          <i class="fa-solid fa-star"></i>
        </div>
      </div>
      <div class="mt-2.5">
        <div class="flex items-baseline gap-1.5">
          <span class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stats['total_testimonials'] }}</span>
          <span class="text-[10px] font-mono text-amber-500 bg-amber-500/10 px-1 py-0.5 rounded font-semibold">
            {{ $stats['avg_rating'] }} ★
          </span>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="mt-2 text-[11px] font-semibold text-amber-500 hover:underline flex items-center gap-1">
          <span>Manage reviews</span>
          <i class="fa-solid fa-chevron-right text-[8px]"></i>
        </a>
      </div>
    </div>

    <!-- 5. Website Traffic Today -->
    <div class="bg-white dark:bg-brand-card p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex flex-col justify-between group hover:border-emerald-500/40 transition-colors">
      <div class="flex items-center justify-between">
        <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400">Today's Visits</span>
        <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-xs">
          <i class="fa-solid fa-chart-line"></i>
        </div>
      </div>
      <div class="mt-2.5">
        <div class="flex items-baseline gap-1.5">
          <span class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">{{ number_format($stats['today_visits']) }}</span>
          <span class="text-[10px] font-mono text-emerald-500 bg-emerald-500/10 px-1 py-0.5 rounded font-semibold">
            {{ $stats['unique_visitors'] }} IPs
          </span>
        </div>
        <a href="{{ route('admin.visitors.index') }}" class="mt-2 text-[11px] font-semibold text-emerald-500 hover:underline flex items-center gap-1">
          <span>Traffic details</span>
          <i class="fa-solid fa-chevron-right text-[8px]"></i>
        </a>
      </div>
    </div>

    <!-- 6. FAQs & Knowledgebase -->
    <div class="bg-white dark:bg-brand-card p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex flex-col justify-between group hover:border-purple-500/40 transition-colors">
      <div class="flex items-center justify-between">
        <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400">FAQs & Help</span>
        <div class="w-7 h-7 rounded-lg bg-purple-500/10 text-purple-500 flex items-center justify-center text-xs">
          <i class="fa-solid fa-circle-question"></i>
        </div>
      </div>
      <div class="mt-2.5">
        <div class="flex items-baseline gap-1.5">
          <span class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stats['total_faqs'] }}</span>
          <span class="text-[10px] font-mono text-purple-500 bg-purple-500/10 px-1 py-0.5 rounded font-semibold">
            {{ $stats['active_faqs'] }} active
          </span>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="mt-2 text-[11px] font-semibold text-purple-500 hover:underline flex items-center gap-1">
          <span>Manage FAQs</span>
          <i class="fa-solid fa-chevron-right text-[8px]"></i>
        </a>
      </div>
    </div>

  </div>

  <!-- MAIN 2-COLUMN DASHBOARD SECTION -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    <!-- LEFT COLUMN (7 / 12 Cols): Support Tickets + Traffic Charts + Live Visitors -->
    <div class="lg:col-span-7 space-y-6">

      <!-- SECTION 1: LATEST SUPPORT INQUIRIES & TICKETS TABLE -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-brand-slate/40 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <div class="w-2.5 h-2.5 rounded-full bg-rose-500 {{ $stats['unread_contacts'] > 0 ? 'animate-ping' : '' }}"></div>
            <h2 class="text-sm font-bold text-slate-900 dark:text-white">Recent Support Tickets & Inquiries</h2>
          </div>
          <a href="{{ route('admin.contacts.index') }}" class="text-xs font-semibold text-brand-accent hover:underline flex items-center gap-1">
            <span>View all ({{ $stats['total_contacts'] }})</span>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs min-w-[540px]">
            <thead class="bg-slate-50 dark:bg-brand-dark/50 text-slate-500 dark:text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-200 dark:border-brand-slate/40">
              <tr>
                <th class="py-2.5 px-4">Ticket / Sender</th>
                <th class="py-2.5 px-4">Subject & Category</th>
                <th class="py-2.5 px-4">Status</th>
                <th class="py-2.5 px-4 text-right">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-slate-700 dark:text-slate-300">
              @forelse($recentContacts as $contact)
                <tr class="hover:bg-slate-50/70 dark:hover:bg-brand-dark/30 transition-colors {{ $contact->status === 'new' ? 'bg-blue-50/30 dark:bg-blue-950/20' : '' }}">
                  <td class="py-2.5 px-4">
                    <div class="font-mono font-bold text-slate-900 dark:text-white text-xs">
                      <a href="{{ route('admin.contacts.show', $contact) }}" class="hover:text-brand-accent transition-colors">
                        #{{ $contact->ticket_no }}
                      </a>
                    </div>
                    <div class="text-[11px] text-slate-400 truncate max-w-[140px]">
                      {{ $contact->name }}
                    </div>
                  </td>
                  <td class="py-2.5 px-4">
                    <div class="font-semibold text-slate-800 dark:text-slate-200 truncate max-w-[200px]">
                      {{ $contact->subject }}
                    </div>
                    <span class="text-[10px] font-mono text-slate-400 bg-slate-100 dark:bg-brand-dark px-1.5 py-0.2 rounded">
                      {{ $contact->issue_type }}
                    </span>
                  </td>
                  <td class="py-2.5 px-4">
                    @if($contact->status === 'new')
                      <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                        NEW
                      </span>
                    @elseif($contact->status === 'in_progress')
                      <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20">
                        IN PROGRESS
                      </span>
                    @elseif($contact->status === 'fixed')
                      <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                        RESOLVED
                      </span>
                    @else
                      <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-semibold bg-slate-100 dark:bg-brand-dark text-slate-500">
                        SEEN
                      </span>
                    @endif
                  </td>
                  <td class="py-2.5 px-4 text-right">
                    <a href="{{ route('admin.contacts.show', $contact) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-brand-accent/10 hover:bg-brand-accent text-brand-accent hover:text-white font-semibold text-[11px] transition-colors">
                      <i class="fa-solid fa-eye text-[10px]"></i>
                      <span>Details</span>
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="py-6 text-center text-slate-400 text-xs">
                    <i class="fa-regular fa-envelope-open text-base mb-1 block opacity-50"></i>
                    No support tickets submitted yet.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- SECTION 2: 7-DAY TRAFFIC TREND GRAPH -->
      <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2">
              <i class="fa-solid fa-chart-area text-brand-accent"></i>
              <span>Traffic Trend (Last 7 Days)</span>
            </h2>
            <p class="text-[11px] text-slate-400 mt-0.5">Total page hits tracked across the public website</p>
          </div>
          <a href="{{ route('admin.visitors.index') }}" class="text-xs font-semibold text-brand-accent hover:underline flex items-center gap-1">
            <span>Visitor log</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
          </a>
        </div>
        <div class="h-56 w-full">
          <canvas id="dashboardTrafficChart"></canvas>
        </div>
      </div>

      <!-- SECTION 3: LATEST 5 REAL-TIME VISITORS -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-brand-slate/40 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-tower-broadcast text-emerald-500 text-sm animate-pulse"></i>
            <h2 class="text-sm font-bold text-slate-900 dark:text-white">Latest Visitors &amp; Real-Time Hits</h2>
          </div>
          <a href="{{ route('admin.visitors.index') }}" class="text-xs font-semibold text-brand-accent hover:underline flex items-center gap-1">
            <span>Manage traffic</span>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs min-w-[500px]">
            <thead class="bg-slate-50 dark:bg-brand-dark/50 text-slate-500 dark:text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-200 dark:border-brand-slate/40">
              <tr>
                <th class="py-2.5 px-4">Visitor & Location</th>
                <th class="py-2.5 px-4">Device & Path</th>
                <th class="py-2.5 px-4">Hits</th>
                <th class="py-2.5 px-4 text-right">Time</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-slate-700 dark:text-slate-300">
              @forelse($latestVisitors as $visitor)
                <tr class="hover:bg-slate-50/70 dark:hover:bg-brand-dark/30 transition-colors">
                  <td class="py-2.5 px-4">
                    <div class="font-mono font-bold text-slate-900 dark:text-white text-xs">
                      {{ $visitor->ip_address }}
                    </div>
                    <div class="text-[11px] text-slate-400 flex items-center gap-1">
                      @if($visitor->country_code)
                        <span class="text-xs">{{ mb_convert_encoding('&#' . (127397 + ord(strtoupper($visitor->country_code[0]))) . ';', 'UTF-8', 'HTML-ENTITIES') }}{{ mb_convert_encoding('&#' . (127397 + ord(strtoupper($visitor->country_code[1]))) . ';', 'UTF-8', 'HTML-ENTITIES') }}</span>
                      @endif
                      <span>{{ $visitor->city ?? 'Unknown' }}, {{ $visitor->country ?? 'Unknown' }}</span>
                    </div>
                  </td>
                  <td class="py-2.5 px-4">
                    <div class="flex items-center gap-1 text-[11px] font-medium text-slate-800 dark:text-slate-200">
                      <span>{{ $visitor->device_type ?? 'Desktop' }}</span>
                      <span class="text-slate-400">·</span>
                      <span class="text-slate-400">{{ $visitor->browser ?? 'Browser' }}</span>
                    </div>
                    <span class="px-1.5 py-0.2 rounded text-[10px] font-mono bg-slate-100 dark:bg-brand-dark text-brand-accent">
                      {{ $visitor->visited_route ?? '/' }}
                    </span>
                  </td>
                  <td class="py-2.5 px-4 font-mono font-bold text-emerald-500">
                    {{ $visitor->hits }}
                  </td>
                  <td class="py-2.5 px-4 text-right font-mono text-[11px] text-slate-400">
                    {{ $visitor->last_activity_at ? $visitor->last_activity_at->diffForHumans() : 'Just now' }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="py-6 text-center text-slate-400">No visitors recorded yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <!-- RIGHT COLUMN (5 / 12 Cols): Notifications + Plans + Domains + Reviews + System -->
    <div class="lg:col-span-5 space-y-6">

      <!-- CARD 1: RECENT NOTIFICATIONS & ALERTS -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-brand-slate/40">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-bell text-brand-accent text-sm"></i>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Admin Alerts</h3>
          </div>
          <a href="{{ route('admin.notifications.index') }}" class="text-[11px] text-brand-accent hover:underline font-semibold">
            View All ({{ $stats['unread_notifications'] }} new)
          </a>
        </div>

        <div class="mt-3 divide-y divide-slate-100 dark:divide-brand-slate/30 text-xs">
          @forelse($recentNotifications as $notif)
            <a href="{{ $notif->link ? route('admin.notifications.read', $notif) : route('admin.notifications.index') }}" class="block py-2.5 hover:bg-slate-50 dark:hover:bg-brand-dark/40 transition-colors {{ !$notif->is_read ? 'bg-blue-50/20' : 'opacity-75' }}">
              <div class="flex items-start justify-between gap-2">
                <div class="font-semibold text-slate-800 dark:text-slate-200 truncate flex items-center gap-1.5">
                  @if(!$notif->is_read)
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-accent shrink-0"></span>
                  @endif
                  <span class="truncate">{{ $notif->title }}</span>
                </div>
                <span class="text-[10px] text-slate-400 font-mono shrink-0">{{ $notif->created_at->diffForHumans(null, true) }}</span>
              </div>
              <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1 mt-0.5">{{ $notif->message }}</p>
            </a>
          @empty
            <div class="py-4 text-center text-slate-400 text-xs">All alerts clear.</div>
          @endforelse
        </div>
      </div>

      <!-- CARD 2: ACTIVE HOSTING PACKAGES SNAPSHOT -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-brand-slate/40">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-server text-indigo-500 text-sm"></i>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Hosting Packages</h3>
          </div>
          <a href="{{ route('admin.plans.index') }}" class="text-[11px] text-brand-accent hover:underline font-semibold">
            Manage ({{ $stats['total_plans'] }})
          </a>
        </div>

        <div class="mt-3 divide-y divide-slate-100 dark:divide-brand-slate/30 text-xs">
          @forelse($recentPlans as $plan)
            <div class="py-2.5 flex items-center justify-between">
              <div>
                <div class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                  <span>{{ $plan->name }}</span>
                  @if($plan->is_featured)
                    <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-amber-500/10 text-amber-500">Popular</span>
                  @endif
                </div>
                <div class="text-[10px] text-slate-400 uppercase font-mono">{{ $plan->category }} · {{ $plan->ssd_storage }}</div>
              </div>
              <div class="text-right">
                <div class="font-mono font-bold text-brand-cyan">৳{{ number_format($plan->monthly_price) }}<span class="text-[10px] font-normal text-slate-400">/mo</span></div>
                <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-semibold {{ $plan->is_active ? 'text-emerald-500 bg-emerald-500/10' : 'text-slate-400 bg-slate-100' }}">
                  {{ $plan->is_active ? 'Active' : 'Draft' }}
                </span>
              </div>
            </div>
          @empty
            <div class="py-4 text-center text-slate-400">No hosting plans configured.</div>
          @endforelse
        </div>
      </div>

      <!-- CARD 3: DOMAIN TLDs & PRICING -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-brand-slate/40">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-globe text-brand-cyan text-sm"></i>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Domain Extensions (TLDs)</h3>
          </div>
          <a href="{{ route('admin.domains.index') }}" class="text-[11px] text-brand-accent hover:underline font-semibold">
            Manage ({{ $stats['total_domains'] }})
          </a>
        </div>

        <div class="mt-3 grid grid-cols-2 gap-2.5 text-xs">
          @forelse($recentDomains as $domain)
            <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-brand-dark/50 border border-slate-100 dark:border-brand-slate/30 flex items-center justify-between">
              <div>
                <span class="font-mono font-bold text-slate-900 dark:text-white text-xs">{{ $domain->tld }}</span>
                @if($domain->is_popular)
                  <span class="block text-[9px] text-amber-500 font-semibold">Hot TLD</span>
                @endif
              </div>
              <div class="text-right">
                <span class="font-mono font-bold text-emerald-500 text-xs">৳{{ number_format($domain->price) }}</span>
                <span class="block text-[9px] text-slate-400">/yr</span>
              </div>
            </div>
          @empty
            <div class="col-span-2 py-3 text-center text-slate-400">No domains set.</div>
          @endforelse
        </div>
      </div>

      <!-- CARD 4: LATEST CLIENT TESTIMONIAL SNAPSHOT -->
      @if($latestTestimonials->isNotEmpty())
        <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5">
          <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-brand-slate/40">
            <div class="flex items-center gap-2">
              <i class="fa-solid fa-comments text-amber-500 text-sm"></i>
              <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Client Feedback</h3>
            </div>
            <a href="{{ route('admin.testimonials.index') }}" class="text-[11px] text-brand-accent hover:underline font-semibold">
              All Reviews
            </a>
          </div>

          <div class="mt-3 space-y-3">
            @foreach($latestTestimonials as $review)
              <div class="p-3 rounded-xl bg-slate-50 dark:bg-brand-dark/40 border border-slate-100 dark:border-brand-slate/30 text-xs">
                <div class="flex items-center justify-between">
                  <span class="font-bold text-slate-900 dark:text-white">{{ $review->client_name }}</span>
                  <div class="text-amber-400 text-[10px]">
                    @for($i = 0; $i < ($review->rating ?? 5); $i++)
                      <i class="fa-solid fa-star"></i>
                    @endfor
                  </div>
                </div>
                <div class="text-[10px] text-slate-400 font-mono">{{ $review->client_role ?? 'Client' }} · {{ $review->client_company ?? 'Business' }}</div>
                <p class="text-[11px] text-slate-600 dark:text-slate-300 italic mt-1 line-clamp-2">"{{ $review->review }}"</p>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- CARD 5: PROMO CODE & SYSTEM INFRASTRUCTURE -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5 space-y-4">
        <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-brand-slate/40">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-microchip text-emerald-500 text-sm"></i>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Active Promo & Server</h3>
          </div>
          <a href="{{ route('admin.settings.index') }}" class="text-[11px] text-brand-accent hover:underline font-semibold">
            Settings
          </a>
        </div>

        <div class="space-y-2 text-xs">
          <div class="flex justify-between items-center py-0.5">
            <span class="text-slate-500 dark:text-slate-400">Coupon Promo:</span>
            <span class="font-mono font-bold px-2 py-0.5 rounded bg-brand-accent/10 text-brand-accent text-xs">
              {{ $promoCode }} ({{ $promoDiscount }})
            </span>
          </div>
          <div class="flex justify-between items-center py-0.5">
            <span class="text-slate-500 dark:text-slate-400">Launch Bundle:</span>
            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $bundlePrice }}</span>
          </div>
          <div class="flex justify-between items-center py-0.5 border-t border-slate-100 dark:border-brand-slate/30 pt-2">
            <span class="text-slate-500 dark:text-slate-400">PHP &amp; Laravel:</span>
            <span class="font-mono text-[11px] text-slate-700 dark:text-slate-300">PHP {{ $systemInfo['php_version'] }} · v{{ $systemInfo['laravel_version'] }}</span>
          </div>
          <div class="flex justify-between items-center py-0.5">
            <span class="text-slate-500 dark:text-slate-400">Database Engine:</span>
            <span class="font-mono text-[11px] text-emerald-500 font-semibold">{{ strtoupper($systemInfo['db_driver']) }} Connected</span>
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

    // Dashboard Traffic Trend Graph
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
  });
</script>
@endpush
@endsection
