<?php
include 'db_connection.php';

if (!isset($_GET['id'])) {
    echo "Thiếu ID sản phẩm!";
    exit;
}

$MaSP = intval($_GET['id']);

// Lấy thông tin sản phẩm cần sửa
$sql = "SELECT * FROM SanPham WHERE MaSP = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $MaSP);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

$sqlData = "SELECT DuongDan1, DuongDan2, DuongDan3, DuongDan4, AnhNote FROM SanPhamData WHERE MaSP = ?";
$stmtData = $conn->prepare($sqlData);
$stmtData->bind_param("i", $MaSP);
$stmtData->execute();
$dataResult = $stmtData->get_result();
$productData = $dataResult->fetch_assoc();

if (!$product) {
    echo "Không tìm thấy sản phẩm!";
    exit;
}

// Lấy danh sách loại
$loaiQuery = "SELECT MaLoai, TenLoai FROM Loai";
$loaiResult = $conn->query($loaiQuery);

// Cập nhật khi submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $TenSP = $_POST['TenSP'];
    $MaLoai = $_POST['MaLoai'];
    $Dai = $_POST['Dai'];
    $Rong = $_POST['Rong'];
    $Cao = $_POST['Cao'];
    $ChatLieu = $_POST['ChatLieu'];
    $Gia = $_POST['Gia'];
    $MoTa = $_POST['MoTa'];

    $updateSQL = "UPDATE SanPham SET TenSP=?, MaLoai=?, Dai=?, Rong=?, Cao=?, ChatLieu=?, Gia=?, MoTa=? WHERE MaSP=?";
    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bind_param("sidddsdsi", $TenSP, $MaLoai, $Dai, $Rong, $Cao, $ChatLieu, $Gia, $MoTa, $MaSP);


    if ($updateStmt->execute()) {
        // Xử lý ảnh nếu có
        $uploadDir = 'images2/';
        $duongDan = [];

        for ($i = 1; $i <= 4; $i++) {
            if (isset($_FILES["DuongDan$i"]) && $_FILES["DuongDan$i"]["error"] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES["DuongDan$i"]["tmp_name"];
                $fileName = basename($_FILES["DuongDan$i"]["name"]);
                $targetPath = $uploadDir . time() . "_$i" . "_" . $fileName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $duongDan[$i] = basename($targetPath);
                }
            }
        }

        if (!empty($duongDan)) {
            // Kiểm tra đã có dữ liệu trong SanPhamData chưa
            $check = $conn->prepare("SELECT MaSP FROM SanPhamData WHERE MaSP = ?");
            $check->bind_param("i", $MaSP);
            $check->execute();
            $checkResult = $check->get_result();

            if ($checkResult->num_rows > 0) {
                // Cập nhật ảnh
                $updateFields = [];
                $params = [];
                $types = '';

                foreach ($duongDan as $index => $file) {
                    $updateFields[] = "DuongDan$index = ?";
                    $params[] = $file;
                    $types .= 's';
                }

                $params[] = $MaSP;
                $types .= 'i';

                $updateSql = "UPDATE SanPhamData SET " . implode(', ', $updateFields) . " WHERE MaSP = ?";
                $stmtImg = $conn->prepare($updateSql);
                $stmtImg->bind_param($types, ...$params);
                $stmtImg->execute();
            } else {
                // Chèn mới ảnh
                $insertSql = "INSERT INTO SanPhamData (MaSP, DuongDan1, DuongDan2, DuongDan3, DuongDan4)
                          VALUES (?, ?, ?, ?, ?)";
                $stmtImg = $conn->prepare($insertSql);
                $stmtImg->bind_param(
                    "issss",
                    $MaSP,
                    $duongDan[1] ?? null,
                    $duongDan[2] ?? null,
                    $duongDan[3] ?? null,
                    $duongDan[4] ?? null
                );
                $stmtImg->execute();
            }
        }

        // ✅ Sau khi xong hết mới chuyển trang
        header("Location: sanpham.php");
        exit;
    } else {
        $error = "Cập nhật thất bại: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <title>TimberCraft | Premium Wood Products</title>
    <link rel="icon" href="../images/logo.png" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
    </header>
    <div class="p-6"></div>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold text-amber-800 mb-6 text-center">Sửa sản phẩm</h1>

        <?php if (isset($error)) echo "<p class='text-red-500 mb-4'>$error</p>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block mb-1">Tên sản phẩm</label>
                <input type="text" name="TenSP" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none" value="<?= htmlspecialchars($product['TenSP']) ?>">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Loại sản phẩm</label>
                <select name="MaLoai" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    <?php while ($row = $loaiResult->fetch_assoc()): ?>
                        <option value="<?= $row['MaLoai'] ?>" <?= $row['MaLoai'] == $product['MaLoai'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['TenLoai']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block mb-1">Dài (cm)</label>
                    <input type="number" step="0.01" name="Dai" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none" value="<?= $product['Dai'] ?>">
                </div>
                <div>
                    <label class="block mb-1">Rộng (cm)</label>
                    <input type="number" step="0.01" name="Rong" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none" value="<?= $product['Rong'] ?>">
                </div>
                <div>
                    <label class="block mb-1">Cao (cm)</label>
                    <input type="number" step="0.01" name="Cao" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none" value="<?= $product['Cao'] ?>">
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Chất liệu</label>
                <input type="text" name="ChatLieu" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none" value="<?= htmlspecialchars($product['ChatLieu']) ?>">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Giá (VNĐ)</label>
                <input type="number" step="0.01" name="Gia" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none" value="<?= $product['Gia'] ?>">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Mô tả</label>
                <textarea name="MoTa" rows="4" class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none"><?= htmlspecialchars($product['MoTa']) ?></textarea>
            </div>

            <!-- Hiển thị ảnh hiện tại (nếu có) -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Ảnh hiện tại</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <div class="text-center">
                            <?php if (!empty($productData["DuongDan$i"])): ?>
                                <img src="images2/<?= htmlspecialchars($productData["DuongDan$i"]) ?>" alt="Ảnh <?= $i ?>" class="w-32 h-32 object-cover rounded border mx-auto mb-1">
                            <?php else: ?>
                                <div class="w-32 h-32 bg-gray-100 flex items-center justify-center rounded border mx-auto mb-1 text-gray-400 text-sm">
                                    No Image <?= $i ?>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="DuongDan<?= $i ?>" accept="image/*" class="block w-full text-sm text-gray-600">
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="sanpham.php" class="text-amber-700 hover:underline">← Quay lại</a>
                <button type="submit" class="bg-amber-600 text-white font-semibold px-6 py-2 rounded hover:bg-amber-700 transition duration-300">Lưu thay đổi</button>
            </div>
        </form>
    </div>


    <footer class="bg-amber-900 text-white py-8 mt-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row justify-between gap-8">
                <div class="flex-1">
                    <div class="flex items-center mb-4">
                        <img src="../images/logo.png" alt="TimberCraft Logo" class="h-20 w-auto mr-2" />
                        <h3 class="text-2xl font-bold">Timber<span class="text-amber-400">Craft</span></h3>
                    </div>
                    <p><i class="fas fa-map-marker-alt mr-2"></i>123 Timber Lane, Forestville, CA 95436</p>
                    <p><i class="fas fa-phone mr-2"></i>(555) 123-4567</p>
                    <p><i class="fas fa-envelope mr-2"></i>info@timbercraft.com</p>
                    <p class="mt-2 text-sm italic">Mọi vấn đề liên quan đến bản quyền, vui lòng liên hệ chúng tôi sẽ xử lý!</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="hover:text-amber-300 text-xl"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="hover:text-amber-300 text-xl"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-amber-300 text-xl"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="hover:text-amber-300 text-xl"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="hover:text-amber-300 text-xl"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-amber-300 text-xl"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 flex-1">
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Về chúng tôi</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-amber-300">Giới thiệu</a></li>
                            <li><a href="#" class="hover:text-amber-300">Nhượng quyền</a></li>
                            <li><a href="#" class="hover:text-amber-300">Khuyến mại</a></li>
                            <li><a href="#" class="hover:text-amber-300">Quy định</a></li>
                            <li><a href="#" class="hover:text-amber-300">Thông tin liên hệ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Chính sách</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-amber-300">Thành viên</a></li>
                            <li><a href="#" class="hover:text-amber-300">Thanh toán</a></li>
                            <li><a href="#" class="hover:text-amber-300">Vận chuyển</a></li>
                            <li><a href="#" class="hover:text-amber-300">Đổi trả</a></li>
                            <li><a href="#" class="hover:text-amber-300">Bảo mật</a></li>
                            <li><a href="#" class="hover:text-amber-300">Bảo hành</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="border-t border-amber-800 mt-8 pt-6 text-sm text-center md:text-left">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p>&copy; 2023 TimberCraft. All rights reserved.</p>
                    <div class="mt-4 md:mt-0 flex flex-wrap justify-center gap-4">
                        <a href="#" class="hover:text-amber-300">Giới thiệu</a>
                        <a href="#" class="hover:text-amber-300">Liên hệ</a>
                        <a href="#" class="hover:text-amber-300">Bản quyền</a>
                        <a href="#" class="hover:text-amber-300">Hợp tác</a>
                        <a href="#" class="hover:text-amber-300">Xếp hạng</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const menuBtn = document.getElementById("mobile-menu-button");
        const mobileMenu = document.getElementById("mobile-menu");
        menuBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    </script>
</body>

</html>