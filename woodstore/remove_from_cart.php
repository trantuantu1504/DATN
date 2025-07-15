<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['masp'])) {
    $masp = (int)$_POST['masp'];

    // Xoá theo key masp
    if (isset($_SESSION['cart'][$masp])) {
        unset($_SESSION['cart'][$masp]);
    }
}

header("Location: cart.php");
exit();
