<?php

namespace App\Utils;

class DefaultResponse
{
    public static function isSuccess($message, $statusCode)
    {
        return response()->json([
            'success' => $message,
        ], $statusCode);
        
    }

    public static function successWithContent($message, $statusCode, $content)
    {
        return response()->json([
            'success' => $message,
            'content' => $content,
        ], $statusCode);
    }
}