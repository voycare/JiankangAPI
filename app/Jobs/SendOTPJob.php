<?php


namespace App\Jobs;


use App\Mail\MailSendOTP;
use Illuminate\Support\Facades\Mail;

class SendOTPJob extends Job
{
    protected $email;
    protected $otp;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $otp, $user)
    {
        $this->email = $email;
        $this->otp = $otp;
        $this->user = $user;
    }

    /**
     * Execute the job.cl
     *
     * @return void
     */
    public function handle()
    {
        $link = env('URL_WEB') . '/confirm-email?code=' . $this->otp;
        $sendemail = new MailSendOTP($link, $this->user->first_name, $this->user->last_name);
        Mail::to($this->email)->send($sendemail);
    }
}
