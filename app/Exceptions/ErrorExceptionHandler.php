<?php

namespace App\Services\Tag\Exceptions;

use Exception;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ErrorExceptionHandler extends Exception
{
    public function render(Request $request, Throwable $exception): Response
    {
        $statusCode = $exception->getCode() ?: 500;

        return Inertia::render('Error', [
            'status' => $statusCode,
            'message' => $exception->getMessage(),
        ])->toResponse($request)->setStatusCode($statusCode);
    }
}
