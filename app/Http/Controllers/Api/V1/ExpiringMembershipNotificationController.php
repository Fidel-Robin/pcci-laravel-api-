<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ExpiringMembershipNotification;

class ExpiringMembershipNotificationController extends Controller
{
    public function index()
    {
        return ExpiringMembershipNotification::latest()->get();
    }

    public function markAsRead($id)
    {
        $notification = ExpiringMembershipNotification::findOrFail($id);

        $notification->update([
            'is_read' => true
        ]);

        return response()->json([
            'message' => 'Notification marked as read.'
        ]);
    }
}