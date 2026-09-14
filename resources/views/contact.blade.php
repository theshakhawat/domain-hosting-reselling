@extends('layout.website')

@section('title', 'Contact & Priority Technical Support — ' . ($settings['site_name'] ?? 'NEXUSHOST'))

@section('content')
<main class="min-h-[75vh] max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 space-y-10">

    <!-- Hero Headline -->
    <div class="text-center max-w-2xl mx-auto space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-mono font-semibold bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>24/7/365 PRIORITY SUPPORT</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
            How can we help your infrastructure today?
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
            Submit a support ticket, request migration assistance, or ask sales questions. Our engineering team responds in minutes.
        </p>
    </div>

    <!-- Flash Success Alert -->
    @if (session('success'))
        <div class="max-w-4xl mx-auto p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 flex items-start gap-3 animate-fadeIn">
            <i class="fa-solid fa-circle-check text-emerald-500 text-lg mt-0.5 shrink-0"></i>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider">Ticket Submitted Successfully</h3>
                <p class="text-xs mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- 2-Column Split: Form (Left) & Channel Cards (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-5xl mx-auto items-start">

        <!-- Form Card (8 Cols) -->
        <div class="lg:col-span-8 bg-white dark:bg-[#0B1B33] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl p-6 sm:p-8">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-100 dark:border-slate-800/80">
                <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Open a Support Inquiry</h2>
                    <p class="text-[11px] text-slate-400">All fields marked with an asterisk (<span class="text-rose-500">*</span>) are required.</p>
                </div>
            </div>

            <form action="{{ route('contact.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf

                <!-- Name & Email -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Your Full Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                            placeholder="e.g. Tanvir Ahmed"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#07111F] text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('name')
                            <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Email Address <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                            placeholder="e.g. tanvir@company.com"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#07111F] text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('email')
                            <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Phone & Issue Category -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Phone Number (optional)
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            placeholder="e.g. +880 1712 345678"
                            class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#07111F] text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('phone')
                            <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Issue Category <span class="text-rose-500">*</span>
                        </label>
                        <select name="issue_type" required
                            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#07111F] text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="Technical Support" {{ old('issue_type') === 'Technical Support' ? 'selected' : '' }}>🛠 Technical Support (cPanel, SSL, PHP)</option>
                            <option value="Billing & Payments" {{ old('issue_type') === 'Billing & Payments' ? 'selected' : '' }}>💳 Billing & Invoice Inquiries</option>
                            <option value="Server Issue" {{ old('issue_type') === 'Server Issue' ? 'selected' : '' }}>🚨 Server Downtime & Performance</option>
                            <option value="Domain & DNS" {{ old('issue_type') === 'Domain & DNS' ? 'selected' : '' }}>🌐 Domain Transfer & DNS Nameservers</option>
                            <option value="Migration Request" {{ old('issue_type') === 'Migration Request' ? 'selected' : '' }}>📦 Free cPanel Website Migration</option>
                            <option value="Sales & Custom VPS" {{ old('issue_type') === 'Sales & Custom VPS' ? 'selected' : '' }}>💼 Enterprise Sales & Custom Cloud</option>
                            <option value="Other" {{ old('issue_type') === 'Other' ? 'selected' : '' }}>💬 Other Inquiry</option>
                        </select>
                        @error('issue_type')
                            <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Subject -->
                <div>
                    <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                        Subject <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="subject" required value="{{ old('subject') }}"
                        placeholder="Brief summary of the issue or inquiry"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#07111F] text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('subject')
                        <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                        Detailed Description <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="description" rows="5" required
                        placeholder="Please describe your problem or question in detail. Include any error messages, domain names, or steps to reproduce."
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#07111F] text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 leading-relaxed">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Optional Screenshot Upload with Live Preview -->
                <div class="pt-2">
                    <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">
                        Attach Screenshot / Error Log (Optional)
                    </label>
                    <div class="flex items-center gap-3">
                        <label class="cursor-pointer inline-flex items-center gap-2 px-3.5 py-2 rounded-lg border border-dashed border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#07111F] text-slate-600 dark:text-slate-300 hover:border-blue-500 transition-colors">
                            <i class="fa-solid fa-cloud-arrow-up text-blue-500 text-sm"></i>
                            <span id="screenshotFileLabel">Choose PNG, JPG, WEBP (Max 5MB)</span>
                            <input type="file" name="screenshot" id="screenshotInput"
                                accept="image/png,image/jpeg,image/webp" class="hidden"
                                onchange="previewScreenshot(this)">
                        </label>
                        <button type="button" id="clearScreenshotBtn" onclick="clearScreenshot()"
                            class="hidden text-[11px] text-rose-500 hover:underline">
                            Remove file
                        </button>
                    </div>

                    <!-- Image Preview Box -->
                    <div id="screenshotPreviewContainer"
                        class="hidden mt-3 p-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-[#07111F] inline-block">
                        <img id="screenshotPreviewImg" src="" alt="Screenshot Preview"
                            class="max-h-36 rounded object-contain">
                    </div>
                    @error('screenshot')
                        <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                    <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                        <span>Encrypted SSL transmission</span>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-lg shadow-blue-500/25 transition-all active:scale-[0.98] cursor-pointer">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Submit Ticket</span>
                    </button>
                </div>

            </form>
        </div>

        <!-- Right Column: Support Badges & Contacts (4 Cols) -->
        <div class="lg:col-span-4 space-y-4 text-xs">

            <!-- Response SLA Badge -->
            <div class="bg-white dark:bg-[#0B1B33] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-md p-5 space-y-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-stopwatch"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 dark:text-white">Fast Response SLA</div>
                        <div class="text-[11px] text-emerald-500 font-semibold font-mono">&lt; 15 Minutes Avg.</div>
                    </div>
                </div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                    Our specialized Level-3 Linux system administrators are on standby 24 hours a day to assist you.
                </p>
            </div>

            <!-- Direct Contact Channels -->
            <div class="bg-white dark:bg-[#0B1B33] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-md p-5 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white pb-2 border-b border-slate-100 dark:border-slate-800">
                    Emergency Direct Channels
                </h3>

                <div class="space-y-2.5">
                    <div class="flex items-start gap-2.5">
                        <i class="fa-solid fa-envelope text-blue-500 mt-0.5 w-4"></i>
                        <div>
                            <div class="font-semibold text-slate-800 dark:text-slate-200">Email Support</div>
                            <a href="mailto:{{ $settings['support_email'] ?? ($settings['header_support_email'] ?? 'support@nexus.com') }}"
                                class="text-blue-500 hover:underline">
                                {{ $settings['support_email'] ?? ($settings['header_support_email'] ?? 'support@nexus.com') }}
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-2.5">
                        <i class="fa-solid fa-phone text-emerald-500 mt-0.5 w-4"></i>
                        <div>
                            <div class="font-semibold text-slate-800 dark:text-slate-200">Hotline Helpline</div>
                            <a href="tel:{{ $settings['support_phone'] ?? ($settings['header_support_phone'] ?? '+880 1700-000000') }}"
                                class="text-emerald-500 font-mono hover:underline">
                                {{ $settings['support_phone'] ?? ($settings['header_support_phone'] ?? '+880 1700-000000') }}
                            </a>
                        </div>
                    </div>

                    @if (!empty($settings['footer_address']))
                        <div class="flex items-start gap-2.5 pt-1 border-t border-slate-100 dark:border-slate-800">
                            <i class="fa-solid fa-location-dot text-slate-400 mt-0.5 w-4"></i>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400">
                                {{ $settings['footer_address'] }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</main>
@endsection

@push('scripts')
<script>
    function previewScreenshot(input) {
        const file = input.files[0];
        const label = document.getElementById('screenshotFileLabel');
        const container = document.getElementById('screenshotPreviewContainer');
        const img = document.getElementById('screenshotPreviewImg');
        const clearBtn = document.getElementById('clearScreenshotBtn');

        if (file) {
            label.textContent = file.name;
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                container.classList.remove('hidden');
                clearBtn.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function clearScreenshot() {
        const input = document.getElementById('screenshotInput');
        const label = document.getElementById('screenshotFileLabel');
        const container = document.getElementById('screenshotPreviewContainer');
        const clearBtn = document.getElementById('clearScreenshotBtn');

        input.value = '';
        label.textContent = 'Choose PNG, JPG, WEBP (Max 5MB)';
        container.classList.add('hidden');
        clearBtn.classList.add('hidden');
    }
</script>
@endpush
