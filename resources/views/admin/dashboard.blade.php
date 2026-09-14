@extends('admin.layouts.app')

@section('title', 'Admin Overview')

@section('content')
<div class="space-y-6">

  <!-- Header Banner -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-brand-card p-6 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
    <div>
      <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md text-[11px] font-mono font-semibold bg-brand-accent/10 text-brand-accent mb-2">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span>SYSTEM OPERATIONAL</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
        Welcome, {{ Auth::user()->name ?? 'Administrator' }}
      </h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
        Manage all frontend hosting packages, domain TLDs, features, testimonials, and active promo discounts.
      </p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="flex items-center gap-2.5">
      <a href="{{ route('admin.plans.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-semibold shadow-md shadow-brand-accent/25 transition-all active:scale-[0.98]">
        <i class="fa-solid fa-plus text-[11px]"></i>
        <span>Add Plan</span>
      </a>
      <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-brand-dark dark:hover:bg-brand-slate/60 text-slate-700 dark:text-slate-200 text-xs font-semibold transition-all">
        <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
        <span>Live Site</span>
      </a>
    </div>
  </div>

  <!-- Metric Counters Grid -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Hosting Plans -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Hosting Packages</span>
        <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-brand-accent flex items-center justify-center text-sm">
          <i class="fa-solid fa-microchip"></i>
        </div>
      </div>
      <div class="mt-3 flex items-baseline gap-2">
        <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stats['total_plans'] }}</span>
        <span class="text-[11px] font-mono text-emerald-500 bg-emerald-500/10 px-1.5 py-0.5 rounded">
          {{ $stats['active_plans'] }} active
        </span>
      </div>
      <a href="{{ route('admin.plans.index') }}" class="mt-3 text-[11px] font-semibold text-brand-accent hover:underline flex items-center gap-1">
        <span>Manage plans</span>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
      </a>
    </div>

    <!-- Domain TLDs -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Domain TLDs</span>
        <div class="w-8 h-8 rounded-lg bg-cyan-500/10 text-brand-cyan flex items-center justify-center text-sm">
          <i class="fa-solid fa-globe"></i>
        </div>
      </div>
      <div class="mt-3 flex items-baseline gap-2">
        <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stats['total_domains'] }}</span>
        <span class="text-[11px] text-slate-400 font-mono">TLD Extensions</span>
      </div>
      <a href="{{ route('admin.domains.index') }}" class="mt-3 text-[11px] font-semibold text-brand-cyan hover:underline flex items-center gap-1">
        <span>Manage TLDs</span>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
      </a>
    </div>

    <!-- Core Features & Testimonials -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Features & Badges</span>
        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-sm">
          <i class="fa-solid fa-bolt"></i>
        </div>
      </div>
      <div class="mt-3 flex items-baseline gap-2">
        <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stats['total_features'] }}</span>
        <span class="text-[11px] text-slate-400 font-mono">Highlights</span>
      </div>
      <a href="{{ route('admin.features.index') }}" class="mt-3 text-[11px] font-semibold text-indigo-400 hover:underline flex items-center gap-1">
        <span>Edit features</span>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
      </a>
    </div>

    <!-- FAQs & Reviews -->
    <div class="bg-white dark:bg-brand-card p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">FAQs & Reviews</span>
        <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-500 flex items-center justify-center text-sm">
          <i class="fa-solid fa-comments"></i>
        </div>
      </div>
      <div class="mt-3 flex items-baseline gap-2">
        <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stats['total_faqs'] }}</span>
        <span class="text-[11px] text-slate-400 font-mono">+ {{ $stats['total_testimonials'] }} Reviews</span>
      </div>
      <a href="{{ route('admin.faqs.index') }}" class="mt-3 text-[11px] font-semibold text-amber-400 hover:underline flex items-center gap-1">
        <span>View FAQs</span>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
      </a>
    </div>
  </div>

  <!-- Main Content 2-Column Split -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left 2 Cols: Recent Hosting Plans Table -->
    <div class="lg:col-span-2 bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-200 dark:border-brand-slate/40 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-server text-brand-accent text-sm"></i>
          <h2 class="text-sm font-bold text-slate-900 dark:text-white">Active Hosting Packages</h2>
        </div>
        <a href="{{ route('admin.plans.index') }}" class="text-xs font-semibold text-brand-accent hover:underline">
          View all {{ $stats['total_plans'] }} →
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-50 dark:bg-brand-dark/50 text-slate-500 dark:text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-200 dark:border-brand-slate/40">
            <tr>
              <th class="py-3 px-4">Plan Name</th>
              <th class="py-3 px-4">Category</th>
              <th class="py-3 px-4">Pricing</th>
              <th class="py-3 px-4">Status</th>
              <th class="py-3 px-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-slate-700 dark:text-slate-300">
            @forelse($recentPlans as $plan)
              <tr class="hover:bg-slate-50/70 dark:hover:bg-brand-dark/30 transition-colors">
                <td class="py-3 px-4 font-semibold text-slate-900 dark:text-white">
                  <div class="flex items-center gap-2">
                    <span>{{ $plan->name }}</span>
                    @if($plan->badge)
                      <span class="px-1.5 py-0.5 rounded text-[9px] font-mono font-bold uppercase bg-brand-accent/20 text-brand-accent">
                        {{ $plan->badge }}
                      </span>
                    @endif
                  </div>
                </td>
                <td class="py-3 px-4 font-mono text-[11px] uppercase">
                  <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-brand-dark text-slate-600 dark:text-slate-300">
                    {{ $plan->category }}
                  </span>
                </td>
                <td class="py-3 px-4 font-mono font-semibold text-brand-cyan">
                  ৳{{ number_format($plan->monthly_price) }}<span class="text-[10px] text-slate-400 font-normal">/mo</span>
                </td>
                <td class="py-3 px-4">
                  @if($plan->is_active)
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-500">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-500/10 text-slate-400">
                      <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                    </span>
                  @endif
                </td>
                <td class="py-3 px-4 text-right">
                  <a href="{{ route('admin.plans.edit', $plan) }}" class="p-1.5 text-slate-400 hover:text-brand-accent transition-colors" title="Edit Plan">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="py-6 text-center text-slate-400">
                  No plans configured yet.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Right 1 Col: Quick Promo & Environment Card -->
    <div class="space-y-6">

      <!-- Active Promo Snapshot -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-brand-slate/40">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-tag text-emerald-500 text-sm"></i>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Active Promotion</h3>
          </div>
          <a href="{{ route('admin.settings.index') }}" class="text-[11px] text-brand-accent hover:underline font-semibold">
            Edit
          </a>
        </div>

        <div class="mt-4 space-y-3 text-xs">
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

      <!-- Server & Environment Stats -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5">
        <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-brand-slate/40">
          <i class="fa-solid fa-hard-drive text-brand-cyan text-sm"></i>
          <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Runtime Environment</h3>
        </div>

        <div class="mt-4 space-y-2.5 text-xs">
          <div class="flex justify-between items-center py-1">
            <span class="text-slate-500 dark:text-slate-400">PHP Version:</span>
            <span class="font-mono font-semibold text-slate-800 dark:text-slate-200">{{ PHP_VERSION }}</span>
          </div>
          <div class="flex justify-between items-center py-1">
            <span class="text-slate-500 dark:text-slate-400">Framework:</span>
            <span class="font-mono font-semibold text-slate-800 dark:text-slate-200">Laravel {{ app()->version() }}</span>
          </div>
          <div class="flex justify-between items-center py-1">
            <span class="text-slate-500 dark:text-slate-400">Database Engine:</span>
            <span class="font-mono font-semibold text-slate-800 dark:text-slate-200 uppercase">{{ config('database.default') }}</span>
          </div>
          <div class="flex justify-between items-center py-1">
            <span class="text-slate-500 dark:text-slate-400">Cache Driver:</span>
            <span class="font-mono font-semibold text-slate-800 dark:text-slate-200 uppercase">{{ config('cache.default') }}</span>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
@endsection

