document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIconOpen = document.getElementById('menu-icon-open');
    const menuIconClose = document.getElementById('menu-icon-close');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
            
            if (isExpanded) {
                // ANIMASI MENUTUP
                mobileMenu.classList.add('opacity-0', '-translate-y-3');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
            } else {
                // ANIMASI MEMBUKA
                mobileMenu.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenu.classList.remove('opacity-0', '-translate-y-3');
                }, 10);
            }

            // Toggle icon
            menuIconOpen.classList.toggle('hidden');
            menuIconClose.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            const isClickInside = mobileMenuButton.contains(event.target) || mobileMenu.contains(event.target);
            
            if (!isClickInside && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                menuIconOpen.classList.remove('hidden');
                menuIconOpen.classList.add('block');
                menuIconClose.classList.add('hidden');
                menuIconClose.classList.remove('block');
            }
        });

        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                menuIconOpen.classList.remove('hidden');
                menuIconOpen.classList.add('block');
                menuIconClose.classList.add('hidden');
                menuIconClose.classList.remove('block');
            });
        });
    }
});
