

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-inner">
            <h1>Elevate your presence with authentic signals 🔥</h1>
            <p class="hero-subtitle">Ad-backed delivery, human oversight, and believable pacing so your brand feels real and ready to scale.</p>

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
            </div>

            <!-- Service Links -->
            <div class="service-links">
                <a href="<?php echo $baseUrl; ?>services/buy-instagram-followers" class="service-link">BUY INSTAGRAM FOLLOWERS</a>
                <a href="<?php echo $baseUrl; ?>services/buy-instagram-likes" class="service-link">BUY INSTAGRAM LIKES</a>
                <a href="<?php echo $baseUrl; ?>services/buy-instagram-views" class="service-link">BUY INSTAGRAM VIEWS</a>
                <a href="<?php echo $baseUrl; ?>services/buy-tiktok-followers" class="service-link">BUY TIKTOK FOLLOWERS</a>
                <a href="<?php echo $baseUrl; ?>services/buy-tiktok-likes" class="service-link">BUY TIKTOK LIKES</a>
            </div>

            <!-- Live Notification Ticker (dynamic from si_orders) -->
            <?php
            $liveNotifications = getRecentOrderNotifications(8, 48);
            $firstNotif = $liveNotifications[0] ?? ['emoji'=>'📸','label'=>'1,000 Instagram Followers delivered','time'=>'43 mins ago'];
            ?>
            <div class="live-notification" id="liveNotification">
                <span class="notif-emoji" id="notifEmoji"><?php echo $firstNotif['emoji']; ?></span>
                <span class="stars">★★★★★</span>
                <span class="notif-label" id="notifLabel"><?php echo htmlspecialchars($firstNotif['label']); ?></span>
                <span class="live-dot"></span>
                <span class="time notif-time" id="notifTime"><?php echo htmlspecialchars($firstNotif['time']); ?></span>
            </div>
            <script>
            (function() {
                var notifications = <?php echo json_encode($liveNotifications, JSON_HEX_TAG | JSON_HEX_APOS); ?>;
                if (notifications.length < 2) return;
                var idx = 0;
                var el    = document.getElementById('liveNotification');
                var emoji = document.getElementById('notifEmoji');
                var label = document.getElementById('notifLabel');
                var time  = document.getElementById('notifTime');
                setInterval(function() {
                    idx = (idx + 1) % notifications.length;
                    var n = notifications[idx];
                    el.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
                    el.style.opacity    = '0';
                    el.style.transform  = 'translateY(-6px)';
                    setTimeout(function() {
                        emoji.textContent = n.emoji;
                        label.textContent = n.label;
                        time.textContent  = n.time;
                        el.style.transform = 'translateY(6px)';
                        el.style.opacity   = '1';
                        el.style.transform = 'translateY(0)';
                    }, 360);
                }, 4500);
            })();
            </script>

            <!-- Trust Badges -->
            <p class="hero-microcopy">Ad-backed delivery • 30-day refill safety net • Real support, 24/7</p>
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
                    <h2>😍 Reliable, fast, and feels organic</h2>
                    <p>At <strong>Genuine Socials</strong>, we run ad-backed delivery that keeps your account safe while growing. Payments stay secure, delivery stays gradual, and everything looks authentic.</p>
                    <p>Our 24/7 success team watches every order. If something slips, we fix it—fast.</p>
                    <p>Try Genuine Socials and see how effortless credible growth can be.</p>
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
                <h2>👉 Genuine Socials, your trusted growth partner 🤩</h2>
                <p>We focus on secure payments, ad-backed delivery, and real-looking engagement. The team is on 24/7 so you always have a human to talk to.</p>
                <p style="margin-top: 1rem;">With a satisfaction guarantee, you're protected. <strong>Try Genuine Socials</strong> and see why brands switch to us for believable growth.</p>
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
                <h2>🫡 Your satisfaction drives how we build</h2>
                <p>See how clients rate their experience with Genuine Socials.</p>
            </div>
            <div class="testimonials-track-wrapper">
                <div class="testimonials-track">
                    <?php
                    $testimonials = getFormattedTestimonials();
                    

                
                    
                    // Display testimonials twice for infinite scroll effect
                    for ($i = 0; $i < 2; $i++) {
                        foreach ($testimonials as $testimonial) {
                            $avatarId = (abs(crc32($testimonial['name'])) % 70) + 1;
                    ?>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/60?img=<?php echo $avatarId; ?>" alt="<?php echo $testimonial['name']; ?>" class="testimonial-avatar">
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
                    <p>We never ask for passwords. Payments and delivery are encrypted end-to-end.</p>
                </div>
                <div class="info-card">
                    <h3>⭐ Experience</h3>
                    <p>Seven years shipping social proof safely. We adapt to platform changes before they hit.</p>
                </div>
                <div class="info-card">
                    <h3>📈 Ad-Based Delivery</h3>
                    <p>We lean on ad distribution for natural-looking reach. Delivery is gradual and believable.</p>
                </div>
                <div class="info-card">
                    <h3>💬 24/7 Support</h3>
                    <p>Real humans on every shift. We handle pre-sales, orders, and follow-up without scripts.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section" id="services">
        <div class="section-inner">
            <div class="services-header">
                <span class="services-label">🔥 FEATURED SERVICES</span>
                <h2>Pick a service and start growing today</h2>
                <p>Join thousands of creators and brands who get believable engagement with Genuine Socials.</p>
                <div class="services-avatars">
                    <div class="avatar-stack">
                        <img src="https://i.pravatar.cc/28?img=11" alt="">
                        <img src="https://i.pravatar.cc/28?img=22" alt="">
                        <img src="https://i.pravatar.cc/28?img=33" alt="">
                        <img src="https://i.pravatar.cc/28?img=44" alt="">
                        <img src="https://i.pravatar.cc/28?img=55" alt="">
                    </div>
                    <span><strong><?php echo number_format(getTotalOrdersThisWeek()); ?></strong> orders this week</span>
                </div>
            </div>

            <div class="services-grid">
                <?php
                // Load homepage services from database
              
                $services = getHomepageServices();

                foreach ($services as $service) {
                ?>
                <div class="service-card">
                    <div class="service-card-top">
                        <div class="service-header">
                            <div class="service-emoji"><?php echo $service['emoji']; ?></div>
                            <div class="service-title-block">
                                <h3><?php echo $service['title']; ?></h3>
                                <p class="subtitle"><?php echo $service['subtitle']; ?></p>
                            </div>
                        </div>
                        <?php if ($service['badge']) { ?>
                        <span class="service-badge <?php echo $service['badge_class']; ?>"><?php echo $service['badge']; ?></span>
                        <?php } ?>
                    </div>
                    <div class="service-rating">
                        <span class="stars">★★★★★</span>
                        <span><?php echo $service['rating']; ?> (<?php echo $service['reviews']; ?>)</span>
                    </div>
                    <div class="service-users">
                        <div class="avatar-stack">
                            <?php foreach ($service['avatars'] as $avatar) { ?>
                            <img src="https://i.pravatar.cc/48?img=<?php echo $avatar; ?>" alt="">
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
                        <span class="service-delivery">Avg. delivery: <strong><?php echo htmlspecialchars($service['avg_delivery']); ?></strong></span>
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
                <p>Everything you need to know about Genuine Socials services</p>
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

    <!-- Trust & Testimonials Section -->
    <section class="section trust-testimonials-section">
        <div class="section-inner">
            <!-- Trust Header -->
            <div class="trust-header">
                <div class="trust-badge-main">
                    ⭐ Trusted by 50K+ customers
                </div>
                <div class="trust-stats-row">
                    <div class="trust-stat-box">
                        <div class="trust-stat-value">4.9</div>
                        <div class="trust-stat-label">Rating</div>
                    </div>
                    <div class="trust-stat-box">
                        <div class="trust-stat-value">24/7</div>
                        <div class="trust-stat-label">Support</div>
                    </div>
                    <div class="trust-stat-box">
                        <div class="trust-stat-value">7yr</div>
                        <div class="trust-stat-label">Experience</div>
                    </div>
                </div>
            </div>

            <!-- Fancy Testimonials Grid -->
            <div class="fancy-testimonials-grid">
            <?php
            $miniTestimonials = getMiniTestimonials(3);
            foreach ($miniTestimonials as $testimonial):
                $imgNumber = 12;
                if (preg_match('/img=(\d+)/', $testimonial['avatar_url'], $matches)) {
                    $imgNumber = (int)$matches[1];
                }
                $avatarId = (abs(crc32($testimonial['name'])) % 70) + 1;
            ?>
            <div class="fancy-testimonial-card">
                <div class="fancy-testimonial-header">
                    <img src="https://i.pravatar.cc/60?img=<?php echo $avatarId; ?>" alt="<?php echo htmlspecialchars($testimonial['name']); ?>" class="fancy-testimonial-avatar">
                    <div class="fancy-testimonial-user">
                        <h4><?php echo htmlspecialchars($testimonial['name']); ?></h4>
                        <span><?php echo ucfirst(str_replace('_', ' ', $testimonial['service_type'])); ?></span>
                    </div>
                </div>
                <div class="fancy-testimonial-rating">
                    ⭐⭐⭐⭐⭐
                </div>
                <p class="fancy-testimonial-text"><?php echo htmlspecialchars($testimonial['content']); ?></p>
            </div>
            <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="section-inner">
                <div class="cta-inner">
                    <p style="font-weight: 600; color: var(--brand-accent, #0fb286); margin-bottom: 0.5rem; font-size: 1rem;">✨ Ready to grow your social presence?</p>
                    <h2 style="font-size: 2rem; margin-bottom: 1.5rem;">Start growing today</h2>
                    <a href="#services" class="btn btn-primary btn-lg" style="padding: 1rem 3rem; font-size: 1.1rem; border-radius: 14px; box-shadow: var(--brand-glow, 0 8px 30px rgba(15, 178, 134, 0.4));">Start now →</a>
                    <div class="cta-avatars" style="margin-top: 2rem;">
                    <div class="avatar-stack">
                        <img src="https://i.pravatar.cc/60?img=21" alt="">
                        <img src="https://i.pravatar.cc/60?img=24" alt="">
                        <img src="https://i.pravatar.cc/60?img=27" alt="">
                        <img src="https://i.pravatar.cc/60?img=30" alt="">
                    </div>
                    <span class="cta-trust"><strong>1,247</strong> people ordered in the last 24 hours</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Second CTA -->
    <section class="section cta-section" style="background: radial-gradient(circle at 12% 18%, rgba(255,107,107,0.14), transparent 42%), radial-gradient(circle at 82% 8%, rgba(255,179,71,0.12), transparent 40%), linear-gradient(180deg, #f7f8fb 0%, #ffffff 100%);">
        <div class="section-inner">
            <div class="cta-inner">
                <span style="display: inline-block; padding: 0.5rem 1.25rem; background: linear-gradient(135deg, rgba(15,178,134,0.18) 0%, rgba(14,165,233,0.16) 100%); border-radius: 50px; font-size: 0.9rem; font-weight: 600; color: #0f766e; margin-bottom: 1.5rem;">🚀 Join 50,000+ Happy Customers</span>
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
                    <a href="<?php echo $baseUrl; ?>/contact" class="btn btn-outline btn-lg">💬 Talk to Us</a>
                </div>
                <div class="cta-badges">
                    <span>🔒 SSL Secured</span>
                    <span>🚫 No Password</span>
                    <span>💰 Money Back Guarantee</span>
                </div>
            </div>
        </div>
    </section>

