<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit;
}

function send_json($status, $payload) {
    http_response_code($status);
    echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function require_method($method) {
    if ($_SERVER["REQUEST_METHOD"] !== $method) {
        header("Allow: " . $method . ", OPTIONS");
        send_json(405, [
            "success" => false,
            "message" => "Metode HTTP tidak diizinkan. Gunakan " . $method . "."
        ]);
    }
}

function read_json_body() {
    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        send_json(400, [
            "success" => false,
            "message" => "Body harus berupa JSON yang valid."
        ]);
    }
    return $data;
}
