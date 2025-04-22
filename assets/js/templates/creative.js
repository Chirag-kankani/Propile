// Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            window.scrollTo({
                top: target.offsetTop - 80,
                behavior: 'smooth'
            });
        }
    });
});

// Animation on scroll
const animateElements = document.querySelectorAll('.hero-content, .about-grid, .timeline-item, .project-card, .contact-content, .contact-form');

function checkIfInView() {
    animateElements.forEach(element => {
        const rect = element.getBoundingClientRect();
        const windowHeight = window.innerHeight || document.documentElement.clientHeight;
        
        if (rect.top <= windowHeight * 0.75 && rect.bottom >= 0) {
            element.style.opacity = 1;
            element.style.transform = 'translateY(0)';
        }
    });
}

// Set initial styles
animateElements.forEach(element => {
    element.style.opacity = 0;
    element.style.transform = 'translateY(30px)';
    element.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
});

// Check elements on load
window.addEventListener('DOMContentLoaded', checkIfInView);

// Check elements on scroll
window.addEventListener('scroll', checkIfInView);

// Parallax effect for hero section
const heroSection = document.querySelector('.hero');
if (heroSection) {
    window.addEventListener('scroll', function() {
        const scrollPosition = window.pageYOffset;
        const shapes = document.querySelectorAll('.shape');
        
        shapes.forEach(shape => {
            const speed = shape.classList.contains('shape-1') ? 0.5 : 0.3;
            shape.style.transform = `translateY(${scrollPosition * speed}px)`;
        });
    });
}

// Form validation
const contactForm = document.querySelector('.contact-form form');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;
        const inputs = this.querySelectorAll('input, textarea');
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('invalid');
                
                // Add error message
                let errorMsg = input.parentElement.querySelector('.error-message');
                if (!errorMsg) {
                    errorMsg = document.createElement('p');
                    errorMsg.className = 'error-message';
                    errorMsg.textContent = 'This field is required';
                    errorMsg.style.color = '#e53e3e';
                    errorMsg.style.fontSize = '0.8rem';
                    errorMsg.style.marginTop = '4px';
                    input.parentElement.appendChild(errorMsg);
                }
            } else {
                input.classList.remove('invalid');
                const errorMsg = input.parentElement.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        });
        
        if (isValid) {
            alert('Form submitted successfully! (This is just a demo)');
            this.reset();
        }
    });
}

// Add style for invalid input
const style = document.createElement('style');
style.textContent = `
    .invalid {
        border-color: #e53e3e !important;
        box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.2) !important;
    }
`;
document.head.appendChild(style);