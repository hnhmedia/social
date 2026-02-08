<!-- Contact Hero Section -->
<section class="contact-hero">
    <div class="hero-inner">
        <h1>Get in Touch with Famoid</h1>
        <p class="hero-subtitle">We're here to help you grow your social media presence. Reach out anytime!</p>
        
        <div class="contact-badges">
            <div class="contact-badge">
                <span>⚡</span>
                <span>Quick Response</span>
            </div>
            <div class="contact-badge">
                <span>🕐</span>
                <span>24/7 Support</span>
            </div>
            <div class="contact-badge">
                <span>🌍</span>
                <span>Worldwide Service</span>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Info Section -->
<section class="section contact-section">
    <div class="section-inner">
        <div class="contact-grid">
            <!-- Contact Form -->
            <div class="contact-form-container">
                <h2>Send us a Message</h2>
                <p style="color: var(--text-gray); margin-bottom: 2rem;">Fill out the form below and we'll get back to you within 24 hours.</p>
                
                <form class="contact-form" id="contactForm" method="POST" action="submit-contact.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Your Name *</label>
                            <input type="text" id="name" name="name" required placeholder="John Doe">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required placeholder="john@example.com">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="support">Technical Support</option>
                            <option value="billing">Billing Question</option>
                            <option value="partnership">Partnership Opportunity</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Your Message *</label>
                        <textarea id="message" name="message" rows="6" required placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg btn-full">
                        Send Message →
                    </button>
                </form>
            </div>
            
            <!-- Contact Information -->
            <div class="contact-info-container">
                <h2>Contact Information</h2>
                <p style="color: var(--text-gray); margin-bottom: 2rem;">Prefer to reach out directly? Here's how to contact us.</p>
                
                <div class="contact-info-items">
                    <div class="contact-info-item">
                        <div class="contact-info-icon">📧</div>
                        <div class="contact-info-content">
                            <h4>Email Us</h4>
                            <p>support@famoid.com</p>
                            <span class="contact-info-note">We typically respond within 24 hours</span>
                        </div>
                    </div>
                    
                    <div class="contact-info-item">
                        <div class="contact-info-icon">💬</div>
                        <div class="contact-info-content">
                            <h4>Live Chat</h4>
                            <p>Available 24/7</p>
                            <span class="contact-info-note">Click the chat icon in the bottom right</span>
                        </div>
                    </div>
                    
                    <div class="contact-info-item">
                        <div class="contact-info-icon">📱</div>
                        <div class="contact-info-content">
                            <h4>Social Media</h4>
                            <p>Follow us on Instagram & Twitter</p>
                            <span class="contact-info-note">@famoid</span>
                        </div>
                    </div>
                    
                    <div class="contact-info-item">
                        <div class="contact-info-icon">🕐</div>
                        <div class="contact-info-content">
                            <h4>Response Time</h4>
                            <p>Average: 2-4 hours</p>
                            <span class="contact-info-note">24/7 support team</span>
                        </div>
                    </div>
                </div>
                
                <!-- Trust Elements -->
                <div class="contact-trust">
                    <h3>Why Choose Famoid?</h3>
                    <ul class="contact-features">
                        <li>✓ 7+ years of experience</li>
                        <li>✓ 50,000+ happy customers</li>
                        <li>✓ 4.9/5 average rating</li>
                        <li>✓ Secure payment processing</li>
                        <li>✓ Money-back guarantee</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Quick Links -->
<section class="section" style="background: var(--bg-gray);">
    <div class="section-inner">
        <div class="section-header">
            <h2>Before You Contact Us</h2>
            <p>Check out our FAQ section - your question might already be answered!</p>
        </div>
        
        <div class="faq-quick-links">
            <a href="/frequently-asked-questions" class="faq-quick-card">
                <div class="faq-quick-icon">❓</div>
                <h4>View All FAQs</h4>
                <p>Browse our complete FAQ section</p>
            </a>
            <a href="/frequently-asked-questions#payment" class="faq-quick-card">
                <div class="faq-quick-icon">💳</div>
                <h4>Payment Questions</h4>
                <p>Payment methods & billing</p>
            </a>
            <a href="/frequently-asked-questions#delivery" class="faq-quick-card">
                <div class="faq-quick-icon">🚀</div>
                <h4>Delivery Info</h4>
                <p>Delivery times & process</p>
            </a>
        </div>
    </div>
</section>

<style>
/* Contact Hero */
.contact-hero {
    padding: 8rem 1.5rem 4rem;
    text-align: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.contact-badges {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.contact-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    backdrop-filter: blur(10px);
    font-weight: 600;
}

/* Contact Section */
.contact-section {
    padding: 4rem 1.5rem;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 4rem;
    max-width: 1200px;
    margin: 0 auto;
}

/* Contact Form */
.contact-form-container h2,
.contact-info-container h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.contact-form {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.9rem;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 1rem;
    font-family: inherit;
    transition: border-color 0.2s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-purple);
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

/* Contact Info */
.contact-info-items {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.contact-info-item {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: white;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s;
}

.contact-info-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(124, 58, 237, 0.1);
    border-color: var(--primary-purple);
}

.contact-info-icon {
    font-size: 2rem;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(236, 72, 153, 0.1) 100%);
    border-radius: 12px;
    flex-shrink: 0;
}

.contact-info-content h4 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: var(--text-dark);
}

.contact-info-content p {
    font-size: 0.95rem;
    color: var(--text-gray);
    margin-bottom: 0.25rem;
}

.contact-info-note {
    font-size: 0.85rem;
    color: var(--text-light);
}

/* Contact Trust */
.contact-trust {
    background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(236, 72, 153, 0.05) 100%);
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid rgba(124, 58, 237, 0.1);
}

.contact-trust h3 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-dark);
}

.contact-features {
    list-style: none;
    padding: 0;
    margin: 0;
}

.contact-features li {
    padding: 0.5rem 0;
    color: var(--text-gray);
    font-size: 0.95rem;
}

/* FAQ Quick Links */
.faq-quick-links {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    max-width: 900px;
    margin: 0 auto;
}

.faq-quick-card {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    text-align: center;
    border: 1px solid var(--border-color);
    transition: all 0.3s;
    text-decoration: none;
}

.faq-quick-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(124, 58, 237, 0.1);
    border-color: var(--primary-purple);
}

.faq-quick-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.faq-quick-card h4 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.faq-quick-card p {
    font-size: 0.9rem;
    color: var(--text-gray);
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .contact-hero {
        padding: 6rem 1.5rem 3rem;
    }
    
    .contact-badges {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .faq-quick-links {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.getElementById('contactForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // You can add AJAX submission here
    alert('Thank you for your message! We\'ll get back to you within 24 hours.');
    this.reset();
});
</script>
