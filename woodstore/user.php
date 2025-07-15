<?php
session_start();

if (!isset($_SESSION['email'])) {
    // Chưa đăng nhập thì chuyển về trang chính hoặc trang đăng nhập
    header("Location: index.php");
    exit();
}

include('db_connection.php');

// Lấy thông tin người dùng từ CSDL
$matk = $_SESSION['matk'];
$sql = $conn->prepare("SELECT * FROM KhachHang WHERE MaTK = ?");
$sql->bind_param("i", $matk);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();
$sql->close();
//$conn->close();

$sql = $conn->prepare("SELECT AvataUser FROM TK WHERE MaTK = ?");
$sql->bind_param("i", $matk);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();

// Nếu có ảnh, dùng ảnh đó, nếu không thì dùng ảnh mặc định
$avatarPath = (!empty($row['AvataUser'])) ? $row['AvataUser'] : "http://localhost/DATN/woodstore/uploads/no-image.jpg";
//$avatarFullPath = "http://localhost/DATN/" . $avatarPath;
//$avatarPath = (!empty($row['AvataUser'])) ? "http://localhost/DATN/uploads/" . $row['AvataUser'] : "http://localhost/DATN/woodstore/uploads/no-image.jpg";
?>



<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>TimberCraft | Premium Wood Products</title>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .account-container {
            font-family: Arial, sans-serif;
            background-color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
            padding-bottom: 20px;
        }

        .account-container h1 {
            margin-top: 30px;
            font-size: 36px;
            color: rgb(209, 112, 56);
            border-bottom: 2px solid #d5c6b8;
            display: inline-block;
            padding-bottom: 5px;
        }

        .account-container .container {
            margin: 40px auto;
            padding: 30px;
            max-width: 900px;
            width: 90%;
            background:
                linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('../images3/f.jpg') no-repeat center center;
            background-size: cover;
            background-position: center;
            border-radius: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #3a2c20;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .account-container .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 10px;
        }

        .account-container .avatar img {
            width: 100%;
            height: auto;
        }

        .account-container .info {
            text-align: left;
            line-height: 2;
            font-size: 18px;
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
        }

        .account-container .info-row {
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
        }

        .account-container .info-gender {
            margin-top: 20px;
        }

        .account-container .buttons {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .account-container .buttons button {
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            background-color: #3a2c20;
            color: white;
            cursor: pointer;
            transition: 0.3s ease;
            min-width: 150px;
        }

        .account-container .buttons button:first-child {
            background-color: #3a2c20;
        }

        .account-container .info-item {
            display: flex;
            margin-bottom: 10px;
            padding-top: 15px;
            /*padding-left: 20px;*/
        }

        .account-container .info-item span {
            /*padding: 8px 0*/
            width: 100%;
            max-width: 300px;
            display: inline-block;
        }

        .account-container .info-item label {
            width: 170px;
            font-weight: bold;
        }

        .account-container .buttons button:hover {
            background-color: #b9a89e;
        }

        .account-container .account-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .avatar-container {
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
        }

        .avatar-label {
            display: block;
            cursor: pointer;
            position: relative;
            width: 100%;
            height: 100%;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            transition: 0.3s;
        }

        .avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .overlay-icon {
            width: 40px;
            height: 40px;
            opacity: 0.8;
        }

        .avatar-label:hover .avatar-overlay {
            opacity: 1;
        }
    </style>
</head>

<body>
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
    </header>

    <section class="account-container">
        <h1>Thông Tin Tài Khoản</h1>
        <div class="container">
            <div class="relative w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-md group">
                <form action="upload_avatar.php" method="POST" enctype="multipart/form-data">
                    <label for="avatarInput" class="cursor-pointer block w-full h-full">
                        <img src="<?= htmlspecialchars($avatarPath) . '?v=' . time() ?>"
                            alt="Avatar"
                            class="w-full h-full object-cover rounded-md" />
                        <!-- Overlay & icon -->
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <i class="fas fa-camera text-white text-7xl"></i>
                        </div>
                    </label>
                    <input type="file" id="avatarInput" name="avatar" class="hidden" onchange="this.form.submit()">
                </form>
            </div>
            <div class="info flex flex-col md:flex-row gap-8">
                <!-- Cột trái -->
                <div class="info-column flex-1">
                    <div class="info-item mb-4 text-white">
                        <label>Họ tên:</label>
                        <span><?= htmlspecialchars($user['HoTen']) ?></span>
                    </div>
                    <div class="info-item mb-4 text-white">
                        <label>Email:</label>
                        <span><?= htmlspecialchars($user['Email']) ?></span>
                    </div>
                </div>
                <!-- Cột phải -->
                <div class="info-column flex-1">
                    <div class="info-item mb-4 text-white">
                        <label>Địa chỉ:</label>
                        <span><?= htmlspecialchars($user['DiaChi']) ?></span>
                    </div>
                    <div class="info-item mb-4 text-white">
                        <label>SĐT:</label>
                        <span><?= htmlspecialchars($user['DienThoai']) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="buttons flex gap-4">
            <!-- Đơn hàng -->
            <form action="donhang.php" method="GET">
                <button type="submit">
                    <i class="fas fa-box-open mr-2"></i>Đơn hàng
                </button>
            </form>

            <!-- Đổi mật khẩu -->
            <form action="doimatkhau.php" method="GET">
                <button type="submit">
                    <i class="fas fa-key mr-2"></i>Đổi mật khẩu
                </button>
            </form>

            <!-- Đăng xuất -->
            <form action="logout.php" method="POST" onsubmit="return confirm('Bạn có chắc muốn đăng xuất?');">
                <button type="submit">
                    <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                </button>
            </form>
        </div>


        <?php if (isset($_SESSION['quyen']) && $_SESSION['quyen'] === 'Admin'): ?>
            <div class="buttons">
                <form action="tk.php" method="GET">
                    <button type="submit">
                        <i class="fas fa-user-cog mr-2"></i>Quản lý tài khoản
                    </button>
                </form>
                <form action="sanpham.php" method="GET">
                    <button type="submit">
                        <i class="fas fa-boxes mr-2"></i>Quản lý sản phẩm
                    </button>
                </form>
                <form action="admin_doanhthu.php" method="GET">
                    <button type="submit">
                        <i class="fas fa-chart-line mr-2"></i>Quản lý doanh thu
                    </button>
                </form>
                <form action="admin_donhang.php" method="GET">
                    <button type="submit">
                        <i class="fas fa-clipboard-list mr-2"></i>Quản lý đơn hàng
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer class="bg-amber-900 text-white py-12">
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

                <div class="grid grid-cols-2 md:grid-cols-2 gap-10">
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

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-amber-700 text-white w-12 h-12 rounded-full shadow-lg hidden">
        <i class="fas fa-arrow-up text-xl"></i>
    </button>

    <script src="../js/main.js"></script>
</body>

</html>