<?php
// Ваш токен бота та chat ID
$botToken = "6147003976:AAEZ_behIaqbYkYEu5UMHZO3F4QRaNf22jc"; // Замість цього вставте ваш токен
$chatId = "-1002290623549"; // Замість цього вставте ваш chat ID

// Перевірка, чи заповнені необхідні поля
if (empty($_POST['name']) || empty($_POST['message'])) {
    echo 'Будь ласка, заповніть всі поля.';
    exit;
}

// Отримання даних з форми
$name = htmlspecialchars($_POST['name']);
$message = htmlspecialchars($_POST['message']);
$imagePath = 'telegram/' . basename($_FILES['petitionImage']['name']);

// Переміщення файлу, якщо воно надане
$imageUrl = '';
if (isset($_FILES['petitionImage']) && $_FILES['petitionImage']['error'] === UPLOAD_ERR_OK) {
    // Переміщення файлу
    if (move_uploaded_file($_FILES['petitionImage']['tmp_name'], $imagePath)) {
        // Формування повної URL-адреси зображення
        $imageUrl = 'http://petucii.free.nf/telegram' . $imagePath; // Змініть 'yourdomain.com' на ваш домен
    } else {
        echo 'Помилка завантаження зображення.';
        exit;
    }
}

// Формування повідомлення для Telegram
$fullMessage = "Ім'я: $name\nПовідомлення: $message";

// Якщо зображення не надане, відправляємо тільки текстове повідомлення
if (empty($imageUrl)) {
    $message_url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($fullMessage);
    $response = file_get_contents($message_url);
} else {
    // Відправлення зображення до Telegram
    $image_url = "https://api.telegram.org/bot$botToken/sendPhoto?chat_id=$chatId&photo=" . urlencode($imageUrl) . "&caption=" . urlencode($fullMessage);
    $response = file_get_contents($image_url);
}

// Перевірка, чи повідомлення надіслано
if ($response) {
    echo 'Петицію успішно надіслано!';
} else {
    echo 'Сталася помилка під час надсилання петиції.';
}
?>



