<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Ticket;
use App\UserNotification;

class UserNotificationController extends Controller
{
    public function notifications()
    {
        $auth = auth()->guard('api');
        if ($auth->check()) {
            $userId = $auth->user()->id;
            if ($auth->user()->user_type === "Admin")
                $notifications = UserNotification::where('user_id', $userId)->orWhere('user_id', 0)->orderBy('id', 'desc')->get();
            else {
                $notifications = UserNotification::where('model_name', '<>', 'Organization Notification')->where(function ($query) use ($userId) {
                    $query->whereUserId($userId)->orWhere('user_id', 0);
                })->orderBy('id', 'desc')->get();
            }
            $this->getRefinedNotificationData($notifications);
        } else {
            $notifications = UserNotification::where('user_id', 0)->orderBy('id', 'desc')->limit(20)->get();
            $this->getRefinedNotificationData($notifications);
        }
        return response([
            'success' => true,
            'data' => $notifications
        ]);
    }

    public function getTicketNotifications()
    {
        $auth = auth()->guard('api');
        if ($auth->check()) {
            $userId = $auth->user()->id;
            $notifications = UserNotification::whereModelName("Ticket")->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)->orWhere('user_id', 0);
            })->orderBy('id', 'desc')->get();
            $this->getRefinedNotificationData($notifications);
        } else {
            $notifications = UserNotification::whereModelName("Ticket")->where('user_id', 0)->orderBy('id', 'desc')->get();
            $this->getRefinedNotificationData($notifications);
        }
        return response([
            'success' => true,
            'data' => $notifications
        ]);
    }

    public function getTaskNotifications()
    {
        $auth = auth()->guard('api');
        if ($auth->check()) {
            $userId = $auth->user()->id;
            $notifications = UserNotification::whereModelName("Task")->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)->orWhere('user_id', 0);
            })->orderBy('id', 'desc')->get();
            $this->getRefinedNotificationData($notifications);
        } else {
            $notifications = UserNotification::whereModelName("Task")->where('user_id', 0)->orderBy('id', 'desc')->get();
            $this->getRefinedNotificationData($notifications);
        }
        return response([
            'success' => true,
            'data' => $notifications
        ]);
    }

    public function allNotifications()
    {
        $auth = auth()->guard('api');
        if ($auth->check()) {
            $userId = $auth->user()->id;
            if ($auth->user()->user_type === "Admin")
                $notifications = UserNotification::where('user_id', $userId)->orWhere('user_id', 0)->orderBy('id', 'desc')->get();
            else {
                $notifications = UserNotification::where('model_name', '<>', 'Organization Notification')->where(function ($query) use ($userId) {
                    $query->whereUserId($userId)->orWhere('user_id', 0);
                })->orderBy('id', 'desc')->get();
            }
            $this->getRefinedNotificationData($notifications);
        } else {
            $notifications = UserNotification::where('user_id', 0)->orderBy('id', 'desc')->get();
            $this->getRefinedNotificationData($notifications);
        }
        return response([
            'success' => true,
            'data' => $notifications
        ]);
    }

    private function getRefinedNotificationData($notifications)
    {
        foreach ($notifications as $key => $notification) {
            $notification->message = strip_tags($notification->message);
            $notification->image = $this->checkImage($notification->image);
            $notification->type = $notification->model_name ? $notification->model_name : 'Notification';
            $notification->target_id = $this->getTargetId($notification);
            $notification->notification_date_time = $notification->created_at->format('Y-m-d h:i:s A');
            $notification->notification_at = $notification->created_at->diffForHumans();
            unset($notification->outlet_id, $notification->customer_id, $notification->model_name, $notification->model_id, $notification->is_read, $notification->created_at, $notification->updated_at);
        }
    }

    public function getTargetId($notification)
    {
        $targetId = strval($notification->id);
        if ($notification->model_id) {
            $targetId = strval($notification->model_id);
            if ($notification->model_name == 'Ticket') {
                $ticket = Ticket::find($notification->model_id);
                if ($ticket)
                    $targetId = $ticket->ticket_id;
            }
        }
        return $targetId;
    }

    private function checkImage($image)
    {
        if (empty($image)) {
            return asset('public/images/logo.png');
        } elseif (file_exists('public/' . $image) && $image != '') {
            return asset('public/' . $image);
        } else {
            return asset('public/images/logo.png');
        }
    }
}
