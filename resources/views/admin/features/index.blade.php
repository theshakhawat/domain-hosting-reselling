@extends('admin.layouts.app')

@section('title', 'Core Features Management')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Core Features & Architecture</h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
        Manage the hardware, network, and infrastructure feature highlights displayed on the homepage.
      </p>
    </div>
    <button onclick="openFeatureModal()" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-semibold shadow-md shadow-brand-accent/25 transition-all">
      <i class="fa-solid fa-plus text-[11px]"></i>
      <span>Add Feature</span>
    </button>
  </div>

  <!-- Features Grid / Table -->
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 dark:bg-brand-dark/60 text-slate-500 dark:text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-200 dark:border-brand-slate/40">
          <tr>
            <th class="py-3 px-4">Feature & Icon</th>
            <th class="py-3 px-4">Description</th>
            <th class="py-3 px-4">Highlight Metric</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-slate-700 dark:text-slate-300">
          @forelse($features as $feat)
            <tr class="hover:bg-slate-50/70 dark:hover:bg-brand-dark/30 transition-colors">
              <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-lg bg-brand-accent/10 text-brand-accent flex items-center justify-center text-sm shrink-0">
                    <i class="{{ $feat->icon }}"></i>
                  </div>
                  <div>
                    <div class="font-bold text-slate-900 dark:text-white">{{ $feat->title }}</div>
                    @if($feat->badge)
                      <span class="inline-block mt-0.5 px-1.5 py-0.2 rounded text-[9px] font-mono uppercase bg-brand-cyan/20 text-brand-cyan">
                        {{ $feat->badge }}
                      </span>
                    @endif
                  </div>
                </div>
              </td>
              <td class="py-3.5 px-4 text-slate-600 dark:text-slate-300 max-w-sm truncate text-[11px]">
                {{ $feat->description }}
              </td>
              <td class="py-3.5 px-4 font-mono text-[11px]">
                @if($feat->highlight_metric)
                  <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-brand-dark text-brand-accent font-bold">
                    {{ $feat->highlight_metric }}
                  </span>
                @else
                  <span class="text-slate-400">—</span>
                @endif
              </td>
              <td class="py-3.5 px-4">
                <form action="{{ route('admin.features.toggle', $feat) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold transition-transform active:scale-95 {{ $feat->is_active ? 'bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20' : 'bg-slate-500/10 text-slate-400 hover:bg-slate-500/20' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $feat->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    <span>{{ $feat->is_active ? 'Active' : 'Inactive' }}</span>
                  </button>
                </form>
              </td>
              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button type="button" onclick="editFeature({{ json_encode($feat) }})" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-accent hover:bg-slate-100 dark:hover:bg-brand-dark transition-colors" title="Edit Feature">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <form action="{{ route('admin.features.destroy', $feat) }}" method="POST" onsubmit="return confirm('Delete this feature?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors" title="Delete Feature">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-8 text-center text-slate-400">
                No features registered yet.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Feature Modal -->
<div id="featureModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden animate-fadeIn">
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 max-w-lg w-full p-6 shadow-2xl">
    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-brand-slate/40 mb-4">
      <h3 id="featureModalTitle" class="text-base font-bold text-slate-900 dark:text-white">Add Feature</h3>
      <button onclick="closeFeatureModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
        <i class="fa-solid fa-xmark text-base"></i>
      </button>
    </div>

    <form id="featureForm" action="{{ route('admin.features.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="hidden" id="featureMethod" name="_method" value="POST">

      <div class="grid grid-cols-3 gap-3">
        <div class="col-span-2">
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Feature Title</label>
          <input type="text" id="feat_title" name="title" required placeholder="e.g. Gen-4 NVMe Enterprise Arrays"
            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">FontAwesome Icon</label>
          <input type="text" id="feat_icon" name="icon" required placeholder="fa-solid fa-bolt"
            class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
      </div>

      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Description</label>
        <textarea id="feat_desc" name="description" rows="3" required placeholder="Brief description of the technology or feature..."
          class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent"></textarea>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Metric / Highlight Text</label>
          <input type="text" id="feat_metric" name="highlight_metric" placeholder="e.g. 7,450 MB/s Read"
            class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Badge</label>
          <input type="text" id="feat_badge" name="badge" placeholder="e.g. ULTRA SPEED"
            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Sort Order</label>
          <input type="number" id="feat_sort" name="sort_order" value="0"
            class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
        <div class="flex items-center gap-4 pt-5">
          <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
            <input type="checkbox" id="feat_active" name="is_active" value="1" checked class="w-4 h-4 rounded text-brand-accent">
            <span>Active</span>
          </label>
        </div>
      </div>

      <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-200 dark:border-brand-slate/40">
        <button type="button" onclick="closeFeatureModal()" class="px-3 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-brand-dark rounded-lg">
          Cancel
        </button>
        <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-brand-accent hover:bg-blue-600 rounded-lg shadow-md shadow-brand-accent/25">
          Save Feature
        </button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  function openFeatureModal() {
    document.getElementById('featureModalTitle').textContent = 'Add Feature';
    document.getElementById('featureForm').action = "{{ route('admin.features.store') }}";
    document.getElementById('featureMethod').value = 'POST';
    document.getElementById('feat_title').value = '';
    document.getElementById('feat_icon').value = 'fa-solid fa-bolt';
    document.getElementById('feat_desc').value = '';
    document.getElementById('feat_metric').value = '';
    document.getElementById('feat_badge').value = '';
    document.getElementById('feat_sort').value = '0';
    document.getElementById('feat_active').checked = true;
    document.getElementById('featureModal').classList.remove('hidden');
  }

  function editFeature(f) {
    document.getElementById('featureModalTitle').textContent = 'Edit Feature: ' + f.title;
    document.getElementById('featureForm').action = "/admin/features/" + f.id;
    document.getElementById('featureMethod').value = 'PUT';
    document.getElementById('feat_title').value = f.title;
    document.getElementById('feat_icon').value = f.icon;
    document.getElementById('feat_desc').value = f.description;
    document.getElementById('feat_metric').value = f.highlight_metric || '';
    document.getElementById('feat_badge').value = f.badge || '';
    document.getElementById('feat_sort').value = f.sort_order || 0;
    document.getElementById('feat_active').checked = !!f.is_active;
    document.getElementById('featureModal').classList.remove('hidden');
  }

  function closeFeatureModal() {
    document.getElementById('featureModal').classList.add('hidden');
  }
</script>
@endpush
@endsection

