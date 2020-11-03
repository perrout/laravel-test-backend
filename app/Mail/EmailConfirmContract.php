<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Contract;

class EmailConfirmContract extends Mailable
{
    use Queueable, SerializesModels;

    protected $contract;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( Contract $contract )
    {
        $this->contract = $contract;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmação de Contrato de Propriedade')
                    ->view('emails.confirm-contract')
                    ->with( [ 'contract' => $this->contract ] );
    }
}
