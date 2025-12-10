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
    // Carousel functionality
        let currentIndex = 0;
        const carousel = document.getElementById('gallery-carousel');
        const dots = document.querySelectorAll('.carousel-dot');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');

        if (carousel && dots.length > 0) {
            const totalSlides = dots.length;

            function updateCarousel() {
                carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
                
                // Update dots
                dots.forEach((dot, index) => {
                    if (index === currentIndex) {
                        dot.classList.add('bg-indigo-600', 'w-8');
                        dot.classList.remove('bg-gray-600', 'w-3');
                    } else {
                        dot.classList.remove('bg-indigo-600', 'w-8');
                        dot.classList.add('bg-gray-600', 'w-3');
                    }
                });
            }

            function nextSlide() {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
            }

            function prevSlide() {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }

            // Button event listeners
            if (nextBtn) {
                nextBtn.addEventListener('click', nextSlide);
            }
            
            if (prevBtn) {
                prevBtn.addEventListener('click', prevSlide);
            }

            // Dot click handlers
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentIndex = index;
                    updateCarousel();
                });
            });

            // Auto-play carousel
            setInterval(nextSlide, 5000);
        }

        // Intersection Observer for scroll animations
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, observerOptions);

        // Observe all animated sections
        const animatedSections = document.querySelectorAll('.gallery-section, .blog-section, .leadership-section');
        animatedSections.forEach(section => {
            if (section) {
                observer.observe(section);
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
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