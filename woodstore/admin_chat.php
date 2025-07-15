<?php
session_start();
include('db_connection.php');

$admin_id = $_SESSION['matk'] ?? null;
if (!$admin_id) {
    die("Bạn chưa đăng nhập với tư cách admin.");
}

// Lấy danh sách tin nhắn gửi cho admin
$sql = "
    SELECT DISTINCT tk.MaTK AS sender_id, kh.HoTen AS sender_name, m.message, m.created_at
    FROM messages m
    JOIN TK tk ON m.sender_id = tk.MaTK
    JOIN KhachHang kh ON tk.MaTK = kh.MaTK
    WHERE m.receiver_id = ?
    ORDER BY m.id DESC
";

$stmt = $conn->prepare($sql); // BẠN BỊ THIẾU DÒNG NÀY

if (!$stmt) {
    die("Lỗi truy vấn SQL: " . $conn->error);
}

$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
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
</head>

<body>
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
        <h2 class="text-2xl font-bold text-amber-700 mb-4 border-b pb-2">📨 Tin nhắn từ người dùng</h2>

        <ul class="space-y-4 max-h-64 overflow-y-auto pr-2">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="border border-gray-200 rounded-md p-3 bg-gray-50 shadow-sm">
                    <div class="text-sm text-gray-800 font-semibold mb-1">
                        👤 <?= htmlspecialchars($row['sender_name']) ?>
                        <span class="text-xs text-gray-500 float-right"><?= htmlspecialchars($row['created_at']) ?></span>
                    </div>
                    <div class="text-gray-700"><?= htmlspecialchars($row['message']) ?></div>
                </li>
            <?php endwhile; ?>
        </ul>

        <form action="chat_save.php" method="POST" class="mt-6">
            <input type="hidden" name="receiver_id" value="<?= $row['sender_id'] ?? '' ?>">
            <div class="flex gap-2">
                <input type="text" name="message" placeholder="Nhập nội dung..." required
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-amber-500 text-sm">
                <button type="submit"
                    class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-2 rounded-md transition">
                    Gửi
                </button>
            </div>
        </form>
    </div>

</body>

</html>