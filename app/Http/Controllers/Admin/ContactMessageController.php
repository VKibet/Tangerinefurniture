<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        $unreadCount = ContactMessage::unread()->count();
        $readCount = ContactMessage::read()->count();
        $repliedCount = ContactMessage::replied()->count();
        
        return view('admin.contact-messages.index', compact('messages', 'unreadCount', 'readCount', 'repliedCount'));
    }

    public function show(ContactMessage $contactMessage)
    {
        // Mark as read if unread
        if ($contactMessage->status === 'unread') {
            $contactMessage->update(['status' => 'read']);
        }
        
        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function updateStatus(Request $request, ContactMessage $contactMessage)
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied'
        ]);

        $contactMessage->update(['status' => $request->status]);

        return back()->with('success', 'Message status updated successfully.');
    }

    public function updateNotes(Request $request, ContactMessage $contactMessage)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $contactMessage->update(['admin_notes' => $request->admin_notes]);

        return back()->with('success', 'Notes updated successfully.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    public function markAllAsRead()
    {
        ContactMessage::unread()->update(['status' => 'read']);
        return back()->with('success', 'All messages marked as read.');
    }
}
