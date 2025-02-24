<?php

namespace App\Helper;

if (!function_exists('apiResponse')) {
    function apiResponse($data = [], $message='success',$status=null,$errors=[]){
        return response()->json([
            "message"=>$message,
            "status"=>$status,
            "data"=>$data,
            "errors"=>$errors
        ],$status);
    }
}

if(!function_exists('handleException')){
    function handleException(callable $callback, $status = 500){
        try {
            return $callback();
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => $status,
                'message' => $e->getMessage(),
                'error'   => class_basename($e),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ],$status);
        }
    }
}