<?php

namespace App\Applications\LeaveRequest\Mail;

use App\Applications\LeaveRequest\Model\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestConfirmationPDF extends Mailable
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
        $subject = $this->leaveRequest->user->country == 1 ? 'ESOF Starter' : 'ESOF BG';
        $email = $this->subject( $subject . ' PDF')
                    ->view('emails.leave_request_confirmation_pdf')
                    ->with([
                        'leaveRequest' => $this->leaveRequest,
                    ]);


        if ($this->pdfPath && file_exists($this->pdfPath)) {
            $email->attach($this->pdfPath, [
                'as' => basename($this->pdfPath),
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}
