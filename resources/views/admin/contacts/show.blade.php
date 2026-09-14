@extends('admin.layouts.app')

@section('title', 'Ticket Details #' . $contact->ticket_no)

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">

  <!-- Breadcrumb & Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="space-y-1">
      <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin.contacts.index') }}" class="hover:text-brand-accent transition-colors flex items-center gap-1">
          <i class="fa-solid fa-arrow-left text-[10px]"></i>
          <span>Support Inquiries</span>
        </a>
        <span>/</span>
        <span class="font-mono text-slate-700 dark:text-slate-300 font-semibold">{{ $contact->ticket_no }}</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
        <i class="fa-solid fa-ticket text-brand-accent"></i>
        <span>Ticket Details & Resolution</span>
      </h1>
    </div>

    <!-- Top Action Buttons -->
    <div class="flex items-center gap-2">
      <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-slate-200 dark:border-brand-slate/50 bg-white dark:bg-brand-card text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-brand-dark transition-colors">
        <i class="fa-solid fa-arrow-left text-xs"></i>
        <span>Back to List</span>
      </a>

      <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete ticket #{{ $contact->ticket_no }}?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-rose-200 dark:border-rose-900/50 bg-rose-50 dark:bg-rose-950/40 text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/60 transition-colors">
          <i class="fa-solid fa-trash-can text-xs"></i>
          <span>Delete Ticket</span>
        </button>
      </form>
    </div>
  </div>

  <!-- Ticket Status Summary Banner -->
  <div class="bg-white dark:bg-brand-card p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex flex-wrap items-center gap-3">
      <span class="px-3 py-1 rounded-lg text-xs font-mono font-bold bg-slate-900 dark:bg-brand-dark text-white border border-slate-800 dark:border-brand-slate/60">
        {{ $contact->ticket_no }}
      </span>

      <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase font-mono bg-blue-500/10 text-brand-accent border border-blue-500/20">
        <i class="fa-solid fa-tag text-[10px] mr-1"></i>
        {{ $contact->issue_type }}
      </span>

      @if($contact->status === 'new')
        <span class="px-3 py-1 rounded-full text-xs font-bold font-mono bg-rose-500/10 text-rose-500 border border-rose-500/20 flex items-center gap-1.5">
          <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
          <span>Status: New Ticket</span>
        </span>
      @elseif($contact->status === 'seen')
        <span class="px-3 py-1 rounded-full text-xs font-bold font-mono bg-blue-500/10 text-blue-500 border border-blue-500/20 flex items-center gap-1.5">
          <i class="fa-solid fa-eye text-xs"></i>
          <span>Status: Seen / Reviewed</span>
        </span>
      @elseif($contact->status === 'in_progress')
        <span class="px-3 py-1 rounded-full text-xs font-bold font-mono bg-amber-500/10 text-amber-500 border border-amber-500/20 flex items-center gap-1.5">
          <i class="fa-solid fa-spinner fa-spin text-xs"></i>
          <span>Status: In Progress</span>
        </span>
      @elseif($contact->status === 'fixed')
        <span class="px-3 py-1 rounded-full text-xs font-bold font-mono bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 flex items-center gap-1.5">
          <i class="fa-solid fa-check text-xs"></i>
          <span>Status: Fixed / Resolved</span>
        </span>
      @endif
    </div>

    <div class="text-xs text-slate-500 dark:text-slate-400 font-mono flex items-center gap-3">
      <span class="flex items-center gap-1">
        <i class="fa-solid fa-clock text-[11px]"></i>
        <span>Submitted {{ $contact->created_at->diffForHumans() }}</span>
      </span>
      <span>•</span>
      <span>{{ $contact->created_at->format('M d, Y - h:i A') }}</span>
    </div>
  </div>

  <!-- 2-Column Responsive Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    <!-- Left Column: Subject, Message, Screenshot (8 cols) -->
    <div class="lg:col-span-8 space-y-6">

      <!-- Subject & Description Card -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5 sm:p-6 space-y-4">
        <div>
          <span class="text-[10px] font-mono uppercase tracking-wider text-slate-400 block mb-1">Inquiry Subject</span>
          <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white leading-snug">
            {{ $contact->subject }}
          </h2>
        </div>

        <div class="pt-3 border-t border-slate-100 dark:border-brand-slate/30">
          <span class="text-[10px] font-mono uppercase tracking-wider text-slate-400 block mb-2">Problem Description / Message</span>
          <div class="p-4 sm:p-5 rounded-xl bg-slate-50 dark:bg-brand-dark/60 border border-slate-200/80 dark:border-brand-slate/30 text-xs sm:text-sm text-slate-800 dark:text-slate-200 whitespace-pre-line leading-relaxed">
{{ $contact->description }}
          </div>
        </div>
      </div>

      <!-- Attachment Screenshot Card -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5 sm:p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-brand-slate/30">
          <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-paperclip text-brand-accent"></i>
            <span>Attached Screenshot / Error Log</span>
          </h3>
          @if($contact->screenshot)
            <a href="{{ asset($contact->screenshot) }}" target="_blank" class="text-xs font-semibold text-brand-accent hover:underline flex items-center gap-1">
              <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
              <span>Open Original</span>
            </a>
          @endif
        </div>

        @if($contact->screenshot)
          <div class="space-y-3">
            <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-brand-slate/50 bg-slate-900/10 dark:bg-black/30 p-2 sm:p-3 text-center">
              <a href="{{ asset($contact->screenshot) }}" target="_blank" title="Click to open full resolution in new tab">
                <img src="{{ asset($contact->screenshot) }}" alt="Ticket Attachment" class="max-h-96 mx-auto rounded-lg object-contain shadow-md hover:opacity-95 transition-opacity cursor-zoom-in">
              </a>
            </div>
            <div class="flex items-center justify-between text-[11px] text-slate-400 font-mono px-1">
              <span>File: {{ basename($contact->screenshot) }}</span>
              <a href="{{ asset($contact->screenshot) }}" download class="text-brand-accent hover:underline flex items-center gap-1 font-semibold">
                <i class="fa-solid fa-download text-[10px]"></i>
                <span>Download Attachment</span>
              </a>
            </div>
          </div>
        @else
          <div class="p-8 text-center text-slate-400">
            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-brand-dark flex items-center justify-center mx-auto mb-2 text-slate-400">
              <i class="fa-regular fa-image text-lg"></i>
            </div>
            <p class="text-xs font-medium">No screenshot or image attached by the client.</p>
          </div>
        @endif
      </div>

    </div>

    <!-- Right Column: Status Manager & Client Info (4 cols) -->
    <div class="lg:col-span-4 space-y-6">

      <!-- Status Manager Card -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5 space-y-4">
        <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2">
          <i class="fa-solid fa-bars-progress text-brand-accent"></i>
          <span>Update Status</span>
        </h3>

        <form action="{{ route('admin.contacts.status', $contact) }}" method="POST" class="space-y-2.5">
          @csrf
          @method('PATCH')

          <button type="submit" name="status" value="new" 
            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border text-xs font-semibold transition-all {{ $contact->status === 'new' ? 'border-rose-500 bg-rose-500/10 text-rose-600 dark:text-rose-400 ring-2 ring-rose-500/20' : 'border-slate-200 dark:border-brand-slate/40 bg-slate-50 dark:bg-brand-dark/50 text-slate-700 dark:text-slate-300 hover:bg-rose-50/50 dark:hover:bg-rose-950/20' }}">
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
              <span>New Ticket</span>
            </div>
            @if($contact->status === 'new')
              <i class="fa-solid fa-circle-check text-rose-500"></i>
            @endif
          </button>

          <button type="submit" name="status" value="seen" 
            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border text-xs font-semibold transition-all {{ $contact->status === 'seen' ? 'border-blue-500 bg-blue-500/10 text-blue-600 dark:text-blue-400 ring-2 ring-blue-500/20' : 'border-slate-200 dark:border-brand-slate/40 bg-slate-50 dark:bg-brand-dark/50 text-slate-700 dark:text-slate-300 hover:bg-blue-50/50 dark:hover:bg-blue-950/20' }}">
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
              <span>Mark as Seen</span>
            </div>
            @if($contact->status === 'seen')
              <i class="fa-solid fa-circle-check text-blue-500"></i>
            @endif
          </button>

          <button type="submit" name="status" value="in_progress" 
            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border text-xs font-semibold transition-all {{ $contact->status === 'in_progress' ? 'border-amber-500 bg-amber-500/10 text-amber-600 dark:text-amber-400 ring-2 ring-amber-500/20' : 'border-slate-200 dark:border-brand-slate/40 bg-slate-50 dark:bg-brand-dark/50 text-slate-700 dark:text-slate-300 hover:bg-amber-50/50 dark:hover:bg-amber-950/20' }}">
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
              <span>In Progress</span>
            </div>
            @if($contact->status === 'in_progress')
              <i class="fa-solid fa-circle-check text-amber-500"></i>
            @endif
          </button>

          <button type="submit" name="status" value="fixed" 
            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border text-xs font-semibold transition-all {{ $contact->status === 'fixed' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 ring-2 ring-emerald-500/20' : 'border-slate-200 dark:border-brand-slate/40 bg-slate-50 dark:bg-brand-dark/50 text-slate-700 dark:text-slate-300 hover:bg-emerald-50/50 dark:hover:bg-emerald-950/20' }}">
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
              <span>Fixed / Resolved</span>
            </div>
            @if($contact->status === 'fixed')
              <i class="fa-solid fa-circle-check text-emerald-500"></i>
            @endif
          </button>
        </form>
      </div>

      <!-- Client Details Card -->
      <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-5 space-y-4">
        <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-brand-slate/30">
          <i class="fa-solid fa-user text-brand-accent"></i>
          <span>Client Details</span>
        </h3>

        <div class="space-y-3 text-xs">
          <!-- Name -->
          <div>
            <span class="text-[10px] font-mono text-slate-400 uppercase block">Client Name</span>
            <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $contact->name }}</span>
          </div>

          <!-- Email -->
          <div>
            <span class="text-[10px] font-mono text-slate-400 uppercase block">Email Address</span>
            <div class="flex items-center justify-between gap-2 mt-0.5">
              <a href="mailto:{{ $contact->email }}" class="font-semibold text-brand-accent hover:underline break-all">
                {{ $contact->email }}
              </a>
              <a href="mailto:{{ $contact->email }}?subject={{ urlencode('Re: [' . $contact->ticket_no . '] ' . $contact->subject) }}" class="p-1 rounded bg-blue-500/10 text-brand-accent hover:bg-brand-accent hover:text-white text-[11px] transition-colors shrink-0" title="Send email">
                <i class="fa-solid fa-envelope"></i>
              </a>
            </div>
          </div>

          <!-- Phone -->
          <div>
            <span class="text-[10px] font-mono text-slate-400 uppercase block">Phone Number</span>
            @if($contact->phone)
              <div class="flex items-center justify-between gap-2 mt-0.5">
                <a href="tel:{{ $contact->phone }}" class="font-mono font-semibold text-slate-800 dark:text-slate-200 hover:text-brand-accent">
                  {{ $contact->phone }}
                </a>
                <a href="tel:{{ $contact->phone }}" class="p-1 rounded bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500 hover:text-white text-[11px] transition-colors shrink-0" title="Call client">
                  <i class="fa-solid fa-phone"></i>
                </a>
              </div>
            @else
              <span class="text-slate-400 italic">Not provided</span>
            @endif
          </div>

          <!-- IP Address -->
          @if($contact->ip_address)
            <div class="pt-2 border-t border-slate-100 dark:border-brand-slate/30">
              <span class="text-[10px] font-mono text-slate-400 uppercase block">Submission IP</span>
              <span class="font-mono text-slate-600 dark:text-slate-400 text-[11px]">{{ $contact->ip_address }}</span>
            </div>
          @endif
        </div>

        <!-- Direct Email Action Button -->
        <div class="pt-2">
          <a href="mailto:{{ $contact->email }}?subject={{ urlencode('Re: [' . $contact->ticket_no . '] ' . $contact->subject) }}" 
            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-brand-accent hover:bg-blue-600 text-white font-bold text-xs shadow-md shadow-blue-500/20 transition-all">
            <i class="fa-solid fa-reply"></i>
            <span>Reply via Email</span>
          </a>
        </div>
      </div>

    </div>

  </div>

</div>
@endsection

