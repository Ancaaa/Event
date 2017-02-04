<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Notification;
use App\User;
use App\Event;

class NotificationsController extends Controller {

    public function __construct(Request $request) {
        $this->middleware(['auth']);
    }

    public function getNotifications() {
        $notifications = Auth::user()->notifications->map(function($notification) {
            return $this->extendNotification($notification);
        });

        return json_encode(array("status" => "success", 'notifications' => $notifications));
    }

    public function updateNotifications() {
        $notifications = Auth::user()->notifications;

        foreach ($notifications as $notification) {
            $notification->seen = true;
            $notification->save();
        }

        return json_encode(array("status" => "success"));
    }

    public function warnEvent($id) {
        if (!Auth::user()->isAdmin()) {
            return json_encode(array("status" => "error", 'message' => "You don't have access to this method."));
        }

        $event = Event::find($id);

        // Create Notification
        $notification = new Notification;
        $notification->user_id = $event->creator_id;
        $notification->ref_id = $event->id;
        $notification->type = 1;
        $notification->save();

        return json_encode(array("status" => "success"));
    }

    // Notifications Manipulation

    public function getMessage($notification) {
        switch ($notification->type) {
            case 1:
                return 'The admin has marked your event under review, please verify to put it back online or it will be deleted.';
            case 2:
                $event = Event::find($notification->ref_id);
                return 'Don’t forget to make it to ' . $event->title . ' today.';
            case 3:
                $event = Event::find($notification->ref_id);
                return 'The host of "' . $event->title . '" has commented on the event page.';
            case 4:
                $event = Event::find($notification->ref_id);
                return 'The host of "' . $event->title . '" has edited the event.';
            case 5:
                $event = Event::find($notification->ref_id);
                $user = User::find($notification->alt_id);
                return $user->name . ' has joined "' . $event->title . '".';
            case 6:
                $event = Event::find($notification->ref_id);
                $user = User::find($notification->alt_id);
                return $user->name . ' has left "' . $event->title . '".';
            case 7:
                $event = Event::find($notification->ref_id);
                $user = User::find($notification->alt_id);
                return $user->name . ' has commented on "' . $event->title . '".';
        }
    }

    public function getHref($notification) {
        switch ($notification->type) {
            case 1:
                return url('events/' . $notification->ref_id);
            case 2:
                return url('events/' . $notification->ref_id);
            case 3:
                return url('events/' . $notification->ref_id);
            case 4:
                return url('events/' . $notification->ref_id);
            case 5:
                return url('events/' . $notification->ref_id);
            case 6:
                return url('events/' . $notification->ref_id);
            case 7:
                return url('events/' . $notification->ref_id);
        }
    }

    public function extendNotification($notification) {
        return $notification = array(
            'id' => $notification->id,
            'type' => $notification->type,
            'text' => $notification->message ? $notification->message : $this->getMessage($notification),
            'href' => $this->getHref($notification),
            'unread' => !$notification->seen
        );
    }
}
