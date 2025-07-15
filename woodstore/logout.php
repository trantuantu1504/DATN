<?php
session_start();
session_unset(); // Xoá tất cả biến phiên
session_destroy(); // Huỷ phiên
// Chuyển về trang đăng nhập hoặc trang chủ
header("Location: login.html");
exit();
?>