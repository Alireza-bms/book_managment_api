<?php

namespace App\Enums;

/**
 * Enum ApiResponseStatus
 *
 * Represents possible statuses for API responses.
 * This enum also provides a default message for each status.
 */
enum ApiResponseStatus: string
{
    /**
     * Indicates a successful operation.
     */
    case SUCCESS = 'success';

    /**
     * Indicates an error occurred during the operation.
     */
    case ERROR = 'error';

    /**
     * Get the default message for the enum case.
     *
     * @return string
     */
    public function defaultMessage(): string
    {
        return match ($this) {
            self::SUCCESS => 'Operation completed successfully.',
            self::ERROR   => 'An unexpected error occurred.',
        };
    }
}
