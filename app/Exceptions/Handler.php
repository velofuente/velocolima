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
    public function render($request, Exception $exception)
    {
        // if($exception instanceof \Illuminate\Auth\AuthenticationException){
        //     return redirect('/login')->with('flash', 'Por favor inicia sesion');
        // }
        //Validar página no encontrada
        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {
                case "404": // No encontrado
                case 404:
                    return redirect()->to('login');
                    break;
                default:
                    break;
            }
        }
        //Validar si tiene sesión expirada
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->to('login');
        }

        return parent::render($request, $exception);
    }
}
