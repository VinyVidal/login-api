<?php

namespace App\Helpers;

use App\Exceptions\ServiceException;
use Exception;

class ResponseHelper {
    /**
     * @param array $response_data
     */
    public static function handleControllerResponse($response_data) {
        $data = [
            'success' => $response_data['success'] ?? true,
            'data' => $response_data['data'] ?? null,
            'message' => $response_data['message'] ?? null,
            'status_code' => $response_data['status_code'] ?? 200,
        ];

        return response()->json($data, $data['status_code']);
    }

    /**
     * @param mixed data
     * @param int $status_code
     */
    public static function handleServiceSuccess($data = null, $status_code = 200) {
        return [
            'success' => true,
            'data' => $data,
            'status_code' => $status_code,
        ];
    }

    public static function handleServiceException($exception) {
        if(get_class($exception) !== ServiceException::class) {
            return self::handleGenericException($exception);
        }

        return [
            'success' => false,
            'status_code' => $exception->getStatusCode(),
            'message' => $exception->getMessage(),
        ];
    }

    private static function handleGenericException(Exception $exception) {
        return [
            'success' => false,
            'status_code' => 500,
            'message' => $exception->getMessage(),
        ];
    }
}
