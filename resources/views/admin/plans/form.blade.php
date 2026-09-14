@extends('admin.layouts.app')

@section('title', $isEdit ? 'Edit Hosting Plan' : 'Add New Hosting Plan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-1">
        <a href="{{ route('admin.plans.index') }}" class="hover:text-brand-accent">Hosting Packages</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span>{{ $isEdit ? 'Edit Plan' : 'Create Plan' }}</span>
      </div>
      <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
        {{ $isEdit ? 'Edit: ' . $plan->name : 'Create New Hosting Package' }}
      </h1>
    </div>
    <a href="{{ route('admin.plans.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-300 dark:border-brand-slate/60 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-brand-card transition-colors">
      <i class="fa-solid fa-arrow-left text-[11px]"></i>
      <span>Back</span>
    </a>
  </div>

  <!-- Form Card -->
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-6 sm:p-8">
    <form action="{{ $isEdit ? route('admin.plans.update', $plan) : route('admin.plans.store') }}" method="POST" class="space-y-6">
      @csrf
      @if($isEdit)
        @method('PUT')
      @endif

      <!-- Basic Info Section -->
      <div>
        <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-brand-accent border-b border-slate-200 dark:border-brand-slate/40 pb-2 mb-4">
          Basic Package Information
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <!-- Name -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Plan Name <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="name" required value="{{ old('name', $plan->name) }}" placeholder="e.g. Starter NVMe"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
            @error('name') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
          </div>

          <!-- Category -->
          <div>
            <div class="flex items-center justify-between mb-1">
              <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                Category <span class="text-rose-500">*</span>
              </label>
              <button type="button" onclick="toggleCustomCategoryInput()" class="text-[11px] text-brand-accent hover:underline flex items-center gap-1">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span id="customCatToggleLabel">New Category</span>
              </button>
            </div>

            <!-- Existing Categories Dropdown -->
            <select name="category" id="categorySelect" onchange="handleCategorySelectChange(this.value)" required
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
              @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ old('category', $plan->category) === $cat->slug ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
              <option value="custom" {{ old('category') === 'custom' ? 'selected' : '' }}>+ Create Custom Category...</option>
            </select>

            <!-- Custom Category Name Input (Revealed if custom chosen or clicked) -->
            <div id="customCategoryGroup" class="{{ old('category') === 'custom' ? '' : 'hidden' }} mt-2">
              <input type="text" name="new_category_name" id="newCategoryName" value="{{ old('new_category_name') }}" placeholder="e.g. Reseller Hosting, WordPress Hosting"
                class="w-full px-3 py-2 text-xs rounded-lg border border-brand-accent bg-blue-50/50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-brand-accent">
              <p class="text-[10px] text-slate-400 mt-1">This will automatically create the category and display it on the homepage.</p>
            </div>
            @error('category') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
          </div>

          <!-- Tagline -->
          <div class="sm:col-span-2">
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Tagline / Short Summary
            </label>
            <input type="text" name="tagline" value="{{ old('tagline', $plan->tagline) }}" placeholder="e.g. Best for portfolios, personal blogs, and lightweight websites."
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
            @error('tagline') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      <!-- Pricing & Badges Section -->
      <div>
        <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-brand-accent border-b border-slate-200 dark:border-brand-slate/40 pb-2 mb-4">
          Pricing & Badges
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <!-- Monthly Price -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Monthly Price (BDT ৳) <span class="text-rose-500">*</span>
            </label>
            <input type="number" step="1" name="monthly_price" required value="{{ old('monthly_price', $plan->monthly_price) }}" placeholder="299"
              class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
            @error('monthly_price') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
          </div>

          <!-- Yearly Price -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Yearly Price (BDT ৳)
            </label>
            <input type="number" step="1" name="yearly_price" value="{{ old('yearly_price', $plan->yearly_price) }}" placeholder="2990"
              class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
            <p class="text-[10px] text-slate-400 mt-1">Leave empty to auto-calculate (10 months equivalent)</p>
          </div>

          <!-- Badge Label -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Highlight Badge (Optional)
            </label>
            <input type="text" name="badge" value="{{ old('badge', $plan->badge) }}" placeholder="e.g. MOST POPULAR"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
          </div>
        </div>
      </div>

      <!-- Key Specs Section -->
      <div>
        <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-brand-accent border-b border-slate-200 dark:border-brand-slate/40 pb-2 mb-4">
          Hardware & Resource Specifications
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">NVMe Storage</label>
            <input type="text" name="storage" value="{{ old('storage', $plan->storage) }}" placeholder="e.g. 10 GB NVMe"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Bandwidth</label>
            <input type="text" name="bandwidth" value="{{ old('bandwidth', $plan->bandwidth) }}" placeholder="e.g. 250 GB Bandwidth"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">CPU Allocation</label>
            <input type="text" name="cpu" value="{{ old('cpu', $plan->cpu) }}" placeholder="e.g. 1 vCPU Core"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">RAM</label>
            <input type="text" name="ram" value="{{ old('ram', $plan->ram) }}" placeholder="e.g. 2 GB RAM"
              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
          </div>
        </div>
      </div>

      <!-- Feature Bullet Points -->
      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
          Feature Bullet Points (One per line)
        </label>
        @php
          $featuresRaw = old('features_raw', is_array($plan->features) ? implode("\n", $plan->features) : '');
        @endphp
        <textarea name="features_raw" rows="5" placeholder="1 Website&#10;10 GB NVMe Storage&#10;Free SSL & CDN&#10;cPanel Control Panel"
          class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">{{ $featuresRaw }}</textarea>
        <p class="text-[10px] text-slate-400 mt-1">Each line will become a bullet point with a green checkmark on the pricing cards.</p>
      </div>

      <!-- Options / Toggles -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-slate-200 dark:border-brand-slate/40">
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Sort Order</label>
          <input type="number" name="sort_order" value="{{ old('sort_order', $plan->sort_order ?? 0) }}"
            class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
        </div>

        <div class="flex items-center gap-3 pt-5">
          <input type="checkbox" id="is_popular" name="is_popular" value="1" {{ old('is_popular', $plan->is_popular) ? 'checked' : '' }}
            class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60">
          <label for="is_popular" class="text-xs font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
            Mark as Popular Card
          </label>
        </div>

        <div class="flex items-center gap-3 pt-5">
          <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $plan->is_active ?? true) ? 'checked' : '' }}
            class="w-4 h-4 rounded text-brand-accent focus:ring-brand-accent border-slate-300 dark:border-brand-slate/60">
          <label for="is_active" class="text-xs font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
            Active / Published
          </label>
        </div>
      </div>

      <!-- Submit Actions -->
      <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-brand-slate/40">
        <a href="{{ route('admin.plans.index') }}" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-brand-dark transition-colors">
          Cancel
        </a>
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-semibold shadow-md shadow-brand-accent/25 transition-all active:scale-[0.98]">
          <i class="fa-solid fa-floppy-disk text-xs"></i>
          <span>{{ $isEdit ? 'Save Changes' : 'Create Package' }}</span>
        </button>
      </div>

    </form>
  </div>

</div>

@push('scripts')
<script>
  function handleCategorySelectChange(val) {
    const group = document.getElementById('customCategoryGroup');
    const input = document.getElementById('newCategoryName');
    const label = document.getElementById('customCatToggleLabel');
    if (val === 'custom') {
      group.classList.remove('hidden');
      input.focus();
      label.textContent = 'Use Existing';
    } else {
      group.classList.add('hidden');
      label.textContent = 'New Category';
    }
  }

  function toggleCustomCategoryInput() {
    const select = document.getElementById('categorySelect');
    const group = document.getElementById('customCategoryGroup');
    const input = document.getElementById('newCategoryName');
    const label = document.getElementById('customCatToggleLabel');

    if (group.classList.contains('hidden')) {
      select.value = 'custom';
      group.classList.remove('hidden');
      input.focus();
      label.textContent = 'Use Existing';
    } else {
      select.value = select.options[0]?.value || 'shared';
      group.classList.add('hidden');
      input.value = '';
      label.textContent = 'New Category';
    }
  }
</script>
@endpush
@endsection

