@extends('admin.layouts.app')

@section('title', 'Domain TLDs & Pricing')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Domain TLDs & Pricing</h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
        Manage top-level domain extensions, registration pricing, renewals, and promo badges.
      </p>
    </div>
    <button onclick="openDomainModal()" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-semibold shadow-md shadow-brand-accent/25 transition-all">
      <i class="fa-solid fa-plus text-[11px]"></i>
      <span>Add New TLD</span>
    </button>
  </div>

  <!-- Domains Table -->
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 dark:bg-brand-dark/60 text-slate-500 dark:text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-200 dark:border-brand-slate/40">
          <tr>
            <th class="py-3 px-4">TLD Extension</th>
            <th class="py-3 px-4">Registration Price</th>
            <th class="py-3 px-4">Renewal Price</th>
            <th class="py-3 px-4">Badge</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-slate-700 dark:text-slate-300">
          @forelse($domains as $domain)
            <tr class="hover:bg-slate-50/70 dark:hover:bg-brand-dark/30 transition-colors">
              <td class="py-3.5 px-4 font-mono font-bold text-sm text-slate-900 dark:text-white">
                <div class="flex items-center gap-2">
                  <span class="w-7 h-7 rounded-lg bg-slate-100 dark:bg-brand-dark flex items-center justify-center text-xs text-brand-accent font-bold">
                    <i class="fa-solid fa-globe"></i>
                  </span>
                  <span>{{ $domain->tld }}</span>
                  @if($domain->is_popular)
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-mono font-bold uppercase bg-amber-500/20 text-amber-500">
                      Popular
                    </span>
                  @endif
                </div>
              </td>
              <td class="py-3.5 px-4 font-mono font-bold text-emerald-500 text-sm">
                ৳{{ number_format($domain->price) }}<span class="text-[10px] text-slate-400 font-normal">/yr</span>
              </td>
              <td class="py-3.5 px-4 font-mono text-slate-600 dark:text-slate-300">
                ৳{{ number_format($domain->renewal_price) }}<span class="text-[10px] text-slate-400 font-normal">/yr</span>
              </td>
              <td class="py-3.5 px-4">
                @if($domain->badge)
                  <span class="px-2 py-0.5 rounded text-[9px] font-mono font-bold uppercase bg-brand-cyan/20 text-brand-cyan">
                    {{ $domain->badge }}
                  </span>
                @else
                  <span class="text-slate-400 font-mono text-[10px]">—</span>
                @endif
              </td>
              <td class="py-3.5 px-4">
                <form action="{{ route('admin.domains.toggle', $domain) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold transition-transform active:scale-95 {{ $domain->is_active ? 'bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20' : 'bg-slate-500/10 text-slate-400 hover:bg-slate-500/20' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $domain->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    <span>{{ $domain->is_active ? 'Active' : 'Inactive' }}</span>
                  </button>
                </form>
              </td>
              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button type="button" onclick="editDomain({{ json_encode($domain) }})" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-accent hover:bg-slate-100 dark:hover:bg-brand-dark transition-colors" title="Edit TLD">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <form action="{{ route('admin.domains.destroy', $domain) }}" method="POST" onsubmit="return confirm('Delete {{ $domain->tld }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors" title="Delete TLD">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-8 text-center text-slate-400">
                No domain TLDs registered yet.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Modal for Create / Edit Domain -->
<div id="domainModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden animate-fadeIn">
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 max-w-md w-full p-6 shadow-2xl">
    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-brand-slate/40 mb-4">
      <h3 id="domainModalTitle" class="text-base font-bold text-slate-900 dark:text-white">Add Domain TLD</h3>
      <button onclick="closeDomainModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
        <i class="fa-solid fa-xmark text-base"></i>
      </button>
    </div>

    <form id="domainForm" action="{{ route('admin.domains.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="hidden" id="domainMethod" name="_method" value="POST">

      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">TLD Extension (e.g. .com)</label>
        <input type="text" id="domain_tld" name="tld" required placeholder=".com"
          class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Registration (৳)</label>
          <input type="number" step="1" id="domain_price" name="price" required placeholder="1290"
            class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Renewal (৳)</label>
          <input type="number" step="1" id="domain_renewal" name="renewal_price" placeholder="1450"
            class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Badge (Optional)</label>
          <input type="text" id="domain_badge" name="badge" placeholder="e.g. Popular"
            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Sort Order</label>
          <input type="number" id="domain_sort" name="sort_order" value="0"
            class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
      </div>

      <div class="flex items-center gap-6 pt-2">
        <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
          <input type="checkbox" id="domain_is_popular" name="is_popular" value="1" class="w-4 h-4 rounded text-brand-accent">
          <span>Highlight as Popular</span>
        </label>
        <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
          <input type="checkbox" id="domain_is_active" name="is_active" value="1" checked class="w-4 h-4 rounded text-brand-accent">
          <span>Active</span>
        </label>
      </div>

      <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-200 dark:border-brand-slate/40">
        <button type="button" onclick="closeDomainModal()" class="px-3 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-brand-dark rounded-lg">
          Cancel
        </button>
        <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-brand-accent hover:bg-blue-600 rounded-lg shadow-md shadow-brand-accent/25">
          Save TLD
        </button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  function openDomainModal() {
    document.getElementById('domainModalTitle').textContent = 'Add Domain TLD';
    document.getElementById('domainForm').action = "{{ route('admin.domains.store') }}";
    document.getElementById('domainMethod').value = 'POST';
    document.getElementById('domain_tld').value = '';
    document.getElementById('domain_price').value = '';
    document.getElementById('domain_renewal').value = '';
    document.getElementById('domain_badge').value = '';
    document.getElementById('domain_sort').value = '0';
    document.getElementById('domain_is_popular').checked = false;
    document.getElementById('domain_is_active').checked = true;
    document.getElementById('domainModal').classList.remove('hidden');
  }

  function editDomain(d) {
    document.getElementById('domainModalTitle').textContent = 'Edit Domain: ' + d.tld;
    document.getElementById('domainForm').action = "/admin/domains/" + d.id;
    document.getElementById('domainMethod').value = 'PUT';
    document.getElementById('domain_tld').value = d.tld;
    document.getElementById('domain_price').value = d.price;
    document.getElementById('domain_renewal').value = d.renewal_price || '';
    document.getElementById('domain_badge').value = d.badge || '';
    document.getElementById('domain_sort').value = d.sort_order || 0;
    document.getElementById('domain_is_popular').checked = !!d.is_popular;
    document.getElementById('domain_is_active').checked = !!d.is_active;
    document.getElementById('domainModal').classList.remove('hidden');
  }

  function closeDomainModal() {
    document.getElementById('domainModal').classList.add('hidden');
  }
</script>
@endpush
@endsection

