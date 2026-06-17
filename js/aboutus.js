// 1. Déclarations
const header = document.getElementById('header');
const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
const navLinks = document.querySelector('.nav-links');

// 2. Menu Mobile
if (mobileMenuBtn && navLinks) {
    mobileMenuBtn.addEventListener('click', () => {
        const isActive = navLinks.classList.toggle('active');
        mobileMenuBtn.innerHTML = isActive ?
            '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
    });
}

// 3. Smooth Scrolling & Éléments Dynamiques
document.addEventListener('DOMContentLoaded', () => {

    // Navigation fluide
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });

                // Fermeture menu mobile
                if (navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                }
            }
        });
    });


    // 4. Création Progress Bar & Back to Top
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    Object.assign(progressBar.style, {
        position: 'fixed', top: '0', left: '0', height: '4px',
        backgroundColor: '#ff4d30', zIndex: '9999', width: '0', transition: 'width 0.1s'
    });
    document.body.appendChild(progressBar);

    const backToTopBtn = document.createElement('button');
    backToTopBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    Object.assign(backToTopBtn.style, {
        position: 'fixed', bottom: '30px', right: '30px', width: '50px', height: '50px',
        backgroundColor: '#ff4d30', color: 'white', border: 'none', borderRadius: '50%',
        cursor: 'pointer', opacity: '0', visibility: 'hidden', transition: '0.3s',
        zIndex: '999', display: 'flex', alignItems: 'center', justifyContent: 'center'
    });
    document.body.appendChild(backToTopBtn);

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // 5. Scroll Event (Unique)
    window.addEventListener('scroll', () => {
        const winScroll = window.pageYOffset || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;

        progressBar.style.width = scrolled + '%';

        // Header & Back to Top visibility
        if (winScroll > 100) {
            header?.classList.add('scrolled');
        } else {
            header?.classList.remove('scrolled');
        }

        if (winScroll > 300) {
            backToTopBtn.style.opacity = '1';
            backToTopBtn.style.visibility = 'visible';
        } else {
            backToTopBtn.style.opacity = '0';
            backToTopBtn.style.visibility = 'hidden';
        }
    });

    // 6. Animations au scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('section').forEach(section => observer.observe(section));

    // 7. Flip Cards Centralisé
    const cardsToFlip = document.querySelectorAll('.value-card, .gallery-item, .vision-card, .feature-card');
    cardsToFlip.forEach(card => {
        card.addEventListener('click', function () {
            const inner = this.querySelector('.vision-card-inner') || this;
            inner.classList.toggle('flipped');
        });
    });
});