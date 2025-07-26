<?php

// Токен, выданный BotFather
$TOKEN = 'ВАШ_ТОКЕН_ТУТ';

// Получаем тело запроса Telegram (JSON)
$body = file_get_contents("php://input");
$data = json_decode($body, true);

// Получаем chat_id и текст сообщения
$chat_id = $data['message']['chat']['id'] ?? null;
$text = $data['message']['text'] ?? '';

// Функция отправки сообщения
function sendMessage($chat_id, $text) {
    global $TOKEN;

    $url = "https://api.telegram.org/bot$TOKEN/sendMessage";
    $post_fields = [
        'chat_id' => $chat_id,
        'text' => $text,
    ];

    // cURL-запрос
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_exec($ch); 
    curl_close($ch);
}

// Обработка команд
if ($text === '/start') {
    sendMessage($chat_id, "Привет! Я простой PHP-бот 😊");
} elseif (!empty($text)) {
    sendMessage($chat_id, "Вы написали: $text");
}

?>
