<?php

namespace App\Http\Controllers;

class ResponseFormatter
{
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null
        ],
        'data' => null
    ];

    public static function success($data = null, $message = null, $status = 200)
    {
        self::$response['meta']['code'] = $status;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;
        return response()->json(self::$response, $status, [], JSON_UNESCAPED_UNICODE);
    }

    public static function error($data = null, $message = null, $code = 400)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }
}
