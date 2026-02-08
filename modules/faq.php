<!-- FAQ Hero Section -->
<section class="faq-hero">
    <div class="hero-inner">
        <h1>Frequently Asked Questions</h1>
        <p class="hero-subtitle">Everything you need to know about Famoid's services</p>
        
        <!-- Search Box -->
        <div class="faq-search-box">
            <input type="text" id="faqSearch" placeholder="Search for answers..." />
            <button type="button" onclick="searchFAQ()">🔍 Search</button>
        </div>
    </div>
</section>

<!-- FAQ Categories -->
<section class="section faq-categories-section">
    <div class="section-inner">
        <div class="faq-categories">
            <button class="faq-category-btn active" onclick="filterFAQ('all')">
                <span class="category-icon">📋</span>
                <span>All Questions</span>
            </button>
            <button class="faq-category-btn" onclick="filterFAQ('general')">
                <span class="category-icon">ℹ️</span>
                <span>General</span>
            </button>
            <button class="faq-category-btn" onclick="filterFAQ('payment')">
                <span class="category-icon">💳</span>
                <span>Payment</span>
            </button>
            <button class="faq-category-btn" onclick="filterFAQ('delivery')">
                <span class="category-icon">🚀</span>
                <span>Delivery</span>
            </button>
            <button class="faq-category-btn" onclick="filterFAQ('safety')">
                <span class="category-icon">🔒</span>
                <span>Safety</span>
            </button>
            <button class="faq-category-btn" onclick="filterFAQ('support')">
                <span class="category-icon">💬</span>
                <span>Support</span>
            </button>
        </div>
    </div>
</section>

<!-- FAQ Content -->
<section class="section" id="faq">
    <div class="section-inner">
        <div class="faq-container">
            
            <!-- General Questions -->
            <div class="faq-section-header" data-category="general">
                <h2>General Questions</h2>
            </div>
            
            <div class="faq-item" data-category="general">
                <button class="faq-question">
                    What is Famoid?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Famoid is a leading social media marketing agency that has been helping individuals and businesses grow their social media presence since 2017. We provide high-quality followers, likes, views, and engagement for platforms like Instagram, TikTok, Facebook, and more.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="general">
                <button class="faq-question">
                    Are your services real and legitimate?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Yes! All our services are 100% real and legitimate. We deliver engagement from real, active accounts - not bots. We've been in business for over 7 years and have served more than 50,000 satisfied customers worldwide.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="general">
                <button class="faq-question">
                    Do I need to provide my password?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        No! We NEVER ask for your password. We only need your username or profile link to deliver the service. Anyone asking for your password is not legitimate. Your account security is our top priority.
                    </div>
                </div>
            </div>

            <!-- Payment Questions -->
            <div class="faq-section-header" data-category="payment" id="payment">
                <h2>Payment & Billing</h2>
            </div>

            <div class="faq-item" data-category="payment">
                <button class="faq-question">
                    What payment methods do you accept?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        We accept all major credit cards (Visa, Mastercard, American Express), debit cards, PayPal, Apple Pay, Google Pay, and cryptocurrency. All payments are processed through secure, PCI-compliant payment gateways.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="payment">
                <button class="faq-question">
                    Is my payment information secure?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Absolutely! We use industry-leading payment processors like Stripe and PayPal with 256-bit SSL encryption. We never store your credit card information on our servers. Your financial data is completely secure.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="payment">
                <button class="faq-question">
                    Do you offer refunds?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Yes! We offer a 30-day money-back guarantee. If you're not satisfied with our service or if we fail to deliver what you ordered, we'll provide a full refund. Please contact our support team to initiate a refund request.
                    </div>
                </div>
            </div>

            <!-- Delivery Questions -->
            <div class="faq-section-header" data-category="delivery" id="delivery">
                <h2>Delivery & Timeline</h2>
            </div>

            <div class="faq-item" data-category="delivery">
                <button class="faq-question">
                    How fast is the delivery?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Delivery typically starts within 60 seconds of placing your order! Most orders are completed within 1-24 hours, depending on the package size. Larger orders may take up to 72 hours for gradual, natural-looking delivery.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="delivery">
                <button class="faq-question">
                    What is gradual delivery?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Gradual delivery means we spread out the delivery of your order over a period of time (usually 24-72 hours) to make it look natural and organic. This is safer for your account and looks more authentic to your audience.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="delivery">
                <button class="faq-question">
                    Will followers/likes drop over time?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        We provide high-quality, real accounts, so drop rates are minimal (typically less than 5%). However, if you experience any significant drops within 30 days, we offer free refills. Just contact our support team!
                    </div>
                </div>
            </div>

            <!-- Safety Questions -->
            <div class="faq-section-header" data-category="safety" id="safety">
                <h2>Safety & Security</h2>
            </div>

            <div class="faq-item" data-category="safety">
                <button class="faq-question">
                    Is it safe for my account?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Yes! Our services are completely safe. We use organic, gradual delivery methods that comply with platform guidelines. We've never had a customer's account banned or suspended due to our services. We've been operating successfully for over 7 years.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="safety">
                <button class="faq-question">
                    Are the followers/likes from real people?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Yes! All our engagement comes from real, active accounts - never bots. These are genuine users who follow, like, or view your content. This ensures authenticity and protects your account.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="safety">
                <button class="faq-question">
                    Will anyone know I bought followers/likes?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        No! Our service is completely confidential. The followers and engagement we deliver look natural and organic. There's no way for anyone to tell you used our service. We maintain strict privacy and never disclose customer information.
                    </div>
                </div>
            </div>

            <!-- Support Questions -->
            <div class="faq-section-header" data-category="support" id="support">
                <h2>Customer Support</h2>
            </div>

            <div class="faq-item" data-category="support">
                <button class="faq-question">
                    How can I contact customer support?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        You can reach our 24/7 support team via email at support@famoid.com, through our live chat (bottom right corner), or by submitting a contact form on our Contact page. We typically respond within 2-4 hours.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="support">
                <button class="faq-question">
                    What if I have a problem with my order?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        If you experience any issues with your order, please contact our support team immediately. We offer free refills for drops, and we'll resolve any problems quickly. Our goal is 100% customer satisfaction!
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="support">
                <button class="faq-question">
                    Do you offer custom packages?
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Yes! If you need a custom package or have special requirements, please contact our support team. We can create tailored solutions for influencers, businesses, and agencies with specific needs.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Still Have Questions CTA -->
<section class="section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center;">
    <div class="section-inner">
        <h2 style="color: white; margin-bottom: 1rem;">Still Have Questions?</h2>
        <p style="font-size: 1.1rem; margin-bottom: 2rem; opacity: 0.9;">Our friendly support team is here to help 24/7</p>
        <a href="/contact" class="btn btn-lg" style="background: white; color: var(--primary-purple); box-shadow: 0 8px 24px rgba(0,0,0,0.2);">
            Contact Support →
        </a>
    </div>
