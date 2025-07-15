<?php
session_start();
include('db_connection.php');

if (isset($_SESSION['matk']) && isset($_FILES['avatar'])) {
    $maTK = $_SESSION['matk'];
    $file = $_FILES['avatar'];

    // Kiểm tra lỗi
    if ($file['error'] === 0) {
        $fileName = basename($file['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . uniqid() . "_" . $fileName;

        // Tạo thư mục nếu chưa có
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Di chuyển file tải lên
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Cập nhật đường dẫn ảnh vào DB
            $relativePath = "http://localhost/DATN/woodstore/" . $targetFile; // lưu tương đối
            $sql = $conn->prepare("UPDATE TK SET AvataUser = ? WHERE MaTK = ?");
            $sql->bind_param("si", $relativePath, $maTK);
            $sql->execute();

            echo "<script>alert('Cập nhật ảnh thành công!'); window.location.href='user.php';</script>";
            exit();
        } else {
            echo "<script>alert('Tải ảnh thất bại!'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Lỗi tải ảnh!'); window.history.back();</script>";
        exit();
    }
} else {
    echo "<script>alert('Không xác định người dùng!'); window.history.back();</script>";
    exit();
}
?>
