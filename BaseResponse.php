<?php

class BaseResponse {
    public static function success($data = null, $code = 200) {
        http_response_code($code);
        echo json_encode([
            'code' => $code,
            'data' => $data
        ]);
        exit;
    }

    public static function error($errors = null, $code = 400) {
        http_response_code($code);
        echo json_encode([
            'code' => $code,
            'errors' => $errors
        ]);
        exit;
    }

    public static function unauthorize($errors = "Unauthorized access", $code = 401) {
        http_response_code($code);
        echo json_encode([
            'code' => $code,
            'errors' => $errors
        ]);
        exit;
    }
}
