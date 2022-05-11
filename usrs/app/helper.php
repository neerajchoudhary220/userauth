<?php
if (!function_exists('responsedata')) {

    function responsedata($msg = '', $errors = null, $data = null, $status = 200)
    {


        $response = [
            'message' => $msg,
            "errors" => $errors ?? new stdClass(),
            "data" => $data ?? new stdClass(),
        ];

        return response()->json($response, $status);
    }
}
