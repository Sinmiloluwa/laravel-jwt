<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

trait ResponseTrait
{
    public function okResponse(string $message, $data = null): JsonResponse
    {
        return $this->successResponse($message, $data);
    }

    public function createdResponse(string $message, $data = null): JsonResponse
    {
        return $this->successResponse($message, $data, 201);
    }

    public function successResponse(string $message, $data = null, int $status = 200): JsonResponse
    {
        return $this->jsonResponse($message, $status, $data);
    }

    public function notFoundResponse(string $message, $error = null): JsonResponse
    {
        return $this->clientErrorResponse($message, 404, $error);
    }

    public function badRequestResponse(string $message, $error = null): JsonResponse
    {
        return $this->clientErrorResponse($message, 400, $error);
    }

    public function forbiddenResponse(string $message, $error = null): JsonResponse
    {
        return $this->clientErrorResponse($message, 403, $error);
    }

    public function clientErrorResponse(string $message, int $status = 400,  $error = null): JsonResponse
    {
        return $this->jsonResponse($message, $status, $error);
    }

    public function jsonResponse(string $message, int $status, $data = null): JsonResponse
    {
        $isSuccessful = $this->isStatusCodeSuccessful($status);

        $responseData = [
            'status' => $isSuccessful,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $responseData[$isSuccessful ? 'data' : 'errors'] = $data;
        }

        return Response::json($responseData, $status);
    }

    public function isStatusCodeSuccessful(int $statusCode): bool
    {
        return $statusCode >= 200 && $statusCode < 300;
    }
}
