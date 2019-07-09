<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    // public function render($request, Exception $exception)
    // {
    //     return parent::render($request, $exception);
    // }

    public function render($request, Exception $e)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(
                          $this->getJsonMessage($e), 
                          $this->getExceptionHTTPStatusCode($e)
                        );
        }
        return parent::render($request, $e);
    }

    protected function getJsonMessage($e){
        // You may add in the code, but it's duplication
        return [
                  'status' => 'false',
                  'message' => $e->getMessage()
               ];
    }

    protected function getExceptionHTTPStatusCode($e){
        // Not all Exceptions have a http status code
        // We will give Error 500 if none found
        return method_exists($e, 'getStatusCode') ? 
                         $e->getStatusCode() : 500;
    }

}
