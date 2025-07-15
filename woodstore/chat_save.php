<?php
session_start();
include('db_connection.php');

$sender = $_SESSION['matk'] ?? null; // admin
$receiver = $_POST['receiver_id'] ?? null;
$message = trim($_POST['message'] ?? '');

if ($sender && $receiver && $message !== '') {
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender, $receiver, $message);
    $stmt->execute();
    header("Location: admin_chat.php"); // quay lại sau khi gửi
} else {
    echo "Thiếu thông tin!";
}
?>
