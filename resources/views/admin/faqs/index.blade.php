@extends('admin.layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">FAQ Accordion Management</h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
        Manage questions and answers displayed in the homepage interactive FAQ section.
      </p>
    </div>
    <button onclick="openFaqModal()" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-semibold shadow-md shadow-brand-accent/25 transition-all">
      <i class="fa-solid fa-plus text-[11px]"></i>
      <span>Add Question</span>
    </button>
  </div>

  <!-- FAQs Table -->
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 dark:bg-brand-dark/60 text-slate-500 dark:text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-200 dark:border-brand-slate/40">
          <tr>
            <th class="py-3 px-4">Question</th>
            <th class="py-3 px-4">Answer Preview</th>
            <th class="py-3 px-4">Order</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-brand-slate/30 text-slate-700 dark:text-slate-300">
          @forelse($faqs as $faq)
            <tr class="hover:bg-slate-50/70 dark:hover:bg-brand-dark/30 transition-colors">
              <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white max-w-xs">
                {{ $faq->question }}
              </td>
              <td class="py-3.5 px-4 text-slate-600 dark:text-slate-300 max-w-md truncate text-[11px]">
                {{ $faq->answer }}
              </td>
              <td class="py-3.5 px-4 font-mono text-slate-400 text-[11px]">
                #{{ $faq->sort_order }}
              </td>
              <td class="py-3.5 px-4">
                <form action="{{ route('admin.faqs.toggle', $faq) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold transition-transform active:scale-95 {{ $faq->is_active ? 'bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20' : 'bg-slate-500/10 text-slate-400 hover:bg-slate-500/20' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $faq->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    <span>{{ $faq->is_active ? 'Active' : 'Inactive' }}</span>
                  </button>
                </form>
              </td>
              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button type="button" onclick="editFaq({{ json_encode($faq) }})" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-accent hover:bg-slate-100 dark:hover:bg-brand-dark transition-colors" title="Edit FAQ">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" onsubmit="return confirm('Delete this FAQ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors" title="Delete FAQ">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-8 text-center text-slate-400">
                No FAQs available.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- FAQ Modal -->
<div id="faqModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden animate-fadeIn">
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 max-w-lg w-full p-6 shadow-2xl">
    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-brand-slate/40 mb-4">
      <h3 id="faqModalTitle" class="text-base font-bold text-slate-900 dark:text-white">Add Question</h3>
      <button onclick="closeFaqModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
        <i class="fa-solid fa-xmark text-base"></i>
      </button>
    </div>

    <form id="faqForm" action="{{ route('admin.faqs.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="hidden" id="faqMethod" name="_method" value="POST">

      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Question</label>
        <input type="text" id="faq_question" name="question" required placeholder="e.g. Do you provide free SSL certificates?"
          class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
      </div>

      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Answer</label>
        <textarea id="faq_answer" name="answer" rows="4" required placeholder="Detailed explanation..."
          class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent"></textarea>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Sort Order</label>
          <input type="number" id="faq_sort" name="sort_order" value="0"
            class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent">
        </div>
        <div class="flex items-center gap-4 pt-5">
          <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
            <input type="checkbox" id="faq_active" name="is_active" value="1" checked class="w-4 h-4 rounded text-brand-accent">
            <span>Active</span>
          </label>
        </div>
      </div>

      <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-200 dark:border-brand-slate/40">
        <button type="button" onclick="closeFaqModal()" class="px-3 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-brand-dark rounded-lg">
          Cancel
        </button>
        <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-brand-accent hover:bg-blue-600 rounded-lg shadow-md shadow-brand-accent/25">
          Save FAQ
        </button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  function openFaqModal() {
    document.getElementById('faqModalTitle').textContent = 'Add FAQ Question';
    document.getElementById('faqForm').action = "{{ route('admin.faqs.store') }}";
    document.getElementById('faqMethod').value = 'POST';
    document.getElementById('faq_question').value = '';
    document.getElementById('faq_answer').value = '';
    document.getElementById('faq_sort').value = '0';
    document.getElementById('faq_active').checked = true;
    document.getElementById('faqModal').classList.remove('hidden');
  }

  function editFaq(f) {
    document.getElementById('faqModalTitle').textContent = 'Edit FAQ Question';
    document.getElementById('faqForm').action = "/admin/faqs/" + f.id;
    document.getElementById('faqMethod').value = 'PUT';
    document.getElementById('faq_question').value = f.question;
    document.getElementById('faq_answer').value = f.answer;
    document.getElementById('faq_sort').value = f.sort_order || 0;
    document.getElementById('faq_active').checked = !!f.is_active;
    document.getElementById('faqModal').classList.remove('hidden');
  }

  function closeFaqModal() {
    document.getElementById('faqModal').classList.add('hidden');
  }
</script>
@endpush
@endsection

