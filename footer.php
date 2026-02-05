    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="#" class="logo">Famoid</a>
                    <p>Established in 2017, Famoid is a marketing agency that delivers ad-based social media services. We prioritize our customers' experiences, and we're confident that you'll be wholly satisfied once you experience our offerings!</p>
                    <div style="margin-bottom: 1rem;">
                        <p style="font-size: 0.85rem; color: #94a3b8; margin-bottom: 0.5rem;">Newsletter</p>
                        <p style="font-size: 0.8rem; color: #64748b;">Subscribe and get the latest news and promotions from Famoid!</p>
                    </div>
                    <div class="footer-newsletter">
                        <input type="email" placeholder="Enter your email">
                        <button>Subscribe</button>
                    </div>
                </div>
                <div class="footer-column">
                    <h4>Services</h4>
                    <ul>
                        <li><a href="#">Buy Instagram Followers</a></li>
                        <li><a href="#">Buy Instagram Likes</a></li>
                        <li><a href="#">Buy Instagram Views</a></li>
                        <li><a href="#">Buy Reels Likes & Views</a></li>
                        <li><a href="#">Automatic Likes</a></li>
                        <li><a href="#">Buy TikTok Followers</a></li>
                        <li><a href="#">Buy TikTok Likes</a></li>
                        <li><a href="#">Buy TikTok Views</a></li>
                        <li><a href="#">Buy Facebook Post Likes</a></li>
                        <li><a href="#">Buy Facebook Page Likes</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Free Tools</h4>
                    <ul>
                        <li><a href="#">Free Followers</a></li>
                        <li><a href="#">Free Likes</a></li>
                        <li><a href="#">Free Views</a></li>
                        <li><a href="#">Instagram Follower Counter</a></li>
                        <li><a href="#">TikTok Counter</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Useful</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Affiliate Program</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#">Famoid's Story</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Refund Policy</a></li>
                        <li><a href="#">Cookie Policy</a></li>
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
                    <a href="#">📸</a>
                    <a href="#">🎵</a>
                    <a href="#">👍</a>
                    <a href="#">✉️</a>
                </div>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <span class="footer-location">📧 contact@famoid.com</span>
                <span class="footer-location">📍 Dubai, UAE • DE, United States</span>
            </div>
            <div class="footer-copyright">
                Copyright © 2026 Famoid • All Rights Reserved.
            </div>
            <p style="text-align: center; font-size: 0.75rem; color: #475569; margin-top: 1rem; max-width: 800px; margin-left: auto; margin-right: auto;">
                Disclaimer: By using this site, you agree to our Terms of Service. Services are "as-is" for personal use only; commercial use and use on accounts you don't own are prohibited. We disclaim liability for third-party services.
            </p>
        </div>
    </footer>

    <script>
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
    </script>
</body>
</html>