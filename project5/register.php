<?php
session_start();
require 'db.php';

if (!empty($_POST['username']) && !empty($_POST['password'])) {

    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Проверяем, есть ли пользователь
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "❌ Пользователь с таким логином уже существует";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            echo "✅ Регистрация прошла успешно";
        } else {
            echo "❌ Ошибка регистрации";
        }
    }
}
?>

<form method="post">
    <input type="text" name="username" placeholder="Логин" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Зарегистрироваться</button>
</form>

<a href="login.php">Войти</a>
