<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $Appointment;

    public function __construct(Appointment $Appointment)
    {
        $this->Appointment = $Appointment;
    }

    public function build()
    {
        $team = $this->Appointment->team->name;
        return $this->subject('New Appointment Request For - ' . $team )
                    ->view('emails.appointment_received')
                    ->with(['inquiry' => $this->Appointment]);
    }
}