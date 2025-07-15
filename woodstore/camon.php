<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['matk'])) {
    header("Location: login.html");
    exit();
}

$matk = $_SESSION['matk'];

// Truy vấn đơn hàng mới nhất của tài khoản
$stmt = $conn->prepare("
    SELECT dh.MaDH, dh.Ngay, dh.TongTien, MAX(ct.GiaoDich) as GiaoDich
    FROM DonHang dh
    JOIN ChiTietDonHang ct ON dh.MaDH = ct.MaDH
    WHERE dh.MaTK = ?
    GROUP BY dh.MaDH, dh.Ngay, dh.TongTien
    ORDER BY dh.MaDH DESC
    LIMIT 1
");
$stmt->bind_param("i", $matk);
$stmt->bind_param("i", $matk);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation | ShopEase</title>
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
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .empty-cart-icon {
            animation: bounce 1.5s infinite;
        }
        
        /* Pulse animation for loading */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

<!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto text-center">
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Checkmark icon -->
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check text-green-600 text-3xl"></i>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Cảm Ơn Bạn Đã Đặt Hàng!</h1>
                <p class="text-gray-600 mb-6">Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng sớm nhất.</p>
                
                <!-- Order Summary -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                    <h3 class="font-medium text-gray-800 mb-4">Tóm tắt đơn hàng</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Số đơn hàng</span>
                            <span class="font-medium"><?= htmlspecialchars($order['MaDH']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ngày</span>
                            <span class="font-medium"><?= date("d/m/Y", strtotime($order['Ngay'])) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tổng</span>
                            <span class="font-medium"><?= number_format($order['TongTien'], 0, ',', '.') ?>₫</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phương thức thanh toán</span>
                            <span class="font-medium"><?= htmlspecialchars($order['GiaoDich']) ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition font-medium">
                        Xem chi tiết đơn hàng
                    </a>
                    <a href="index.php" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition font-medium">
                        Tiếp tục mua hàng
                    </a>
                </div>
                    
                    <!-- Cart Items -->
                    <!-- <div class="cart-items max-h-[500px] overflow-y-auto">
                        
                        <div class="p-6 border-b border-gray-200 hover:bg-gray-50 transition">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="w-full sm:w-24 h-24 bg-gray-100 rounded-md overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" 
                                         alt="Wireless Headphones" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <div>
                                            <h3 class="font-medium text-gray-800">Premium Wireless Headphones</h3>
                                            <p class="text-gray-500 text-sm mt-1">Color: Black</p>
                                        </div>
                                        <button class="text-gray-400 hover:text-red-500 transition">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="flex items-center border border-gray-200 rounded-md w-fit">
                                            <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition">-</button>
                                            <span class="px-4 py-1 text-center w-12">1</span>
                                            <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition">+</button>
                                        </div>
                                        <div class="font-bold text-gray-800">$129.99</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="p-6 border-b border-gray-200 hover:bg-gray-50 transition">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="w-full sm:w-24 h-24 bg-gray-100 rounded-md overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" 
                                         alt="Smart Watch" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <div>
                                            <h3 class="font-medium text-gray-800">Smart Watch Series 5</h3>
                                            <p class="text-gray-500 text-sm mt-1">Size: 42mm</p>
                                        </div>
                                        <button class="text-gray-400 hover:text-red-500 transition">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="flex items-center border border-gray-200 rounded-md w-fit">
                                            <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition">-</button>
                                            <span class="px-4 py-1 text-center w-12">2</span>
                                            <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition">+</button>
                                        </div>
                                        <div class="font-bold text-gray-800">$199.98</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="p-6 hover:bg-gray-50 transition">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="w-full sm:w-24 h-24 bg-gray-100 rounded-md overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" 
                                         alt="Headphones" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <div>
                                            <h3 class="font-medium text-gray-800">Noise Cancelling Headphones</h3>
                                            <p class="text-gray-500 text-sm mt-1">Color: White</p>
                                        </div>
                                        <button class="text-gray-400 hover:text-red-500 transition">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="flex items-center border border-gray-200 rounded-md w-fit">
                                            <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition">-</button>
                                            <span class="px-4 py-1 text-center w-12">1</span>
                                            <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition">+</button>
                                        </div>
                                        <div class="font-bold text-gray-800">$89.99</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    
                    <!-- Empty Cart State (Hidden) -->
                    <!-- <div id="empty-cart" class="hidden p-8 text-center">
                        <div class="empty-cart-icon text-gray-300 mb-4">
                            <i class="fas fa-shopping-cart text-6xl"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-700 mb-2">Your cart is empty</h3>
                        <p class="text-gray-500 mb-6">Looks like you haven't added anything to your cart yet</p>
                        <a href="#" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Continue Shopping</a>
                    </div> -->
                </div>
                
            </div>
        </div>
    </main>

</body>