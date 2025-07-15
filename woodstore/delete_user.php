<?php
include 'db_connection.php';

if (!isset($_GET['id'])) {
    echo "Thiếu mã tài khoản.";
    exit;
}

$id = intval($_GET['id']);

// Xóa bản ghi trong bảng KhachHang trước (vì có khóa ngoại liên kết tới TK)
$stmt1 = $conn->prepare("DELETE FROM KhachHang WHERE MaTK = ?");
$stmt1->bind_param("i", $id);

// Xóa bản ghi trong bảng TK
$stmt2 = $conn->prepare("DELETE FROM TK WHERE MaTK = ?");
$stmt2->bind_param("i", $id);

// Thực hiện lệnh xóa
if ($stmt1->execute() && $stmt2->execute()) {
    header("Location: tk.php");
    exit;
} else {
    echo "Lỗi khi xóa tài khoản: " . $conn->error;
}
?>
