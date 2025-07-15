<?php
session_start();
include('db_connection.php'); // Kết nối CSDL

// Chỉ xử lý nếu là POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ================= XỬ LÝ ĐĂNG KÝ =================
    if (isset($_POST['signup'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $password = $_POST['password'];

        // Kiểm tra email đã tồn tại chưa
        $checkEmail = $conn->prepare("SELECT * FROM TK WHERE Email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $result = $checkEmail->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email đã tồn tại. Vui lòng sử dụng email khác!'); window.history.back();</script>";
            exit();
        }

        // Tạo tài khoản trong bảng TK
        $sqlTK = $conn->prepare("INSERT INTO TK (MatKhau, Email, Quyen, AvataUser, TrangThai) VALUES (?, ?, 'User', '', 1)");
        $sqlTK->bind_param("ss", $password, $email);

        if ($sqlTK->execute()) {
            $maTK = $conn->insert_id;

            // Tạo khách hàng tương ứng
            $sqlKH = $conn->prepare("INSERT INTO KhachHang (MaTK, HoTen, DienThoai, DiaChi, Email, MatKhau, TrangThai) 
                         VALUES (?, ?, ?, ?, ?, ?, ?)");
            $sqlKH->bind_param("isssssi", $maTK, $name, $phone, $address, $email, $password, $trangthai);

            $trangthai = 1;
            $sqlKH->execute();

            echo "<script>alert('Đăng ký thành công!'); window.location.href='user.php';</script>";
            exit();
        } else {
            echo "<script>alert('Đăng ký thất bại!'); window.history.back();</script>";
            exit();
        }

        // ================= XỬ LÝ ĐĂNG NHẬP =================
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = $conn->prepare("SELECT * FROM TK WHERE Email = ? AND MatKhau = ?");
        $sql->bind_param("ss", $email, $password);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $_SESSION['email'] = $user['Email'];
            $_SESSION['quyen'] = $user['Quyen'];
            $_SESSION['matk'] = $user['MaTK'];

            echo "<script>alert('Đăng nhập thành công!'); window.location.href='user.php';</script>";
            exit();
        } else {
            echo "<script>alert('Sai email hoặc mật khẩu!'); window.history.back();</script>";
            exit();
        }
    }

    // Đóng kết nối
    $checkEmail->close();
    $sqlTK->close();
    if (isset($sqlKH)) $sqlKH->close();
    if (isset($sql)) $sql->close();
    $conn->close();
} else {
    // Nếu không phải POST, không cho truy cập
    http_response_code(405);
    echo "<h2>405 Method Not Allowed</h2><p>Trang này chỉ hỗ trợ phương thức POST.</p>";
    exit();
}
?>