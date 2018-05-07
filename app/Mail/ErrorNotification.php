<?php

namespace App\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Request;

class ErrorNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;
    public $file;
    public $line;
    public $ip;
    public $server;
    public $url;

    /**
    * Create a new message instance.
    *
    * @return void
    */
    public function __construct(Exception $exception)
      {
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
        $this->msg = $exception->getMessage();
        $this->url = Request::fullUrl();
        
        /////////////////////////////////////////////////////////////////////
        // ogni variabile pubblica viene automaticamente passata alla view //
        /////////////////////////////////////////////////////////////////////
        
      }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.error-notification');
    }

}
