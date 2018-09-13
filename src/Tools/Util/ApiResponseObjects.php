<?php


namespace App\Tools\Util;


use Symfony\Component\HttpFoundation\JsonResponse;

trait ApiResponseObjects
{

    /**
     * @param array $data
     * @return JsonResponse
     * @author Robert Glazer
     */
    protected function getSuccessResponse(array $data): JsonResponse
    {
        $dataResponse['status'] = 'ok';
        $dataResponse['data'] = $data;

        $response = new JsonResponse($dataResponse);
        $response->headers->set('Cache-Control', 'private, no-cache');
        return $response;
    }

    /**
     * @param string $message
     * @return JsonResponse
     * @author Robert Glazer
     */
    protected function getBadRequestErrorResponse(string $message): JsonResponse
    {
        $dataResponse = [
            'status' => 'error',
            'error_code' => 400,
            'message' => $message,
        ];

        $response = new JsonResponse($dataResponse, 400);
        $response->headers->set('Cache-Control', 'private, no-cache');
        return $response;
    }

    /**
     * @param string $message
     * @author Borys Pawluczuk
     * @return JsonResponse
     */
    protected function getAccessDeniedErrorResponse(string $message = 'Access Denied'): JsonResponse
    {
        $dataResponse = [
            'status' => 'error',
            'error_code' => 401,
            'message' => $message
        ];

        $response = new JsonResponse($dataResponse, 401);
        $response->headers->set('Cache-Control', 'private, no-cache');
        return $response;
    }

    /**
     * @param string $message
     * @author Borys Pawluczuk
     * @return JsonResponse
     */
    protected function getForbiddenErrorResponse(string $message = 'Forbidden'): JsonResponse
    {
        $dataResponse = [
            'status' => 'error',
            'error_code' => 403,
            'message' => $message
        ];

        $response = new JsonResponse($dataResponse, 403);
        $response->headers->set('Cache-Control', 'private, no-cache');
        return $response;
    }

    /**
     * @param string $message
     * @return JsonResponse
     * @author Borys Pawluczuk
     * @author Robert Glazer
     */
    protected function getNotFoundErrorResponse(string $message = 'Object not found'): JsonResponse
    {
        $dataResponse = [
            'status' => 'error',
            'error_code' => 404,
            'message' => $message
        ];

        $response = new JsonResponse($dataResponse, 404);
        $response->headers->set('Cache-Control', 'private, no-cache');
        return $response;
    }

}