<?php
include 'db_connection.php';

// Lấy danh sách loại sản phẩm
$loaiQuery = "SELECT MaLoai, TenLoai FROM Loai";
$loaiResult = $conn->query($loaiQuery);

// Xử lý khi submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $TenSP = $_POST['TenSP'];
    $MaLoai = $_POST['MaLoai'];
    $Dai = $_POST['Dai'];
    $Rong = $_POST['Rong'];
    $Cao = $_POST['Cao'];
    $ChatLieu = $_POST['ChatLieu'];
    $Gia = $_POST['Gia'];
    $MoTa = $_POST['MoTa'];
    $AnhNote = $_POST['AnhNote'];

    // Thêm sản phẩm vào bảng SanPham
    $sql = "INSERT INTO SanPham (TenSP, MaLoai, Dai, Rong, Cao, ChatLieu, Gia, MoTa)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sidddsds", $TenSP, $MaLoai, $Dai, $Rong, $Cao, $ChatLieu, $Gia, $MoTa);

    if ($stmt->execute()) {
        $MaSP = $conn->insert_id; // Lấy ID vừa thêm

        // Xử lý ảnh
        $uploadDir = 'images2/';
        $duongDan = [];

        for ($i = 1; $i <= 4; $i++) {
            $fileKey = "DuongDan$i";
            if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === 0) {
                $ext = pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);
                $newName = uniqid("sp{$MaSP}_img{$i}_") . '.' . $ext;
                $targetPath = $uploadDir . $newName;

                if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $targetPath)) {
                    $duongDan[$i] = $newName;
                } else {
                    $duongDan[$i] = null;
                }
            } else {
                $duongDan[$i] = null;
            }
        }

        // Thêm dữ liệu ảnh vào bảng SanPhamData
        $sqlAnh = "INSERT INTO SanPhamData (MaSP, DuongDan1, DuongDan2, DuongDan3, DuongDan4, AnhNote)
                   VALUES (?, ?, ?, ?, ?, ?)";

        $stmtAnh = $conn->prepare($sqlAnh);
        $stmtAnh->bind_param("isssss", $MaSP, $duongDan[1], $duongDan[2], $duongDan[3], $duongDan[4], $AnhNote);
        $stmtAnh->execute();

        header("Location: sanpham.php");
        exit;
    } else {
        $error = "Lỗi khi thêm sản phẩm: " . $conn->error;
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

    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold text-amber-800 mb-6">Thêm sản phẩm mới</h1>

        <?php if (isset($error)) echo "<p class='text-red-500 mb-4'>$error</p>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block mb-1">Tên sản phẩm</label>
                <input type="text" name="TenSP" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Loại sản phẩm</label>
                <select name="MaLoai" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    <option value="">-- Chọn loại --</option>
                    <?php while ($row = $loaiResult->fetch_assoc()): ?>
                        <option value="<?= $row['MaLoai'] ?>"><?= htmlspecialchars($row['TenLoai']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block mb-1">Dài (cm)</label>
                    <input type="number" step="0.01" name="Dai" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
                <div>
                    <label class="block mb-1">Rộng (cm)</label>
                    <input type="number" step="0.01" name="Rong" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
                <div>
                    <label class="block mb-1">Cao (cm)</label>
                    <input type="number" step="0.01" name="Cao" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Chất liệu</label>
                <input type="text" name="ChatLieu" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Giá (VNĐ)</label>
                <input type="number" step="0.01" name="Gia" required class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Mô tả</label>
                <textarea name="MoTa" rows="4" class="w-full border p-2 rounded focus:ring-2 focus:ring-amber-500 focus:outline-none"></textarea>
            </div>

            <!-- Hình ảnh sản phẩm -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Hình ảnh sản phẩm</label>
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="mb-3">
                        <label class="text-sm text-gray-700">Ảnh <?= $i ?>:</label>
                        <input type="file" name="DuongDan<?= $i ?>" accept="image/*" class="w-full border p-2 rounded bg-white file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200">
                    </div>
                <?php endfor; ?>
                <div class="mt-2">
                    <label class="text-sm font-medium">Ghi chú ảnh:</label>
                    <input type="text" name="AnhNote" class="w-full border p-2 rounded" placeholder="Ví dụ: Hình chụp từ các góc khác nhau">
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <a href="sanpham.php" class="text-amber-700 hover:underline">← Quay lại</a>
                <button type="submit" class="bg-amber-700 text-white px-4 py-2 rounded hover:bg-amber-800">Thêm sản phẩm</button>
            </div>
        </form>
    </div>

    <div class="p-6"></div>

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
</body>


</html>