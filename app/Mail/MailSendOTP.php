<?php


namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSendOTP extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $first_name;
    public $last_name;

    public function __construct($otp, $first_name, $last_name)
    {
        $this->otp = $otp;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    public function build()
    {
        return $this->subject('Please confirm your email address')->view('mailSendOTP');
    }
}
