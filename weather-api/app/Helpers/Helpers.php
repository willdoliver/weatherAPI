<?php


if (!function_exists('apiResponse')) {
    function apiResponse(
        bool $status,
        String $message,
        $data = [],
        $httpCode = 200
    ) {
        return response()->json([
            'status'    => $status,
            'message'   => $message,
            'data'      => $data
        ], status: $httpCode);
    }
}

function extractParamFromResponse($response, $param) {

}