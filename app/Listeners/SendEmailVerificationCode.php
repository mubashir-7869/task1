<?php

namespace App\Listeners;

use App\Events\EmailVerificationCode;
use App\Services\VerifyEmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailVerificationCode
{
    /**
     * Create the event listener.
     */
    public function __construct(VerifyEmailService $verifyEmailService)
    {
        $this->verifyEmailService = $verifyEmailService;
    }

    /**
     * Handle the event.
     */
    public function handle(EmailVerificationCode $event): void
    {
        $to = $event->email;
        $to = config('app.email');
        $subject =  "Task 1";

        $template = "email.template";   // this is view like ===> view(email.template); 
        $verificationLink = $event->verificationLink;
        $data = [
            'subject' => 'Verify Email Address',
            '$actionUrl' => $verificationLink,
        ];

        $emailSent = $this->verifyEmailService->sendEmail(
            $from,
            $to,
            $subject,
            $data,
            null,
        );
        if(!$emailSent){
            dd($emailSent);
        }
    }
}
