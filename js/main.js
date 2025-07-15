// Mobile Menu Toggle
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
    
mobileMenuButton.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
});
        
// Back to Top Button
const backToTopButton = document.getElementById('back-to-top');
        
window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        backToTopButton.classList.remove('hidden');
    } else {
        backToTopButton.classList.add('hidden');
    }
});
        
backToTopButton.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
        
// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
                
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
                    
            // Close mobile menu if open
            mobileMenu.classList.add('hidden');
        }
    });
});
        
// Add fade-in animation to elements as they come into view
const fadeElements = document.querySelectorAll('.fade-in');
        
const fadeInObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-fadeIn');
        }
    });
}, {
    threshold: 0.1
});
        
fadeElements.forEach(element => {
    fadeInObserver.observe(element);
});

// Hero Slider Functionality
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.slider-dot');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');
let currentSlide = 0;
let slideInterval;

// Initialize the slider
function initSlider() {
    if (slides.length === 0) return;
            
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
            
    // Start auto slide
    startAutoSlide();
}

// Show a specific slide
function showSlide(index) {
    // Reset all slides and dots
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
            
    // Set new current slide
    currentSlide = (index + slides.length) % slides.length;
            
    // Show new slide and dot
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
}

// Next slide
function nextSlide() {
    showSlide(currentSlide + 1);
}

// Previous slide
function prevSlide() {
    showSlide(currentSlide - 1);
}

// Start auto sliding
function startAutoSlide() {
    clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, 5000);
}

// Event listeners
prevBtn.addEventListener('click', () => {
    prevSlide();
    startAutoSlide(); // Reset timer on manual navigation
});

nextBtn.addEventListener('click', () => {
    nextSlide();
    startAutoSlide(); // Reset timer on manual navigation
});

// Dot navigation
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        showSlide(index);
        startAutoSlide(); // Reset timer on manual navigation
    });
});

// Initialize the slider when the page loads
window.addEventListener('load', initSlider);

//
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.category-slide');
    const dots = document.querySelectorAll('.slider-dot2');
    let currentSlide = 0;
            
    // Initialize slider
    function initSlider() {
        showSlide(currentSlide);
        updateButtons();
    }
            
            
    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
                
        currentSlide = index;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
                
        updateButtons();
    }
            
    // Next slide
    function nextSlide() {
        let newIndex = currentSlide + 1;
        if (newIndex >= slides.length) newIndex = 0;
        showSlide(newIndex);
    }
            
    // Previous slide
    function prevSlide() {
        let newIndex = currentSlide - 1;
        if (newIndex < 0) newIndex = slides.length - 1;
        showSlide(newIndex);
    }
            
    // Update button states
    function updateButtons() {
        prevBtn.classList.toggle('disabled', currentSlide === 0);
        nextBtn.classList.toggle('disabled', currentSlide === slides.length - 1);
    }
            
    // Event listeners
    prevBtn.addEventListener('click', () => {
        if (!prevBtn.classList.contains('disabled')) {
            prevSlide();
        }
    });
            
    nextBtn.addEventListener('click', () => {
        if (!nextBtn.classList.contains('disabled')) {
            nextSlide();
        }
    });
            
    // Dot navigation
    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            const slideIndex = parseInt(this.getAttribute('data-slide'));
            showSlide(slideIndex);
        });
    });
            
    // Initialize the slider
    initSlider();
            
    // Auto-advance slides (optional)
    // let slideInterval = setInterval(nextSlide, 5000);
            
    // // Pause auto-advance on hover
    // const sliderContainer = document.querySelector('.relative');
    // sliderContainer.addEventListener('mouseenter', () => {
    //     clearInterval(slideInterval);
    // });
            
    // sliderContainer.addEventListener('mouseleave', () => {
    //     slideInterval = setInterval(nextSlide, 5000);
    // });
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
