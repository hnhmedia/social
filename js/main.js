// FAQ Accordion
document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
        const faqItem = button.parentElement;
        const isActive = faqItem.classList.contains('active');
        
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });
        
        if (!isActive) {
            faqItem.classList.add('active');
        }
    });
});

// Platform card selection
document.querySelectorAll('.platform-card').forEach(card => {
    card.addEventListener('click', () => {
        document.querySelectorAll('.platform-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
    });
});

// Dropdown menus - click functionality for mobile
document.querySelectorAll('.account-dropdown, .lang-dropdown').forEach(dropdown => {
    dropdown.addEventListener('click', (e) => {
        e.stopPropagation();
        // Close other dropdowns
        document.querySelectorAll('.account-dropdown, .lang-dropdown').forEach(d => {
            if (d !== dropdown) d.classList.remove('active');
        });
        dropdown.classList.toggle('active');
    });
});

// Close dropdowns when clicking outside
document.addEventListener('click', () => {
    document.querySelectorAll('.account-dropdown, .lang-dropdown').forEach(dropdown => {
        dropdown.classList.remove('active');
    });
});

// Prevent menu click from closing dropdown
document.querySelectorAll('.account-menu, .lang-menu').forEach(menu => {
    menu.addEventListener('click', (e) => {
        e.stopPropagation();
    });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Navbar background on scroll
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.08)';
        } else {
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            navbar.style.boxShadow = 'none';
        }
    }
});
