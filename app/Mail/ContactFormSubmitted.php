<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function build()
    {
        return $this
            ->subject('Nuevo formulario recibido')
            ->replyTo(
                $this->customer->email,
                trim($this->customer->first_name . ' ' . $this->customer->last_name)
            )
            ->view('emails.contact-form-submitted');
    }
}
