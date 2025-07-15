<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $MaSP = intval($_GET['id']);

    // Xóa dữ liệu liên quan trong bảng SanPhamData trước
    $stmt1 = $conn->prepare("DELETE FROM SanPhamData WHERE MaSP = ?");
    $stmt1->bind_param("i", $MaSP);
    $stmt1->execute();

    // Sau đó mới xóa sản phẩm chính
    $stmt2 = $conn->prepare("DELETE FROM SanPham WHERE MaSP = ?");
    $stmt2->bind_param("i", $MaSP);

    if ($stmt2->execute()) {
        header("Location: sanpham.php");
        exit;
    } else {
        echo "Lỗi khi xóa sản phẩm: " . $conn->error;
    }
} else {
    echo "Không tìm thấy ID sản phẩm!";
}
?>
