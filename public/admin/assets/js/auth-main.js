document.addEventListener('DOMContentLoaded', function() {
    // --- Password Toggle Functionality ---
    document.querySelectorAll('.password-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const passwordField = document.getElementById(targetId);

            if (passwordField) {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
                
            }
        });
    });

    // --- Form Page Load Animation ---
    const currentFormPanel = document.querySelector('.form-panel'); // Har page par ek hi form-panel hoga
    const transitionDuration = 500; // CSS transition duration ms mein

    if (currentFormPanel) {
        const entryDirection = sessionStorage.getItem('formEntryDirection');
        const isInitialLoad = !entryDirection; // Check if it's the very first load or refresh

        // Default to no transition for initial load or if no direction specified
        if (isInitialLoad) {
            currentFormPanel.style.transition = 'none';
            currentFormPanel.style.opacity = '1';
            currentFormPanel.style.visibility = 'visible';
            currentFormPanel.style.transform = 'translateX(0)';
        } else {
            // Apply initial state based on entry direction for animated entry
            if (entryDirection === 'left') {
                currentFormPanel.classList.add('entering-from-left');
            } else if (entryDirection === 'right') {
                currentFormPanel.classList.add('entering-from-right');
            }

            // Trigger animation
            // Use requestAnimationFrame for smoother initial render before animation
            requestAnimationFrame(() => {
                currentFormPanel.classList.add('active'); // Activate the panel
                // Re-enable transition after initial state is applied for animation
                currentFormPanel.style.transition = ''; // Remove inline transition override
            });

            // Clean up entering classes after animation completes
            setTimeout(() => {
                currentFormPanel.classList.remove('entering-from-left', 'entering-from-right');
                sessionStorage.removeItem('formEntryDirection'); // Clean up session storage
            }, transitionDuration + 50); // Small buffer
        }
    }

    // --- Page Navigation with Exit Animation ---
    document.querySelectorAll('.form-switch-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default navigation immediately
            const targetPage = this.getAttribute('href');
            const exitDirection = this.dataset.direction; // 'left' or 'right'

            if (currentFormPanel) {
                // Apply exiting class based on the direction we want it to leave
                if (exitDirection === 'left') {
                    currentFormPanel.classList.add('exiting-to-left');
                } else if (exitDirection === 'right') {
                    currentFormPanel.classList.add('exiting-to-right');
                }

                // Store the *incoming* direction for the next page
                // If this page exits left, the next page should enter from the right, and vice-versa
                sessionStorage.setItem('formEntryDirection', exitDirection === 'left' ? 'right' : 'left');

                // Navigate after the animation completes
                setTimeout(() => {
                    window.location.href = targetPage;
                }, transitionDuration);
            }
        });
    });


    // --- Image Slider Functionality (Remains the same) ---
    const slides = document.querySelectorAll('.slide');
    const dotsContainer = document.querySelector('.slider-dots');
    const dots = document.querySelectorAll('.dot');
    let currentSlide = 0;
    let slideInterval;
    const slideDuration = 3000; // 5 seconds for auto-slide

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            dots[i].classList.remove('active');
        });

        slides[index].classList.add('active');
        dots[index].classList.add('active');
        currentSlide = index;
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function startSlider() {
        slideInterval = setInterval(nextSlide, slideDuration);
    }

    function stopSlider() {
        clearInterval(slideInterval);
    }

    if (dotsContainer) {
        dotsContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('dot')) {
                const slideIndex = parseInt(event.target.dataset.slideIndex);
                if (!isNaN(slideIndex)) {
                    stopSlider();
                    showSlide(slideIndex);
                    startSlider();
                }
            }
        });
    }

    if (slides.length > 0) {
        showSlide(0);
        startSlider();
    }

    // Optional: Add a class to body after animation for scrollbar visibility
    setTimeout(() => {
        document.body.style.overflow = 'auto';
    }, 1000);
});