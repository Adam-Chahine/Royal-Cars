document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('header');
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');

    // 1. Menu Mobile
    if (mobileMenuBtn && navLinks) {
        mobileMenuBtn.addEventListener('click', () => {
            const isActive = navLinks.classList.toggle('active');
            mobileMenuBtn.innerHTML = isActive ?
                '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        });
    }

    // 2. Barre de progression (Rouge en haut)
    const progressBar = document.createElement('div');
    Object.assign(progressBar.style, {
        position: 'fixed', top: '0', left: '0', height: '4px',
        backgroundColor: '#ff4d30', zIndex: '9999', width: '0', transition: 'width 0.1s'
    });
    document.body.appendChild(progressBar);

    // 3. Bouton Retour en haut
    const backToTopBtn = document.createElement('button');
    backToTopBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    Object.assign(backToTopBtn.style, {
        position: 'fixed', bottom: '30px', right: '30px', width: '50px', height: '50px',
        backgroundColor: '#ff4d30', color: 'white', border: 'none', borderRadius: '50%',
        cursor: 'pointer', opacity: '0', visibility: 'hidden', transition: '0.3s',
        zIndex: '999', display: 'flex', alignItems: 'center', justifyContent: 'center',
        boxShadow: '0 5px 15px rgba(0,0,0,0.2)'
    });
    document.body.appendChild(backToTopBtn);

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // 4. Scroll Events (Header + Progress + Button)
    window.addEventListener('scroll', () => {
        const winScroll = window.scrollY;
        const height = document.documentElement.scrollHeight - window.innerHeight;
        const scrolled = (winScroll / height) * 100;

        progressBar.style.width = scrolled + '%';
        header?.classList.toggle('scrolled', winScroll > 50);

        if (winScroll > 400) {
            backToTopBtn.style.opacity = '1';
            backToTopBtn.style.visibility = 'visible';
        } else {
            backToTopBtn.style.opacity = '0';
            backToTopBtn.style.visibility = 'hidden';
        }
    });

    // 5. Animations d'apparition (Seulement pour les cartes de police)
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, { threshold: 0.1 });

    // On applique l'animation uniquement aux cartes et au banner
    document.querySelectorAll('.policy-card, .warning-banner').forEach(el => {
        el.style.opacity = "0";
        el.style.transform = "translateY(30px)";
        el.style.transition = "all 0.6s ease-out";
        observer.observe(el);
    });

    document.querySelectorAll('.nav-links a').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId.startsWith('#')) {
                e.preventDefault();
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            }
            if (navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
                mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });
    });
});