<?php
session_start();
include('db_connection.php'); // Kết nối CSDL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form, có mặc định nếu không có
    $masp = isset($_POST['masp']) ? (int)$_POST['masp'] : 0;
    $soluong = isset($_POST['soluong']) ? (int)$_POST['soluong'] : 1;

    if ($masp <= 0 || $soluong <= 0) {
        echo "Dữ liệu không hợp lệ.";
        exit();
    }

    // Truy vấn sản phẩm
    $stmt = $conn->prepare("
        SELECT sp.TenSP, sp.Gia, spd.DuongDan1
        FROM SanPham sp
        LEFT JOIN SanPhamData spd ON sp.MaSP = spd.MaSP
        WHERE sp.MaSP = ?
    ");
    $stmt->bind_param("i", $masp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $sp = $result->fetch_assoc();
        $ten = $sp['TenSP'];
        $gia = (float)$sp['Gia'];
        $anh = $sp['DuongDan1'] ?? 'images/no-image.png';

        // Tạo session giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Nếu sản phẩm đã tồn tại thì tăng số lượng
        if (isset($_SESSION['cart'][$masp])) {
            $_SESSION['cart'][$masp]['soluong'] += $soluong;
            $_SESSION['cart'][$masp]['thanhtien'] = $_SESSION['cart'][$masp]['soluong'] * $gia;
        } else {
            $_SESSION['cart'][$masp] = [
                'masp' => $masp,
                'tensp' => $ten,
                'gia' => $gia,
                'duongdan' => $anh,
                'soluong' => $soluong,
                'thanhtien' => $gia * $soluong
            ];
        }

        $stmt->close();
        header("Location: cart.php");
        exit();
    } else {
        echo "Không tìm thấy sản phẩm!";
    }
}
?>
