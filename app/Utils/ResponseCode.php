<?php

namespace App\Utils;

class ResponseCode {
    static function successGet($message, $data){
        return response()->json([
            'message' => $message,
            'success' => true,
            'data' => $data
        ], 200);
    }

    static function successPost($message){
        return response()->json([
            'message' => $message,
            'success' => true,
            'data' => NULL
        ], 201);
    }

    static function errorPost($message){
        return response()->json([
            'message' => $message,
            'success' => false,
            'data' => NULL
        ], 400);
    }

    static function errorGet($message){
        return response()->json([
            'message' => $message,
            'success' => false,
            'data' => NULL
        ], 404);
    }

    static function unauthorized($message = null){
        return response()->json([
            'message' => $message ? $message : 'You are unauthorized to access this resource',
            'success' => false
        ], 401);
    }
}