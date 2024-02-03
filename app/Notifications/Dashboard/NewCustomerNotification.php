<?php

namespace App\Notifications\Dashboard;

use App\Http\Resources\NotificationResource;
use App\Models\Customer;
use App\Services\NotificationBroadCastFormatService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Support\Facades\Log;

class NewCustomerNotification extends Notification
{
    use Queueable;
    public $customer;
    
    /**
     * Create a new notification instance.
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }


    public function toArray(object $notifiable): array
    {
        $details = $this->customer->verified_at
                ? "Needs your Approval, New Customer added" 
                : "New Customer added";

        $icon = $this->customer->verified_at
                ? config("notification.icons.approval") 
                : config("notification.icons.user");

        return [
            'icons'     => $icon,
            'details'   => $details,
            'link'      => route("dashboard.customer.show", $this->customer)
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage(
            NotificationBroadCastFormatService::format($notifiable)
        );
    }
}
