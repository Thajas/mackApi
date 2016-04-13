<?php

defined('ACCESS') or exit('No direct script access allowed');

header('Content-Type: application/json');

if ($error) {
    echo json_encode(array(
                'status' => 0,
                'error_code' => 400,
                'message' => $data,
        ), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array(
                'status' => 1,
                'data' => array_filter($data),
        ), JSON_PRETTY_PRINT);
}
