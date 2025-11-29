<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Mail\Mailable;

class AppointmentTeamMail extends Mailable
{
    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->subject('New Appointment Scheduled')
            ->view('emails.team-appointment');
    }
}
