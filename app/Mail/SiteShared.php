<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contact;

class SiteShared extends Mailable
{
    use Queueable, SerializesModels;
    public $contact;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
	$this->contact = $contact;	
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	return $this->from($this->contact)
                    ->view('emails.share.sent')
                    ->text('emails.share.sent_plain');
    }
}
