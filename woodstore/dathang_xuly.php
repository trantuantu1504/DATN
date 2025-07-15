<?php

session_start();
if (!isset($_SESSION['matk'])) {
    header("Location: login.html");
    exit();
}

$paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'Chưa chọn';
$matk = $_SESSION['matk'];

include('db_connection.php');
$stmt = $conn->prepare("SELECT * FROM KhachHang WHERE MaTK = ?");
$stmt->bind_param("i", $matk);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$khachHangTen = $user['HoTen'];
$ngay = date('Y-m-d');
$maCN = 'CN001'; // nếu có chi nhánh, hoặc để tạm

$stmt = $conn->prepare("INSERT INTO DonHang (MaTK, KH, Ngay, MaCN) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $matk, $khachHangTen, $ngay, $maCN);
$stmt->execute();

$maDonHang = $conn->insert_id; // ✅ lấy mã đơn hàng vừa tạo

$tongTien = 0;
$phiVanChuyen = 30000; // Phí vận chuyển cố định

foreach ($_SESSION['cart'] as $item) {
    $masp = $item['masp'];
    $soluong = $item['soluong'];

    // Lấy thông tin sản phẩm
    $stmt = $conn->prepare("SELECT TenSP, Gia FROM SanPham WHERE MaSP = ?");
    $stmt->bind_param("i", $masp);
    $stmt->execute();
    $sp = $stmt->get_result()->fetch_assoc();

    $gia = $sp['Gia'];
    $thanhtien = $gia * $soluong;
    $tongTien += $thanhtien; // ✅ Cộng dồn thành tiền của từng sản phẩm

    // Lưu vào ChiTietDonHang
    $stmt = $conn->prepare("INSERT INTO ChiTietDonHang (KH, MaDH, MaSP, SoLuong, TenSP, DuongDan, Gia, ThanhTien, Ngay, DiaChiGiao, GiaoDich)
VALUES (?, ?, ?, ?, ?, '', ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiisddsss", $khachHangTen, $maDonHang, $masp, $soluong, $sp['TenSP'], $gia, $thanhtien, $ngay, $user['DiaChi'], $paymentMethod);
    $stmt->execute();
}

$tongTien += $phiVanChuyen; // ✅ Cộng thêm phí vận chuyển sau khi tính xong tất cả sản phẩm

// Nếu bạn có cột TongTien trong DonHang, thì cập nhật:
$stmt = $conn->prepare("UPDATE DonHang SET TongTien = ? WHERE MaDH = ?");
$stmt->bind_param("di", $tongTien, $maDonHang);
$stmt->execute();


unset($_SESSION['cart']);

header("Location: camon.php");
exit();
