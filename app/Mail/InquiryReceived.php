<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Inquiry;

class InquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;

    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function build()
    {
        return $this->subject('New Property Inquiry - ' . $this->inquiry->name)
                    ->view('emails.inquiry_received')
                    ->with(['inquiry' => $this->inquiry]);
    }
}