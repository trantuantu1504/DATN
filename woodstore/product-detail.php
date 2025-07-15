<?php
include('db_connection.php');
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['email']) || !isset($_SESSION['matk'])) {
    header("Location: login.html");
    exit();
}

// Kiểm tra mã sản phẩm truyền vào có hợp lệ không
if (isset($_GET['masp']) && is_numeric($_GET['masp'])) {
    $masp = (int)$_GET['masp'];

    // Lấy thông tin sản phẩm
    $stmt = $conn->prepare("
        SELECT sp.*, spd.DuongDan1, spd.DuongDan2, spd.DuongDan3, spd.DuongDan4, spd.AnhNote 
        FROM SanPham sp
        LEFT JOIN SanPhamData spd ON sp.MaSP = spd.MaSP
        WHERE sp.MaSP = ?
    ");
    $stmt->bind_param("i", $masp);
    $stmt->execute();
    $result = $stmt->get_result();

    // Nếu sản phẩm tồn tại
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $maLoai = $row['MaLoai']; // Lấy luôn MaLoai tại đây
    } else {
        echo "<h2>Sản phẩm không tồn tại!</h2>";
        exit();
    }

    $stmt->close();

    // Truy vấn 4 sản phẩm cùng loại, trừ sản phẩm hiện tại
    $stmt = $conn->prepare("
    SELECT sp.*, spd.DuongDan1 
    FROM SanPham sp
    LEFT JOIN SanPhamData spd ON sp.MaSP = spd.MaSP
    WHERE sp.MaLoai = ? AND sp.MaSP != ?
    ORDER BY RAND() 
    LIMIT 4
");
    $stmt->bind_param("ii", $maLoai, $masp);
    $stmt->execute();
    $result_related = $stmt->get_result();
} else {
    echo "<h2>Không có sản phẩm được chọn!</h2>";
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
        /* Custom CSS for parts not easily done with Tailwind */
        .product-gallery {
            scrollbar-width: none;
            /* Firefox */
        }

        .product-gallery::-webkit-scrollbar {
            display: none;
            /* Safari and Chrome */
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .highlight-box {
            position: relative;
        }

        .highlight-box::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 2px solid #3b82f6;
            border-radius: 0.5rem;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .highlight-box:hover::before {
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



    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6" style="padding-left: 200px;">
                <!-- Product Images -->
                <div>
                    <div class="relative overflow-hidden rounded-lg bg-gray-100 h-96 flex items-center justify-center">
                        <img id="mainImage" src="<?= $row['DuongDan1'] ? 'images2/' . htmlspecialchars($row['DuongDan1']) : 'images/no-image.png' ?>" class="w-full h-full object-contain">
                    </div>
                    <div class="product-gallery flex space-x-3 mt-4 overflow-x-auto py-2">
                        <?php if (!empty($row['DuongDan1'])): ?>
                            <button onclick="changeImage('images2/<?= htmlspecialchars($row['DuongDan1']) ?>')" class="flex-shrink-0 w-20 h-20 border-2 border-blue-500 rounded-lg overflow-hidden">
                                <img src="images2/<?= htmlspecialchars($row['DuongDan1']) ?>" class="w-full h-full object-contain" alt="Product thumbnail 1">
                            </button>
                        <?php endif; ?>

                        <?php if (!empty($row['DuongDan2'])): ?>
                            <button onclick="changeImage('images2/<?= htmlspecialchars($row['DuongDan2']) ?>')" class="flex-shrink-0 w-20 h-20 border border-gray-200 rounded-lg overflow-hidden hover:border-blue-500">
                                <img src="images2/<?= htmlspecialchars($row['DuongDan2']) ?>" class="w-full h-full object-cover" alt="Product thumbnail 2">
                            </button>
                        <?php endif; ?>

                        <?php if (!empty($row['DuongDan3'])): ?>
                            <button onclick="changeImage('images2/<?= htmlspecialchars($row['DuongDan3']) ?>')" class="flex-shrink-0 w-20 h-20 border border-gray-200 rounded-lg overflow-hidden hover:border-blue-500">
                                <img src="images2/<?= htmlspecialchars($row['DuongDan3']) ?>" class="w-full h-full object-cover" alt="Product thumbnail 3">
                            </button>
                        <?php endif; ?>

                        <?php if (!empty($row['DuongDan4'])): ?>
                            <button onclick="changeImage('images2/<?= htmlspecialchars($row['DuongDan4']) ?>')" class="flex-shrink-0 w-20 h-20 border border-gray-200 rounded-lg overflow-hidden hover:border-blue-500">
                                <img src="images2/<?= htmlspecialchars($row['DuongDan4']) ?>" class="w-full h-full object-cover" alt="Product thumbnail 4">
                            </button>
                        <?php endif; ?>
                    </div>
                    <!-- <div class="mt-4 flex justify-center">
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-expand mr-1"></i> View fullscreen
                        </button>
                    </div> -->
                </div>
                <!-- Product Info -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($row['TenSP']) ?></h1>
                    <div class="flex items-center mt-2">
                        <!-- <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div> -->
                        <!-- <span class="text-gray-500 ml-2">(128 reviews)</span>
                        <span class="ml-4 text-green-600 text-sm font-medium flex items-center">
                            <i class="fas fa-check-circle mr-1"></i> In Stock
                        </span> -->
                    </div>

                    <div class="mt-6">
                        <!--giá-->
                        <p class="text-3xl font-bold text-gray-900"><?= number_format($row['Gia'], 0, ',', '.') ?>₫</p>
                        <!-- <p class="text-gray-500 line-through mt-1">$1,599.00</p> -->
                        <!-- <p class="text-green-600 font-medium mt-1">You save $300.00 (19%)</p> -->
                    </div>

                    <div class="mt-6">
                        <p class="text-gray-700 mb-2"><strong>Kích thước:</strong> <?= $row['Dai'] ?> x <?= $row['Rong'] ?> x <?= $row['Cao'] ?> cm</p>
                        <p class="text-gray-700 mb-2"><strong>Chất liệu:</strong> <?= htmlspecialchars($row['ChatLieu']) ?></p>
                        <p class="text-gray-700 mt-4"><strong>Mô tả:</strong> <?= htmlspecialchars($row['MoTa']) ?></p>
                    </div>

                    <div class="mt-6">
                        <!--các sản phẩm khác màu
                        <h3 class="text-sm font-medium text-gray-900">Wood Finish</h3>
                        <div class="mt-2 flex space-x-2">
                            <button class="w-8 h-8 rounded-full bg-amber-900 border-2 border-blue-600 focus:outline-none" title="Dark Walnut"></button>
                            <button class="w-8 h-8 rounded-full bg-amber-700 hover:border-2 hover:border-blue-600 focus:outline-none" title="Cherry"></button>
                            <button class="w-8 h-8 rounded-full bg-amber-500 hover:border-2 hover:border-blue-600 focus:outline-none" title="Natural Oak"></button>
                        </div>-->
                    </div>

                    <form action="add_to_cart.php" method="POST" class="flex space-x-4 mt-8">
                        <!-- Chọn số lượng -->
                        <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                            <button type="button" onclick="decrement()" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="soluong" id="quantity" value="1" min="1" class="w-12 text-center focus:outline-none">
                            <button type="button" onclick="increment()" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <!-- Mã sản phẩm (ẩn) -->
                        <input type="hidden" name="masp" value="<?= $row['MaSP'] ?>">

                        <!-- Nút thêm vào giỏ -->
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center pulse-animation">
                            <i class="fas fa-shopping-cart mr-2"></i> Thêm vào giỏ
                        </button>
                    </form>

                    <div class="mt-6 flex items-center text-sm text-gray-500">
                        <i class="fas fa-truck mr-2"></i>
                        <p>Miễn phí vận chuyển cho đơn hàng trên 30.000đ</p>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <button class="text-gray-600 hover:text-blue-600">
                            <i class="far fa-heart text-2xl"></i>
                        </button>
                        <button class="text-gray-600 hover:text-blue-600">
                            <i class="fas fa-share-alt text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Related Products -->
        <div class="container mx-auto px-4 mt-16">
            <h2 class="text-2xl font-bold text-gray-900">Bạn cũng có thể thích</h2>
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php while ($row_related = $result_related->fetch_assoc()): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        <a href="product-detail.php?masp=<?= $row_related['MaSP'] ?>" class="group block">
                            <div class="relative pt-[100%] bg-gray-100">
                                <img src="<?= !empty($row_related['DuongDan1']) ? 'images2/' . htmlspecialchars($row_related['DuongDan1']) : 'images/no-image.png' ?>" alt="<?= htmlspecialchars($row_related['MaSP']) ?>" class="absolute top-0 left-0 w-full h-full object-contain p-4">
                            </div>
                        </a>
                        <div class="p-4">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="product-detail.php?masp=<?= $row_related['MaSP'] ?>" class="hover:text-amber-700">
                                    <?= htmlspecialchars($row_related['TenSP']) ?>
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 text-ellipsis whitespace-nowrap overflow-hidden">
                                <?= htmlspecialchars($row_related['MoTa']) ?>
                            </p>
                            <div class="mt-2 flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900"><?= number_format($row_related['Gia'], 0, ',', '.') ?>₫</p>
                            </div>
                            <button class="mt-4 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-200">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
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

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-amber-700 text-white w-12 h-12 rounded-full shadow-lg hidden">
        <i class="fas fa-arrow-up text-xl"></i>
    </button>

    <script src="../js/main.js"></script>
    <script>
        // Change product image when thumbnail is clicked
        function changeImage(src) {
            document.getElementById('mainImage').src = src;

            // Update active thumbnail styling
            const thumbButtons = document.querySelectorAll('.product-gallery button');
            thumbButtons.forEach(button => {
                button.classList.remove('border-blue-500', 'border-2');
                button.classList.add('border-gray-200', 'border');
            });

            event.currentTarget.classList.add('border-blue-500', 'border-2');
            event.currentTarget.classList.remove('border-gray-200', 'border');
        }

        // Product quantity controls
        function increment() {
            const quantityInput = document.getElementById('quantity');
            quantityInput.value = parseInt(quantityInput.value) + 1;
        }

        function decrement() {
            const quantityInput = document.getElementById('quantity');
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        }

        // Tab switching functionality
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(tab => {
                tab.classList.add('hidden');
            });

            // Remove active styling from all tabs
            const tabs = document.querySelectorAll('[id$="-tab"]');
            tabs.forEach(tab => {
                tab.classList.remove('border-blue-600', 'text-blue-600');
                tab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });

            // Show selected tab content
            document.getElementById(tabName).classList.remove('hidden');

            // Add active styling to selected tab
            document.getElementById(`${tabName}-tab`).classList.add('border-blue-600', 'text-blue-600');
            document.getElementById(`${tabName}-tab`).classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        }

        // FAQ toggle functionality
        function toggleFAQ(id) {
            const content = document.getElementById(`faq-content-${id}`);
            const icon = document.getElementById(`faq-icon-${id}`);

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
            }
        }
    </script>
</body>

</html>