@extends('admin.layouts.app')

@section('title', 'Hosting Packages & Categories')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
        <i class="fa-solid fa-server text-brand-accent"></i>
        <span>Hosting Packages & Categories</span>
      </h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
        Manage plans and custom hosting categories. Changes immediately reflect on the live homepage.
      </p>
    </div>
    <div class="flex items-center gap-2">
      <!-- Open Category Manager Modal Button -->
      <button type="button" onclick="toggleModal('categoryModal', true)" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg border border-slate-300 dark:border-brand-slate/60 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-dark text-xs font-semibold transition-all">
        <i class="fa-solid fa-tags text-brand-accent text-xs"></i>
        <span>Manage Categories ({{ $categories->count() }})</span>
      </button>

      <!-- Add New Plan Button -->
      <a href="{{ route('admin.plans.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-semibold shadow-md shadow-brand-accent/25 transition-all">
        <i class="fa-solid fa-plus text-[11px]"></i>
        <span>Add New Package</span>
      </a>
    </div>
  </div>

  <!-- Dynamic Category Filter Tabs -->
  <div class="flex items-center gap-2 overflow-x-auto pb-1 border-b border-slate-200 dark:border-brand-slate/40">
    <a href="{{ route('admin.plans.index') }}"
      class="px-3 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition-colors {{ empty($category) ? 'bg-brand-accent text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-brand-card' }}">
      All Categories
    </a>
    @foreach($categories as $cat)
      <a href="{{ route('admin.plans.index', ['category' => $cat->slug]) }}"
        class="px-3 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition-colors {{ $category === $cat->slug ? 'bg-brand-accent text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-brand-card' }}">
        {{ $cat->name }}
      </a>
    @endforeach
  </div>

  <!-- Plans Table -->
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 dark:bg-brand-dark/60 text-slate-500 dark:text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-200 dark:border-brand-slate/40">
          <tr>
            <th class="py-3 px-4">Plan & Category</th>
            <th class="py-3 px-4">Pricing (Mo / Yr)</th>
            <th class="py-3 px-4">Specs Summary</th>
            <th class="py-3 px-4">Badges</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-slate-700 dark:text-slate-300">
          @forelse($plans as $plan)
            <tr class="hover:bg-slate-50/70 dark:hover:bg-brand-dark/30 transition-colors">
              <!-- Plan Name & Category -->
              <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white">
                <div class="font-bold text-sm text-slate-900 dark:text-white">{{ $plan->name }}</div>
                <div class="text-[11px] text-slate-400 font-normal">{{ $plan->tagline }}</div>
                <span class="inline-block mt-1 px-2 py-0.5 rounded text-[9px] font-mono uppercase bg-blue-500/10 text-blue-500 font-semibold">
                  {{ $plan->category }}
                </span>
              </td>

              <!-- Pricing -->
              <td class="py-3.5 px-4 font-mono">
                <div class="font-bold text-brand-cyan text-sm">৳{{ number_format($plan->monthly_price) }}<span class="text-[10px] text-slate-400 font-normal">/mo</span></div>
                @if($plan->yearly_price)
                  <div class="text-[10px] text-slate-400">৳{{ number_format($plan->yearly_price) }}/yr</div>
                @endif
              </td>

              <!-- Specs -->
              <td class="py-3.5 px-4 text-slate-600 dark:text-slate-300 text-[11px] space-y-0.5">
                <div><strong class="text-slate-800 dark:text-slate-200">Disk:</strong> {{ $plan->storage ?? 'N/A' }}</div>
                <div><strong class="text-slate-800 dark:text-slate-200">Bandwidth:</strong> {{ $plan->bandwidth ?? 'N/A' }}</div>
                <div><strong class="text-slate-800 dark:text-slate-200">CPU/RAM:</strong> {{ $plan->cpu ?? '' }} / {{ $plan->ram ?? '' }}</div>
              </td>

              <!-- Badges -->
              <td class="py-3.5 px-4 space-y-1">
                @if($plan->badge)
                  <span class="inline-block px-2 py-0.5 rounded text-[9px] font-mono font-bold uppercase bg-brand-accent/20 text-brand-accent">
                    {{ $plan->badge }}
                  </span>
                @endif
                @if($plan->is_popular)
                  <div>
                    <span class="inline-block px-2 py-0.5 rounded text-[9px] font-mono font-bold uppercase bg-amber-500/20 text-amber-500">
                      POPULAR
                    </span>
                  </div>
                @endif
              </td>

              <!-- Status Toggle -->
              <td class="py-3.5 px-4">
                <form action="{{ route('admin.plans.toggle', $plan) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold transition-transform active:scale-95 {{ $plan->is_active ? 'bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20' : 'bg-slate-500/10 text-slate-400 hover:bg-slate-500/20' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $plan->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    <span>{{ $plan->is_active ? 'Active' : 'Inactive' }}</span>
                  </button>
                </form>
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <a href="{{ route('admin.plans.edit', $plan) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-accent hover:bg-slate-100 dark:hover:bg-brand-dark transition-colors" title="Edit Plan">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $plan->name }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors" title="Delete Plan">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-8 text-center text-slate-400">
                No hosting plans found in this category.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- ============================================================== -->
