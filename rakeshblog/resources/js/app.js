import '../css/app.css';

document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.nav-link');
    // Smooth scrolling ONLY on Home page
    if (window.location.pathname === '/' || window.location.pathname === '/home') {
        navLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                // Only intercept links that contain #
                if (href && href.includes('#')) {
                    e.preventDefault();
                    const targetId = href.split('#')[1];
                    const target = document.getElementById(targetId);
                    if (target) {
                        const headerHeight = document.querySelector('header').offsetHeight;
                        window.scrollTo({
                            top: target.offsetTop - headerHeight,
                            behavior: 'smooth'
                        });
                        navLinks.forEach(l =>
                            l.classList.remove(
                                'active',
                                'border-b-2',
                                'border-[#D4AF37]',
                                'text-[#D4AF37]'
                            )
                        );
                        this.classList.add(
                            'active',
                            'border-b-2',
                            'border-[#D4AF37]',
                            'text-[#D4AF37]'
                        );
                   }
                }
            });
        });

        // Active section while scrolling
        const sections = document.querySelectorAll('section[id]');
        window.addEventListener('scroll', function () {
            let current = '';
            const headerHeight = document.querySelector('header').offsetHeight;
            sections.forEach(section => {
                if (window.scrollY >= section.offsetTop - headerHeight - 100) {
                    current = section.id;
                }
            });

            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (!href.includes('#')) return;
                const id = href.split('#')[1];
                link.classList.remove(
                    'active',
                    'border-b-2',
                    'border-[#D4AF37]',
                    'text-[#D4AF37]'
                );
                if (id === current) {
                    link.classList.add(
                        'active',
                        'border-b-2',
                        'border-[#D4AF37]',
                        'text-[#D4AF37]'
                    );
                }
            });
        });
    }
});