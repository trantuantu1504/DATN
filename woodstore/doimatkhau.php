<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['matk'])) {
    header("Location: login.html");
    exit();
}
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
            color: #b9a89e;
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
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .account-container .avatar:hover {
            background-color: #f5f7fa;
        }

        .account-container .avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(58, 44, 32, 0.7);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 50%;
        }

        .account-container .avatar:hover .avatar-overlay {
            opacity: 1;
        }

        .account-container .avatar-overlay i {
            font-size: 24px;
            margin-bottom: 5px;
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
            justify-content: flex-start;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
            padding-top: 15px;
            padding-left: 20px;
        }

        .account-container .info-item span,
        .account-container .info-item input {
            padding: 8px 0;
            width: 100%;
            max-width: 300px;
            display: inline-block;
        }

        .account-container .info-item input {
            background-color: white;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #d5c6b8;
        }

        .account-container .info-item input:focus {
            outline: none;
            border-color: #3a2c20;
            box-shadow: 0 0 0 2px rgba(58, 44, 32, 0.2);
        }

        .account-container .info-item label {
            width: 140px;
            font-weight: bold;
            flex-shrink: 0;
        }

        .account-container .buttons button:hover {
            background-color: #b9a89e;
        }

        .account-container .account-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
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
        <h1>Đổi Mật Khẩu</h1>
        <div class="container">
            <form id="password-change-form">
                <div class="info-item">
                    <label for="old-password" class="text-white">Mật khẩu cũ:</label>
                    <input type="password" id="old-password" name="old-password" required class="w-full max-w-[300px] p-2 border border-amber-200 rounded">
                </div>
                <div class="info-item">
                    <label for="new-password" class="text-white">Mật khẩu mới:</label>
                    <input type="password" id="new-password" name="new-password" required class="w-full max-w-[300px] p-2 border border-amber-200 rounded">
                </div>
                <div class="info-item">
                    <label for="confirm-password" class="text-white">Xác nhận mật khẩu:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required class="w-full max-w-[300px] p-2 border border-amber-200 rounded">
                </div>
                <div class="buttons">
                    <button type="submit" class="bg-amber-700 hover:bg-amber-800">
                        <i class="fas fa-save mr-2"></i>Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
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
    <script>
        document.getElementById('password-change-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('doimatkhau_xuly.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    alert(data);
                    if (data.includes("thành công")) {
                        document.getElementById('password-change-form').reset();
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Đã xảy ra lỗi khi đổi mật khẩu.");
                });
        });
    </script>

</body>

</html>