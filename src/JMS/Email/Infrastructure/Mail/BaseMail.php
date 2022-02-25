<?php
 
 namespace JMS\Email\Infrastructure\Mail;
 
use Illuminate\Mail\Mailable;
 
class BaseMail extends Mailable
{
 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this;
    }
}