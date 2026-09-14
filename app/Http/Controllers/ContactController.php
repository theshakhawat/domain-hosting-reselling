<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\ContactMessage;
use App\Models\PlanCategory;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Show the public contact / support page.
     */
    public function showForm(): View
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $categories = PlanCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('contact', compact('settings', 'categories'));
    }

    /**
     * Handle contact / support ticket submission.
     */
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:150'],
            'issue_type' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:5000'],
            'screenshot' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        // Generate unique ticket number
        $ticketNo = 'TKT-'.date('Ymd').'-'.strtoupper(Str::random(4));

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $filename = 'ticket_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/screenshots');

            if (! File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $file->move($destinationPath, $filename);
            $screenshotPath = 'uploads/screenshots/'.$filename;
        }

        $contact = ContactMessage::create([
            'ticket_no' => $ticketNo,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'issue_type' => $validated['issue_type'],
            'description' => $validated['description'],
            'screenshot' => $screenshotPath,
            'status' => 'new',
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        // Trigger Admin Notification
        AdminNotification::create([
            'type' => 'contact_form',
            'title' => "Support Ticket {$ticketNo}",
            'message' => "{$validated['name']} submitted inquiry: '{$validated['subject']}' ({$validated['issue_type']})",
            'link' => route('admin.contacts.index', ['search' => $ticketNo]),
            'is_read' => false,
        ]);

        return redirect()->route('contact.show')
            ->with('success', "Ticket #{$ticketNo} submitted successfully! Our engineering team will review your inquiry shortly.")
            ->with('ticket_submitted', true)
            ->with('ticket_no', $ticketNo);
    }
}
