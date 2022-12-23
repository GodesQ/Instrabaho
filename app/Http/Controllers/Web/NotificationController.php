<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notification;
use App\Models\Employer;
use App\Models\Freelancer;
use App\Models\User;

class NotificationController extends Controller
{
    public function notifications() {
        $role = session()->get('role');
        $id = session()->get('id');

        $user = $role == 'employer' ? Employer::where('user_id', $id)->firstOrFail() : Freelancer::where('user_id', $id)->firstOrFail();

        $notifications = Notification::where([
            ['notifier_id', $user->id],
            ['notifier_role', $role],
            ['is_read', false]
        ])->limit(5)->latest('created_at')->with('entity')->get();

        return response()->json($notifications, 200);
    }

    public function mark_as_read(Request $request) {
        $notifications = $request->notification_ids;

        $update_notifications = Notification::whereIn('id', $notifications)->update([
            'is_read' => true,
        ]);

        if($update_notifications) {
            return response()->json([
                'status' => true,
                'message' => 'Notification successfully read.'
            ], 200);
        }

    }
}
