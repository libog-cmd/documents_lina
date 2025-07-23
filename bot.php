<?php
http_response_code(200);
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Минимальный лог — сразу при вызове
file_put_contents("log.txt", date("Y-m-d H:i:s") . " - PHP Call\n", FILE_APPEND);

// Читаем входящий JSON
$raw = file_get_contents("php://input");
file_put_contents("log.txt", "RAW: $raw\n", FILE_APPEND);

// Пытаемся распарсить JSON
$data = json_decode($raw, true);
file_put_contents("log.txt", "PARSED: " . print_r($data, true) . "\n", FILE_APPEND);

// Проверка: пришло ли сообщение
if (isset($data["message"]["chat"]["id"])) {
    $chat_id = $data["message"]["chat"]["id"];
    $text = $data["message"]["text"] ?? "";

    $token = "7446956113:AAEYChHE3Lcq6MPVB-sT0RFTVoCINie8REM"; // <-- вставь свой токен!
    $url = "https://api.telegram.org/bot$token/sendMessage";

    $response = [
        'chat_id' => $chat_id,
        'text' => "Ты написал: $text"
    ];

    file_get_contents($url . "?" . http_build_query($response));
    file_put_contents("log.txt", "Send response\n", FILE_APPEND);
} else {
    file_put_contents("log.txt", "No message/chat/id\n", FILE_APPEND);
}
?>
