<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $phone = trim($_POST['phone']);
        $password = trim($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Валідація даних
if (!preg_match("/^[\p{L}\p{N}]*$/u", $username)) {
    echo "Ім'я користувача може містити лише літери (латиниця або кирилиця) та цифри.";
    exit();
}

        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            echo "Номер телефону повинен містити 10 цифр.";
            exit();
        }

        // Читаємо дані з файлу
        $data = file_get_contents('users.txt');
        $users = json_decode($data, true) ?? [];

        // Перевірка на наявність користувача
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                echo "Цей користувач вже зареєстрований.";
                exit();
            }
        }

        // Додаємо нового користувача
        $users[] = [
            'username' => $username,
            'phone' => $phone,
            'password' => $hashedPassword
        ];

        // Записуємо оновлені дані у файл
        file_put_contents('users.txt', json_encode($users));

        echo "Реєстрація успішна!";
    } else {
        echo "Будь ласка, заповніть всі поля.";
    }
}
?>


