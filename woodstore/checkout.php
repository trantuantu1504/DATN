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
        .star-rating {
            direction: rtl;
            display: inline-block;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            color: #cbd5e0;
            font-size: 24px;
            padding: 0 2px;
            cursor: pointer;
        }

        .star-rating label:hover,
        .star-rating label:hover~label,
        .star-rating input[type="radio"]:checked~label {
            color: #f59e0b;
        }

        .animate-bounce-in {
            animation: bounceIn 0.5s;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.9);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
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
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Customer Reviews</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Share your experience with our product and read what others have to say</p>
            <div class="mt-4 flex items-center justify-center">
                <div class="flex items-center mr-4">
                    <div class="text-yellow-400 flex">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="ml-2 text-gray-700">4.5/5</span>
                </div>
                <span class="text-gray-500">•</span>
                <span class="ml-4 text-gray-700">128 Reviews</span>
            </div>
        </header>

        <!-- Review Form -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Write a Review</h2>
            <form id="reviewForm" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (optional)</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5" />
                        <label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                    </div>
                </div>
                <div>
                    <label for="review" class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                    <textarea id="review" name="review" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required></textarea>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="recommend" name="recommend" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="recommend" class="ml-2 block text-sm text-gray-700">I recommend this product</label>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300">
                    Submit Review
                </button>
            </form>
        </div>

        <!-- Reviews List -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Customer Reviews</h2>
                <div class="relative">
                    <select id="sortReviews" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="newest">Newest First</option>
                        <option value="highest">Highest Rated</option>
                        <option value="lowest">Lowest Rated</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>

            <div id="reviewsContainer" class="space-y-6">
                <!-- Review cards will be dynamically added here -->
            </div>

            <div class="mt-8 flex justify-center">
                <button id="loadMore" class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 transition duration-300">
                    Load More Reviews
                </button>
            </div>
        </div>
    </div>



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
        document.addEventListener('DOMContentLoaded', function() {
            // Sample review data
            const reviews = [{
                    id: 1,
                    name: "Alex Johnson",
                    rating: 5,
                    date: "2023-06-15",
                    review: "Absolutely love this product! It exceeded all my expectations. The quality is outstanding and it arrived earlier than expected. Will definitely purchase again.",
                    recommend: true
                },
                {
                    id: 2,
                    name: "Sarah Miller",
                    rating: 4,
                    date: "2023-06-10",
                    review: "Very good product overall. The only reason I'm not giving 5 stars is because the color was slightly different than shown in the pictures. Otherwise, great quality.",
                    recommend: true
                },
                {
                    id: 3,
                    name: "Michael Chen",
                    rating: 3,
                    date: "2023-06-05",
                    review: "It's an okay product. Does what it's supposed to but nothing extraordinary. The price seems a bit high for what you get.",
                    recommend: false
                },
                {
                    id: 4,
                    name: "Emily Wilson",
                    rating: 5,
                    date: "2023-05-28",
                    review: "This is my second purchase and I'm just as happy as the first time! The customer service is excellent and the product is durable. Highly recommend!",
                    recommend: true
                },
                {
                    id: 5,
                    name: "David Thompson",
                    rating: 2,
                    date: "2023-05-20",
                    review: "Unfortunately, the product arrived damaged. Customer service was helpful in resolving the issue, but it was still disappointing.",
                    recommend: false
                }
            ];

            // Display initial reviews
            displayReviews(reviews);

            // Form submission
            const reviewForm = document.getElementById('reviewForm');
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const name = document.getElementById('name').value;
                const rating = document.querySelector('input[name="rating"]:checked').value;
                const reviewText = document.getElementById('review').value;
                const recommend = document.getElementById('recommend').checked;

                const newReview = {
                    id: reviews.length + 1,
                    name: name,
                    rating: parseInt(rating),
                    date: new Date().toISOString().split('T')[0],
                    review: reviewText,
                    recommend: recommend
                };

                reviews.unshift(newReview);
                displayReviews(reviews);

                // Reset form
                reviewForm.reset();

                // Show success message
                alert('Thank you for your review!');
            });

            // Sort reviews
            const sortSelect = document.getElementById('sortReviews');
            sortSelect.addEventListener('change', function() {
                const sortValue = this.value;
                let sortedReviews = [...reviews];

                if (sortValue === 'newest') {
                    sortedReviews.sort((a, b) => new Date(b.date) - new Date(a.date));
                } else if (sortValue === 'highest') {
                    sortedReviews.sort((a, b) => b.rating - a.rating);
                } else if (sortValue === 'lowest') {
                    sortedReviews.sort((a, b) => a.rating - b.rating);
                }

                displayReviews(sortedReviews);
            });

            // Load more reviews
            const loadMoreBtn = document.getElementById('loadMore');
            let displayedCount = 5;

            loadMoreBtn.addEventListener('click', function() {
                displayedCount += 5;
                displayReviews(reviews.slice(0, displayedCount));

                if (displayedCount >= reviews.length) {
                    loadMoreBtn.style.display = 'none';
                }
            });

            // Function to display reviews
            function displayReviews(reviewsToDisplay) {
                const reviewsContainer = document.getElementById('reviewsContainer');
                reviewsContainer.innerHTML = '';

                reviewsToDisplay.forEach(review => {
                    const reviewCard = document.createElement('div');
                    reviewCard.className = 'bg-white rounded-xl shadow-sm p-6 animate-bounce-in';

                    // Create stars HTML
                    let starsHTML = '';
                    for (let i = 1; i <= 5; i++) {
                        if (i <= review.rating) {
                            starsHTML += '<i class="fas fa-star text-yellow-400"></i>';
                        } else if (i - 0.5 <= review.rating) {
                            starsHTML += '<i class="fas fa-star-half-alt text-yellow-400"></i>';
                        } else {
                            starsHTML += '<i class="far fa-star text-yellow-400"></i>';
                        }
                    }

                    reviewCard.innerHTML = `
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-semibold text-lg text-gray-800">${review.name}</h3>
                                <div class="flex items-center mt-1">
                                    <div class="flex mr-2">
                                        ${starsHTML}
                                    </div>
                                    <span class="text-sm text-gray-500">${review.date}</span>
                                </div>
                            </div>
                            ${review.recommend ? 
                                '<span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Recommends</span>' : 
                                '<span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">Doesn\'t recommend</span>'}
                        </div>
                        <p class="text-gray-700 mt-3">${review.review}</p>
                        <div class="mt-4 flex space-x-4">
                            <button class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                <i class="far fa-thumbs-up mr-1"></i> Helpful
                            </button>
                            <button class="text-gray-500 hover:text-gray-700 text-sm flex items-center">
                                <i class="far fa-comment mr-1"></i> Comment
                            </button>
                        </div>
                    `;

                    reviewsContainer.appendChild(reviewCard);
                });

                // Show/hide load more button
                loadMoreBtn.style.display = reviewsToDisplay.length >= reviews.length ? 'none' : 'block';
            }
        });
    </script>
</body>

</html>