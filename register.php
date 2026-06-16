<?php
header("Access-Control-Allow-Origin: *");

$host = "localhost"; $user = "имя_пользователя_бд"; $pass = "пароль_бд"; $db = "game_db";
$conn = new mysqli($host, $user, $pass, $db);

$user_input = trim($_POST['username']);
$pass_input = trim($_POST['password']);

if (empty($user_input) || empty($pass_input)) {
    die("EmptyFields");
}

// Хэшируем пароль перед записью в БД
$hashed_password = password_hash($pass_input, PASSWORD_BCRYPT);

// Записываем безопасным запросом
$stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
$stmt->bind_param("ss", $user_input, $hashed_password);

if ($stmt->execute()) {
    echo "RegisterSuccess";
} else {
    echo "UserExists"; // Если имя уже занято
}
?>
