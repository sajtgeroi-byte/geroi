<?php
// Заміни на свій токен і chat_id
$botToken = "6147003976:AAEZ_behIaqbYkYEu5UMHZO3F4QRaNf22jc";
$chatId = "-1002290623549";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Отримання даних із форми
    $name = $_POST['name'];
    $message = $_POST['message'];
    $file = $_FILES['petitionImage'];

    // Підготовка тексту повідомлення
    $textMessage = "Ім'я: " . $name . "\n";
    $textMessage .= "Повідомлення: " . $message;

    // Надсилання текстового повідомлення у Telegram
    $sendMessageUrl = "https://api.telegram.org/bot$botToken/sendMessage";
    $sendMessageData = [
        'chat_id' => $chatId,
        'text' => $textMessage
    ];

    file_get_contents($sendMessageUrl . '?' . http_build_query($sendMessageData));

    // Перевірка завантаження зображення
    if ($file['error'] === UPLOAD_ERR_OK) {
        $filePath = $file['tmp_name'];

        // Надсилання фото у Telegram
        $sendPhotoUrl = "https://api.telegram.org/bot$botToken/sendPhoto";
        $postFields = [
            'chat_id' => $chatId,
            'photo' => new CURLFile($filePath)
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sendPhotoUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        echo 'Петиція успішно надіслана!';
    } else {
        echo 'Помилка при завантаженні зображення.';
    }
}
?>

