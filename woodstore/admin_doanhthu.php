<?php include 'db_connection.php'; ?>

<?php
// 1. Dữ liệu biểu đồ cột (Monthly Revenue)
$monthlyLabels = [];
$monthlyData = [];

// Khởi tạo mảng doanh thu mặc định với 0 cho các tháng từ 1 đến 12
$doanhThuTheoThang = array_fill(1, 12, 0);

// Lấy dữ liệu từ bảng donhang
$sql1 = "SELECT MONTH(Ngay) AS Thang, SUM(TongTien) AS DoanhThu
        FROM donhang
        GROUP BY Thang
        ORDER BY Thang";
$result1 = $conn->query($sql1);

while ($row = $result1->fetch_assoc()) {
    $thang = (int)$row['Thang'];
    $doanhThuTheoThang[$thang] = (float)$row['DoanhThu'];
}

// Tạo mảng label và data
foreach ($doanhThuTheoThang as $thang => $doanhThu) {
    $monthlyLabels[] = "Tháng " . $thang;
    $monthlyData[] = $doanhThu;
}


// 2. Dữ liệu biểu đồ tròn (Tổng doanh thu, số sản phẩm, số người dùng)
$categoryLabels = ['Đơn đặt hàng', 'Sản phẩm', 'Người dùng'];

// Doanh thu
$sqlDoanhThu = "SELECT SUM(ThanhTien) AS TongDoanhThu FROM chitietdonhang";
$resultDoanhThu = $conn->query($sqlDoanhThu);
$rowDoanhThu = $resultDoanhThu->fetch_assoc();
$tongDoanhThu = (float)$rowDoanhThu['TongDoanhThu'];

// Sản phẩm
$sqlSanPham = "SELECT COUNT(*) AS TongSP FROM sanpham";
$resultSanPham = $conn->query($sqlSanPham);
$rowSanPham = $resultSanPham->fetch_assoc();
$tongSanPham = (int)$rowSanPham['TongSP'];

// Người dùng
$sqlNguoiDung = "SELECT COUNT(*) AS TongKH FROM khachhang";
$resultNguoiDung = $conn->query($sqlNguoiDung);
$rowNguoiDung = $resultNguoiDung->fetch_assoc();
$tongNguoiDung = (int)$rowNguoiDung['TongKH'];

// Gán mảng dữ liệu cho biểu đồ
$categoryData = [30, 50, 20];

// 3. Giao dịch gần nhất
$sql3 = "SELECT dh.MaDH, kh.HoTen AS Customer, dh.Ngay, dh.TongTien
        FROM donhang dh
        JOIN khachhang kh ON dh.MaTK = kh.MaTK
        ORDER BY dh.Ngay DESC LIMIT 5";
$result3 = $conn->query($sql3);
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            position: relative;
            height: 300px;
            /* Hoặc 400px tùy nhu cầu */
            width: 100%;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .card-hover {
            transition: all 0.3s ease;
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


    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Bảng điều khiển doanh thu</h1>
                <p class="text-gray-600">Theo dõi và phân tích các nguồn doanh thu của bạn</p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-4">
                <div class="relative">
                    <select
                        class="appearance-none bg-white border border-gray-300 rounded-lg py-2 pl-4 pr-8 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Tháng này</option>
                        <option>Tháng trước</option>
                        <option>Quý này</option>
                        <option>Năm này</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-download mr-2"></i> Xuất khẩu
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Tổng doanh thu</p>
                        <h2 class="text-2xl font-bold text-gray-800">$48,256</h2>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-green-600 mt-2 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i> 0% từ tháng trước
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Khách hàng mới</p>
                        <h2 class="text-2xl font-bold text-gray-800">1,284</h2>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-green-600 mt-2 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i> 0% từ tháng trước
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Giá trị đơn hàng trung bình</p>
                        <h2 class="text-2xl font-bold text-gray-800">$124.50</h2>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-shopping-cart text-purple-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-red-600 mt-2 flex items-center">
                    <i class="fas fa-arrow-down mr-1"></i> 0% từ tháng trước
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Tỷ lệ chuyển đổi</p>
                        <h2 class="text-2xl font-bold text-gray-800">3.42%</h2>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-green-600 mt-2 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i> 0% từ tháng trước
                </p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Column Chart -->
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Doanh thu hàng tháng</h2>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-lg">Doanh thu</button>
                        <button class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Đơn hàng</button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="columnChart"></canvas>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Doanh thu theo danh mục</h2>
                    <div class="relative">
                        <select
                            class="appearance-none bg-gray-100 border-0 py-1 pl-3 pr-6 text-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option>Tháng này</option>
                            <option>Tháng trước</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
                <div class="chart-container" style="display: flex; justify-content: center; align-items: center;">
                    <canvas id="pieChart" ></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <!-- <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Recent Transactions</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#4567</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">John Smith</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">May 15, 2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">$245.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#4566</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Sarah Johnson</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">May 14, 2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">$189.50</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#4565</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Michael Brown</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">May 14, 2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">$320.75</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                <p class="text-sm text-gray-500">Showing <span class="font-medium">1</span> to <span
                        class="font-medium">3</span> of <span class="font-medium">24</span> results</p>
                <div class="flex space-x-2">
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Previous</button>
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Next</button>
                </div>
            </div>
        </div> -->
    </div>

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
        const columnChart = new Chart(document.getElementById('columnChart'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($monthlyLabels) ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?= json_encode($monthlyData) ?>,
                    backgroundColor: 'rgba(59,130,246,0.7)',
                    borderColor: 'rgba(59,130,246,1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '$' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => '$' + value.toLocaleString()
                        }
                    }
                }
            }
        });

        const pieChart = new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: <?= json_encode($categoryLabels) ?>,
                datasets: [{
                    data: <?= json_encode($categoryData) ?>,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)', // Doanh thu
                        'rgba(16, 185, 129, 0.7)', // Sản phẩm
                        'rgba(245, 158, 11, 0.7)', // Người dùng
                        'rgba(233, 73, 29, 0.7)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 0.7)', // Doanh thu
                        'rgba(16, 185, 129, 0.7)', // Sản phẩm
                        'rgba(245, 158, 11, 0.7)', // Người dùng
                        'rgba(233, 73, 29, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': $' + context.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>