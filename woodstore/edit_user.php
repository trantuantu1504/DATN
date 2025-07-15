<?php
include 'db_connection.php';

if (!isset($_GET['id'])) {
    echo "Thiếu ID.";
    exit;
}

$id = intval($_GET['id']);

// Lấy dữ liệu từ 2 bảng TK và KhachHang
$sql = "
    SELECT TK.Email, TK.Quyen, TK.TrangThai,
           KH.HoTen, KH.MatKhau, KH.DienThoai, KH.DiaChi
    FROM TK
    JOIN KhachHang KH ON TK.MaTK = KH.MaTK
    WHERE TK.MaTK = $id
";
$result = $conn->query($sql);
if ($result->num_rows === 0) {
    echo "Không tìm thấy tài khoản.";
    exit;
}
$row = $result->fetch_assoc();

// Xử lý cập nhật
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $quyen = $_POST['quyen'];
    $trangthai = isset($_POST['trangthai']) ? 1 : 0;
    $hoten = $_POST['hoten'];
    $matkhau = $_POST['matkhau'];
    $sdt = $_POST['dienthoai'];
    $diachi = $_POST['diachi'];

    // Cập nhật TK
    $stmt1 = $conn->prepare("UPDATE TK SET Email=?, Quyen=?, TrangThai=? WHERE MaTK=?");
    $stmt1->bind_param("ssii", $email, $quyen, $trangthai, $id);

    // Cập nhật KhachHang
    $stmt2 = $conn->prepare("UPDATE KhachHang SET HoTen=?, MatKhau=?, DienThoai=?, DiaChi=? WHERE MaTK=?");
    $stmt2->bind_param("ssssi", $hoten, $matkhau, $sdt, $diachi, $id);

    if ($stmt1->execute() && $stmt2->execute()) {
        header("Location: tk.php");
        exit;
    } else {
        echo "Lỗi cập nhật: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa tài khoản</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <img src="../images/logo.png" alt="TimberCraft Logo" class="h-20 w-auto mr-2">
                <h1 class="text-2xl font-bold text-amber-900">Timber<span class="text-amber-600">Craft</span></h1>
            </div>

            <nav class="hidden md:flex space-x-8">
                <a href="../woodstore/index.php" class="nav-link text-black hover:text-amber-700">Trang chủ</a>
                <a href="../woodstore/products.php" class="nav-link text-black hover:text-amber-700">Sản Phẩm</a>
                <a href="../woodstore/about.php" class="nav-link text-black hover:text-amber-700">Giới thiệu</a>
                <a href="../woodstore/checkout.php" class="nav-link text-black hover:text-amber-700">Đánh giá</a>
                <a href="../woodstore/contact.php" class="nav-link text-black hover:text-amber-700">Liên hệ</a>
            </nav>

            <div class="flex items-center space-x-4">
                <!-- Search Box -->
                <form action="search.php" method="GET" class="relative hidden md:block">
                    <input type="text" name="keyword" placeholder="Tìm kiếm..."
                        class="search-box bg-green-50 border border-green-200 rounded-full px-4 py-2 pr-10 w-full focus:outline-none focus:ring-2 focus:ring-green-500">

                    <button type="submit" class="absolute right-3 top-2 text-green-600">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <!-- Cart Icon -->
                <a href="cart.php" class="text-black hover:text-amber-700">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </a>

                <!-- User Icon -->
                <a href="check_login_redirect.php" class="text-black hover:text-amber-700">
                    <i class="fas fa-user-circle text-xl"></i>
                </a>

                <button id="mobile-menu-button" class="md:hidden text-amber-900">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white py-4 px-4 shadow-lg">
            <div class="flex flex-col space-y-3">
                <a href="../woodstore/index.php" class="text-amber-900 hover:text-amber-700">Trang chủ</a>
                <a href="../woodstore/products.php" class="text-amber-900 hover:text-amber-700">Sản Phẩm</a>
                <a href="../woodstore/about.php" class="text-amber-900 hover:text-amber-700">Giới thiệu</a>
                <a href="../woodstore/checkout.php" class="text-amber-900 hover:text-amber-700">Đánh giá</a>
                <a href="../woodstore/contact.php" class="text-amber-900 hover:text-amber-700">Liên Hệ</a>
            </div>

            <!-- Mobile Search Box -->
            <div class="mt-4 relative">
                <input type="text" placeholder="Tìm kiếm..." class="w-full bg-amber-50 border border-amber-200 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                <button class="absolute right-3 top-2 text-amber-600">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <!-- Mobile User Links -->
            <div class="mt-4 flex justify-between">
                <a href="cart.php" class="text-amber-900 hover:text-amber-700 flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i> Cart
                </a>
                <a href="check_login_redirect.php" class="text-amber-900 hover:text-amber-700 flex items-center">
                    <i class="fas fa-user-circle mr-2"></i> Account
                </a>
            </div>
        </div>
    </header><br>

    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold text-center text-amber-800 mb-6">Sửa thông tin tài khoản</h1>
        <form method="POST">
            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700">Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($row['Email']) ?>" required class="w-full p-2 border rounded">
            </div>

            <!-- Họ tên -->
            <div class="mb-4">
                <label class="block text-gray-700">Họ tên:</label>
                <input type="text" name="hoten" value="<?= htmlspecialchars($row['HoTen']) ?>" required class="w-full p-2 border rounded">
            </div>

            <!-- Mật khẩu -->
            <div class="mb-4">
                <label class="block text-gray-700">Mật khẩu:</label>
                <input type="text" name="matkhau" value="<?= htmlspecialchars($row['MatKhau']) ?>" required class="w-full p-2 border rounded">
            </div>

            <!-- SĐT -->
            <div class="mb-4">
                <label class="block text-gray-700">Số điện thoại:</label>
                <input type="text" name="dienthoai" value="<?= htmlspecialchars($row['DienThoai']) ?>" required class="w-full p-2 border rounded">
            </div>

            <!-- Địa chỉ -->
            <div class="mb-4">
                <label class="block text-gray-700">Địa chỉ:</label>
                <input type="text" name="diachi" value="<?= htmlspecialchars($row['DiaChi']) ?>" required class="w-full p-2 border rounded">
            </div>

            <!-- Quyền -->
            <div class="mb-4">
                <label class="block text-gray-700">Quyền:</label>
                <select name="quyen" class="w-full p-2 border rounded">
                    <option value="admin" <?= $row['Quyen'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= $row['Quyen'] == 'user' ? 'selected' : '' ?>>User</option>
                </select>
            </div>

            <!-- Trạng thái -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="trangthai" <?= $row['TrangThai'] ? 'checked' : '' ?> class="form-checkbox">
                    <span class="ml-2 text-gray-700">Hoạt động</span>
                </label>
            </div>

            <!-- Nút cập nhật -->
            <div class="flex justify-between">
                <a href="tk.php" class="text-gray-600 hover:underline">← Quay lại</a>
                <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700 transition">
                    Cập nhật tài khoản
                </button>
            </div>
        </form>
    </div><br>

    <footer class="bg-amber-900 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center mb-4">
                        <img src="../images/logo.png" alt="TimberCraft Logo" class="h-20 w-auto mr-2">
                        <h3 class="text-2xl font-bold">Timber<span class="text-amber-400">Craft</span></h3>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-2"></h3>
                        <p class="mb-2"><i class="fas fa-map-marker-alt mr-2"></i> 123 Timber Lane, Forestville, CA 95436</p>
                        <p class="mb-2"><i class="fas fa-phone mr-2"></i> (555) 123-4567</p>
                        <p><i class="fas fa-envelope mr-2"></i> info@timbercraft.com</p>
                    </div>
                    <p class="mb-4">
                        Mọi vấn đề liên quan đến bản quyền, vui lòng liên hệ chúng tôi sẽ cập nhật và xử lý!
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white hover:text-amber-300 text-xl">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-white hover:text-amber-300 text-xl">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-white hover:text-amber-300 text-xl">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" class="text-white hover:text-amber-300 text-xl">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="text-white hover:text-amber-300 text-xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-white hover:text-amber-300 text-xl">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Về chúng tôi</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-amber-300">Giới thiệu về TimberCraft</a></li>
                            <li><a href="#" class="hover:text-amber-300">Nhượng quyền</a></li>
                            <li><a href="#" class="hover:text-amber-300">Tin tức khuyến mại</a></li>
                            <li><a href="#" class="hover:text-amber-300">Quy định chung</a></li>
                            <li><a href="#" class="hover:text-amber-300">TT liên hệ & ĐKKD</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold mb-4">Chính sách</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-amber-300">Chính sách thành viên</a></li>
                            <li><a href="#" class="hover:text-amber-300">Hình thức thanh toán</a></li>
                            <li><a href="#" class="hover:text-amber-300">Vận chuyển giao nhận</a></li>
                            <li><a href="#" class="hover:text-amber-300">Đổi trả và hoàn tiền</a></li>
                            <li><a href="#" class="hover:text-amber-300">Bảo vệ thông tin cá nhân</a></li>
                            <li><a href="#" class="hover:text-amber-300">Bảo trì & bảo hành</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="border-t border-amber-800 mt-8 pt-8 text-sm text-center md:text-left">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p>&copy; 2023 TimberCraft. All rights reserved.</p>
                    <div class="mt-4 md:mt-0">
                        <a href="#" class="hover:text-amber-300 mr-4">Giới thiệu</a>
                        <a href="#" class="hover:text-amber-300 mr-4">Liên hệ</a>
                        <a href="#" class="hover:text-amber-300">Bản quyền</a>
                        <a href="#" class="hover:text-amber-300 mr-4">Hợp tác</a>
                        <a href="#" class="hover:text-amber-300 mr-4">Đánh giá và xếp hạng</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>