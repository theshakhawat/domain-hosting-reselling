@extends('admin.layouts.app')

@section('title', 'Support Tickets & Contact Inquiries')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
        <i class="fa-solid fa-headset text-brand-accent"></i>
        <span>Support Inquiries & Contact Messages</span>
      </h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
        Manage client technical issues, sales inquiries, bug reports, and customer tickets.
      </p>
    </div>
  </div>

  <!-- Metric Badges & Filter Tabs -->
  <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-white dark:bg-brand-card p-4 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
    <!-- Filter Pills -->
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('admin.contacts.index', ['search' => request('search')]) }}" 
        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ !request('status') || request('status') === 'all' ? 'bg-brand-accent text-white shadow-sm shadow-blue-500/25' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-dark' }}">
        All ({{ $counts['all'] }})
      </a>
      
      <a href="{{ route('admin.contacts.index', ['status' => 'new', 'search' => request('search')]) }}" 
        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors flex items-center gap-1.5 {{ request('status') === 'new' ? 'bg-rose-500 text-white shadow-sm shadow-rose-500/25' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-dark' }}">
        <span>New</span>
        @if($counts['new'] > 0)
          <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ request('status') === 'new' ? 'bg-white text-rose-600' : 'bg-rose-500 text-white' }} font-bold">{{ $counts['new'] }}</span>
        @endif
      </a>

      <a href="{{ route('admin.contacts.index', ['status' => 'seen', 'search' => request('search')]) }}" 
        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ request('status') === 'seen' ? 'bg-blue-500 text-white shadow-sm shadow-blue-500/25' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-dark' }}">
        Seen ({{ $counts['seen'] }})
      </a>

      <a href="{{ route('admin.contacts.index', ['status' => 'in_progress', 'search' => request('search')]) }}" 
        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ request('status') === 'in_progress' ? 'bg-amber-500 text-white shadow-sm shadow-amber-500/25' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-dark' }}">
        In Progress ({{ $counts['in_progress'] }})
      </a>

      <a href="{{ route('admin.contacts.index', ['status' => 'fixed', 'search' => request('search')]) }}" 
        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ request('status') === 'fixed' ? 'bg-emerald-500 text-white shadow-sm shadow-emerald-500/25' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-dark' }}">
        Fixed / Resolved ({{ $counts['fixed'] }})
      </a>
    </div>

    <!-- Search Form -->
    <form action="{{ route('admin.contacts.index') }}" method="GET" class="flex items-center gap-2">
      @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
      @endif
      <div class="relative w-full sm:w-64">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ticket, client, email..."
          class="w-full pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 dark:border-brand-slate/50 bg-slate-50 dark:bg-brand-dark text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-brand-accent">
        <i class="fa-solid fa-magnifying-glass text-slate-400 text-[11px] absolute left-2.5 top-2.5"></i>
      </div>
      @if(request('search'))
        <a href="{{ route('admin.contacts.index', ['status' => request('status')]) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-brand-dark text-slate-500 hover:text-slate-700 text-xs shrink-0">
          Clear
        </a>
      @endif
    </form>
  </div>

  <!-- Messages Table Card -->
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden">
    
    <!-- Table Container with horizontal scrolling support for smaller screens -->
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300 min-w-[780px]">
        <thead class="bg-slate-50/75 dark:bg-brand-dark/40 font-mono text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-brand-slate/40">
          <tr>
            <th class="px-4 py-3.5 w-40">Ticket ID</th>
            <th class="px-4 py-3.5 w-48">Client Info</th>
            <th class="px-4 py-3.5">Issue & Subject</th>
            <th class="px-4 py-3.5 text-center w-24">Attachment</th>
            <th class="px-4 py-3.5 w-36">Status</th>
            <th class="px-4 py-3.5 text-right w-28">Received</th>
            <th class="px-4 py-3.5 text-center w-28">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-brand-slate/20">
          @forelse($messages as $msg)
            <tr class="hover:bg-slate-50/50 dark:hover:bg-brand-dark/30 transition-colors {{ $msg->status === 'new' ? 'bg-rose-50/20 dark:bg-rose-950/10' : '' }}">
              
              <!-- Ticket ID -->
              <td class="px-4 py-3 font-mono">
                <a href="{{ route('admin.contacts.show', $msg) }}" class="font-bold text-slate-900 dark:text-white px-2 py-0.5 rounded bg-slate-100 dark:bg-brand-dark border border-slate-200 dark:border-brand-slate/40 hover:text-brand-accent hover:border-brand-accent/50 transition-colors inline-flex items-center gap-1.5">
                  <span>{{ $msg->ticket_no }}</span>
                  @if($msg->status === 'new')
                    <span class="inline-block w-2 h-2 rounded-full bg-rose-500 shrink-0" title="New Ticket"></span>
                  @endif
                </a>
              </td>

              <!-- Client Info -->
              <td class="px-4 py-3">
                <div class="font-bold text-slate-900 dark:text-white">{{ $msg->name }}</div>
                <div class="text-[11px] text-slate-500 dark:text-slate-400 flex items-center gap-1 mt-0.5">
                  <i class="fa-solid fa-envelope text-[10px] text-slate-400 shrink-0"></i>
                  <a href="mailto:{{ $msg->email }}" class="hover:text-brand-accent transition-colors truncate max-w-[150px]">{{ $msg->email }}</a>
                </div>
                @if($msg->phone)
                  <div class="text-[11px] text-slate-500 dark:text-slate-400 flex items-center gap-1 mt-0.5">
                    <i class="fa-solid fa-phone text-[10px] text-slate-400 shrink-0"></i>
                    <span class="font-mono">{{ $msg->phone }}</span>
                  </div>
                @endif
              </td>

              <!-- Category & Subject -->
              <td class="px-4 py-3 max-w-xs">
                <div class="flex items-center gap-1.5">
                  <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase font-mono bg-blue-500/10 text-brand-accent border border-blue-500/20">
                    {{ $msg->issue_type }}
                  </span>
                </div>
                <a href="{{ route('admin.contacts.show', $msg) }}" class="block font-semibold text-slate-800 dark:text-slate-200 mt-1 truncate hover:text-brand-accent transition-colors" title="{{ $msg->subject }}">
                  {{ $msg->subject }}
                </a>
                <p class="text-[11px] text-slate-400 truncate max-w-xs mt-0.5">
                  {{ Str::limit($msg->description, 60) }}
                </p>
              </td>

              <!-- Screenshot Attachment -->
              <td class="px-4 py-3 text-center">
                @if($msg->screenshot)
                  <a href="{{ asset($msg->screenshot) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-brand-dark border border-slate-200 dark:border-brand-slate/40 text-brand-accent hover:border-brand-accent/50 text-[11px] font-semibold transition-colors shadow-sm" title="Click to preview screenshot">
                    <i class="fa-solid fa-image"></i>
                    <span>Preview</span>
                  </a>
                @else
                  <span class="text-slate-400 text-[11px] font-mono">—</span>
                @endif
              </td>

              <!-- Status Changer Dropdown -->
              <td class="px-4 py-3">
                <form action="{{ route('admin.contacts.status', $msg) }}" method="POST" class="inline">
                  @csrf
                  @method('PATCH')
                  <select name="status" onchange="this.form.submit()" 
                    class="text-[11px] font-semibold font-mono py-1 px-2.5 rounded-lg border transition-colors cursor-pointer focus:outline-none focus:ring-1 focus:ring-brand-accent {{ $msg->status === 'new' ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500/30' : ($msg->status === 'seen' ? 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/30' : ($msg->status === 'in_progress' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/30' : 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/30')) }}">
                    <option value="new" {{ $msg->status === 'new' ? 'selected' : '' }}>New</option>
                    <option value="seen" {{ $msg->status === 'seen' ? 'selected' : '' }}>Seen</option>
                    <option value="in_progress" {{ $msg->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="fixed" {{ $msg->status === 'fixed' ? 'selected' : '' }}>Fixed / Done</option>
                  </select>
                </form>
              </td>

              <!-- Received Time -->
              <td class="px-4 py-3 text-right font-mono">
                <div class="text-slate-900 dark:text-white font-medium text-xs">
                  {{ $msg->created_at->diffForHumans() }}
                </div>
                <div class="text-[10px] text-slate-400">
                  {{ $msg->created_at->format('M d, H:i') }}
                </div>
              </td>

              <!-- Actions -->
              <td class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-1.5">
                  
                  <!-- View Details Link (Dedicated Show Page) -->
                  <a href="{{ route('admin.contacts.show', $msg) }}"
                    class="p-1.5 rounded-lg text-slate-500 hover:text-brand-accent hover:bg-blue-50 dark:hover:bg-brand-dark transition-colors" 
                    title="View Ticket Details & Full Message">
                    <i class="fa-solid fa-up-right-from-square text-xs"></i>
                  </a>

                  <!-- Delete -->
                  <form action="{{ route('admin.contacts.destroy', $msg) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete ticket {{ $msg->ticket_no }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors" title="Delete Ticket">
                      <i class="fa-solid fa-trash-can text-xs"></i>
                    </button>
                  </form>

                </div>
              </td>

            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                <div class="flex flex-col items-center justify-center">
                  <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-brand-dark text-slate-400 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-inbox text-xl"></i>
                  </div>
                  <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">No support tickets found</span>
                  <span class="text-xs text-slate-400 mt-0.5">Customer contact requests and queries will appear here.</span>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($messages->hasPages())
      <div class="p-4 border-t border-slate-200 dark:border-brand-slate/40">
        {{ $messages->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
