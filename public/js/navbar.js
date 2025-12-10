document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIconOpen = document.getElementById('menu-icon-open');
    const menuIconClose = document.getElementById('menu-icon-close');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function () {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);

            if (isExpanded) {
                // TRANSISI MENUTUP LEBIH MULUS
                mobileMenu.classList.add('opacity-0', '-translate-y-3');
                mobileMenu.classList.remove('opacity-100', 'translate-y-0');

                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);

            } else {
                // TRANSISI MEMBUKA
                mobileMenu.classList.remove('hidden');

                // delay kecil agar browser bisa apply "hidden" → state visible sebelum animasi
                setTimeout(() => {
                    mobileMenu.classList.remove('opacity-0', '-translate-y-3');
                    mobileMenu.classList.add('opacity-100', 'translate-y-0');
                }, 10);
            }

            // Toggle icons
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
