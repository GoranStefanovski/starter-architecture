<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SickDayNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vacationDay;

    public function __construct($vacationDay)
    {
        $this->vacationDay = $vacationDay;
    }

    public function build()
    {
        return $this->subject('Sick Day Notification')
                    ->view('emails.sick_day_notification')
                    ->with([
                        'vacationDay' => $this->vacationDay
                    ]);
    }
}
