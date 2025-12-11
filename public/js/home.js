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
    let currentSlide = 0;
    const carousel = document.getElementById('gallery-carousel');
    const slides = carousel?.children;
    const dots = document.querySelectorAll('.carousel-dot');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');

    function updateCarousel() {
        if (!carousel || !slides) return;
        carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        // Update dots
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.add('bg-indigo-600', 'w-8');
                dot.classList.remove('bg-gray-600', 'w-3');
            } else {
                dot.classList.remove('bg-indigo-600', 'w-8');
                dot.classList.add('bg-gray-600', 'w-3');
            }
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentSlide = currentSlide > 0 ? currentSlide - 1 : slides.length - 1;
            updateCarousel();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentSlide = currentSlide < slides.length - 1 ? currentSlide + 1 : 0;
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

    // Auto-advance carousel
    if (carousel && slides && slides.length > 1) {
        setInterval(() => {
            currentSlide = currentSlide < slides.length - 1 ? currentSlide + 1 : 0;
            updateCarousel();
        }, 5000);
    }

    // Scroll reveal animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all animated sections
    const animatedSections = document.querySelectorAll(
        '.gallery-section, .blog-section, .leadership-section, .contact-section'
    );

    animatedSections.forEach(section => {
        observer.observe(section);
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

