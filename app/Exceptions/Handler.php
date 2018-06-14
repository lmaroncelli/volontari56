<?php

namespace App\Exceptions;

use App\Mail\ErrorNotification;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Request;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];



    private function _getMyLog(Exception $e)
      {
      $file = $e->getFile();
      $line = $e->getLine();
      $msg = $e->getMessage();
      $url = Request::fullUrl();
     


      $trace =  "
      url: $url
      file : $file 
      line: $line
      exception: $msg 
      ";

      return $trace;

      }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
      {   
      //dd($exception);
      if (! $exception instanceof ValidationException) 
        { 
        
        try 
          {
          //$myLog = $this->_getMyLog($exception);
          //Log::critical($myLog);
          
          //\Mail::to('lmaroncelli@gmail.com')->send(new ErrorNotification($exception));  
          } 
        catch (\Exception $e) 
          {
          //errore nell'inviare la mail oppure nello scrivere nel log file;
          }
        
        }
        
        parent::report($exception);
      }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
