<?php
// session_start();
// if (!isset($_SESSION['email']) || !isset($_SESSION['matk'])) {
//     header("Location: login.html");
//     exit();
// }

include('db_connection.php');

$maLoai = 1;
$soLuongHienThi = 8;

$stmt = $conn->prepare("
    SELECT sp.*, spd.DuongDan1 
    FROM SanPham sp
    LEFT JOIN SanPhamData spd ON sp.MaSP = spd.MaSP
    WHERE sp.MaLoai = ?
    LIMIT ?
");

$stmt->bind_param("ii", $maLoai, $soLuongHienThi);
$stmt->execute();
$result = $stmt->get_result();

//chatbot
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $sender = $_SESSION['matk'] ?? null;
//     $receiver = $_POST['receiver_id'] ?? null;
//     $message = trim($_POST['message'] ?? '');

//     if ($sender && $receiver && $message !== '') {
//         $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
//         $stmt->bind_param("iis", $sender, $receiver, $message);
//         $stmt->execute();

//         if ($stmt->affected_rows > 0) {
//             echo "OK";
//         } else {
//             echo "Không thêm được tin nhắn!";
//         }
//     } else {
//         echo "Thiếu dữ liệu!";
//     }
// }

// $stmt = $conn->prepare("
//     SELECT * FROM messages 
//     WHERE (sender_id = ? AND receiver_id = ?) 
//        OR (sender_id = ? AND receiver_id = ?)
//     ORDER BY created_at ASC
// ");
// $stmt->bind_param("iiii", $admin_id, $user_id, $user_id, $admin_id);
// $stmt->execute();
// $result = $stmt->get_result();

// while ($row = $result->fetch_assoc()) {
//     echo "<p><strong>{$row['sender_id']}:</strong> {$row['message']} ({$row['created_at']})</p>";
// }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        /* Custom CSS for animations and effects */
        .product-card2 {
            transition: all 0.3s ease;
        }

        .product-card2:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .category-card {
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: scale(1.03);
        }

        .deal-timer {
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

        .nav-link2 {
            position: relative;
        }

        .nav-link2::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }

        .nav-link2:hover::after {
            width: 100%;
        }

        .zalo-button {
            position: fixed;
            bottom: 100px;
            right: 32px;
            width: 50px;
            height: 50px;
            background-color: #e05c0c;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        /* Hiệu ứng khi rê chuột */
        .zalo-button:hover {
            transform: scale(1.1);
            /* Phóng to nhẹ */
        }

        /* Ảnh Zalo */
        .zalo-button img {
            width: 30px;
            height: 30px;
            animation: shakeAndZoom 0.8s infinite ease-in-out;
        }

        @keyframes shakeAndZoom {

            0% {
                transform: scale(0.5) rotate(0deg);
            }

            25% {
                transform: scale(1.1) rotate(-20deg);
            }

            50% {
                transform: scale(1.1) rotate(20deg);
            }

            75% {
                transform: scale(1.1) rotate(-20deg);
            }

            100% {
                transform: scale(0.5) rotate(0deg);
            }
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

    <!-- Hero Slider Section -->
    <section id="home" class="hero-slider fade-in">
        <!-- Slide 1 -->
        <div class="slide active" style="background-image: url('http://4.bp.blogspot.com/-PyqehQapRvg/Ugmy6kqP4XI/AAAAAAAAJ68/kxhF7Ik5nTE/s1600/trang-tri-noi-that-go-soi.JPG');">
            <div class="slide-content">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Sản phẩm gỗ chất lượng cao</h1>
                <p class="text-xl md:text-2xl mb-8">Được làm thủ công bằng gỗ tốt nhất của thiên nhiên cho ngôi nhà và văn phòng của bạn</p>
                <a href="#products" class="bg-amber-700 hover:bg-amber-800 text-white px-8 py-3 rounded-full font-semibold transition duration-300 inline-block">
                    Khám phá bộ sưu tập của chúng tôi
                </a>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="slide" style="background-image: url('https://tnthome.com.vn/wp-content/uploads/2023/05/noi-that-phong-khach-bang-go-.jpg');">
            <div class="slide-content">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Nguồn cung cấp gỗ bền vững</h1>
                <p class="text-xl md:text-2xl mb-8">Được thu hoạch có đạo đức từ các khu rừng được quản lý có trách nhiệm</p>
                <a href="#about" class="bg-amber-700 hover:bg-amber-800 text-white px-8 py-3 rounded-full font-semibold transition duration-300 inline-block">
                    Lời cam kết bền vững của chúng tôi
                </a>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="slide" style="background-image: url('../images/a2.png');">
            <div class="slide-content">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Làm mộc theo yêu cầu</h1>
                <p class="text-xl md:text-2xl mb-8">Đồ nội thất được thiết kế riêng theo đúng thông số kỹ thuật của bạn</p>
                <a href="#contact" class="bg-amber-700 hover:bg-amber-800 text-white px-8 py-3 rounded-full font-semibold transition duration-300 inline-block">
                    Yêu cầu tư vấn
                </a>
            </div>
        </div>

        <!-- Slide 4 -->
        <div class="slide" style="background-image: url('../images/a1.png');">
            <div class="slide-content">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Custom Woodworking</h1>
                <p class="text-xl md:text-2xl mb-8">Bespoke furniture crafted to your exact specifications</p>
                <a href="#contact" class="bg-amber-700 hover:bg-amber-800 text-white px-8 py-3 rounded-full font-semibold transition duration-300 inline-block">
                    Request a Consultation
                </a>
            </div>
        </div>

        <!-- Navigation Arrows -->
        <button class="slider-arrow prev">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slider-arrow next">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Navigation Dots -->
        <div class="slider-nav">
            <div class="slider-dot active" data-slide="0"></div>
            <div class="slider-dot" data-slide="1"></div>
            <div class="slider-dot" data-slide="2"></div>
            <div class="slider-dot" data-slide="3"></div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Danh mục sản phẩm</h2>
                <a href="#" class="text-blue-600 hover:underline flex items-center">
                    Xem thêm <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <!-- Category 1 -->
                <a href="category.php?maloai=2" class="category-card bg-white rounded-lg overflow-hidden shadow-md border border-gray-100 text-center p-6 hover:shadow-lg transition">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <!-- <i class="fas fa-tshirt text-blue-600 text-2xl"></i> -->
                        <img src="../images/icon-tu-bat-dia.png" class="h-12" alt="img">
                    </div>
                    <h3 class="font-semibold text-gray-800">Tủ</h3>
                    <p class="text-xs text-gray-500 mt-1">1,200 items</p>
                </a>

                <!-- Category 2 -->
                <a href="category.php?maloai=3" class="category-card bg-white rounded-lg overflow-hidden shadow-md border border-gray-100 text-center p-6 hover:shadow-lg transition">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <img src="../images/25.png" class="h-12" alt="img">
                    </div>
                    <h3 class="font-semibold text-gray-800">Giường</h3>
                    <p class="text-xs text-gray-500 mt-1">850 items</p>
                </a>

                <!-- Category 3 -->
                <a href="category.php?maloai=4" class="category-card bg-white rounded-lg overflow-hidden shadow-md border border-gray-100 text-center p-6 hover:shadow-lg transition">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <img src="../images/ban-an.png" class="h-12" alt="img">
                    </div>
                    <h3 class="font-semibold text-gray-800">Bàn</h3>
                    <p class="text-xs text-gray-500 mt-1">1,500 items</p>
                </a>

                <!-- Category 4 -->
                <a href="category.php?maloai=5" class="category-card bg-white rounded-lg overflow-hidden shadow-md border border-gray-100 text-center p-6 hover:shadow-lg transition">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <img src="../images/1.png" class="h-12" alt="img">
                    </div>
                    <h3 class="font-semibold text-gray-800">Ghé</h3>
                    <p class="text-xs text-gray-500 mt-1">2,300 items</p>
                </a>

                <!-- Category 5 -->
                <a href="category.php?maloai=6" class="category-card bg-white rounded-lg overflow-hidden shadow-md border border-gray-100 text-center p-6 hover:shadow-lg transition">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <img src="../images/9.png" class="h-12" alt="img">
                    </div>
                    <h3 class="font-semibold text-gray-800">Kệ</h3>
                    <p class="text-xs text-gray-500 mt-1">980 items</p>
                </a>

                <!-- Category 6 -->
                <a href="category.php?maloai=7" class="category-card bg-white rounded-lg overflow-hidden shadow-md border border-gray-100 text-center p-6 hover:shadow-lg transition">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <img src="../images/33.png" class="h-12" alt="img">
                    </div>
                    <h3 class="font-semibold text-gray-800">Vật dụng khác</h3>
                    <p class="text-xs text-gray-500 mt-1">1,750 items</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-16 bg-white" id="products">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Sản phẩm mới</h2>
                <a href="products.php" class="text-blue-600 hover:underline flex items-center">
                    Xem Thêm <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product-card bg-white rounded-lg overflow-hidden shadow-lg transition duration-300">
                        <a href="product-detail.php?masp=<?= $row['MaSP'] ?>" class="group block">
                            <div class="relative overflow-hidden h-64 bg-gray-100 flex items-center justify-center">
                                <img src="<?= $row['DuongDan1'] ? 'images2/' . htmlspecialchars($row['DuongDan1']) : 'images/no-image.png' ?>"
                                    class="h-full object-cover transform transition duration-300 ease-in-out group-hover:scale-105">
                                <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    MỚI
                                </div>
                            </div>
                        </a>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-black mb-2">
                                <a href="product-detail.php?masp=<?= $row['MaSP'] ?>" class="hover:underline hover:text-amber-700">
                                    <?= htmlspecialchars($row['TenSP']) ?>
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4 overflow-hidden text-ellipsis whitespace-nowrap"><?= htmlspecialchars($row['MoTa']) ?></p>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-black"><?= number_format($row['Gia'], 0, ',', '.') ?>₫</span>
                                <form action="add_to_cart.php" method="POST">
                                    <input type="hidden" name="masp" value="<?= $row['MaSP'] ?>">
                                    <input type="hidden" name="soluong" value="1">
                                    <button class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded transition duration-300">
                                        Thêm vào giỏ
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        </div>
    </section>

    <?php
    // --- Khung cho MaLoai = 2 ---
    $maLoai = 3;
    $soLuongHienThi = 4;
    $phanTramGiam = 30; // giảm 30%

    $stmt = $conn->prepare("
        SELECT sp.*, spd.DuongDan1 
        FROM SanPham sp
        LEFT JOIN SanPhamData spd ON sp.MaSP = spd.MaSP
        WHERE sp.MaLoai = ?
        LIMIT ?
    ");
    $stmt->bind_param("ii", $maLoai, $soLuongHienThi);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    <!-- Hot Deals Section -->
    <section id="hot-deals" class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Khuyến mại hấp dẫn</h2>
                <a href="products.php" class="text-blue-600 hover:underline flex items-center">
                    Xem thêm <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Big Deal Banner -->
                <div class="bg-gradient-to-r from-red-500 to-orange-500 rounded-xl overflow-hidden shadow-lg">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/2 p-8 text-white">
                            <span class="bg-white text-red-500 text-xs font-bold px-3 py-1 rounded-full inline-block mb-4">THỜI GIAN CÓ HẠN</span>
                            <h3 class="text-2xl font-bold mb-2">Khuyến mại mùa hè</h3>
                            <p class="mb-4">Giảm giá tới 60% cho một số mặt hàng được chọn. Đừng bỏ lỡ!</p>
                            <div class="deal-timer bg-white bg-opacity-20 rounded-lg p-4 mb-6">
                                <h4 class="text-sm font-semibold mb-2">ƯU ĐÃI KẾT THÚC SAU:</h4>
                                <div class="flex space-x-2">
                                    <div class="bg-white text-red-500 rounded p-2 text-center">
                                        <div class="text-xl font-bold" id="deal-hours">12</div>
                                        <div class="text-xs">HOURS</div>
                                    </div>
                                    <div class="bg-white text-red-500 rounded p-2 text-center">
                                        <div class="text-xl font-bold" id="deal-minutes">45</div>
                                        <div class="text-xs">MINUTES</div>
                                    </div>
                                    <div class="bg-white text-red-500 rounded p-2 text-center">
                                        <div class="text-xl font-bold" id="deal-seconds">30</div>
                                        <div class="text-xs">SECONDS</div>
                                    </div>
                                </div>
                            </div>
                            <button class="bg-white text-red-500 px-6 py-2 rounded-full font-medium hover:bg-gray-100 transition">Mua Ngay</button>
                        </div>
                        <div class="md:w-1/2 flex items-center justify-center p-4">
                            <img src="../images3/14.jpg" alt="Summer Sale" class="max-w-full h-auto rounded-lg shadow-md">
                        </div>
                    </div>
                </div>

                <!-- Deal Products -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Deal 1 -->
                    <?php while ($row = $result->fetch_assoc()) {
                        $giaGoc = $row['Gia'];
                        $giaSauGiam = $giaGoc * (1 - $phanTramGiam / 100);
                    ?>
                        <div class="product-card2 bg-white rounded-lg overflow-hidden shadow-md border border-gray-100 relative">
                            <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">-30%</div>
                            <div class="p-4 flex">
                                <div class="w-1/1">
                                    <img src="<?= $row['DuongDan1'] ? 'images2/' . htmlspecialchars($row['DuongDan1']) : 'images/no-image.png' ?>"
                                        alt="<?= htmlspecialchars($row['TenSP']) ?>" class="w-full h-24 object-cover rounded">
                                </div>
                                <div class="w-2/3 pl-4">
                                    <h3 class="font-semibold text-gray-800 mb-1 text-ellipsis">
                                        <?= htmlspecialchars($row['TenSP']) ?>
                                    </h3>
                                    <div class="row items-center mb-1">
                                        <span class="text-lg font-bold text-red-500"><?= number_format($giaSauGiam, 0, ',', '.') ?>₫</span>
                                        <span class="text-sm text-gray-500 line-through ml-2"><?= number_format($giaGoc, 0, ',', '.') ?>₫</span>
                                    </div>
                                    <!-- <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                                        <div class="bg-red-500 h-1.5 rounded-full" style="width: 30%"></div>
                                    </div> -->
                                    <form action="add_to_cart.php" method="POST">
                                        <input type="hidden" name="masp" value="<?= $row['MaSP'] ?>">
                                        <input type="hidden" name="soluong" value="1">
                                        <button class="bg-red-600 hover:bg-amber-700 text-white px-4 py-2 rounded transition duration-300">
                                            Thêm vào giỏ
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>


    <?php
    $maLoai = 7;
    $soLuongHienThi = 8;

    // JOIN để lấy ảnh DuongDan1 từ bảng SanPhamData
    $stmt = $conn->prepare("
        SELECT sp.*, spd.DuongDan1 
        FROM SanPham sp
        LEFT JOIN SanPhamData spd ON sp.MaSP = spd.MaSP
        WHERE sp.MaLoai = ?
        LIMIT ?
    ");
    $stmt->bind_param("ii", $maLoai, $soLuongHienThi);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    <!--sản phẩm nổi bật-->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Sản phẩm nổi bật</h2>
                <a href="products.php" class="text-blue-600 hover:underline flex items-center">
                    Xem Thêm <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Swiper Container -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="swiper-slide">
                            <div class="product-card bg-white rounded-lg overflow-hidden shadow-lg transition duration-300 w-[300px]">
                                <a href="product-detail.php?masp=<?= $row['MaSP'] ?>" class="group block">
                                    <div class="relative overflow-hidden h-64 bg-gray-100 flex items-center justify-center">
                                        <img src="<?= $row['DuongDan1'] ? 'images2/' . htmlspecialchars($row['DuongDan1']) : 'images/no-image.png' ?>"
                                            alt="<?= htmlspecialchars($row['TenSP']) ?>"
                                            class="h-full object-cover transform transition duration-300 ease-in-out group-hover:scale-105">
                                        <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                            HOT
                                        </div>
                                    </div>
                                </a>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-black mb-2">
                                        <a href="product-detail.php?masp=<?= $row['MaSP'] ?>" class="hover:underline hover:text-amber-700">
                                            <?= htmlspecialchars($row['TenSP']) ?>
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-4 overflow-hidden text-ellipsis whitespace-nowrap">
                                        <?= htmlspecialchars($row['MoTa']) ?>
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xl font-bold text-black">
                                            <?= number_format($row['Gia'], 0, ',', '.') ?>₫
                                        </span>
                                        <form action="add_to_cart.php" method="POST">
                                            <input type="hidden" name="masp" value="<?= $row['MaSP'] ?>">
                                            <input type="hidden" name="soluong" value="1">
                                            <button class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded transition duration-300">
                                                Thêm vào giỏ
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>




    <?php
    $maLoai = 2;
    $soLuongHienThi = 8;

    // JOIN để lấy ảnh DuongDan1 từ bảng SanPhamData
    $stmt = $conn->prepare("
        SELECT sp.*, spd.DuongDan1 
        FROM SanPham sp
        LEFT JOIN SanPhamData spd ON sp.MaSP = spd.MaSP
        WHERE sp.MaLoai = ?
        LIMIT ?
    ");
    $stmt->bind_param("ii", $maLoai, $soLuongHienThi);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Sản phẩm thường</h2>
                <a href="products.php" class="text-blue-600 hover:underline flex items-center">
                    Xem Thêm <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product-card bg-white rounded-lg overflow-hidden shadow-lg transition duration-300">
                        <a href="product-detail.php?masp=<?= $row['MaSP'] ?>" class="group block">
                            <div class="relative overflow-hidden h-64 bg-gray-100 flex items-center justify-center">
                                <img src="<?= $row['DuongDan1'] ? 'images2/' . htmlspecialchars($row['DuongDan1']) : 'images/no-image.png' ?>"
                                    alt="<?= htmlspecialchars($row['TenSP']) ?>"
                                    class="h-full object-cover transform transition duration-300 ease-in-out group-hover:scale-105">
                            </div>
                        </a>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-black mb-2">
                                <a href="product-detail.php?masp=<?= $row['MaSP'] ?>" class="hover:underline hover:text-amber-700">
                                    <?= htmlspecialchars($row['TenSP']) ?>
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4 overflow-hidden text-ellipsis whitespace-nowrap"><?= htmlspecialchars($row['MoTa']) ?></p>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-black"><?= number_format($row['Gia'], 0, ',', '.') ?>₫</span>
                                <form action="add_to_cart.php" method="POST">
                                    <input type="hidden" name="masp" value="<?= $row['MaSP'] ?>">
                                    <input type="hidden" name="soluong" value="1">
                                    <button class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded transition duration-300">
                                        Thêm vào giỏ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-12 bg-amber-100">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-amber-900 mb-4">Tham gia cộng đồng Woodcraft của chúng tôi</h2>
            <p class="text-gray-700 mb-6 max-w-2xl mx-auto">
                Đăng ký nhận bản tin của chúng tôi để nhận các ưu đãi độc quyền, mẹo làm đồ gỗ và thông báo về sản phẩm mới.
            </p>

            <div class="max-w-md mx-auto flex">
                <input type="email" placeholder="Địa chỉ email của bạn" class="flex-grow px-4 py-3 rounded-l-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500">
                <button class="bg-amber-700 hover:bg-amber-800 text-white px-6 py-3 rounded-r-lg font-semibold transition duration-300">
                    Đặt mua
                </button>
            </div>
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

    <!-- Nút Chatbot (ở trên) -->
    <!-- <div id="chatbot-toggle"
        class="fixed bottom-24 right-8 bg-orange-500 text-white w-12 h-12 flex items-center justify-center rounded-full shadow-lg cursor-pointer hover:bg-orange-600 z-50">
        <i class="fas fa-comment-dots text-xl"></i>
    </div> -->
    <a href="https://zalo.me/0353027393" target="_blank" class="zalo-button">
        <img src="https://media.metu.vn/fillcolor?url=https%3A%2F%2Fmedia.metu.vn%2Fimages%2Ficon_zalo_01.svg&color=%23ffffff" alt="Zalo">
    </a>

    <!-- Chatbot Box -->
    <!-- <div id="chatbot-box" class="fixed bottom-36 right-6 w-80 bg-white border border-gray-300 rounded-lg shadow-lg hidden z-50">
        <div class="bg-amber-600 text-white px-4 py-3 flex justify-between items-center rounded-t-lg">
            <h3 class="font-semibold">Trợ lý ảo</h3>
            <button onclick="closeChatbot()" class="text-white text-lg">&times;</button>
        </div>
        <div class="p-4 h-64 overflow-y-auto text-sm" id="chat-log">
            <div class="text-gray-500 text-center">Xin chào! Tôi có thể giúp gì cho bạn?</div>
        </div>
        <form id="chat-form" class="border-t flex">
            <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." class="w-full px-3 py-2 text-sm focus:outline-none" required>
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-4">Gửi</button>
        </form>
    </div> -->

    <!-- Back to Top Button -->
    <button id="back-to-top"
        class="fixed bottom-8 right-8 bg-orange-700 text-white w-12 h-12 rounded-full shadow-lg hidden z-40">
        <i class="fas fa-arrow-up text-xl"></i>
    </button>

    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            breakpoints: {
                640: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 4
                }
            },
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            }
        });


        // Countdown timer for hot deals
        function updateDealTimer() {
            const now = new Date();
            const endTime = new Date();
            endTime.setHours(23, 59, 59); // Set to end of day

            const diff = endTime - now;

            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById('deal-hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('deal-minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('deal-seconds').textContent = seconds.toString().padStart(2, '0');
        }

        setInterval(updateDealTimer, 1000);
        updateDealTimer();

        //chatbot
        // function closeChatbot() {
        //     document.getElementById('chatbot-box').classList.add('hidden');
        // }

        // document.getElementById('chatbot-toggle').addEventListener('click', function() {
        //     document.getElementById('chatbot-box').classList.toggle('hidden');
        // });
        // const chatLog = document.getElementById('chat-log');

        // Gửi tin nhắn
        // document.getElementById('chat-form').addEventListener('submit', function(e) {
        //     e.preventDefault();
        //     const input = document.getElementById('chat-input');
        //     const message = input.value.trim();
        //     if (!message) return;

        //     chatLog.innerHTML += `<div class="text-right text-amber-800 my-1">${message}</div>`;
        //     chatLog.scrollTop = chatLog.scrollHeight;
        //     input.value = '';

        //     fetch('chat_save.php', {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/x-www-form-urlencoded'
        //         },
        //         body: `message=${encodeURIComponent(message)}&receiver_id=1`
        //     });
        // });

        // Tự động tải tin nhắn mỗi 5s
        // setInterval(() => {
        //     fetch('chat_get.php')
        //         .then(res => res.text())
        //         .then(data => {
        //             document.getElementById('chat-log').innerHTML = data;
        //         });
        // }, 5000);
    </script>
</body>

</html>