<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    /**
     * Mengembalikan respons sukses.
     *
     * @param  mixed       $data
     * @param  string      $message
     * @param  int         $statusCode
     * @return JsonResponse
     */
    protected function successResponse (
        $data = null,
        string $message = 'Request successful',
        int $statusCode = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }

    /**
     * Mengembalikan respons error.
     *
     * @param  string      $message
     * @param  int         $statusCode
     * @param  mixed       $errors
     * @return JsonResponse
     */
    protected function errorResponse (
        string $message = 'An error occurred',
        int $statusCode = 400, $errors = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $statusCode);
    }

    /**
     * Mengembalikan respons 404 Not Found.
     *
     * @param  string      $message
     * @return JsonResponse
     */
    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Mengembalikan respons 401 Unauthorized.
     *
     * @param  string      $message
     * @return JsonResponse
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }
}