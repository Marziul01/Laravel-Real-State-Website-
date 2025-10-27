<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        // ✅ Check if Blade views exist before proceeding
        if (!View::exists('emails.invoice_mail')) {
            Log::error("Missing Blade file: emails.invoice_mail");
            throw new \Exception("Missing Blade file: emails.invoice_mail");
        }

        if (!View::exists('emails.invoice_pdf')) {
            Log::error("Missing Blade file: emails.invoice_pdf");
            throw new \Exception("Missing Blade file: emails.invoice_pdf");
        }

        try {
            // ✅ Generate PDF invoice
            $pdf = Pdf::loadView('emails.invoice_pdf', ['booking' => $this->booking]);

            return $this->subject('Your Booking Invoice #' . $this->booking->id)
                ->view('emails.invoice_mail')
                ->with(['booking' => $this->booking])
                ->attachData(
                    $pdf->output(),
                    'Invoice-' . $this->booking->id . '.pdf',
                    ['mime' => 'application/pdf']
                );
        } catch (\Exception $e) {
            Log::error('Error building InvoiceMail: ' . $e->getMessage());
            throw $e;
        }
    }
}