<!-- CATEGORY MANAGER MODAL -->
<!-- ============================================================== -->
<div id="categoryModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/50 shadow-2xl max-w-xl w-full p-6 animate-fadeIn">
    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-brand-slate/40">
      <div class="flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-lg bg-brand-accent/10 text-brand-accent flex items-center justify-center">
          <i class="fa-solid fa-tags text-sm"></i>
        </div>
        <div>
          <h2 class="text-sm font-bold text-slate-900 dark:text-white">Hosting Categories Manager</h2>
          <p class="text-[11px] text-slate-400">Add, edit, or delete categories. Active categories appear as tabs on the homepage.</p>
        </div>
      </div>
      <button type="button" onclick="toggleModal('categoryModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
        <i class="fa-solid fa-xmark text-sm"></i>
      </button>
    </div>

    <!-- Create New Category Form -->
    <form action="{{ route('admin.categories.store') }}" method="POST" class="mt-4 p-4 rounded-xl bg-slate-50 dark:bg-brand-dark/40 border border-slate-200 dark:border-brand-slate/40 space-y-3">
      @csrf
      <div class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
        <i class="fa-solid fa-circle-plus text-emerald-500"></i>
        <span>Create New Category</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Category Name <span class="text-rose-500">*</span>
          </label>
          <input type="text" name="name" required placeholder="e.g. Reseller Hosting, WordPress"
            class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
        <div>
          <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">
            URL Slug (optional)
          </label>
          <input type="text" name="slug" placeholder="Auto-generated if empty"
            class="w-full px-3 py-1.5 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Badge (e.g. High Speed, Reseller)
          </label>
          <input type="text" name="badge" placeholder="Optional badge text"
            class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
        <div>
          <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Sort Order
          </label>
          <input type="number" name="sort_order" value="{{ $categories->count() + 1 }}"
            class="w-full px-3 py-1.5 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-card text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
      </div>

      <div class="text-right">
        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition-all">
          <i class="fa-solid fa-plus text-[10px]"></i>
          <span>Save Category</span>
        </button>
      </div>
    </form>

    <!-- Existing Categories List -->
    <div class="mt-4">
      <div class="text-xs font-bold text-slate-900 dark:text-white mb-2">Existing Categories ({{ $categories->count() }})</div>
      <div class="divide-y divide-slate-100 dark:divide-brand-slate/30 max-h-64 overflow-y-auto pr-1">
        @foreach($categories as $cat)
          @php
            $plansCount = \App\Models\HostingPlan::where('category', $cat->slug)->count();
          @endphp
          <div class="py-2.5 flex items-center justify-between gap-3 text-xs hover:bg-slate-50/50 dark:hover:bg-brand-dark/20 px-2 rounded-lg transition-colors">
            <div class="flex items-center gap-2 flex-wrap">
              <span class="font-bold text-slate-900 dark:text-white">{{ $cat->name }}</span>
              <span class="px-1.5 py-0.5 rounded text-[10px] font-mono bg-slate-100 dark:bg-brand-dark text-slate-500">
                slug: {{ $cat->slug }}
              </span>
              @if($cat->badge)
                <span class="px-1.5 py-0.5 rounded text-[9px] font-mono uppercase bg-brand-accent/10 text-brand-accent font-semibold">
                  {{ $cat->badge }}
                </span>
              @endif
              <span class="text-[10px] text-slate-400 font-mono">
                (Order: {{ $cat->sort_order }})
              </span>
            </div>

            <div class="flex items-center gap-2 shrink-0">
              <span class="text-[11px] text-slate-400 font-mono">
                {{ $plansCount }} {{ Str::plural('plan', $plansCount) }}
              </span>

              <!-- Edit Category Button -->
              <button type="button" 
                onclick="openEditCategoryModal({{ json_encode([
                  'id' => $cat->id,
                  'name' => $cat->name,
                  'slug' => $cat->slug,
                  'badge' => $cat->badge ?? '',
                  'sort_order' => $cat->sort_order ?? 0,
                  'update_url' => route('admin.categories.update', $cat)
                ]) }})" 
                class="p-1.5 text-slate-400 hover:text-brand-accent hover:bg-slate-100 dark:hover:bg-brand-dark rounded-md transition-colors" 
                title="Edit Category">
                <i class="fa-solid fa-pen-to-square text-xs"></i>
              </button>

              <!-- Delete Category Button -->
              <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" 
                onsubmit="return confirm('Are you sure you want to delete category \'{{ addslashes($cat->name) }}\'? @if($plansCount > 0)\n\nNote: {{ $plansCount }} plan(s) in this category will be automatically reassigned to the default category so no packages are lost.@endif');">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-md transition-colors" title="Delete Category">
                  <i class="fa-solid fa-trash-can text-xs"></i>
                </button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-brand-slate/30 text-right">
      <button type="button" onclick="toggleModal('categoryModal', false)" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-dark transition-colors">
        Close
      </button>
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- EDIT CATEGORY MODAL -->
<!-- ============================================================== -->
<div id="editCategoryModal" class="hidden fixed inset-0 z-[60] overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/50 shadow-2xl max-w-lg w-full p-6 animate-fadeIn">
    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-brand-slate/40">
      <div class="flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-brand-accent flex items-center justify-center">
          <i class="fa-solid fa-pen-to-square text-sm"></i>
        </div>
        <div>
          <h2 class="text-sm font-bold text-slate-900 dark:text-white">Edit Category</h2>
          <p class="text-[11px] text-slate-400">Update category name, badge, URL slug, or order.</p>
        </div>
      </div>
      <button type="button" onclick="toggleModal('editCategoryModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
        <i class="fa-solid fa-xmark text-sm"></i>
      </button>
    </div>

    <form id="editCategoryForm" action="" method="POST" class="mt-4 space-y-4">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Category Name <span class="text-rose-500">*</span>
          </label>
          <input type="text" id="editCatName" name="name" required
            class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
        <div>
          <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">
            URL Slug
          </label>
          <input type="text" id="editCatSlug" name="slug"
            class="w-full px-3 py-1.5 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
          <p class="text-[10px] text-slate-400 mt-0.5">Existing packages will update automatically.</p>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Badge (e.g. Recommended)
          </label>
          <input type="text" id="editCatBadge" name="badge" placeholder="Optional badge text"
            class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
        <div>
          <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Sort Order
          </label>
          <input type="number" id="editCatSortOrder" name="sort_order"
            class="w-full px-3 py-1.5 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-white dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
      </div>

      <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-brand-slate/30">
        <button type="button" onclick="toggleModal('editCategoryModal', false)" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-dark transition-colors">
          Cancel
        </button>
        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-semibold shadow-md shadow-brand-accent/25 transition-all">
          <i class="fa-solid fa-floppy-disk text-xs"></i>
          <span>Save Changes</span>
        </button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  function toggleModal(modalId, show) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    if (show) {
      modal.classList.remove('hidden');
    } else {
      modal.classList.add('hidden');
    }
  }

  function openEditCategoryModal(data) {
    const form = document.getElementById('editCategoryForm');
    const nameInput = document.getElementById('editCatName');
    const slugInput = document.getElementById('editCatSlug');
    const badgeInput = document.getElementById('editCatBadge');
    const sortOrderInput = document.getElementById('editCatSortOrder');

    if (form && data) {
      form.action = data.update_url;
      nameInput.value = data.name || '';
      slugInput.value = data.slug || '';
      badgeInput.value = data.badge || '';
      sortOrderInput.value = data.sort_order ?? 0;
      toggleModal('editCategoryModal', true);
    }
  }

  // Close on backdrop click
  document.getElementById('categoryModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
      toggleModal('categoryModal', false);
    }
  });

  document.getElementById('editCategoryModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
      toggleModal('editCategoryModal', false);
    }
  });
</script>
@endpush
@endsection


