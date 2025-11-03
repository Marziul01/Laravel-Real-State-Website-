<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Inquiry;

class ContactReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $Contact;

    public function __construct(Contact $Contact)
    {
        $this->Contact = $Contact;
    }

    public function build()
    {
        return $this->subject('New Service Contact Inquiry - ' . $this->Contact->name)
                    ->view('emails.contact_received')
                    ->with(['inquiry' => $this->Contact]);
    }
}