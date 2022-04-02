<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            return response()->json(['mensaje' => 'Error De Modelo', 400]);
        });
        $this->reportable(function (Throwable $e) {
            return response()->json(['mensaje' => 'Error De Autenticación', 401]);
        });
        $this->reportable(function (Throwable $e) {
            return response()->json(['mensaje' => 'Error De Autenticación, No Tiene Permisos', 403]);
        });
        $this->reportable(function (Throwable $e) {
            return response()->json(['mensaje' => 'Objeto No Encontrado', 404]);
        });
        $this->reportable(function (Throwable $e) {
            return response()->json(['mensaje' => 'Objeto De Consultad BD', 500]);
        });
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'mensaje' => 'Los datos proporcionados no son validos',
            'error' => $exception->errors(),
        ], $exception->status);
    }
}
