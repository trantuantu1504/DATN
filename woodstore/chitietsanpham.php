<?php
include('db_connection.php');
session_start();

// Kiểm tra mã sản phẩm có tồn tại không
if (isset($_GET['masp']) && is_numeric($_GET['masp'])) {
    $masp = (int)$_GET['masp'];

    // Lấy thông tin sản phẩm từ CSDL
    $stmt = $conn->prepare("SELECT * FROM SanPham WHERE MaSP = ?");
    $stmt->bind_param("i", $masp);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra sản phẩm có tồn tại không
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "<h2>Sản phẩm không tồn tại!</h2>";
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<h2>Không có sản phẩm được chọn!</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10 px-6">
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row gap-6">
            <!-- Ảnh đại diện (hiện tại placeholder vì chưa có cột ảnh) -->
            <div class="w-full md:w-1/2">
                <img src="images2/<?= $row['MaSP'] ?>.jpg" alt="<?= htmlspecialchars($row['TenSP']) ?>" class="h-full object-cover">
            </div>

            <!-- Thông tin chi tiết -->
            <div class="w-full md:w-1/2">
                <h1 class="text-3xl font-bold text-amber-800 mb-4"><?= htmlspecialchars($row['TenSP']) ?></h1>
                <p class="text-gray-700 mb-2"><strong>Giá:</strong> <?= number_format($row['Gia'], 0, ',', '.') ?>₫</p>
                <p class="text-gray-700 mb-2"><strong>Kích thước:</strong> <?= $row['Dai'] ?> x <?= $row['Rong'] ?> x <?= $row['Cao'] ?> cm</p>
                <p class="text-gray-700 mb-2"><strong>Chất liệu:</strong> <?= htmlspecialchars($row['ChatLieu']) ?></p>
                <p class="text-gray-700 mt-4"><strong>Mô tả:</strong><br><?= nl2br(htmlspecialchars($row['MoTa'])) ?></p>

                <div class="mt-6">
                    <button class="bg-amber-600 hover:bg-amber-700 text-black px-6 py-2 rounded transition duration-300">
                        Thêm vào giỏ hàng
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <a href="products.php" class="text-amber-700 hover:underline">&larr; Quay lại danh sách sản phẩm</a>
        </div>
    </div>
</body>
</html>
