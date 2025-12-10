document.addEventListener('DOMContentLoaded', function() {
    const scrollIndicator = document.querySelector('a[href="#content"]');
    
    if (scrollIndicator) {
        scrollIndicator.addEventListener('click', (e) => {
            e.preventDefault();
            const target = document.querySelector('#content');
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 84,
                    behavior: 'smooth',
                });
            }
        });
    }
});

// Intersection Observer for scroll reveal animations (Gallery & Blog sections only)
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
            observer.unobserve(entry.target); // Stop observing after it becomes visible
        }
    });
}, {
    threshold: 0.2, 
    rootMargin: '0px 0px -50px 0px' 
});

document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.gallery-section, .blog-section');
    
    // Debug: Log found sections
    console.log('Found sections:', sections.length);
    
    sections.forEach((element) => {
        observer.observe(element);
        console.log('Observing:', element.className);
    });
    
    sections.forEach((element) => {
        const rect = element.getBoundingClientRect();
        const windowHeight = window.innerHeight || document.documentElement.clientHeight;
        
        if (rect.top < windowHeight && rect.bottom > 0) {
            console.log('Section already in viewport, showing immediately');
            element.classList.add('show');
        }
    });
});

// Carousel functionality - SIMPLIFIED & FIXED
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('gallery-carousel');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const dots = document.querySelectorAll('.carousel-dot');
    
    if (!carousel) return;
    
    const slides = carousel.children.length;
    let currentSlide = 0;
    let autoPlayInterval;

    // Main update function
    function updateCarousel() {
        if (slides === 0) return;
        
        // Update carousel position
        carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        // Update dots
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.add('bg-indigo-600', 'w-8');
                dot.classList.remove('bg-gray-600');
            } else {
                dot.classList.remove('bg-indigo-600', 'w-8');
                dot.classList.add('bg-gray-600');
            }
        });
    }

    // Previous button
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + slides) % slides;
            updateCarousel();
            resetAutoPlay();
        });
    }

    // Next button
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % slides;
            updateCarousel();
            resetAutoPlay();
        });
    }

    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            updateCarousel();
            resetAutoPlay();
        });
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!carousel) return;
        
        if (e.key === 'ArrowLeft') {
            currentSlide = (currentSlide - 1 + slides) % slides;
            updateCarousel();
            resetAutoPlay();
        } else if (e.key === 'ArrowRight') {
            currentSlide = (currentSlide + 1) % slides;
            updateCarousel();
            resetAutoPlay();
        }
    });

    // Auto-play functionality
    function startAutoPlay() {
        if (slides > 1) {
            autoPlayInterval = setInterval(() => {
                currentSlide = (currentSlide + 1) % slides;
                updateCarousel();
            }, 5000);
        }
    }

    function resetAutoPlay() {
        clearInterval(autoPlayInterval);
        startAutoPlay();
    }

    // Initialize
    updateCarousel();
    startAutoPlay();

    // Pause autoplay when user hovers over carousel
    if (carousel.parentElement) {
        carousel.parentElement.addEventListener('mouseenter', () => {
            clearInterval(autoPlayInterval);
        });
        
        carousel.parentElement.addEventListener('mouseleave', () => {
            startAutoPlay();
        });
    }
});

// Parallax effect for hero section
window.addEventListener('scroll', function() {
    const heroSection = document.querySelector('.h-screen');
    if (heroSection) {
        const scrolled = window.pageYOffset;
        const parallax = heroSection.querySelector('.absolute.inset-0');
        if (parallax && scrolled < window.innerHeight) {
            parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    }
});