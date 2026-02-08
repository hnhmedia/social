

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-inner">
            <h1>Buy Likes, Followers, Views and More to Fast-Track Your Social Proof 🔥</h1>
            <p class="hero-subtitle">Being popular in social media is not that difficult anymore. It's time to meet Famoid's excellent social media services.</p>

            <!-- Platform Cards -->
            <div class="platform-cards">
                <div class="platform-card active">
                    <div class="platform-icon instagram">📸</div>
                    <div class="platform-card-info">
                        <h3>Instagram</h3>
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span>5.0 · 3450+</span>
                        </div>
                    </div>
                </div>
                <div class="platform-card">
                    <div class="platform-icon tiktok">🎵</div>
                    <div class="platform-card-info">
                        <h3>TikTok</h3>
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span>5.0 · 2720+</span>
                        </div>
                    </div>
                </div>
                <div class="platform-card">
                    <div class="platform-icon facebook">👍</div>
                    <div class="platform-card-info">
                        <h3>Facebook</h3>
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span>5.0 · 2890+</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Links -->
            <div class="service-links">
                <a href="index.php?p=buy-instagram-followers" class="service-link">BUY INSTAGRAM FOLLOWERS</a>
                <a href="index.php?p=buy-instagram-likes" class="service-link">BUY INSTAGRAM LIKES</a>
                <a href="index.php?p=buy-instagram-views" class="service-link">BUY INSTAGRAM VIEWS</a>
                <a href="index.php?p=buy-tiktok-followers" class="service-link">BUY TIKTOK FOLLOWERS</a>
                <a href="index.php?p=buy-tiktok-likes" class="service-link">BUY TIKTOK LIKES</a>
            </div>

            <!-- Live Notification -->
            <div class="live-notification">
                <span class="stars">★★★★★</span>
                <span>1,000 Instagram followers delivered</span>
                <span class="live-dot"></span>
                <span class="time">43 mins ago</span>
            </div>

            <!-- Trust Badges -->
            <div class="trust-badges">
                <div class="trust-badge">
                    <span>🍎</span>
                    <span>Apple Pay</span>
                </div>
                <div class="trust-badge">
                    <span>🔒</span>
                    <span>Secure</span>
                </div>
                <div class="trust-badge">
                    <span>⚡</span>
                    <span>Fast</span>
                </div>
                <div class="trust-badge">
                    <span>🕐</span>
                    <span>24/7</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section features-section">
        <div class="section-inner">
            <div class="features-grid">
                <div class="features-content">
                    <h2>😍 Reliability and Fast Delivery</h2>
                    <p>At <strong>Famoid</strong>, we aim to change your views on social media services. You can use our services safely with secure payment options. We offer <strong>Natural & Gradual delivery</strong> to ensure a smooth experience.</p>
                    <p>Our team values Instant delivery and reliability. That's why our <strong>24/7 Active Support Team</strong> is always ready to help. We promise a full refund if any issue arises.</p>
                    <p>Try Famoid's services and see the difference for yourself. You won't regret it.</p>
                </div>
                <div class="features-image">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #faf5ff 0%, #fdf2f8 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 4rem;">
                        📱✨
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section">
        <div class="section-inner">
            <div class="section-header">
                <h2>👉 Famoid, Your Trusted Social Media Growth Expert 🤩</h2>
                <p>Famoid is here to reshape your perceptions of social media services. We focus on secure payments and gradual delivery. Our team is always ready to help, 24/7.</p>
                <p style="margin-top: 1rem;">With a full refund guarantee, you're protected. <strong>Try Famoid's services</strong> and see why we're <strong>America's No. 1 Social Media Marketing Agency</strong> since 2017.</p>
            </div>
            <div style="text-align: center;">
                <a href="#services" class="btn btn-primary btn-lg">Explore Our Services Now!</a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section testimonials-section">
        <div class="section-inner">
            <div class="section-header">
                <h2>🫡 At Famoid, Your Satisfaction Drives Our Excellence!</h2>
                <p>How do clients rate their experience with Famoid? Find out here!</p>
            </div>
            <div class="testimonials-track-wrapper">
                <div class="testimonials-track">
                    <?php
                    $testimonials = getFormattedTestimonials();
                    

                
                    
                    // Display testimonials twice for infinite scroll effect
                    for ($i = 0; $i < 2; $i++) {
                        foreach ($testimonials as $testimonial) {
                    ?>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/96?img=<?php echo $testimonial['img']; ?>" alt="<?php echo $testimonial['name']; ?>" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4><?php echo $testimonial['name']; ?></h4>
                                <span><?php echo $testimonial['date']; ?></span>
                            </div>
                            <span class="testimonial-verified">✓</span>
                        </div>
                        <p class="testimonial-text"><?php echo $testimonial['text']; ?></p>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Cards Section -->
    <section class="section">
        <div class="section-inner">
            <div class="info-grid">
                <div class="info-card">
                    <h3>🔒 Privacy & Safety</h3>
                    <p>We are deeply committed to Privacy and Safety. Our trusted platforms like Checkout & Nuvei make sure your transactions are secure. Your password is never asked for.</p>
                </div>
                <div class="info-card">
                    <h3>⭐ Experience</h3>
                    <p>With over 5 years in the industry, the Famoid team deeply understands the sector's needs. We're always adapting to meet these needs.</p>
                </div>
                <div class="info-card">
                    <h3>📈 Ad-Based Delivery</h3>
                    <p>At the core of what we do is timely delivery. We focus on gradual and organic delivery methods. This ensures your orders arrive quickly.</p>
                </div>
                <div class="info-card">
                    <h3>💬 24/7 Support</h3>
                    <p>Many claim to offer quality support, but our mission is to elevate your support experience before and after the sale. We're here for you from the start.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section" id="services">
        <div class="section-inner">
            <div class="services-header">
                <span class="services-label">🔥 FEATURED SERVICES</span>
                <h2>Pick Your Service and Start Growing Today</h2>
                <p>Join 2 million+ people who use our services to grow their social media. Simple pricing, fast delivery, real results.</p>
                <div class="services-avatars">
                    <div class="avatar-stack">
                        <img src="https://i.pravatar.cc/28?img=11" alt="">
                        <img src="https://i.pravatar.cc/28?img=22" alt="">
                        <img src="https://i.pravatar.cc/28?img=33" alt="">
                        <img src="https://i.pravatar.cc/28?img=44" alt="">
                        <img src="https://i.pravatar.cc/28?img=55" alt="">
                    </div>
                    <span><strong>2,847</strong> orders this week</span>
                </div>
            </div>

            <div class="services-grid">
                <?php
                $services = [
                    [
                        'emoji' => '👥',
                        'title' => 'Buy Instagram Followers',
                        'subtitle' => 'Get real followers fast',
                        'badge' => 'Most Popular',
                        'badge_class' => '',
                        'rating' => '5.0',
                        'reviews' => '10,450+',
                        'today' => '+847 today',
                        'avatars' => [56, 41, 26],
                        'features' => ['Real followers (not bots)', 'Starts in literally 60 seconds', 'Choose from 100 to 100,000+', 'We never ask for your password'],
                        'link' => 'buy-instagram-followers.php'
                    ],
                    [
                        'emoji' => '❤️',
                        'title' => 'Buy Instagram Likes',
                        'subtitle' => 'Make your posts pop',
                        'badge' => 'Best Value',
                        'badge_class' => '',
                        'rating' => '5.0',
                        'reviews' => '8,700+',
                        'today' => '+623 today',
                        'avatars' => [7, 13, 19],
                        'features' => ['Real people, real likes', 'Works on posts, reels, videos', '50 to 100,000+ available', 'You pick the delivery speed'],
                        'link' => 'buy-instagram-likes.php'
                    ],
                    [
                        'emoji' => '▶️',
                        'title' => 'Buy Instagram Views',
                        'subtitle' => 'Boost your video reach',
                        'badge' => 'Fast Delivery',
                        'badge_class' => '',
                        'rating' => '4.9',
                        'reviews' => '7,200+',
                        'today' => '+412 today',
                        'avatars' => [65, 59, 53],
                        'features' => ['Real video views', 'Instant delivery', 'Boosts algorithm ranking', 'No password required'],
                        'link' => 'buy-instagram-views.php'
                    ],
                    [
                        'emoji' => '🎬',
                        'title' => 'Instagram Reels',
                        'subtitle' => 'Likes & Views for Reels',
                        'badge' => 'Trending',
                        'badge_class' => 'trending',
                        'rating' => '4.9',
                        'reviews' => '5,800+',
                        'today' => '+389 today',
                        'avatars' => [60, 49, 38],
                        'features' => ['Real Reels engagement', 'Go viral faster', 'Reach Explore page', 'Safe & secure delivery'],
                        'link' => 'buy-reels-likes-views.php'
                    ],
                    [
                        'emoji' => '🎵',
                        'title' => 'Buy TikTok Followers',
                        'subtitle' => 'Go viral on TikTok',
                        'badge' => 'Creator Pick',
                        'badge_class' => 'creator',
                        'rating' => '4.9',
                        'reviews' => '6,200+',
                        'today' => '+531 today',
                        'avatars' => [68, 65, 62],
                        'features' => ['Quality TikTok followers', 'Helps you hit the For You page', '100 to 50,000+ followers', 'Natural-looking growth'],
                        'link' => 'buy-tiktok-followers.php'
                    ],
                    [
                        'emoji' => '👀',
                        'title' => 'Buy TikTok Views',
                        'subtitle' => 'Get your videos seen',
                        'badge' => '',
                        'badge_class' => '',
                        'rating' => '4.9',
                        'reviews' => '5,500+',
                        'today' => '+298 today',
                        'avatars' => [45, 19, 63],
                        'features' => ['Real people watching', 'Helps with TikTok SEO', '1,000 to 1M+ views', 'Increases your watch time'],
                        'link' => 'buy-tiktok-views.php'
                    ],
                ];

                foreach ($services as $service) {
                ?>
                <div class="service-card">
                    <?php if ($service['badge']) { ?>
                    <span class="service-badge <?php echo $service['badge_class']; ?>"><?php echo $service['badge']; ?></span>
                    <?php } ?>
                    <div class="service-emoji"><?php echo $service['emoji']; ?></div>
                    <h3><?php echo $service['title']; ?></h3>
                    <p class="subtitle"><?php echo $service['subtitle']; ?></p>
                    <div class="service-rating">
                        <span class="stars">★★★★★</span>
                        <span><?php echo $service['rating']; ?> (<?php echo $service['reviews']; ?>)</span>
                    </div>
                    <div class="service-users">
                        <div class="avatar-stack">
                            <?php foreach ($service['avatars'] as $avatar) { ?>
                            <img src="https://i.pravatar.cc/32?img=<?php echo $avatar; ?>" alt="">
                            <?php } ?>
                        </div>
                        <span><?php echo $service['today']; ?></span>
                    </div>
                    <ul class="service-features">
                        <?php foreach ($service['features'] as $feature) { ?>
                        <li><?php echo $feature; ?></li>
                        <?php } ?>
                    </ul>
                    <div class="service-footer">
                        <span class="service-delivery">Avg. delivery: <strong>30 min</strong></span>
                        <span class="service-status">In stock</span>
                    </div>
                    <a href="<?php echo $service['link']; ?>" class="btn btn-primary"><?php echo $service['title']; ?> →</a>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Stats Banner -->
    <div class="stats-banner">
        <div class="stat-item">
            <div class="stat-value">50,000+</div>
            <div class="stat-label">Happy Customers</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">Instant</div>
            <div class="stat-label">Delivery Start</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">🛡️ 30-Day</div>
            <div class="stat-label">Money Back</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">⚡ 24/7</div>
            <div class="stat-label">Live Support</div>
        </div>
    </div>

    <?php 
    $faqs = getFormattedFaqs();


    
    ?>
    <!-- FAQ Section -->
    <section class="section faq-section" id="faq">
        <div class="section-inner">
            <div class="section-header">
                <h2>Frequently Asked Questions</h2>
                <p>Everything you need to know about Famoid's social media services</p>
            </div>
            
            <div class="faq-container">
                <?php
                // Display dynamic FAQs from database
                foreach ($faqs as $index => $faq) {
                ?>
                <div class="faq-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <button class="faq-question">
                        <?php echo htmlspecialchars($faq['q']); ?>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <?php echo htmlspecialchars($faq['a']); ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Mini Testimonials Section -->
    <section class="section testimonial-mini-section">
        <div class="section-inner">
            <div class="testimonial-mini-grid">
                <div class="testimonial-mini-stats">
                    <div>Trusted by 50K+ customers</div>
                    <div class="rating-value">4.9</div>
                    <div class="rating-label">Rating</div>
                </div>
                <div class="testimonial-mini-stats">
                    <div class="rating-value">24/7</div>
                    <div class="rating-label">Support</div>
                </div>
                <div class="testimonial-mini-stats">
                    <div class="rating-value">7yr</div>
                    <div class="rating-label">Experience</div>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 2rem;">
            <?php
            $miniTestimonials = getMiniTestimonials(3);
            foreach ($miniTestimonials as $testimonial):
                $imgNumber = 12;
                if (preg_match('/img=(\d+)/', $testimonial['avatar_url'], $matches)) {
                    $imgNumber = (int)$matches[1];
                }
            ?>
            <div class="testimonial-mini-card">
                <div class="testimonial-mini-header">
                    <img src="https://i.pravatar.cc/48?img=<?php echo $imgNumber; ?>" alt="">
                    <div>
                        <h4><?php echo htmlspecialchars($testimonial['name']); ?></h4>
                        <span><?php echo ucfirst(str_replace('_', ' ', $testimonial['service_type'])); ?></span>
                    </div>
                </div>
                <p><?php echo htmlspecialchars($testimonial['content']); ?></p>
            </div>
            <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="section-inner">
            <div class="cta-inner">
                <p style="font-weight: 600; color: var(--primary-purple); margin-bottom: 0.5rem; font-size: 1rem;">✨ Ready to grow your social presence?</p>
                <h2 style="font-size: 2rem; margin-bottom: 1.5rem;">Start Growing Today</h2>
                <a href="#services" class="btn btn-primary btn-lg" style="padding: 1rem 3rem; font-size: 1.1rem; border-radius: 14px; box-shadow: 0 8px 30px rgba(124, 58, 237, 0.4);">Start Growing Now →</a>
                <div class="cta-avatars" style="margin-top: 2rem;">
                    <div class="avatar-stack">
                        <img src="https://i.pravatar.cc/40?img=12" alt="">
                        <img src="https://i.pravatar.cc/40?img=33" alt="">
                        <img src="https://i.pravatar.cc/40?img=45" alt="">
                        <img src="https://i.pravatar.cc/40?img=67" alt="">
                    </div>
                    <span class="cta-trust"><strong>1,247</strong> people ordered in the last 24 hours</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Second CTA -->
    <section class="section cta-section" style="background: linear-gradient(180deg, #ffffff 0%, #faf5ff 50%, #fdf2f8 100%);">
        <div class="section-inner">
            <div class="cta-inner">
                <span style="display: inline-block; padding: 0.5rem 1.25rem; background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(236, 72, 153, 0.1) 100%); border-radius: 50px; font-size: 0.9rem; font-weight: 600; color: var(--primary-purple); margin-bottom: 1.5rem;">🚀 Join 50,000+ Happy Customers</span>
                <h2>Ready to Join Them?</h2>
                <p>Don't wait another day watching others grow while you stay stuck. Your audience is waiting for you.</p>
                
                <div class="cta-stats">
                    <div class="cta-stat">
                        <div class="cta-stat-value">50K+</div>
                        <div class="cta-stat-label">Happy Users</div>
                    </div>
                    <div class="cta-stat">
                        <div class="cta-stat-value">24/7</div>
                        <div class="cta-stat-label">Support</div>
                    </div>
                    <div class="cta-stat">
                        <div class="cta-stat-value">30 Min</div>
                        <div class="cta-stat-label">Start Time</div>
                    </div>
                </div>

                <div class="cta-buttons">
                    <a href="#services" class="btn btn-primary btn-lg">🚀 Start Growing Now</a>
                    <a href="contact.php" class="btn btn-outline btn-lg">💬 Talk to Us</a>
                </div>
                <div class="cta-badges">
                    <span>🔒 SSL Secured</span>
                    <span>🚫 No Password</span>
                    <span>💰 Money Back Guarantee</span>
                </div>
            </div>
        </div>
    </section>

