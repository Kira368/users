<?php
$host = "MySQL-8.4"; // как в config.php
$user = "root";
$pass = "";
$db   = "project5";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

?>
