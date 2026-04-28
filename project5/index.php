<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
require 'db.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title></title>
</head>
<body>
<div class="container">
    <h1>Главная страница</h1>
    <p>Здравствуйте, <b><?= $_SESSION['username'] ?></b></p>
</div>
<div class="profile-info">
    <h3>Ваши данные</h3>
    <?php if ($profile): ?>
        <p><strong>ФИО:</strong> <?=($profile['full_name'] ?? '') ?></p>
        <p><strong>Email:</strong> <?=($profile['email'] ?? '' ) ?></p>
        <p><strong>Возраст:</strong> <?=($profile['age'] ?? '' )?></p>
        <p><strong>О себе:</strong> <?=($profile['about'] ?? '' )?></p>
    <?php else: ?>
        <p>Профиль не заполнен</p>
    <?php endif; ?>
</div>
<a href="logout.php">Выйти из аккаунта</a>
<a href="profile.php">Мой профиль</a>
</body>
</html>