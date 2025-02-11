<?php

namespace App\Applications\LeaveRequest\Mail;

use App\Applications\LeaveRequest\Model\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestConfirmation extends Mailable
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
        $subject =$this->leaveRequest->user->first_name . ' ' . $this->leaveRequest->user->last_name . ': ' . $this->leaveRequest->leaveType->name .  ' ' . $this->leaveRequest->start_date . ($this->leaveRequest->end_date ? ' to ' . $this->leaveRequest->end_date : '');
        $email = $this->subject($subject .' was Approved')
                    ->view('emails.leave_request_confirmation')
                    ->with([
                        'leaveRequest' => $this->leaveRequest,
                    ]);


        return $email;
    }
}
