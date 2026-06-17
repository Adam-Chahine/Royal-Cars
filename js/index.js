// Smooth Scrolling for All Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        if (targetId === '#') return;

        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80, // Adjust for header height
                behavior: 'smooth'
            });

            // Close mobile menu if open
            if (navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
            }
        }
    });
});

// Scroll Progress Indicator
const progressBar = document.createElement('div');
progressBar.style.position = 'fixed';
progressBar.style.top = '0';
progressBar.style.left = '0';
progressBar.style.height = '4px';
progressBar.style.backgroundColor = '#ff4d30';
progressBar.style.zIndex = '9999';
progressBar.style.width = '0';
document.body.appendChild(progressBar);

// Scroll Spy for Sections
const sections = document.querySelectorAll('section');
const navItems = document.querySelectorAll('.nav-links a');

// Intersection Observer for Scroll Animations
const observerOptions = {
    threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Add animation class
            entry.target.classList.add('animate-in');

            // Highlight corresponding nav item
            const id = entry.target.getAttribute('id');
            if (id) {
                navItems.forEach(item => {
                    item.classList.remove('active');
                    if (item.getAttribute('href') === `#${id}`) {
                        item.classList.add('active');
                    }
                });
            }
        }
    });
}, observerOptions);

sections.forEach(section => {
    observer.observe(section);
});

// Update progress bar on scroll
window.addEventListener('scroll', () => {
    // Progress bar
    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    progressBar.style.width = `${scrolled}%`;

    // Header effect (existing code)
    if (window.scrollY > 100) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }

    // Back to top button logic
    if (window.scrollY > 300) {
        backToTopBtn.style.opacity = '1';
        backToTopBtn.style.visibility = 'visible';
    } else {
        backToTopBtn.style.opacity = '0';
        backToTopBtn.style.visibility = 'hidden';
    }
});

// Back to Top Button
const backToTopBtn = document.createElement('button');
backToTopBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
backToTopBtn.style.position = 'fixed';
backToTopBtn.style.bottom = '30px';
backToTopBtn.style.right = '30px';
backToTopBtn.style.width = '50px';
backToTopBtn.style.height = '50px';
backToTopBtn.style.backgroundColor = '#ff4d30';
backToTopBtn.style.color = 'white';
backToTopBtn.style.border = 'none';
backToTopBtn.style.borderRadius = '50%';
backToTopBtn.style.cursor = 'pointer';
backToTopBtn.style.opacity = '0';
backToTopBtn.style.visibility = 'hidden';
backToTopBtn.style.transition = 'all 0.3s ease';
backToTopBtn.style.zIndex = '999';
backToTopBtn.style.display = 'flex';
backToTopBtn.style.alignItems = 'center';
backToTopBtn.style.justifyContent = 'center';
backToTopBtn.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
document.body.appendChild(backToTopBtn);

backToTopBtn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Mobile Menu Toggle
const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
const navLinks = document.querySelector('.nav-links');

mobileMenuBtn.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    mobileMenuBtn.innerHTML = navLinks.classList.contains('active') ?
        '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
});

// Header Scroll Effect (existing code)
const header = document.getElementById('header');

window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
        section {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }
        
        section.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        .timeline-item {
            transition-delay: 0.2s;
        }
        
        .value-card, .team-member, .gallery-item {
            transition-delay: 0.1s;
        }`;
document.head.appendChild(style);

document.addEventListener('DOMContentLoaded', function () {
    const featureCards = document.querySelectorAll('.feature-card');

    featureCards.forEach(card => {
        card.addEventListener('click', function () {
            this.classList.toggle('flipped');
        });
    });
});