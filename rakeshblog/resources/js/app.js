import '../css/app.css';

/**
 * Main application entry point
 * Initializes all interactive features when DOM is fully loaded
 */
document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // NAVIGATION SYSTEM
    // ==========================================

    const header = document.querySelector('header');
    const navLinks = document.querySelectorAll('.nav-link');
    
    const isHomePage = ['/', '/home', ''].includes(window.location.pathname);

    if (isHomePage) {
        initializeHomePageNavigation();
    }

    /**
     * Initializes all navigation features specific to the home page
     * including smooth scrolling and active section highlighting
     */
    function initializeHomePageNavigation() {
        setupSmoothScrolling();
        setupActiveSectionTracking();
    }

    /**
     * Configures smooth scrolling for navigation links with hash targets
     * Handles offset calculation for fixed header
     */
    function setupSmoothScrolling() {
        navLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                
                // Skip if link doesn't target a section
                if (!href || !href.includes('#')) {
                    return;
                }

                const targetId = href.split('#')[1];
                const target = document.getElementById(targetId);

                if (!target) {
                    return;
                }

                e.preventDefault();

                const headerHeight = header?.offsetHeight || 80;
                const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

                setActiveNav(this);
            });
        });
    }

    /**
     * Tracks scroll position and updates active navigation link
     * based on which section is currently in viewport
     */
    function setupActiveSectionTracking() {
        const sections = document.querySelectorAll('section[id]');

        function updateActiveSection() {
            const headerHeight = header?.offsetHeight || 80;
            let currentSection = 'home';

            sections.forEach(section => {
                const sectionTop = section.offsetTop - headerHeight - 100;
                if (window.scrollY >= sectionTop) {
                    currentSection = section.id;
                }
            });

            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (!href || !href.includes('#')) {
                    return;
                }

                const sectionId = href.split('#')[1];
                if (sectionId === currentSection) {
                    setActiveNav(link);
                }
            });
        }

        window.addEventListener('scroll', updateActiveSection, { passive: true });
        updateActiveSection(); // Initial state
    }


    // ==========================================
    // NAVIGATION HELPERS
    // ==========================================

    /**
     * Updates the active state of navigation links
     * Removes active classes from all links and applies them to the clicked link
     * 
     * @param {HTMLElement} activeLink - The navigation link to set as active
     */
    function setActiveNav(activeLink) {
        const activeClasses = ['active', 'border-b-2', 'border-[#D4AF37]', 'text-[#D4AF37]', 'pb-1'];
        
        navLinks.forEach(link => {
            link.classList.remove(...activeClasses);
        });

        if (activeLink) {
            activeLink.classList.add(...activeClasses);
        }
    }


    // ==========================================
    // AUTHENTICATION FEATURES
    // ==========================================

    /**
     * Handles OTP (One-Time Password) resend functionality
     * Manages button state and form submission with AJAX
     */
    initializeOTPResend();

    function initializeOTPResend() {
        const resendForm = document.getElementById('resendForm');
        if (!resendForm) return;

        resendForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const btn = document.getElementById('resendBtn');
            const originalText = btn?.textContent || 'Resend OTP';

            // Disable button during request
            if (btn) {
                btn.textContent = 'Sending...';
                btn.disabled = true;
                Object.assign(btn.style, {
                    opacity: '0.6',
                    cursor: 'not-allowed'
                });
            }

            const formData = new FormData(form);
            const csrfToken = document.querySelector('input[name="_token"]')?.value || '';

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || (data.success ? 'OTP sent successfully!' : 'Failed to send OTP. Please try again.'));
            })
            .catch(error => {
                console.error('OTP Resend Error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                // Restore button state
                if (btn) {
                    btn.textContent = originalText;
                    btn.disabled = false;
                    Object.assign(btn.style, {
                        opacity: '1',
                        cursor: 'pointer'
                    });
                }
            });
        });
    }

    /**
     * Manages OTP input fields with automatic focus progression
     * Supports keyboard navigation, paste events, and combines inputs
     */
    initializeOTPInputs();

    function initializeOTPInputs() {
        const otpInputs = document.querySelectorAll('input[name="otp_parts[]"]');
        if (otpInputs.length === 0) return;

        otpInputs.forEach((input, index) => {
            // Auto-advance to next input on digit entry
            input.addEventListener('input', function () {
                if (this.value.length === 1 && index < otpInputs.length - 1) {
                    const nextInput = otpInputs[index + 1];
                    if (nextInput) nextInput.focus();
                }
                updateOtp();
            });

            // Handle backspace to navigate to previous input
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                    const previousInput = otpInputs[index - 1];
                    if (previousInput) previousInput.focus();
                }
            });

            // Handle paste events for OTP codes
            input.addEventListener('paste', function (e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                const digits = paste.replace(/\D/g, '').slice(0, 6);
                
                for (let i = 0; i < digits.length; i++) {
                    const targetInput = otpInputs[i];
                    if (targetInput) {
                        targetInput.value = digits[i];
                    }
                }
                
                const nextIndex = Math.min(digits.length, 5);
                if (nextIndex < otpInputs.length) {
                    otpInputs[nextIndex].focus();
                }
                
                updateOtp();
            });
        });
    }

    /**
     * Combines individual OTP input values into a single hidden field
     */
    function updateOtp() {
        let otp = '';
        document.querySelectorAll('input[name="otp_parts[]"]').forEach(input => {
            otp += input.value;
        });

        const combined = document.getElementById('otp_combined');
        if (combined) {
            combined.value = otp;
        }
    }


    // ==========================================
    // UI UTILITIES
    // ==========================================

    /**
     * Toggles password field visibility between text and password types
     * 
     * @param {string} fieldId - The ID of the password input field
     */
    window.togglePassword = function (fieldId) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    };


    // ==========================================
    // ACCESSIBILITY & USER EXPERIENCE
    // ==========================================

    /**
     * Closes dropdown menus when ESC key is pressed
     */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const dropdowns = document.querySelectorAll('.group .absolute');
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('opacity-100', 'visible');
                dropdown.classList.add('opacity-0', 'invisible');
            });
        }
    });

    /**
     * Closes dropdown menus when clicking outside
     */
    document.addEventListener('click', function (e) {
        const userMenu = document.querySelector('.group');
        if (!userMenu) return;

        if (!userMenu.contains(e.target)) {
            const dropdown = userMenu.querySelector('.absolute');
            if (dropdown) {
                dropdown.classList.remove('opacity-100', 'visible');
                dropdown.classList.add('opacity-0', 'invisible');
            }
        }
    });

}); 
// ==========================================
// SCROLL-TRIGGERED COUNT-UP ANIMATION
// ==========================================

