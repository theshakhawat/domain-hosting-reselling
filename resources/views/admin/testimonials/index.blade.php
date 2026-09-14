@extends('admin.layouts.app')

@section('title', 'Client Reviews & Testimonials')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Client Reviews & Testimonials</h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
        Manage customer reviews, testimonials, company designations, and ratings on the homepage.
      </p>
    </div>
    <button onclick="openReviewModal()" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-semibold shadow-md shadow-brand-accent/25 transition-all">
      <i class="fa-solid fa-plus text-[11px]"></i>
      <span>Add Review</span>
    </button>
  </div>

  <!-- Reviews Grid / Table -->
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 dark:bg-brand-dark/60 text-slate-500 dark:text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-200 dark:border-brand-slate/40">
          <tr>
            <th class="py-3 px-4">Client & Role</th>
            <th class="py-3 px-4">Review Text</th>
            <th class="py-3 px-4">Rating</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-slate-700 dark:text-slate-300">
          @forelse($testimonials as $rev)
            <tr class="hover:bg-slate-50/70 dark:hover:bg-brand-dark/30 transition-colors">
              <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-brand-dark flex items-center justify-center font-bold text-xs text-brand-accent shrink-0">
                    {{ strtoupper(substr($rev->client_name, 0, 1)) }}
                  </div>
                  <div>
                    <div class="font-bold text-slate-900 dark:text-white">{{ $rev->client_name }}</div>
                    <div class="text-[11px] text-slate-400 font-normal">
                      {{ $rev->role }} @if($rev->company) · <span class="font-medium">{{ $rev->company }}</span>@endif
                    </div>
                  </div>
                </div>
              </td>
              <td class="py-3.5 px-4 text-slate-600 dark:text-slate-300 max-w-sm truncate text-[11px]">
                "{{ $rev->review_text }}"
              </td>
              <td class="py-3.5 px-4">
                <div class="flex items-center text-amber-400 text-xs">
                  @for($i = 1; $i <= 5; $i++)
                    <i class="fa-solid fa-star {{ $i <= $rev->rating ? 'text-amber-400' : 'text-slate-300 dark:text-brand-slate/50' }}"></i>
                  @endfor
                </div>
              </td>
              <td class="py-3.5 px-4">
                <form action="{{ route('admin.testimonials.toggle', $rev) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold transition-transform active:scale-95 {{ $rev->is_active ? 'bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20' : 'bg-slate-500/10 text-slate-400 hover:bg-slate-500/20' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $rev->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    <span>{{ $rev->is_active ? 'Active' : 'Inactive' }}</span>
                  </button>
                </form>
              </td>
              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button type="button" onclick="editReview({{ json_encode($rev) }})" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-accent hover:bg-slate-100 dark:hover:bg-brand-dark transition-colors" title="Edit Review">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <form action="{{ route('admin.testimonials.destroy', $rev) }}" method="POST" onsubmit="return confirm('Delete this review?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors" title="Delete Review">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-8 text-center text-slate-400">
                No reviews found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden animate-fadeIn">
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 max-w-lg w-full p-6 shadow-2xl">
    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-brand-slate/40 mb-4">
      <h3 id="reviewModalTitle" class="text-base font-bold text-slate-900 dark:text-white">Add Review</h3>
      <button onclick="closeReviewModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
        <i class="fa-solid fa-xmark text-base"></i>
      </button>
    </div>

    <form id="reviewForm" action="{{ route('admin.testimonials.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="hidden" id="reviewMethod" name="_method" value="POST">

      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Client Name</label>
        <input type="text" id="rev_name" name="client_name" required placeholder="e.g. Tanvir Ahmed"
          class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Role / Designation</label>
          <input type="text" id="rev_role" name="role" placeholder="e.g. CTO & Co-Founder"
            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Company</label>
          <input type="text" id="rev_company" name="company" placeholder="e.g. ShoperBD"
            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Rating (1 to 5)</label>
          <select id="rev_rating" name="rating" required
            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
            <option value="5">★★★★★ (5 Stars)</option>
            <option value="4">★★★★☆ (4 Stars)</option>
            <option value="3">★★★☆☆ (3 Stars)</option>
            <option value="2">★★☆☆☆ (2 Stars)</option>
            <option value="1">★☆☆☆☆ (1 Star)</option>
          </select>
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Sort Order</label>
          <input type="number" id="rev_sort" name="sort_order" value="0"
            class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
      </div>

      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Review Text</label>
        <textarea id="rev_text" name="review_text" rows="3" required placeholder="What the client said about our hosting..."
          class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent"></textarea>
      </div>

      <div class="flex items-center gap-4 pt-1">
        <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
          <input type="checkbox" id="rev_active" name="is_active" value="1" checked class="w-4 h-4 rounded text-brand-accent">
          <span>Active / Published</span>
        </label>
      </div>

      <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-200 dark:border-brand-slate/40">
        <button type="button" onclick="closeReviewModal()" class="px-3 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-brand-dark rounded-lg">
          Cancel
        </button>
        <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-brand-accent hover:bg-blue-600 rounded-lg shadow-md shadow-brand-accent/25">
          Save Review
        </button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  function openReviewModal() {
    document.getElementById('reviewModalTitle').textContent = 'Add Review';
    document.getElementById('reviewForm').action = "{{ route('admin.testimonials.store') }}";
    document.getElementById('reviewMethod').value = 'POST';
    document.getElementById('rev_name').value = '';
    document.getElementById('rev_role').value = '';
    document.getElementById('rev_company').value = '';
    document.getElementById('rev_rating').value = '5';
    document.getElementById('rev_sort').value = '0';
    document.getElementById('rev_text').value = '';
    document.getElementById('rev_active').checked = true;
    document.getElementById('reviewModal').classList.remove('hidden');
  }

  function editReview(r) {
    document.getElementById('reviewModalTitle').textContent = 'Edit Review: ' + r.client_name;
    document.getElementById('reviewForm').action = "/admin/testimonials/" + r.id;
    document.getElementById('reviewMethod').value = 'PUT';
    document.getElementById('rev_name').value = r.client_name;
    document.getElementById('rev_role').value = r.role || '';
    document.getElementById('rev_company').value = r.company || '';
    document.getElementById('rev_rating').value = r.rating || 5;
    document.getElementById('rev_sort').value = r.sort_order || 0;
    document.getElementById('rev_text').value = r.review_text;
    document.getElementById('rev_active').checked = !!r.is_active;
    document.getElementById('reviewModal').classList.remove('hidden');
  }

  function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
  }
</script>
@endpush
@endsection

