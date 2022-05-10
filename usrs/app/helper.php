<?php
if (!function_exists('responsedata')) {

    function responsedata($msg = 'page not found', $errors = null, $data = null, $status = 404)
    {

        // if ($errors) {
        //     $errors = $errors;
        // } else {
        //     $errors = new stdClass();
        // }
        $response = [
            'message' => $msg,
            "errors" => $errors ?? new stdClass(),
            "data" => $data ?? new stdClass(),
        ];

        return response()->json($response, $status);
    }
}
