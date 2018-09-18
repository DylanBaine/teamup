<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Markup\Tasks\TaskUpdatedMarkup;
use Illuminate\Contracts\Queue\ShouldQueue;
class TaskUpdated extends Notification /* implements ShouldQueue */
{

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $parent, $task, $type, $by;
    public function __construct($task, $parent = null, $type, $by)
    {
        $this->parent = $parent;
        $this->task = $task;
        $this->type = $type;
        $this->by = $by;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new TaskUpdatedMarkup($this->task, $this->by))->markup($this->type);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
