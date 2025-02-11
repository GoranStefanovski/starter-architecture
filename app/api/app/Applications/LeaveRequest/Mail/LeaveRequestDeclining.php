<?php

namespace App\Applications\LeaveRequest\Mail;

use App\Applications\LeaveRequest\Model\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestDeclining extends Mailable
{
    use Queueable, SerializesModels;

    public LeaveRequest $leaveRequest;

    /**
     * Create a new message instance.
     */
    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        $subject = $this->leaveRequest->leaveType->name .  ' ' . $this->leaveRequest->start_date . ($this->leaveRequest->end_date ? ' to ' . $this->leaveRequest->end_date : '');  
        return $this->subject($subject)
                    ->view('emails.leave_request_decline')
                    ->with([
                        'leaveRequest' => $this->leaveRequest,
                    ]);
    }
}
