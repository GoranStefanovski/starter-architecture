<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DayOffRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vacationDay;

    public function __construct($vacationDay)
    {
        $this->vacationDay = $vacationDay;
    }

    public function build()
    {
        return $this->subject('Day Off Request')
                    ->view('emails.day_off_request')
                    ->with([
                        'vacationDay' => $this->vacationDay
                    ]);
    }
}
