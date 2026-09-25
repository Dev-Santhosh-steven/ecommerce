<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoRequest;

class DemoRequestController extends Controller
{
    public function index()
    {
        $demoRequests = DemoRequest::with('category')
            ->latest()
            ->paginate(15);

        return view('admin.demo-requests.index', compact('demoRequests'));
    }

    public function markRead(DemoRequest $demoRequest)
    {
        $demoRequest->update(['is_read' => true]);

        return back()->with('success', 'Marked as read.');
    }

    public function markAllRead()
    {
        DemoRequest::unread()->update(['is_read' => true]);

        return back()->with('success', 'All demo requests marked as read.');
    }

    public function destroy(DemoRequest $demoRequest)
    {
        $demoRequest->delete();

        return redirect()
            ->route('admin.demo-requests.index')
            ->with('success', 'Demo request deleted.');
    }
}
