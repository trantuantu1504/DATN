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

// Kiểm tra giỏ hàng
$hasItems = isset($_SESSION['cart']) && !empty($_SESSION['cart']);

$tongSanPham = 0;

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $tongSanPham += $item['soluong'];
    }
}

$stmt = $conn->prepare("
    SELECT sp.*, spd.DuongDan1, spd.DuongDan2, spd.DuongDan3, spd.DuongDan4, spd.AnhNote 
    FROM SanPham sp
    LEFT JOIN SanPhamData spd ON sp.MaSP = spd.MaSP
    WHERE sp.MaSP = ?
");
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
        /* Custom scrollbar */
        .cart-items::-webkit-scrollbar {
            width: 6px;
        }

        .cart-items::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .cart-items::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        .cart-items::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Animation for empty cart */
        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .empty-cart-icon {
            animation: bounce 1.5s infinite;
        }

        /* Pulse animation for loading */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>

<body>
    <!-- Header/Navigation -->
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

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items Section -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h1 class="text-2xl font-bold text-gray-800">Giỏ Hàng Của Bạn</h1>
                        <p class="text-gray-500 mt-1"><?= $tongSanPham ?> sản phẩm trong giỏ hàng của bạn</p>
                    </div>

                    <!-- Cart Items -->
                    <?php
                    $tongGia = 0; // ✅ Khởi tạo để tránh undefined variable
                    $tongCong = 0;
                    $cart = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];

                    if (!empty($cart)) {
                        foreach ($cart as $item):

                            $masp = $item['masp'];
                            $soluong = $item['soluong'];

                            // Truy vấn thông tin sản phẩm
                            $stmt = $conn->prepare("
                                SELECT sp.TenSP, sp.Gia, spd.DuongDan1 
                                FROM SanPham sp
                                LEFT JOIN SanPhamData spd ON sp.MaSP = spd.MaSP
                                WHERE sp.MaSP = ?
                            ");
                            $stmt->bind_param("i", $masp);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $stmt->close();

                            if (!$row) continue;

                            $gia = $row['Gia'];
                            $thanhTien = $gia * $soluong;
                            $tongGia += $thanhTien;
                            $phiVanChuyen = 30000; // phí vận chuyển cố định
                            $tongCong = $tongGia + $phiVanChuyen;
                    ?>
                            <div class="p-6 border-b border-gray-200 hover:bg-gray-50 transition">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <div class="w-full sm:w-24 h-24 bg-gray-100 rounded-md overflow-hidden">
                                        <img src="<?= $row['DuongDan1'] ? 'images2/' . htmlspecialchars($row['DuongDan1']) : 'images/no-image.png' ?>" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="font-medium text-gray-800"><?= htmlspecialchars($row['TenSP']) ?></h3>
                                            </div>
                                            <form action="remove_from_cart.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="masp" value="<?= $item['masp'] ?>">
                                                <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                            <p class="text-gray-500 text-sm mt-1">Số lượng: <?= $item['soluong'] ?></p>
                                            <div class="font-bold text-gray-800"><?= number_format($row['Gia'], 0, ',', '.') ?>₫</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php } else { ?>
                        <!-- Giỏ hàng trống -->
                        <div id="empty-cart" class="p-8 text-center">
                            <div class="empty-cart-icon text-gray-300 mb-4">
                                <i class="fas fa-shopping-cart text-6xl"></i>
                            </div>
                            <h3 class="text-xl font-medium text-gray-700 mb-2">Giỏ hàng của bạn trống</h3>
                            <p class="text-gray-500 mb-6">Có vẻ như bạn chưa thêm sản phẩm nào vào giỏ hàng</p>
                            <a href="index.php" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Tiếp tục mua sắm</a>
                        </div>

                    <?php } ?>

                </div>

                <!-- Thông tin giao hàng -->
                <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-shopping-cart mr-2"></i> Thông Tin Giao Hàng
                    </h3>
                    <!--Thông tin khách hàng-->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                            <div class="px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-800"><?= htmlspecialchars($user['HoTen']) ?></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                            <div class="px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-800"><?= htmlspecialchars($user['DiaChi']) ?></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                            <div class="px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-800"><?= htmlspecialchars($user['DienThoai']) ?></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <div class="px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-800"><?= htmlspecialchars($user['Email']) ?></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Thanh toán -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Tóm Tắt Đơn Hàng</h2>

                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tạm tính</span>
                            <span class="font-medium"><?= number_format($tongGia, 0, ',', '.') ?>₫</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phí vận chuyển</span>
                            <span class="font-medium">30.000 đ</span>
                        </div>
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Tổng cộng</span>
                                <span><?= number_format($tongCong, 0, ',', '.') ?>₫</span>
                            </div>
                        </div>
                    </div>
                    <?php
                    $cart = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];
                    $hasItems = !empty($cart);
                    ?>
                    <form action="dathang_xuly.php" method="POST" onsubmit="return checkCartBeforeSubmit();">
                        <button type="submit"
                            class="w-full mt-6 px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition font-medium <?= !$hasItems ? 'opacity-50 cursor-not-allowed' : '' ?>"
                            <?= !$hasItems ? 'disabled' : '' ?>>
                            Xác nhận đặt hàng
                        </button>

                        <div class="mt-4 text-center text-sm text-gray-500">
                            <p>hoặc <a href="index.php" class="text-indigo-600 hover:underline">Tiếp tục mua hàng</a></p>
                        </div>

                        <!--Phương thức thanh toán-->
                        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-credit-card mr-2"></i> Phương Thức Thanh Toán
                            </h3>

                            <div class="space-y-3">
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" name="payment_method" value="COD" checked class="form-radio text-green-500">
                                    <i class="fas fa-money-bill-wave text-green-600"></i>
                                    <span class="text-gray-700">Thanh toán khi nhận hàng (COD)</span>
                                </label>

                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" name="payment_method" value="bank" class="form-radio text-blue-500">
                                    <i class="fas fa-university text-blue-600"></i>
                                    <span class="text-gray-700">Chuyển khoản ngân hàng</span>
                                </label>

                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" name="payment_method" value="e-wallet" class="form-radio text-purple-500">
                                    <i class="fas fa-mobile-alt text-purple-600"></i>
                                    <span class="text-gray-700">Ví điện tử (Momo, ZaloPay)</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

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

    <script>
        // Cart functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity buttons
            const quantityButtons = document.querySelectorAll('[class*="flex items-center border"] button');
            quantityButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const parentDiv = this.parentElement;
                    const quantitySpan = parentDiv.querySelector('span');
                    let quantity = parseInt(quantitySpan.textContent);

                    if (this.textContent === '+' && quantity < 10) {
                        quantity++;
                    } else if (this.textContent === '-' && quantity > 1) {
                        quantity--;
                    }

                    quantitySpan.textContent = quantity;
                    updateCartTotal();
                });
            });

            // Remove item buttons
            const removeButtons = document.querySelectorAll('[class*="fa-times"]');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const cartItem = this.closest('[class*="p-6 border-b"]') || this.closest('[class*="p-6 hover:bg-gray-50"]');
                    cartItem.classList.add('opacity-0', 'transition-opacity', 'duration-300');

                    setTimeout(() => {
                        cartItem.remove();
                        updateCartCount();
                        updateCartTotal();

                        // Show empty cart if no items left
                        if (document.querySelectorAll('[class*="p-6 border-b"], [class*="p-6 hover:bg-gray-50"]').length === 0) {
                            document.querySelector('.cart-items').classList.add('hidden');
                            document.getElementById('empty-cart').classList.remove('hidden');
                        }
                    }, 300);
                });
            });

            // Update cart count
            function updateCartCount() {
                const cartCount = document.querySelectorAll('[class*="p-6 border-b"], [class*="p-6 hover:bg-gray-50"]').length;
                document.getElementById('cart-count').textContent = cartCount;
            }

            // Update cart total (simplified for demo)
            function updateCartTotal() {
                // In a real app, you would calculate based on actual prices and quantities
                console.log('Cart total updated');
            }

            // Coupon code application
            const couponButton = document.querySelector('[class*="px-4 py-2 bg-indigo-600"]');
            couponButton.addEventListener('click', function() {
                const couponInput = this.previousElementSibling;
                if (couponInput.value.trim() === '') {
                    alert('Please enter a coupon code');
                } else {
                    alert('Coupon code applied!');
                    couponInput.value = '';
                }
            });

            // Checkout button
            const checkoutButton = document.querySelector('[class*="w-full mt-6 px-6 py-3"]');
            checkoutButton.addEventListener('click', function() {
                alert('Proceeding to checkout!');
            });
        });
    </script>

</body>