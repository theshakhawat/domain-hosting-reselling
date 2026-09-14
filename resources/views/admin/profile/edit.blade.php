@extends('admin.layouts.app')

@section('title', 'Admin Profile & Security')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-brand-accent">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span>Account Profile</span>
      </div>
      <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
        <i class="fa-solid fa-user-gear text-brand-accent"></i>
        <span>Admin Profile & Security</span>
      </h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
        Update your personal details, email address, profile avatar, and account credentials.
      </p>
    </div>
  </div>

  <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <!-- Profile Information Card -->
    <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-6 sm:p-8 space-y-6">
      <div class="border-b border-slate-200 dark:border-brand-slate/40 pb-3">
        <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
          <i class="fa-solid fa-id-badge text-brand-accent"></i>
          <span>Personal & Contact Information</span>
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
          General information associated with your administrator login account.
        </p>
      </div>

      <!-- Avatar & Basic Identity -->
      <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 pb-6 border-b border-slate-100 dark:border-brand-slate/30">
        <!-- Avatar Preview -->
        <div class="relative group shrink-0">
          <div id="avatarContainer" class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-brand-accent to-indigo-600 text-white flex items-center justify-center font-bold text-2xl shadow-md border-2 border-white dark:border-brand-card overflow-hidden">
            @if($user->profile_picture && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_picture))
              <img id="avatarImage" src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
            @else
              <span id="avatarInitials">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
              <img id="avatarImage" src="" alt="Preview" class="hidden w-full h-full object-cover">
            @endif
          </div>
          <label for="profile_picture" class="absolute -bottom-1 -right-1 w-7 h-7 rounded-lg bg-brand-accent text-white flex items-center justify-center shadow-md cursor-pointer hover:bg-blue-600 transition-colors" title="Upload new photo">
            <i class="fa-solid fa-camera text-xs"></i>
          </label>
        </div>

        <div class="flex-1 text-center sm:text-left space-y-2">
          <div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->name }}</h3>
            <p class="text-xs text-slate-400 font-mono">{{ $user->email }}</p>
          </div>
          <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-500">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active Administrator
            </span>
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono bg-blue-500/10 text-brand-accent">
              <i class="fa-solid fa-shield-halved text-[9px]"></i> Super Admin
            </span>
          </div>
          <div class="pt-1">
            <input type="file" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/webp" onchange="previewAvatar(this)" class="hidden">
            <button type="button" onclick="document.getElementById('profile_picture').click()" class="text-xs font-semibold text-brand-accent hover:underline">
              Change Profile Photo
            </button>
            <span class="text-[11px] text-slate-400 ml-2">(Max: 2MB, JPG, PNG, WEBP)</span>
          </div>
          @error('profile_picture')
            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- Form Fields -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Full Name -->
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Full Name <span class="text-rose-500">*</span>
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
              <i class="fa-solid fa-user text-xs"></i>
            </div>
            <input type="text" name="name" required value="{{ old('name', $user->name) }}" placeholder="Your Name"
              class="w-full pl-9 pr-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
          </div>
          @error('name') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Email Address -->
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Email Address <span class="text-rose-500">*</span>
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
              <i class="fa-solid fa-envelope text-xs"></i>
            </div>
            <input type="email" name="email" required value="{{ old('email', $user->email) }}" placeholder="admin@nexus.com"
              class="w-full pl-9 pr-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
          </div>
          @error('email') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Phone Number -->
        <div class="sm:col-span-2">
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Contact Phone Number (Optional)
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
              <i class="fa-solid fa-phone text-xs"></i>
            </div>
            <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="+880 1700-000000"
              class="w-full pl-9 pr-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
          </div>
          @error('phone_number') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>
      </div>
    </div>

    <!-- Security & Password Change Card -->
    <div class="bg-white dark:bg-brand-card rounded-2xl border border-slate-200 dark:border-brand-slate/40 shadow-sm p-6 sm:p-8 space-y-6">
      <div class="border-b border-slate-200 dark:border-brand-slate/40 pb-3">
        <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
          <i class="fa-solid fa-lock text-amber-500"></i>
          <span>Change Password & Security</span>
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
          Leave these fields blank if you do not wish to change your current password.
        </p>
      </div>

      <div class="space-y-4">
        <!-- Current Password -->
        <div>
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
            Current Password
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
              <i class="fa-solid fa-key text-xs"></i>
            </div>
            <input type="password" name="current_password" placeholder="••••••••"
              class="w-full pl-9 pr-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
          </div>
          <p class="text-[10px] text-slate-400 mt-1">Required only when changing to a new password.</p>
          @error('current_password') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <!-- New Password -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              New Password
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-lock text-xs"></i>
              </div>
              <input type="password" name="new_password" placeholder="Minimum 8 characters"
                class="w-full pl-9 pr-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
            </div>
            @error('new_password') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
          </div>

          <!-- Confirm New Password -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
              Confirm New Password
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-shield-check text-xs"></i>
              </div>
              <input type="password" name="new_password_confirmation" placeholder="Repeat new password"
                class="w-full pl-9 pr-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-brand-slate/60 bg-slate-50 dark:bg-brand-dark text-slate-900 dark:text-white focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Submit Action Bar -->
    <div class="flex items-center justify-between p-4 bg-white dark:bg-brand-card rounded-xl border border-slate-200 dark:border-brand-slate/40 shadow-sm">
      <div class="text-xs text-slate-500 dark:text-slate-400">
        <i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> Changes apply immediately across all sessions.
      </div>
      <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg bg-brand-accent hover:bg-blue-600 text-white text-xs font-semibold shadow-md shadow-brand-accent/25 transition-all active:scale-[0.98]">
        <i class="fa-solid fa-floppy-disk text-xs"></i>
        <span>Save Profile Changes</span>
      </button>
    </div>
  </form>

</div>

@push('scripts')
<script>
  function previewAvatar(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const img = document.getElementById('avatarImage');
        const initials = document.getElementById('avatarInitials');
        if (img) {
          img.src = e.target.result;
          img.classList.remove('hidden');
        }
        if (initials) {
          initials.classList.add('hidden');
        }
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endpush
@endsection