(function() {
    // Wait for DOM to be ready
    const initCounter = function() {
        const counters = document.querySelectorAll('.counter');
        let started = false;
        let animationFrame = null;

        // Function to animate a single counter
        function animateCounter(counter) {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000; // 2 seconds
            const startTime = performance.now();
            const startValue = 0;

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function for smooth animation
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const currentValue = Math.floor(easeOutQuart * target);
                
                counter.textContent = currentValue;
                
                if (progress < 1) {
                    animationFrame = requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                    animationFrame = null;
                }
            }

            animationFrame = requestAnimationFrame(updateCounter);
        }

        // Function to check if element is in viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            const threshold = 100; // Start animation when element is 100px from viewport
            
            return rect.top <= windowHeight - threshold && rect.bottom >= threshold;
        }

        // Function to start counting
        function startCounting() {
            const section = document.getElementById('impact');
            if (!section) return;

            // Check if section is visible
            if (isInViewport(section) && !started) {
                started = true;
                
                // Animate each counter with a delay
                counters.forEach((counter, index) => {
                    setTimeout(() => {
                        animateCounter(counter);
                    }, index * 200); // 200ms delay between each counter
                });
            }
        }

        // Throttle function for scroll events
        function throttle(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        }

        // Check on scroll with throttling
        const throttledStartCounting = throttle(startCounting, 200);

        // Add scroll listener
        window.addEventListener('scroll', throttledStartCounting, { passive: true });
        
        // Check on load
        window.addEventListener('load', function() {
            setTimeout(startCounting, 300);
        });

        // Also check on resize
        window.addEventListener('resize', throttledStartCounting, { passive: true });
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCounter);
    } else {
        initCounter();
    }
})();
// ==========================================
// BACK TO TOP BUTTON
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    const backToTopBtn = document.querySelector('.go-top-btn');
    if (!backToTopBtn) return;

    // Show/hide button on scroll
    window.addEventListener('scroll', function() {
        if (window.scrollY > 400) {
            backToTopBtn.classList.add('visible');
        } else {
            backToTopBtn.classList.remove('visible');
        }
    });

    // Scroll to top on click
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
