<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function successResponse($data, $message = 'Success', $statusCode = 200)
    {
        return response()->json(['message' => $message, 'data' => $data], $statusCode);
    }

    public function errorResponse($message, $statusCode = 400)
    {
        return response()->json(['error' => $message], $statusCode);
    }

    public function validationErrorResponse($errors, $statusCode = 422)
    {
        return response()->json(['errors' => $errors], $statusCode);
    }
}
