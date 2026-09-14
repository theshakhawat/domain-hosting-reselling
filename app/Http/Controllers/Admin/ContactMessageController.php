<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of support inquiries and contact messages.
     */
    public function index(Request $request): View
    {
        $query = ContactMessage::query();

        if ($status = $request->input('status')) {
            if ($status !== 'all') {
                $query->where('status', $status);
            }
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('ticket_no', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('issue_type', 'like', "%{$search}%");
            });
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $counts = [
            'all' => ContactMessage::count(),
            'new' => ContactMessage::where('status', 'new')->count(),
            'seen' => ContactMessage::where('status', 'seen')->count(),
            'in_progress' => ContactMessage::where('status', 'in_progress')->count(),
            'fixed' => ContactMessage::where('status', 'fixed')->count(),
        ];

        return view('admin.contacts.index', compact('messages', 'counts'));
    }

    /**
     * Display the specified contact message and mark as seen.
     */
    public function show(ContactMessage $contact): JsonResponse|View
    {
        if ($contact->status === 'new') {
            $contact->update(['status' => 'seen']);
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'contact' => $contact,
            ]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update the status of the contact message.
     */
    public function updateStatus(Request $request, ContactMessage $contact): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,seen,in_progress,fixed'],
        ]);

        $contact->update(['status' => $validated['status']]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $contact->status,
            ]);
        }

        $statusLabel = match ($validated['status']) {
            'fixed' => 'Fixed / Resolved',
            'in_progress' => 'In Progress',
            'seen' => 'Seen',
            default => 'New',
        };

        return redirect()->back()->with('success', "Ticket {$contact->ticket_no} marked as '{$statusLabel}'.");
    }

    /**
     * Remove the specified contact message from storage.
     */
    public function destroy(ContactMessage $contact): RedirectResponse
    {
        $ticketNo = $contact->ticket_no;

        if ($contact->screenshot && File::exists(public_path($contact->screenshot))) {
            File::delete(public_path($contact->screenshot));
        }

        $contact->delete();

        return redirect()->back()->with('success', "Ticket {$ticketNo} deleted successfully.");
    }
}
