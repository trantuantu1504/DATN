<?php
include('db_connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM TK WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['MatKhau'])) {
                // Lưu thông tin đăng nhập
                $_SESSION['MaTK'] = $user['MaTK'];
                $_SESSION['Email'] = $user['Email'];
                $_SESSION['Quyen'] = $user['Quyen'];
                
                header("Location: user.php");
                exit();
            } else {
                header("Location: SignIn.php?error=wrongpass");
                exit();
            }
        } else {
            header("Location: SignIn.php?error=wrongemail");
            exit();
        }
    } else {
        echo "Lỗi truy vấn.";
    }
}

// ✅ Đặt phần hiển thị lỗi ra ngoài POST để khi GET vẫn hoạt động
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'wrongemail') {
        echo "<p style='color:red;'>Email không tồn tại!</p>";
    } elseif ($_GET['error'] === 'wrongpass') {
        echo "<p style='color:red;'>Sai mật khẩu!</p>";
    }
}
?>
