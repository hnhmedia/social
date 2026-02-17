    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="<?php echo Config::baseUrl(); ?>/" class="logo"><?php echo Config::siteName(); ?></a>
                    <p>Established in 2017, <?php echo Config::siteName(); ?> is a marketing agency that delivers ad-based social media services. We prioritize our customers' experiences, and we're confident that you'll be wholly satisfied once you experience our offerings!</p>
                    <!-- div style="margin-bottom: 1rem;">
                        <p style="font-size: 0.85rem; color: #94a3b8; margin-bottom: 0.5rem;">Newsletter</p>
                        <p style="font-size: 0.8rem; color: #64748b;">Subscribe and get the latest news and promotions from <?php echo Config::siteName(); ?>!</p>
                    </div>
                    <form class="footer-newsletter" action="<?php echo Config::baseUrl('subscribe'); ?>" method="POST">
                        <input type="email" name="email" placeholder="Enter your email" required>
                        <button type="submit">Subscribe</button>
                    </form -->
                </div>
                <div class="footer-column">
                    <h4>Services</h4>
                    <ul>
                        <li><a href="<?php echo Config::baseUrl('services/buy-instagram-followers'); ?>">Buy Instagram Followers</a></li>
                        <li><a href="<?php echo Config::baseUrl('services/buy-instagram-likes'); ?>">Buy Instagram Likes</a></li>
                        <li><a href="<?php echo Config::baseUrl('services/buy-instagram-views'); ?>">Buy Instagram Views</a></li>
                        <li><a href="<?php echo Config::baseUrl('services/buy-instagram-reels'); ?>">Buy Reels Likes & Views</a></li>
                        <li><a href="<?php echo Config::baseUrl('services/automatic-likes'); ?>">Automatic Likes</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>&nbsp;</h4>
                    <ul>
                        <li><a href="<?php echo Config::baseUrl('services/buy-tiktok-followers'); ?>">Buy TikTok Followers</a></li>
                        <li><a href="<?php echo Config::baseUrl('services/buy-tiktok-likes'); ?>">Buy TikTok Likes</a></li>
                        <li><a href="<?php echo Config::baseUrl('services/buy-tiktok-views'); ?>">Buy TikTok Views</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Useful</h4>
                    <ul>
                        <li><a href="<?php echo Config::baseUrl('frequently-asked-questions'); ?>">FAQ</a></li>
                        <li><a href="<?php echo Config::baseUrl('blog'); ?>">Blog</a></li>
                        <li><a href="<?php echo Config::baseUrl('contact'); ?>">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="<?php echo Config::baseUrl('about'); ?>"><?php echo Config::siteName(); ?>'s Story</a></li>
                        <li><a href="<?php echo Config::baseUrl('privacy-policy'); ?>">Privacy Policy</a></li>
                        <li><a href="<?php echo Config::baseUrl('terms-of-service'); ?>">Terms of Service</a></li>
                   </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="footer-badges-row">
                    <span style="padding: 0.5rem 0.75rem; background: #1e293b; border-radius: 6px; font-size: 0.75rem;">TrustIndex ★★★★★</span>
                    <span style="padding: 0.5rem 0.75rem; background: #1e293b; border-radius: 6px; font-size: 0.75rem;">🔒 SSL Secure</span>
                    <span style="padding: 0.5rem 0.75rem; background: #1e293b; border-radius: 6px; font-size: 0.75rem;">💳 Visa MC Amex</span>
                </div>
                <div class="footer-social">
                    <a href="https://instagram.com/<?php echo strtolower(Config::siteName()); ?>" target="_blank">📸</a>
                    <a href="https://tiktok.com/@<?php echo strtolower(Config::siteName()); ?>" target="_blank">🎵</a>
                    <a href="mailto:<?php echo Config::supportEmail(); ?>">✉️</a>
                </div>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <span class="footer-location">📧 <?php echo Config::supportEmail(); ?></span>
                <span class="footer-location">📍 Dubai, UAE • DE, United States</span>
            </div>
            <div class="footer-copyright">
                Copyright © <?php echo date('Y'); ?> <?php echo Config::siteName(); ?> • All Rights Reserved.
            </div>
            <p style="text-align: center; font-size: 0.75rem; color: #475569; margin-top: 1rem; max-width: 800px; margin-left: auto; margin-right: auto;">
                Disclaimer: By using this site, you agree to our Terms of Service. Services are "as-is" for personal use only; commercial use and use on accounts you don't own are prohibited. We disclaim liability for third-party services.
            </p>
        </div>
    </footer>

    <script src="<?php echo Config::baseUrl('js/main.js'); ?>"></script>
    
    <!-- Footer Scripts (Analytics, Chat Widgets, etc.) -->
<?php 
require_once __DIR__ . '/includes/SEOHelper.php';
echo SEOHelper::renderFooterScripts(); 
?>
</body>
</html>
