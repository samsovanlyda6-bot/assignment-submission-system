<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('notification_id', $id)
            ->firstOrFail();
        
        $notification->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('notification_id', $id)
            ->firstOrFail();
        
        $notification->delete();
        
        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }
}