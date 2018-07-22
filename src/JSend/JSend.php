<?php

namespace App\JSend;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * See https://labs.omniti.com/labs/jsend.
 */
class JSend
{
    public static function createError(string $message, int $code = null, $data = null): JsonResponse
    {
        $response = ['status' => 'error', 'message' => $message];
        if (null !== $code) {
            $response['code'] = $code;
        }
        if (null !== $data) {
            $response['data'] = $data;
        }

        return new JsonResponse($response, $code ?? 500);
    }

    public static function createFail($data): JsonResponse
    {
        return new JsonResponse(['status' => 'fail', 'data' => $data], 200);
    }

    public static function createSuccess($data): JsonResponse
    {
        return new JsonResponse(['status' => 'success', 'data' => $data], 200);
    }
}
