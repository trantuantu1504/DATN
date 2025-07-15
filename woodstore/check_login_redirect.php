<?php
session_start();

// Kiểm tra xem đã đăng nhập chưa
if (isset($_SESSION['email']) && isset($_SESSION['matk'])) {
    header("Location: user.php");
} else {
    header("Location: login.html");
}
exit();
?>
