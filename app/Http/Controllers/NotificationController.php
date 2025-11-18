<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function dropdown()
    {
        $notifications = Notification::orderBy('id', 'DESC')
            ->where('read', 1)
            ->take(10)
            ->get();

        $data = $notifications->map(function ($n) {

            // GET USER ROLE
            if ($n->user_id == null) {
                $sender = "User";
                $sender_type = "user";
            } else {
                $user = User::find($n->user_id);

                if ($user) {
                    if ($user->role == 1) {
                        $sender = "User";
                        $sender_type = "user";
                    } else {
                        $sender = "Admin : " . $user->name;
                        $sender_type = "admin";
                    }
                } else {
                    $sender = "User";
                    $sender_type = "user";
                }
            }

            return [
                'id'              => $n->id,
                'sender'          => $sender,
                'sender_type'     => $sender_type,
                'notification_for'=> $n->notification_for,
                'message'         => $n->message,
                'time'            => $n->created_at->diffForHumans(),
                'read'            => $n->read,
            ];
        });

        return response()->json([
            'notifications' => $data,
            'total' => Notification::where('read', 1)->count() // FIXED
        ]);
    }


    public function markRead()
    {
        Notification::where('read', 1)->update(['read' => 2]);
        return response()->json(['success' => true]);
    }

    public function viewAll()
    {
        $notifications = Notification::orderBy('id', 'DESC')
            ->get();

        return view('admin.notifications.all', compact('notifications'));
    }


}
