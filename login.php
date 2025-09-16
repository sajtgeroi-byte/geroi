<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Читаємо дані з файлу
    $data = file_get_contents('users.txt');
    $users = json_decode($data, true) ?? [];

    // Перевіряємо наявність користувача та перевіряємо пароль
    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            echo 'Успішний вхід';
            exit();
        }
    }

    http_response_code(401);
    echo 'Невірне ім\'я користувача або пароль';
} else {
    http_response_code(405);
    echo 'Метод не дозволено';
}
?>





