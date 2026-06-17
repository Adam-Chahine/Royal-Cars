const header = document.getElementById('header');
const mobileMenuBtn = document.getElementById('menuBtn');
const navLinks = document.getElementById('navLinks');

if (mobileMenuBtn && navLinks) {
    mobileMenuBtn.addEventListener('click', () => {
        const isActive = navLinks.classList.toggle('active');
        mobileMenuBtn.innerHTML = isActive ?
            '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    Object.assign(progressBar.style, {
        position: 'fixed', top: '0', left: '0', height: '4px',
        backgroundColor: '#ff4d30', zIndex: '9999', width: '0'
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

    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    if (contactForm) {
        contactForm.addEventListener('submit', () => {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.style.opacity = "0.7";
        });
    }

    window.addEventListener('scroll', () => {
        const winScroll = window.pageYOffset || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;

        progressBar.style.width = scrolled + '%';

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

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.contact-info, .contact-form, footer, section').forEach(el => observer.observe(el));

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