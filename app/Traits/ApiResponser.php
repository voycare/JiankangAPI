<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{

    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response($data, $code)->header('Content-Type', 'application/json');
    }

    public function errorResponse($message, $code)
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
        ], 501);
    }

    public function errorMessage($message, $code)
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
        ], $code);
    }

    /**
     * @param $data
     * @param int $code
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponseMessage($data, $code = Response::HTTP_OK, $message = '')
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
