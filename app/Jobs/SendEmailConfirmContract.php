<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Mail;
use App\Models\Contract;
use App\Mail\EmailConfirmContract;

class SendEmailConfirmContract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $contract, $mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( Contract $contract )
    {
        $this->contract = $contract;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new EmailConfirmContract( $this->contract );
        Mail::to( $this->contract['email'] )->send( $email );
    }
}
