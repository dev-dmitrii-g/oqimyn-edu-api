<?php
// Функция для возвращения ошибки
function error(string $message = "", int $status_code = 500): void {
    http_response_code($status_code);
    json_response(array("message" => $message));
};

// Функция для возвращения JSON ответа
function json_response(array $data = []): void {
    header("Content-type: application/json; charset=UTF-8");
    die(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
};
?>