</section>

<style>
/* FAQ Hero */
.faq-hero {
    padding: 8rem 1.5rem 4rem;
    text-align: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.faq-search-box {
    max-width: 600px;
    margin: 2rem auto 0;
    display: flex;
    gap: 0.5rem;
    background: white;
    padding: 0.5rem;
    border-radius: 50px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
}

.faq-search-box input {
    flex: 1;
    padding: 0.875rem 1.5rem;
    border: none;
    border-radius: 50px;
    font-size: 1rem;
    outline: none;
}

.faq-search-box button {
    padding: 0.875rem 2rem;
    background: var(--gradient-primary);
    color: white;
    border: none;
    border-radius: 50px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
}

.faq-search-box button:hover {
    transform: scale(1.05);
}

/* FAQ Categories */
.faq-categories-section {
    background: var(--bg-gray);
    padding: 2rem 1.5rem;
}

.faq-categories {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    max-width: 900px;
    margin: 0 auto;
}

.faq-category-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    color: var(--text-gray);
}

.faq-category-btn:hover,
.faq-category-btn.active {
    background: var(--gradient-primary);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
}

.category-icon {
    font-size: 1.2rem;
}

/* FAQ Section Headers */
.faq-section-header {
    margin: 3rem 0 1.5rem;
}

.faq-section-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-dark);
    padding-bottom: 1rem;
    border-bottom: 3px solid var(--primary-purple);
    display: inline-block;
}

/* FAQ Items */
.faq-item {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    margin-bottom: 1rem;
    overflow: hidden;
    transition: all 0.3s;
}

.faq-item:hover {
    border-color: var(--primary-purple);
    box-shadow: 0 4px 16px rgba(124, 58, 237, 0.1);
}

.faq-question {
    width: 100%;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: none;
    border: none;
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--text-dark);
    cursor: pointer;
    text-align: left;
    font-family: inherit;
}

.faq-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--bg-gray);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: var(--text-gray);
    transition: transform 0.2s;
    flex-shrink: 0;
}

.faq-item.active .faq-icon {
    transform: rotate(45deg);
    background: var(--primary-purple);
    color: white;
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.faq-item.active .faq-answer {
    max-height: 500px;
}

.faq-answer-inner {
    padding: 0 2rem 1.5rem;
    font-size: 1rem;
    color: var(--text-gray);
    line-height: 1.7;
}

/* Responsive */
@media (max-width: 768px) {
    .faq-hero {
        padding: 6rem 1.5rem 3rem;
    }
    
    .faq-search-box {
        flex-direction: column;
        border-radius: 16px;
    }
    
    .faq-search-box input,
    .faq-search-box button {
        border-radius: 12px;
    }
    
    .faq-categories {
        flex-direction: column;
    }
    
    .faq-category-btn {
        width: 100%;
        justify-content: center;
    }
    
    .faq-question {
        padding: 1.25rem 1.5rem;
        font-size: 1rem;
    }
    
    .faq-answer-inner {
        padding: 0 1.5rem 1.25rem;
    }
}
</style>

<script>
// FAQ Toggle
document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
        const faqItem = button.parentElement;
        const isActive = faqItem.classList.contains('active');
        
        // Close all FAQ items
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Open clicked item if it wasn't active
        if (!isActive) {
            faqItem.classList.add('active');
        }
    });
});

// FAQ Category Filter
function filterFAQ(category) {
    // Update active button
    document.querySelectorAll('.faq-category-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.closest('.faq-category-btn').classList.add('active');
    
    // Filter FAQ items
    const items = document.querySelectorAll('.faq-item, .faq-section-header');
    
    items.forEach(item => {
        if (category === 'all') {
            item.style.display = '';
        } else {
            if (item.dataset.category === category) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        }
    });
}

// FAQ Search
function searchFAQ() {
    const searchTerm = document.getElementById('faqSearch').value.toLowerCase();
    const items = document.querySelectorAll('.faq-item');
    
    items.forEach(item => {
        const question = item.querySelector('.faq-question').textContent.toLowerCase();
        const answer = item.querySelector('.faq-answer-inner').textContent.toLowerCase();
        
        if (question.includes(searchTerm) || answer.includes(searchTerm)) {
            item.style.display = '';
            if (searchTerm.length > 0) {
                item.classList.add('active');
            }
        } else {
            item.style.display = 'none';
        }
    });
}

// Enter key search
document.getElementById('faqSearch')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchFAQ();
    }
});
</script>
