<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $about = $_POST['about'];

    if ($profile) {
        $stmt = $conn->prepare("
            UPDATE profiles 
            SET full_name=?, email=?, age=?, about=? 
            WHERE user_id=?
        ");
        $stmt->bind_param("ssisi", $full_name, $email, $age, $about, $user_id);
    } else {
        $stmt = $conn->prepare("
            INSERT INTO profiles (user_id, full_name, email, age, about)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("issis", $user_id, $full_name, $email, $age, $about);
    }

    $stmt->execute();
    header("Location: profile.php");
    exit;
}
?>

<h2>Профиль</h2>

<form method="post">
    <input type="text" name="full_name" placeholder="ФИО"
           value="<?= $profile['full_name'] ?? '' ?>"><br><br>

    <input type="email" name="email" placeholder="Email"
           value="<?= $profile['email'] ?? '' ?>"><br><br>

    <input type="number" name="age" placeholder="Возраст"
           value="<?= $profile['age'] ?? '' ?>"><br><br>

    <textarea name="about" placeholder="О себе"><?= $profile['about'] ?? '' ?></textarea><br><br>

    <button type="submit">Сохранить</button>
</form>

<a href="index.php">← На главную</a>
