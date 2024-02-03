<?php
namespace App\Services;

class NotificationBroadCastFormatService {

    public static function format($notifiable) : array
    {
        $notification = $notifiable->notifications()->latest()->first();
        return [
            'icon'          => $notification->data['icons'],
            'details'       => $notification->data['details'],
            'link'          => $notification->data['link'] . "?notif=" . $notification->id, 
            'read_at'       => $notification->read_at,
            'created_at'    => $notification->created_at
        ]; 
    }
}