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
        $formattedStartDate = \Carbon\Carbon::parse($this->leaveRequest->start_date)->format('d M Y');
        $formattedEndDate = $this->leaveRequest->end_date
            ? \Carbon\Carbon::parse($this->leaveRequest->end_date)->format('d M Y')
            : null;
        $subject = $this->leaveRequest->user->first_name . ' ' . $this->leaveRequest->user->last_name . ': ' . $this->leaveRequest->leaveType->name .  ': ' . $formattedStartDate . ($this->leaveRequest->end_date ? ' to ' . $formattedEndDate : '');
        $email = $this->subject($subject .' (Canceled)')
                    ->view('emails.leave_request_cancelation')
                    ->with([
                        'leaveRequest' => $this->leaveRequest,
                    ]);

        return $email;
    }
}
