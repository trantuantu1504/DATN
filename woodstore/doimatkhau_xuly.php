<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['matk'])) {
    http_response_code(403);
    echo "Bạn chưa đăng nhập.";
    exit();
}

$matk = $_SESSION['matk'];
$oldPass = $_POST['old-password'] ?? '';
$newPass = $_POST['new-password'] ?? '';
$confirmPass = $_POST['confirm-password'] ?? '';

if ($newPass !== $confirmPass) {
    echo "Mật khẩu xác nhận không khớp.";
    exit();
}

// Lấy mật khẩu cũ từ DB
$stmt = $conn->prepare("SELECT MatKhau FROM KhachHang WHERE MaTK = ?");
$stmt->bind_param("i", $matk);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// So sánh mật khẩu cũ
if (!$user || $oldPass !== $user['MatKhau']) {
    echo "Mật khẩu cũ không đúng.";
    exit();
}

// Cập nhật mật khẩu mới vào KhachHang
$stmt = $conn->prepare("UPDATE KhachHang SET MatKhau = ? WHERE MaTK = ?");
$stmt->bind_param("si", $newPass, $matk);
$stmt->execute();

// ✅ Cập nhật mật khẩu vào bảng TK
$stmt = $conn->prepare("UPDATE TK SET MatKhau = ? WHERE MaTK = ?");
$stmt->bind_param("si", $newPass, $matk);
$stmt->execute();

echo "Đổi mật khẩu thành công!";
exit();
?>
