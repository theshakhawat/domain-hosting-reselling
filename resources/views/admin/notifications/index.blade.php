@extends('admin.layouts.app')

@section('title', 'Admin Notifications')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
        <i class="fa-solid fa-bell text-brand-accent"></i>
        <span>System & Support Notifications</span>
      </h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
        Real-time event alerts for contact queries, support submissions, and administrative events.
      </p>
    </div>
    
    <!-- Action buttons -->
    <div class="flex items-center gap-2">
      @if($unreadCount > 0)
        <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="inline">
          @csrf
          <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-slate-200 dark:border-brand-slate/50 bg-white dark:bg-brand-card text-xs font-semibold text-slate-700 dark:text-slate-200 hover:text-brand-accent hover:border-brand-accent/50 transition-colors">
            <i class="fa-solid fa-check-double text-xs text-brand-accent"></i>
            <span>Mark All as Read</span>
          </button>
        </form>
      @endif

      @if($totalCount > 0)
        <form action="{{ route('admin.notifications.clear') }}" method="POST" class="inline" onsubmit="return confirm('Clear ALL notifications? This cannot be undone.');">
          @csrf
          @method('DELETE')
          <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-rose-200 dark:border-rose-900/50 bg-rose-50 dark:bg-rose-950/40 text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/60 transition-colors">
            <i class="fa-solid fa-trash-can text-xs"></i>
            <span>Clear All</span>
          </button>
        </form>
      @endif
    </div>
  </div>

  <!-- Metric Badges & Filter Tabs -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-brand-card p-4 rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
    <div class="flex items-center gap-2">
      <a href="{{ route('admin.notifications.index') }}" 
        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ !request('filter') ? 'bg-brand-accent text-white shadow-sm shadow-blue-500/25' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-dark' }}">
        All ({{ $totalCount }})
      </a>
      <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}" 
        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors flex items-center gap-1.5 {{ request('filter') === 'unread' ? 'bg-brand-accent text-white shadow-sm shadow-blue-500/25' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-dark' }}">
        <span>Unread</span>
        @if($unreadCount > 0)
          <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ request('filter') === 'unread' ? 'bg-white text-brand-accent' : 'bg-rose-500 text-white' }} font-bold">{{ $unreadCount }}</span>
        @endif
      </a>
      <a href="{{ route('admin.notifications.index', ['filter' => 'read']) }}" 
        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ request('filter') === 'read' ? 'bg-brand-accent text-white shadow-sm shadow-blue-500/25' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-brand-dark' }}">
        Read ({{ $totalCount - $unreadCount }})
      </a>
    </div>

    <div class="text-xs text-slate-500 dark:text-slate-400 font-mono">
      <span>Showing {{ $notifications->count() }} of {{ $notifications->total() }} alerts</span>
    </div>
  </div>

  <!-- Notification List -->
  <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm overflow-hidden divide-y divide-slate-100 dark:divide-brand-slate/20">
    @forelse($notifications as $notification)
      <div class="p-4 sm:p-5 flex items-start justify-between gap-4 transition-colors {{ !$notification->is_read ? 'bg-blue-50/40 dark:bg-brand-accent/5' : 'hover:bg-slate-50/50 dark:hover:bg-brand-dark/30' }}">
        
        <div class="flex items-start gap-3.5 flex-1 min-w-0">
          <!-- Icon -->
          <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ !$notification->is_read ? 'bg-brand-accent text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 dark:bg-brand-dark text-slate-400' }}">
            @if($notification->type === 'contact_form')
              <i class="fa-solid fa-headset text-sm"></i>
            @else
              <i class="fa-solid fa-bell text-sm"></i>
            @endif
          </div>

          <!-- Content -->
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2">
              <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white truncate">
                {{ $notification->title }}
              </h3>
              @if(!$notification->is_read)
                <span class="inline-block w-2 h-2 rounded-full bg-brand-accent shrink-0" title="Unread"></span>
              @endif
            </div>
            
            <p class="text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
              {{ $notification->message }}
            </p>

            <div class="flex items-center gap-3 mt-2 text-[11px] text-slate-400 font-mono">
              <span class="flex items-center gap-1">
                <i class="fa-solid fa-clock text-[10px]"></i>
                {{ $notification->created_at->diffForHumans() }}
              </span>
              <span>•</span>
              <span>{{ $notification->created_at->format('M d, Y H:i') }}</span>
              @if($notification->is_read && $notification->read_at)
                <span>•</span>
                <span class="text-emerald-500 flex items-center gap-1">
                  <i class="fa-solid fa-check"></i> Read {{ $notification->read_at->diffForHumans() }}
                </span>
              @endif
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-1 shrink-0">
          @if($notification->link)
            <form action="{{ route('admin.notifications.read', $notification) }}" method="POST" class="inline">
              @csrf
              @method('PATCH')
              <button type="submit" class="px-3 py-1.5 rounded-lg bg-brand-accent/10 hover:bg-brand-accent text-brand-accent hover:text-white text-xs font-semibold transition-colors flex items-center gap-1.5">
                <span>View</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </button>
            </form>
          @elseif(!$notification->is_read)
            <form action="{{ route('admin.notifications.read', $notification) }}" method="POST" class="inline">
              @csrf
              @method('PATCH')
              <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-brand-accent hover:bg-slate-100 dark:hover:bg-brand-dark transition-colors" title="Mark as Read">
                <i class="fa-solid fa-check text-xs"></i>
              </button>
            </form>
          @endif

          <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" class="inline" onsubmit="return confirm('Delete this notification?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors" title="Delete">
              <i class="fa-solid fa-trash-can text-xs"></i>
            </button>
          </form>
        </div>

      </div>
    @empty
      <div class="p-12 text-center text-slate-400">
        <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-brand-dark text-slate-400 flex items-center justify-center mx-auto mb-3">
          <i class="fa-solid fa-bell-slash text-xl"></i>
        </div>
        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">No notifications found</p>
        <p class="text-xs text-slate-400 mt-0.5">When new client tickets or system events occur, alerts will appear here.</p>
      </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($notifications->hasPages())
    <div class="p-4 bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40">
      {{ $notifications->links() }}
    </div>
  @endif

</div>
@endsection

