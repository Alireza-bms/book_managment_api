<?php

namespace App\Traits;

use App\Enums\ApiResponseStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Trait ApiResponse
 *
 * This trait provides standardized methods for returning JSON responses in APIs.
 * Its main purpose is to unify the API output structure for both success and error responses.
 *
 * Advantages:
 * - Supports plain data (arrays, models, etc.) as well as Laravel Resources and Collections.
 * - Preserves Laravel's default Resource structure (including `data`, `links`, `meta` for pagination).
 * - Uses default messages from the `ApiResponseStatus` enum when no custom message is provided.
 * - Allows passing a custom message and HTTP status code.
 *
 * Example success response:
 * {
 *     "status": "success",
 *     "message": "Operation completed successfully.",
 *     "data": { ... },
 *     "links": { ... },
 *     "meta": { ... }
 * }
 *
 * Example error response:
 * {
 *     "status": "error",
 *     "message": "An unexpected error occurred.",
 *     "errors": { ... }
 * }
 */
trait ApiResponse
{
    /**
     * Build a success JSON response.
     *
     * If the provided $data is a Laravel Resource or Collection,
     * the original structure (including `data`, `links`, `meta`) is preserved.
     *
     * @param mixed $data The payload (can be plain data, model, or Laravel Resource/Collection).
     * @param string|null $message Custom success message (falls back to enum default if null).
     * @param int $status HTTP status code (default: 200).
     *
     * @return JsonResponse
     */
    protected function successResponse(mixed $data = null, ?string $message = null, int $status = 200): JsonResponse
    {
        // If it's a Laravel Resource, we let it build its own structure first
        if ($data instanceof JsonResource) {
            $resourceArray = $data->response()->getData(true);

            return response()->json(array_merge([
                'status'  => ApiResponseStatus::SUCCESS->value,
                'message' => $message ?? ApiResponseStatus::SUCCESS->defaultMessage(),
            ], $resourceArray), $status);
        }

        // For plain data
        return response()->json([
            'status'  => ApiResponseStatus::SUCCESS->value,
            'message' => $message ?? ApiResponseStatus::SUCCESS->defaultMessage(),
            'data'    => $data,
        ], $status);
    }

    /**
     * Build an error JSON response.
     *
     * You can provide extra error details in the $errors parameter
     * (e.g., validation errors or additional info).
     *
     * @param string|null $message Custom error message (falls back to enum default if null).
     * @param int $status HTTP status code (default: 400).
     * @param mixed|null $errors Additional error details (optional).
     *
     * @return JsonResponse
     */
    protected function errorResponse(?string $message = null, int $status = 400, mixed $errors = null): JsonResponse
    {
        return response()->json([
            'status'  => ApiResponseStatus::ERROR->value,
            'message' => $message ?? ApiResponseStatus::ERROR->defaultMessage(),
            'errors'  => $errors,
        ], $status);
    }
}
