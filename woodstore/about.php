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
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <img src="../images/logo.png" alt="TimberCraft Logo" class="h-20 w-auto mr-2">
                <h1 class="text-2xl font-bold text-amber-900">Timber<span class="text-amber-600">Craft</span></h1>
            </div>

            <nav class="hidden md:flex space-x-8">
                <a href="../woodstore/index.php" class="nav-link text-amber-900 hover:text-amber-700">Trang chủ</a>
                <a href="../woodstore/products.php" class="nav-link text-amber-900 hover:text-amber-700">Sản Phẩm</a>
                <a href="../woodstore/about.php" class="nav-link text-amber-900 hover:text-amber-700">Giới thiệu</a>
                <a href="../woodstore/checkout.php" class="nav-link text-amber-900 hover:text-amber-700">Đánh giá</a>
                <a href="../woodstore/contact.php" class="nav-link text-amber-900 hover:text-amber-700">Liên hệ</a>
            </nav>

            <div class="flex items-center space-x-4">
                <!-- Search Box -->
                <form action="search.php" method="GET" class="relative hidden md:block">
                    <input type="text" name="keyword" placeholder="Tìm kiếm..."
                        class="search-box bg-amber-50 border border-amber-200 rounded-full px-4 py-2 pr-10 w-full focus:outline-none focus:ring-2 focus:ring-amber-500">

                    <button type="submit" class="absolute right-3 top-2 text-amber-600">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <!-- Cart Icon -->
                <a href="cart.php" class="text-amber-900 hover:text-amber-700">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </a>

                <!-- User Icon -->
                <a href="check_login_redirect.php" class="text-amber-900 hover:text-amber-700">
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

    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-8 lg:mb-0 lg:pr-12">
                    <h2 class="text-3xl font-bold text-black mb-6">Câu chuyện của chúng tôi</h2>
                    <p class="text-gray-700 mb-4">
                        Được thành lập vào năm 1995, TimberCraft bắt đầu là một xưởng mộc nhỏ do gia đình sở hữu ở Tây Bắc Thái Bình Dương. Bắt đầu từ niềm đam mê chế biến gỗ chất lượng đã phát triển thành điểm đến hàng đầu cho các sản phẩm gỗ cao cấp.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Chúng tôi lấy gỗ từ các khu rừng bền vững và các nhà cung cấp có trách nhiệm, đảm bảo rằng mọi sản phẩm chúng tôi bán đều đáp ứng các tiêu chuẩn cao về chất lượng và trách nhiệm với môi trường.
                    </p>
                    <p class="text-gray-700 mb-6">
                        Đội ngũ thợ thủ công bậc thầy của chúng tôi mang đến nhiều thập kỷ kinh nghiệm cho mọi dự án, dù đó là đồ nội thất theo yêu cầu, sàn nhà hay đồ gỗ đặc biệt.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <!-- <div class="flex items-center">
                            <i class="fas fa-leaf text-green-600 text-2xl mr-2"></i>
                            <span class="font-semibold">Sustainable Sourcing</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-award text-amber-600 text-2xl mr-2"></i>
                            <span class="font-semibold">Award Winning</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-truck text-blue-600 text-2xl mr-2"></i>
                            <span class="font-semibold">N Nationwide Delivery</span>
                        </div> -->
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-lg overflow-hidden shadow-lg">
                            <img src="https://images.squarespace-cdn.com/content/v1/634818e10bc63a0035d44d3a/144f2b2c-3942-4ebf-b580-2dcdab1eb21b/Warriner-Leather-_Workshop-Studio.jpeg.jpg" alt="Workshop" class="w-full h-64 object-cover">
                        </div>
                        <div class="rounded-lg overflow-hidden shadow-lg mt-8">
                            <img src="https://images.squarespace-cdn.com/content/v1/5b06fb625cfd7959a8129113/1586377251136-LJ5OXUESWWGUDPXE4SEJ/A+traditional+firewood+stack+must+be+elevated+of+the+ground+to+prevent+moisture+from+infiltrating+the+pile" alt="Wood Stack" class="w-full h-64 object-cover">
                        </div>
                        <div class="rounded-lg overflow-hidden shadow-lg">
                            <img src="https://img.freepik.com/premium-photo/portrait-craftsman-standing-with-confidence-generative-ai_73899-7722.jpg" alt="Craftsman" class="w-full h-64 object-cover">
                        </div>
                        <div class="rounded-lg overflow-hidden shadow-lg mt-8">
                            <img src="" alt="Finished Product" class="w-full h-64 object-cover">
                        </div>
                    </div>
                </div>
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

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-amber-700 text-white w-12 h-12 rounded-full shadow-lg hidden">
        <i class="fas fa-arrow-up text-xl"></i>
    </button>

    <script src="../js/main.js"></script>
</body>
</html>