<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Nhận dữ liệu từ form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Tạo tài khoản mới trong bảng TK
    $sqlTK = "INSERT INTO TK (MatKhau, Email, Quyen, TrangThai) VALUES (?, ?, 'user', 1)";
    $stmtTK = $conn->prepare($sqlTK);
    $stmtTK->bind_param("ss", $password, $email);

    if ($stmtTK->execute()) {
        $maTK = $conn->insert_id; // Lấy MaTK vừa thêm

        // Chèn vào bảng KhachHang
        $sqlKH = "INSERT INTO KhachHang (MaTK, HoTen, DienThoai, GioiTinh, DiaChi, Email, MatKhau)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtKH = $conn->prepare($sqlKH);
        $stmtKH->bind_param("issssss", $maTK, $name, $phone, $gender, $address, $email, $password);

        if ($stmtKH->execute()) {
            // Đăng ký thành công -> chuyển tới trang người dùng
            header("Location: user.php");
            exit();
        } else {
            echo "❌ Lỗi khi thêm vào KhachHang: " . $stmtKH->error;
        }

        $stmtKH->close();
    } else {
        echo "❌ Lỗi khi thêm vào TK: " . $stmtTK->error;
    }

    $stmtTK->close();
    $conn->close();
}
?>
