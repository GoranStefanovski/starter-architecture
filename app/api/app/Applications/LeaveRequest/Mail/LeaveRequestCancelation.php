<?php

namespace App\Applications\LeaveRequest\Mail;

use App\Applications\LeaveRequest\Model\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestCancelation extends Mailable
{
    use Queueable, SerializesModels;

    public LeaveRequest $leaveRequest;
    public ?string $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct(LeaveRequest $leaveRequest, ?string $pdfPath = null)
    {
        $this->leaveRequest = $leaveRequest;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        $email = $this->subject($this->leaveRequest->user->first_name . ' ' . $this->leaveRequest->user->last_name .' Leave Request was Canceled')
                    ->view('emails.leave_request_cancelation')
                    ->with([
                        'leaveRequest' => $this->leaveRequest,
                    ]);

        return $email;
    }
}
