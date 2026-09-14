<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display a listing of admin notifications.
     */
    public function index(Request $request): View
    {
        $query = AdminNotification::query();

        if ($filter = $request->input('filter')) {
            if ($filter === 'unread') {
                $query->where('is_read', false);
            } elseif ($filter === 'read') {
                $query->where('is_read', true);
            }
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $unreadCount = AdminNotification::where('is_read', false)->count();
        $totalCount = AdminNotification::count();

        return view('admin.notifications.index', compact('notifications', 'unreadCount', 'totalCount'));
    }

    /**
     * Mark a single notification as read and redirect if link provided.
     */
    public function markAsRead(AdminNotification $notification): RedirectResponse|JsonResponse
    {
        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        if ($notification->link) {
            return redirect($notification->link);
        }

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead(): RedirectResponse
    {
        AdminNotification::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Delete a single notification.
     */
    public function destroy(AdminNotification $notification): RedirectResponse
    {
        $notification->delete();

        return redirect()->back()->with('success', 'Notification removed.');
    }

    /**
     * Clear all notifications.
     */
    public function clearAll(): RedirectResponse
    {
        AdminNotification::truncate();

        return redirect()->back()->with('success', 'All notifications cleared.');
    }
}
