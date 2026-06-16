<?php
header("Access-Control-Allow-Origin: *");

$host = "localhost"; $user = "имя_пользователя_бд"; $pass = "пароль_бд"; $db = "game_db";
$conn = new mysqli($host, $user, $pass, $db);

$user_input = trim($_POST['username']);
$pass_input = trim($_POST['password']);

// Ищем пользователя в базе
$stmt = $conn->prepare("SELECT password_hash FROM users WHERE username = ?");
$stmt->bind_param("s", $user_input);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Проверяем, совпадает ли введенный пароль с хэшем из БД
    if (password_verify($pass_input, $row['password_hash'])) {
        echo "LoginSuccess";
    } else {
        echo "WrongPassword";
    }
} else {
    echo "UserNotFound";
}
?>
