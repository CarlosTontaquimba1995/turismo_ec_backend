<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $exception->errors(),
        ], $exception->status);
    }

    /**
     * Convert a validation exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function invalid($request, ValidationException $exception)
    {
        if (! $request->expectsJson()) {
            return redirect()->to($exception->redirectTo ?? url()->previous())
                ->withInput(collect($request->input())->except(['password', 'password_confirmation'])->all())
                ->withErrors($exception->errors(), $exception->errorBag);
        }

        return $this->invalidJson($request, $exception);
    }
}
