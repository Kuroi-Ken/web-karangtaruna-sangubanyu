// public/js/home.js

// Smooth scroll to content when clicking scroll indicator
document.addEventListener('DOMContentLoaded', function() {
    const scrollIndicator = document.querySelector('a[href="#content"]');
    
    if (scrollIndicator) {
        scrollIndicator.addEventListener('click', (e) => {
            e.preventDefault();

            // Find the content section
            const target = document.querySelector('#content');

            if (target) {
                // Scroll to element with offset (navbar height = 64px + 20px margin)
                window.scrollTo({
                    top: target.offsetTop - 84,
                    behavior: 'smooth',
                });
            }
        });
    }
});

// Intersection Observer for scroll reveal animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        // Check if the element is in the viewport
        if (entry.isIntersecting) {
            entry.target.classList.add('show'); // Add 'show' class to trigger transition
            observer.unobserve(entry.target); // Stop observing after it becomes visible
        }
    });
}, {
    threshold: 0.3, // Trigger when 30% of the element is in view
    rootMargin: '0px 0px -50px 0px' // Trigger slightly before element fully enters viewport
});

// Observe all sections that need scroll reveal animation
document.addEventListener('DOMContentLoaded', function() {
    const elementsToObserve = document.querySelectorAll(
        '.scroll-reveal, .gallery-section, .blog-section, .section-animate'
    );
    
    elementsToObserve.forEach((element) => {
        // Add initial hidden state
        element.style.opacity = '0';
        element.style.transform = 'translateY(50px)';
        element.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
        
        // Start observing
        observer.observe(element);
    });
});

// Carousel functionality
document.addEventListener('DOMContentLoaded', function() {
    let currentSlide = 0;
    const carousel = document.getElementById('gallery-carousel');
    const slides = carousel?.children.length || 0;
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const dots = document.querySelectorAll('.carousel-dot');

    function updateCarousel() {
        if (carousel && slides > 0) {
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
    }

    // Previous button
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + slides) % slides;
            updateCarousel();
        });
    }

    // Next button
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % slides;
            updateCarousel();
        });
    }

    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            updateCarousel();
        });
    });

    // Auto-play carousel every 5 seconds
    if (slides > 1) {
        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides;
            updateCarousel();
        }, 5000);
    }
});

// Add keyboard navigation for carousel
document.addEventListener('keydown', function(e) {
    const carousel = document.getElementById('gallery-carousel');
    if (!carousel) return;

    const slides = carousel.children.length;
    let currentSlide = Math.round(Math.abs(parseInt(carousel.style.transform?.match(/-?\d+/)?.[0] || 0) / 100));

    if (e.key === 'ArrowLeft') {
        currentSlide = (currentSlide - 1 + slides) % slides;
        carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
        updateDots(currentSlide);
    } else if (e.key === 'ArrowRight') {
        currentSlide = (currentSlide + 1) % slides;
        carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
        updateDots(currentSlide);
    }
});

// Helper function to update dots
function updateDots(currentIndex) {
    const dots = document.querySelectorAll('.carousel-dot');
    dots.forEach((dot, index) => {
        if (index === currentIndex) {
            dot.classList.add('bg-indigo-600', 'w-8');
            dot.classList.remove('bg-gray-600');
        } else {
            dot.classList.remove('bg-indigo-600', 'w-8');
            dot.classList.add('bg-gray-600');
        }
    });
}

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