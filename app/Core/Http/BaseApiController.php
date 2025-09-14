<?php

namespace App\Core\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseApiController extends BaseController
{
    /**
     * Return a success response
     */
    protected function successResponse($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => $this->getMeta()
        ], $code);
    }

    /**
     * Return an error response
     */
    protected function errorResponse(string $message = 'Error', int $code = 400, $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'meta' => $this->getMeta()
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Return a paginated response
     */
    protected function paginatedResponse(LengthAwarePaginator $data, string $message = 'Data retrieved successfully'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
                'has_more_pages' => $data->hasMorePages(),
            ],
            'meta' => $this->getMeta()
        ], 200);
    }

    /**
     * Return a created response
     */
    protected function createdResponse($data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return $this->successResponse($data, $message, 201);
    }

    /**
     * Return a not found response
     */
    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Return a validation error response
     */
    protected function validationErrorResponse($errors, string $message = 'Validation failed'): JsonResponse
    {
        return $this->errorResponse($message, 422, $errors);
    }

    /**
     * Return an unauthorized response
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }

    /**
     * Return a forbidden response
     */
    protected function forbiddenResponse(string $message = 'Forbidden'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }

    /**
     * Return a server error response
     */
    protected function serverErrorResponse(string $message = 'Internal server error'): JsonResponse
    {
        return $this->errorResponse($message, 500);
    }

    /**
     * Return a no content response
     */
    protected function noContentResponse(): JsonResponse
    {
        return response()->json(null, 204);
    }

    /**
     * Get meta information for response
     */
    protected function getMeta(): array
    {
        return [
            'timestamp' => now()->toISOString(),
            'timezone' => config('app.timezone'),
            'version' => config('app.version', '1.0.0'),
        ];
    }

    /**
     * Handle API exceptions
     */
    protected function handleException(\Exception $e, string $defaultMessage = 'An error occurred'): JsonResponse
    {
        if (config('app.debug')) {
            return $this->errorResponse($e->getMessage(), 500, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return $this->serverErrorResponse($defaultMessage);
    }

    /**
     * Transform data using a resource class
     */
    protected function transformResponse($data, string $resourceClass, string $message = 'Success'): JsonResponse
    {
        if (class_exists($resourceClass)) {
            $transformedData = new $resourceClass($data);
            return $this->successResponse($transformedData, $message);
        }

        return $this->successResponse($data, $message);
    }
}
