<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ApiResponse
{
    /**
     * Send a successful response for a collection of items.
     * Returns 404 if no items found and $allowEmpty is false.
     *
     * @param mixed $data Collection or array of items
     * @param string $message Success message
     * @param bool $allowEmpty If false, returns 404 when no items found
     * @return \Illuminate\Http\JsonResponse
     */
    public static function collection($data, string $message = 'Data retrieved successfully', bool $allowEmpty = true): JsonResponse
    {
        // Convert collections to array
        $items = $data instanceof \Illuminate\Support\Collection 
            ? $data->toArray() 
            : (is_array($data) ? $data : []);
        
        // Check if we should return 404 for empty results
        if (!$allowEmpty && empty($items)) {
            return response()->json([
                'success' => false,
                'message' => 'No resources found',
            ], 404);
        }
        
        // Return successful response with data
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $items
        ]);
    }

    /**
     * Send a successful response for a single resource.
     * Returns 404 if the resource is not found.
     *
     * @param mixed $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function resource($data, string $message = 'Resource retrieved successfully'): JsonResponse
    {
        if ($data === null || (is_array($data) && empty($data))) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Send a successful response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(
        $data = null,
        string $message = 'Operation successful',
        int $code = 200
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Send a successful response for a created resource.
     *
     * @param mixed $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function created(
        $data = null,
        string $message = 'Resource created successfully'
    ): JsonResponse {
        return self::success($data, $message, HttpResponse::HTTP_CREATED);
    }

    /**
     * Send a successful response with no content.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function noContent(): JsonResponse
    {
        return response()->json(null, HttpResponse::HTTP_NO_CONTENT);
    }

    /**
     * Send an error response.
     *
     * @param string $message
     * @param array $errors
     * @param int $code
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error(
        string $message = 'An error occurred',
        array $errors = [],
        int $code = HttpResponse::HTTP_BAD_REQUEST,
        $data = null
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        // Log error for server-side tracking
        if ($code >= 500) {
            Log::error('API Error: ' . $message, [
                'code' => $code,
                'errors' => $errors,
                'data' => $data
            ]);
        }

        return response()->json($response, $code);
    }

    /**
     * Send a not found response.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return self::error($message, [], HttpResponse::HTTP_NOT_FOUND);
    }

    /**
     * Send a validation error response.
     *
     * @param array $errors
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function validationError(
        array $errors,
        string $message = 'Validation failed'
    ): JsonResponse {
        return self::error($message, $errors, HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Send an unauthorized response.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function unauthorized(string $message = 'Unauthorized access'): JsonResponse
    {
        return self::error($message, [], HttpResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Send a forbidden response.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return self::error($message, [], HttpResponse::HTTP_FORBIDDEN);
    }

    /**
     * Send a method not allowed response.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function methodNotAllowed(string $message = 'Method not allowed'): JsonResponse
    {
        return self::error($message, [], HttpResponse::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * Send a too many requests response.
     *
     * @param string $message
     * @param int $retryAfter
     * @return \Illuminate\Http\JsonResponse
     */
    public static function tooManyRequests(
        string $message = 'Too many requests',
        int $retryAfter = 60
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], HttpResponse::HTTP_TOO_MANY_REQUESTS)->header('Retry-After', $retryAfter);
    }

    /**
     * Send a server error response.
     *
     * @param string $message
     * @param \Throwable|null $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public static function serverError(
        string $message = 'Internal server error',
        ?\Throwable $exception = null
    ): JsonResponse {
        $data = [];
        
        if (config('app.debug') && $exception) {
            $data['exception'] = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ];
        }

        return self::error(
            $message,
            [],
            HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
            !empty($data) ? $data : null
        );
    }

    /**
     * Send a service unavailable response.
     *
     * @param string $message
     * @param int $retryAfter
     * @return \Illuminate\Http\JsonResponse
     */
    public static function serviceUnavailable(
        string $message = 'Service temporarily unavailable',
        int $retryAfter = 60
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], HttpResponse::HTTP_SERVICE_UNAVAILABLE)->header('Retry-After', $retryAfter);
    }

    /**
     * Send a custom response.
     *
     * @param bool $success
     * @param string $message
     * @param int $code
     * @param mixed $data
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public static function custom(
        bool $success,
        string $message,
        int $code,
        $data = null,
        array $errors = []
    ): JsonResponse {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

}
