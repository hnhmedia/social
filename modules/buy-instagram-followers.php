<?php
/**
 * Buy Instagram Followers - Service Page
 * Exact replica of Famoid's buy-instagram-followers page layout
 */

// Package data for each tab
$realFollowersPacks = [
    ['qty' => 100, 'price' => 3.95, 'label' => ''],
    ['qty' => 250, 'price' => 5.95, 'label' => '40% Off'],
    ['qty' => 500, 'price' => 9.95, 'label' => '55% Off'],
    ['qty' => 1000, 'price' => 15.95, 'label' => '60% Off'],
    ['qty' => 2500, 'price' => 29.95, 'label' => '60% Off'],
    ['qty' => 5000, 'price' => 49.95, 'label' => '65% Off'],
    ['qty' => 10000, 'price' => 89.95, 'label' => '67% Off'],
    ['qty' => 15000, 'price' => 129.95, 'label' => '66% Off'],
];

$managedGrowthPacks = [
    ['qty' => 100, 'price' => 9.95, 'label' => '/month'],
    ['qty' => 250, 'price' => 19.95, 'label' => '/month'],
    ['qty' => 500, 'price' => 34.95, 'label' => '/month'],
    ['qty' => 1000, 'price' => 59.95, 'label' => '/month'],
    ['qty' => 2500, 'price' => 99.95, 'label' => '/month'],
    ['qty' => 5000, 'price' => 179.95, 'label' => '/month'],
    ['qty' => 10000, 'price' => 299.95, 'label' => '/month'],
    ['qty' => 15000, 'price' => 449.95, 'label' => '/month'],
];

$prestigePacks = [
    ['qty' => 1000, 'price' => 29.95, 'label' => 'Premium'],
    ['qty' => 2500, 'price' => 59.95, 'label' => 'Premium'],
    ['qty' => 5000, 'price' => 99.95, 'label' => 'Premium'],
    ['qty' => 10000, 'price' => 179.95, 'label' => 'Premium'],
    ['qty' => 15000, 'price' => 259.95, 'label' => 'Premium'],
    ['qty' => 25000, 'price' => 399.95, 'label' => 'Premium'],
    ['qty' => 50000, 'price' => 699.95, 'label' => 'Premium'],
    ['qty' => 100000, 'price' => 1299.95, 'label' => 'Premium'],
];

// FAQ data
$faqItems = [
    ['q' => 'Why should I buy Instagram followers?', 'a' => 'Purchasing Instagram followers from Famoid boosts your online presence, enhances credibility, and improves brand awareness by expanding your audience and increasing engagement on your posts.'],
    ['q' => 'Is buying followers on Instagram safe?', 'a' => 'Yes, buying followers from Famoid is safe. We prioritize your account\'s security, employing methods that adhere to Instagram\'s guidelines, and ensuring no compromise on account safety.'],
    ['q' => 'Will my bought followers engage with my content?', 'a' => 'Famoid strives to provide quality followers that enhance engagement levels. While bought followers inherently have lower interaction rates, they elevate your account\'s credibility, indirectly fostering organic engagement.'],
    ['q' => 'How quickly will I receive my purchased followers?', 'a' => 'Famoid is renowned for its instant delivery! Once your transaction is complete, your Instagram followers typically begin to increase within minutes, empowering your brand\'s presence swiftly.'],
    ['q' => 'Will people know I\'ve bought followers?', 'a' => 'No, Famoid ensures a discrete service, providing followers that look authentic. Your purchase details and information are confidential and will not be shared with third parties.'],
    ['q' => 'Can I lose followers after purchasing?', 'a' => 'Famoid offers a 30-day refill guarantee for any drops in followers after your purchase. Our team diligently works to restore follower counts and maintain your enhanced presence.'],
    ['q' => 'Is it legal to buy Instagram followers?', 'a' => 'Yes, buying Instagram followers is legal and complies with Instagram\'s terms of service when executed through legitimate practices, like those employed by Famoid.'],
    ['q' => 'How can Famoid help grow my Instagram?', 'a' => 'Famoid amplifies your Instagram growth by providing authentic-looking followers, improving your account\'s credibility, and attracting organic followers through enhanced visibility and perceived popularity.'],
    ['q' => 'What type of accounts accepted for this service?', 'a' => 'It must be your own and personal account. With the intent of commercial purposes and use of business accounts not allowed.'],
];
?>

<style>
/* ===================== */
/* ORDER WIDGET STYLES   */
/* ===================== */
.ig-page-title { text-align: center; margin: 1.5rem 1.25rem; }
.ig-page-title h1 { font-size: 1.875rem; font-weight: 700; line-height: 1.3; }
.ig-page-title h1 span { color: #fc481c; }
.ig-page-title p { font-size: 1.125rem; line-height: 1.6; color: #6b7280; margin: 0; }

.order-main-card {
    max-width: 1000px; margin: 2rem auto; padding: 1.5rem;
    background: linear-gradient(to bottom right, #fff, #f9fafb);
    border-radius: 1rem; border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 4px 20px rgba(0,0,0,0.06), 0 1px 3px rgba(0,0,0,0.08);
    position: relative; overflow: hidden;
}
.order-main-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(to right, #22c55e, #10b981, #22c55e);
    background-size: 200% 100%; animation: shimmer 2s linear infinite;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

/* Rating Bar */
.rating-bar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem; padding: 0 0.5rem; }
.rating-left { display: flex; flex-direction: column; gap: 0.25rem; }
.rating-stars { display: flex; align-items: center; gap: 0.5rem; }
.rating-stars svg { color: #facc15; }
.rating-stars .score { font-weight: 700; font-size: 1.125rem; color: #111827; }
.rating-meta { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
.rating-meta .excellent { background: #22c55e; color: #fff; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 4px; }
.rating-meta .reviews-count { color: #9ca3af; font-size: 0.875rem; }

.live-order-badge {
    display: flex; align-items: center; gap: 0.5rem;
    padding: 0.375rem 0.75rem; background: #f9fafb; border-radius: 9999px; font-size: 0.75rem;
}
.live-order-badge .pulse { position: relative; display: flex; width: 10px; height: 10px; }
.live-order-badge .pulse span:first-child {
    animation: ping 1s cubic-bezier(0,0,0.2,1) infinite;
    position: absolute; width: 100%; height: 100%; border-radius: 9999px; background: #4ade80; opacity: 0.75;
}
.live-order-badge .pulse span:last-child {
    position: relative; display: inline-flex; width: 10px; height: 10px; border-radius: 9999px; background: #22c55e;
}
@keyframes ping { 75%,100%{transform:scale(2);opacity:0} }
.live-order-badge .order-text { font-weight: 600; color: #16a34a; }

.safe-badge { display: flex; align-items: center; gap: 0.375rem; }
.safe-badge svg { color: #22c55e; }
.safe-badge span { font-weight: 500; color: #4b5563; }

/* Tabs */
.order-widget-inner { max-width: 650px; margin: 0 auto; }
.service-tabs { display: flex; flex-wrap: wrap; gap: 5px; justify-content: center; margin-bottom: 1rem; }
.service-tab {
    position: relative; display: flex; align-items: center; gap: 5px;
    padding: 0.625rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600;
    cursor: pointer; border: 2px solid transparent; background: #f3f4f6; color: #374151;
    transition: all 0.2s;
}
.service-tab.active { background: #fff; border-color: #fc481c; color: #fc481c; box-shadow: 0 2px 8px rgba(252,72,28,0.15); }
.service-tab .tab-badge {
    position: absolute; top: -10px; right: -10px; padding: 1px 6px; border-radius: 4px;
    color: #fff; font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap;
}
.service-tab svg { width: 20px; height: 20px; stroke: #fc481c; fill: none; stroke-width: 2; }

/* Trust Bar under tabs */
.trust-bar {
    display: flex; justify-content: center; flex-wrap: wrap; gap: 0.625rem;
    background: rgba(253,126,20,0.09); padding: 0.625rem; border-radius: 10px;
    margin-bottom: 1rem; max-width: 590px; margin-left: auto; margin-right: auto;
}
.trust-bar-item { display: flex; align-items: center; gap: 5px; height: 28px; }
.trust-bar-item svg { width: 20px; height: 20px; stroke: #fc481c; fill: none; stroke-width: 2; }
.trust-bar-item span { font-size: 0.875rem; font-weight: 600; }

/* Package Grid */
.package-select-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem; padding: 0.5rem 0;
    max-width: 620px; margin: 0.75rem auto 0.5rem;
}
.pkg-card {
    position: relative; min-height: 90px;
    background: #f3f4f6; border: 2px solid #e5e7eb;
    border-radius: 0.75rem; padding: 1rem 0.75rem 0.75rem; text-align: center; cursor: pointer;
    transition: all 0.2s ease; display: flex; flex-direction: column; align-items: center; justify-content: center;
}
.pkg-card:hover { border-color: #0080ff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,128,255,0.12); }
.pkg-card.selected {
    background: #0080ff; border-color: #0080ff; color: #fff;
    box-shadow: 0 4px 16px rgba(0,128,255,0.3);
}
.pkg-card.selected .pkg-qty { color: #fff; }
.pkg-card.selected .pkg-label-text { color: rgba(255,255,255,0.9); }
.pkg-card .pkg-check {
    position: absolute; top: -8px; right: -8px; width: 24px; height: 24px; border-radius: 50%;
    background: #0080ff; color: #fff; display: none; align-items: center; justify-content: center;
    box-shadow: 0 2px 6px rgba(0,128,255,0.4); border: 2px solid #fff;
}
.pkg-card.selected .pkg-check { display: flex; }
.pkg-qty { font-size: 1.375rem; font-weight: 700; line-height: 1.2; display: block; color: #1e293b; }
.pkg-label-text { font-weight: 600; margin-top: 2px; white-space: nowrap; display: block; font-size: 0.875rem; color: #4b5563; }
.pkg-save-badge {
    display: inline-block; margin-top: 6px; padding: 2px 8px; border-radius: 4px;
    font-size: 0.7rem; font-weight: 700; white-space: nowrap;
}
.pkg-card:not(.selected) .pkg-save-badge { background: #dbeafe; color: #1d4ed8; }
.pkg-card.selected .pkg-save-badge { background: rgba(255,255,255,0.25); color: #fff; }

/* Price & Buy */
.order-action { display: flex; flex-direction: column; align-items: center; padding: 1.25rem 5px; }
.order-price { font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; }
.buy-now-btn {
    background: #f97316; color: #fff; border: none; padding: 0.625rem 1.875rem;
    border-radius: 1.25rem; font-weight: 700; font-size: 1.0625rem;
    width: 100%; max-width: 300px; height: 42px; display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.2s;
}
.buy-now-btn:hover { background: #ea580c; }
.order-terms { text-align: center; color: #9ca3af; font-size: 10px; margin-top: 1rem; }
.order-terms a { color: inherit; text-decoration: underline; }

/* Payment Footer */
.payment-footer {
    display: flex; align-items: center; justify-content: space-evenly; flex-wrap: nowrap; gap: 0.75rem;
    border-top: 1px solid #e5e7eb; padding-top: 1rem; margin-top: 0.5rem; width: 100%;
}
.payment-footer .pay-icon { height: 40px; width: auto; }
.payment-footer .social-proof-text { display: flex; align-items: center; gap: 0.25rem; font-size: 11px; }
.payment-footer .social-proof-text .dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; flex-shrink: 0; }
.payment-footer .social-proof-text span { color: #6b7280; white-space: nowrap; }
.payment-footer .social-proof-text strong { color: #374151; }
.payment-footer .card-icons { display: flex; gap: 0.25rem; }
.payment-footer .card-icon {
    width: 32px; height: 20px; background: #fff; border: 1px solid #e5e7eb; border-radius: 4px;
    display: flex; align-items: center; justify-content: center; opacity: 0.8; font-size: 9px; font-weight: 700;
}

/* ===================== */
/* FEATURES GRID         */
/* ===================== */
.ig-features-section { max-width: 1024px; margin: 2rem auto; padding: 2rem 1rem 1.5rem; }
.ig-features-section .section-badge {
    display: inline-block; background: #f1f3f5; color: #797979; font-size: 0.875rem;
    font-weight: 500; padding: 0.25rem 0.75rem; border-radius: 9999px; margin-bottom: 0.75rem;
}
.ig-features-section h2 { font-size: 1.5rem; font-weight: 700; text-align: center; margin-top: 0.75rem; }
.ig-features-section > p { color: #6b7280; text-align: center; margin-top: 0.75rem; }
.ig-features-grid {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 3rem;
}
.ig-feature-card { background: #fff; border-radius: 0.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08); padding: 1.5rem; }
.ig-feature-card .icon { width: 60px; height: 60px; color: #0080ff; margin-bottom: 0.5rem; }
.ig-feature-card h3 { font-size: 1.125rem; font-weight: 500; margin-top: 0.75rem; }
.ig-feature-card p { font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem; line-height: 1.6; }

/* ===================== */
/* CATCHY CTA SECTION    */
/* ===================== */
.ig-catchy-section {
    text-align: center; background: #f4f4f4; padding: 2.5rem 1.5rem; border-radius: 0.5rem;
    margin: 2.5rem auto; max-width: 1200px;
}
.ig-catchy-section h2 { font-size: 1.5rem; font-weight: 800; color: #111827; margin-bottom: 1rem; }
.ig-catchy-section p { font-size: 1rem; color: #4b5563; max-width: 1150px; margin: 0 auto; line-height: 1.6; }

/* ===================== */
/* TESTIMONIALS          */
/* ===================== */
/* Uses existing .testimonials-track-wrapper from style.css */

/* ===================== */
/* FAQ SECTION           */
/* ===================== */
.ig-faq-section { max-width: 1200px; margin: 2.5rem auto; padding: 0 1rem; }
.ig-faq-grid { display: grid; grid-template-columns: 7fr 5fr; gap: 2.5rem; align-items: start; }

.ig-faq-card {
    background: #fff; border-radius: 0.75rem; box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb; overflow: hidden;
}
.ig-faq-card-header {
    padding: 1.25rem 1.5rem; background: linear-gradient(to right, #f9fafb, #fff);
    border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 1rem;
}
.ig-faq-card-header .faq-icon-box {
    width: 40px; height: 40px; border-radius: 0.75rem; flex-shrink: 0;
    background: linear-gradient(to right, #fc481c, #ff6b47);
    display: flex; align-items: center; justify-content: center;
}
.ig-faq-card-header h3 { font-size: 1.25rem; font-weight: 700; color: #111827; }
.ig-faq-card-header p { font-size: 0.875rem; color: #6b7280; }

.ig-faq-item { border-bottom: 1px solid #e5e7eb; background: #fff; }
.ig-faq-item:last-child { border-bottom: none; }
.ig-faq-btn {
    width: 100%; padding: 1rem 1.5rem; display: flex; align-items: center; gap: 0.75rem;
    text-align: left; background: none; border: none; cursor: pointer; transition: background 0.15s;
}
.ig-faq-btn:hover { background: #f9fafb; }
.ig-faq-btn .num {
    width: 24px; height: 24px; border-radius: 50%; background: #e5e7eb; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; font-weight: 700; color: #6b7280; transition: all 0.3s;
}
.ig-faq-item.active .ig-faq-btn .num { background: #fc481c; color: #fff; }
.ig-faq-btn h4 { flex: 1; font-size: 0.9375rem; font-weight: 600; color: #1f2937; line-height: 1.4; }
.ig-faq-btn .chevron { transition: transform 0.3s; color: #9ca3af; flex-shrink: 0; }
.ig-faq-item.active .ig-faq-btn .chevron { transform: rotate(180deg); }
.ig-faq-answer {
    max-height: 0; overflow: hidden; transition: max-height 0.3s ease, opacity 0.3s; opacity: 0;
}
.ig-faq-item.active .ig-faq-answer { max-height: 300px; opacity: 1; }
.ig-faq-answer-inner {
    padding: 0 1.5rem 1rem; padding-left: 4rem;
}
.ig-faq-answer-inner p { font-size: 0.9375rem; color: #4b5563; line-height: 1.6; }
.ig-faq-answer-inner .verified {
    display: inline-flex; align-items: center; gap: 0.25rem; margin-top: 0.625rem;
    padding: 0.25rem 0.5rem; background: #dcfce7; color: #15803d; font-size: 0.75rem;
    font-weight: 500; border-radius: 9999px;
}

/* FAQ Sidebar */
.ig-faq-sidebar { position: sticky; top: 1.25rem; }
.ig-faq-sidebar-card {
    background: #fff; border-radius: 0.75rem; box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb; overflow: hidden; transition: transform 0.3s;
}
.ig-faq-sidebar-card:hover { transform: scale(1.02); }
.ig-faq-sidebar-img {
    width: 100%; height: 250px; object-fit: cover; display: block;
    background: linear-gradient(135deg, #fdf2f8, #faf5ff); position: relative;
}
.ig-faq-sidebar-img-placeholder {
    width: 100%; height: 250px; background: linear-gradient(135deg, #fdf2f8, #faf5ff);
    display: flex; align-items: center; justify-content: center; font-size: 4rem;
}
.ig-faq-sidebar-badge {
    position: absolute; top: 0.625rem; right: 0.625rem; background: rgba(255,255,255,0.95);
    backdrop-filter: blur(4px); border-radius: 0.5rem; padding: 0.375rem 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.ig-faq-sidebar-badge span { font-size: 0.875rem; font-weight: 600; color: #fc481c; }
.ig-faq-sidebar-body { padding: 1.25rem 1.5rem; }
.ig-faq-sidebar-body h4 { font-size: 1.25rem; font-weight: 700; color: #111827; margin-bottom: 0.625rem; }
.ig-faq-sidebar-body p { font-size: 0.875rem; color: #6b7280; line-height: 1.6; }
.ig-faq-sidebar-tip {
    margin-top: 1rem; padding: 0.75rem 1rem; background: #f9fafb;
    border-radius: 0.5rem; border: 1px solid #e5e7eb;
}
.ig-faq-sidebar-tip .tip-label { font-size: 0.75rem; font-weight: 600; color: #1f2937; display: flex; align-items: center; gap: 0.375rem; }
.ig-faq-sidebar-tip .tip-label svg { color: #fc481c; }
.ig-faq-sidebar-tip p { font-size: 0.75rem; color: #6b7280; margin-top: 0.375rem; }

/* ===================== */
/* HOW TO BUY SECTION    */
/* ===================== */
.ig-howto-section { background: #f3f4f6; text-align: center; padding: 2.25rem 1.5rem 0; }
.ig-howto-section h2 { font-size: 1.875rem; font-weight: 700; }
.ig-howto-section > p { font-size: 1.125rem; }
.ig-howto-steps {
    max-width: 1300px; margin: 0 auto; padding: 0 1.25rem 2rem;
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;
}
.ig-howto-step { max-width: 330px; margin: 0 auto; width: 100%; }
.ig-howto-step-inner { border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem; background: #fff; }
.ig-howto-step-inner .step-head { display: flex; align-items: center; gap: 0.75rem; }
.ig-howto-step-inner .step-head svg { width: 38px; height: 38px; stroke: #0080ff; fill: none; stroke-width: 2; }
.ig-howto-step-inner .step-head h3 { font-size: 1.125rem; font-weight: 600; }
.ig-howto-step-inner .step-img {
    width: 100%; height: auto; margin-top: 0.75rem; border-radius: 4px;
    background: linear-gradient(135deg, #f0f4ff, #fdf2f8); min-height: 120px;
    display: flex; align-items: center; justify-content: center; font-size: 2.5rem;
}

.ig-howto-cta { margin: 2.5rem 0; text-align: center; }
.ig-howto-cta a {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: #3b82f6; color: #fff; font-weight: 500; padding: 0.625rem 2rem;
    border-radius: 0.375rem; text-decoration: none; transition: background 0.2s;
}
.ig-howto-cta a:hover { background: #2563eb; }

/* ===================== */
/* RELATED SERVICES      */
/* ===================== */
.ig-related-section { text-align: center; margin: 2rem auto; padding: 0 1.25rem; }
.ig-related-section h2 { font-size: 1.875rem; font-weight: 700; color: #111827; }
.ig-related-section > p { font-size: 1.125rem; color: #4b5563; }
.ig-related-btns { display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; max-width: 1000px; margin: 2rem auto 0; }
.ig-related-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
    background: linear-gradient(to bottom right, #E1306C, #F77737);
    color: #fff; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 9999px;
    text-decoration: none; min-width: 200px; transition: all 0.3s;
}
.ig-related-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); filter: brightness(1.1); }

/* ===================== */
/* AUTHOR BIO            */
/* ===================== */
.ig-author-section { max-width: 1200px; margin: 4rem auto; padding: 0 1rem; }
.ig-author-card {
    background: linear-gradient(to bottom right, #f9fafb, #fff); border-radius: 1rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;
    padding: 1.5rem 2rem; display: flex; gap: 2rem; transition: box-shadow 0.3s;
}
.ig-author-card:hover { box-shadow: 0 12px 35px rgba(0,0,0,0.1); }
.ig-author-avatar { flex-shrink: 0; text-align: center; }
.ig-author-avatar .avatar-circle {
    width: 128px; height: 128px; border-radius: 50%; overflow: hidden;
    border: 4px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    background: linear-gradient(135deg, #fdf2f8, #faf5ff);
    display: flex; align-items: center; justify-content: center; font-size: 3rem;
}
.ig-author-info { flex: 1; }
.ig-author-info .written-by { color: #0080ff; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
.ig-author-info h3 { font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 0.75rem; }
.ig-author-info .title { font-size: 0.875rem; font-weight: 500; color: #0080ff; margin-bottom: 1rem; }
.ig-author-info .bio { color: #4b5563; line-height: 1.6; margin-bottom: 1.5rem; font-size: 0.9375rem; }
.ig-author-meta { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin-bottom: 1rem; }
.ig-author-meta .meta-item { display: flex; align-items: center; gap: 0.5rem; color: #6b7280; font-size: 0.875rem; }

/* ===================== */
/* CMS CONTENT SECTION   */
/* ===================== */
.ig-content-section { max-width: 1200px; margin: 2.5rem auto; padding: 0 1.25rem; }
.ig-content-section .ck-content { padding: 0 1.25rem; line-height: 2; }
.ig-content-section .ck-content h2 { font-size: 1.5rem; font-weight: 700; margin: 2rem 0 0.75rem; }
.ig-content-section .ck-content h3 { font-size: 1.25rem; font-weight: 700; margin: 1.5rem 0 0.5rem; }
.ig-content-section .ck-content p { color: #374151; margin-bottom: 1rem; }
.ig-content-section .ck-content a { color: #0080ff; }

/* ===================== */
/* RESPONSIVE            */
/* ===================== */
@media (max-width: 768px) {
    .ig-features-grid { grid-template-columns: 1fr; }
    .ig-faq-grid { grid-template-columns: 1fr; }
    .ig-faq-sidebar { order: -1; }
    .ig-howto-steps { grid-template-columns: 1fr 1fr; }
    .ig-author-card { flex-direction: column; text-align: center; }
    .ig-author-meta { justify-content: center; }
    .service-tabs { gap: 4px; }
    .service-tab { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
    .pkg-card { min-width: 55px; max-width: 70px; }
}
@media (max-width: 480px) {
    .ig-howto-steps { grid-template-columns: 1fr; }
    .rating-bar { flex-direction: column; align-items: flex-start; }
    .live-order-badge { display: none; }
}
</style>

<!-- ============================================ -->
<!-- PAGE TITLE                                   -->
<!-- ============================================ -->
<main style="flex: 1;">
<div class="ig-page-title">
    <h1>Buy Instagram Followers to <span>Accelerate Growth</span> 🔥</h1>
    <p>Famoid offers the best way to buy real Instagram followers safely and efficiently with just a few clicks.</p>
</div>

<!-- ============================================ -->
<!-- MAIN ORDER WIDGET                            -->
<!-- ============================================ -->
<div style="max-width: 100%; margin: 0 auto 2rem; padding: 0 1rem;">
<div class="order-main-card" id="order">
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div style="width: 100%;">
            <div style="max-width: 650px; margin: 0 auto; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

                <!-- Rating Bar -->
                <div class="rating-bar">
                    <div class="rating-left">
                        <div class="rating-stars">
                            <?php for($i=0;$i<5;$i++): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <?php endfor; ?>
                            <span class="score">4.9</span>
                        </div>
                        <div class="rating-meta">
                            <span class="excellent">EXCELLENT</span>
                            <span class="reviews-count">12,847 verified reviews</span>
                        </div>
                    </div>

                    <!-- Live Order Badge (desktop) -->
                    <div class="live-order-badge" style="display: none;" id="liveOrderBadge">
                        <span class="pulse"><span></span><span></span></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span class="order-text" id="liveOrderText">2,500 likes</span>
                        <span style="color:#d1d5db">|</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span style="color:#9ca3af;font-size:0.875rem" id="liveOrderTime">8 MINS AGO</span>
                        <span style="color:#d1d5db">|</span>
                        <span id="liveOrderFlag">🇬🇧 UK</span>
                    </div>

                    <!-- Safe Badge -->
                    <div class="safe-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11.46 8.574a1 1 0 0 1 1.08 0l5.178 3.318a1 1 0 0 1 0 1.69l-5.178 3.318a1 1 0 0 1-1.08 0l-5.178-3.318a1 1 0 0 1 0-1.69z" fill="none"/><path d="M12 2l8 4.5v5a11.72 11.72 0 0 1-8 10.5A11.72 11.72 0 0 1 4 11.5V6.5z"/><path d="m9 12 2 2 4-4"/></svg>
                        <span>100% Safe & Secure</span>
                    </div>
                </div>

                <!-- Service Tabs -->
                <div class="order-widget-inner">
                    <div style="overflow: visible; background: transparent;">
                        <div style="display: flex; justify-content: center;">
                            <div class="service-tabs">
                                <button class="service-tab active" onclick="switchTab('real', this)" data-tab="real">
                                    <div style="position: relative;">
                                        <span class="tab-badge" style="background: linear-gradient(to right, #f97316, #ef4444);">STANDARD</span>
                                        <span style="display:flex;align-items:center;justify-content:center;">
                                            <svg viewBox="0 0 24 24"><path d="M12 4v3m-4 -1.5l1.5 2.5m-5.5 -0.5l2.5 1m8 -3l-1.5 2.5m5.5 -0.5l-2.5 1m-2 5a4 4 0 1 0 -4 0m-1 1h6l1 5h-8z"/></svg>
                                        </span>
                                    </div>
                                    <span style="margin-left:5px;">Real Followers</span>
                                </button>
                                <button class="service-tab" onclick="switchTab('managed', this)" data-tab="managed">
                                    <div style="position: relative;">
                                        <span class="tab-badge" style="background: #3b82f6;">POPULAR</span>
                                        <span style="display:flex;align-items:center;justify-content:center;">
                                            <svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M16 3v4"/><path d="M8 3v4"/><path d="M4 11h16"/><path d="M12 16h.01"/></svg>
                                        </span>
                                    </div>
                                    <span style="margin-left:5px;">Managed Growth</span>
                                </button>
                                <button class="service-tab" onclick="switchTab('prestige', this)" data-tab="prestige">
                                    <div style="position: relative;">
                                        <span class="tab-badge" style="background: #ec4899;">EXCLUSIVE</span>
                                        <span style="display:flex;align-items:center;justify-content:center;">
                                            <svg viewBox="0 0 24 24"><path d="M12 6l4 6l5 -4l-2 10h-14l-2 -10l5 4z"/></svg>
                                        </span>
                                    </div>
                                    <span style="margin-left:5px;">Prestige Packs</span>
                                </button>
                            </div>
                        </div>

                        <!-- Trust Bar -->
                        <div class="trust-bar">
                            <div class="trust-bar-item">
                                <svg viewBox="0 0 24 24"><path d="M12 4v3m-4 -1.5l1.5 2.5m-5.5 -0.5l2.5 1m8 -3l-1.5 2.5m5.5 -0.5l-2.5 1m-2 5a4 4 0 1 0 -4 0m-1 1h6l1 5h-8z"/></svg>
                                <span>Real Followers</span>
                            </div>
                            <div class="trust-bar-item">
                                <svg viewBox="0 0 24 24"><path d="M12 2l8 4.5v5a11.72 11.72 0 0 1-8 10.5A11.72 11.72 0 0 1 4 11.5V6.5z"/><rect x="8" y="11" width="8" height="5" rx="1"/><path d="M10 11v-2a2 2 0 1 1 4 0v2"/></svg>
                                <span>No Password</span>
                            </div>
                            <div class="trust-bar-item">
                                <svg viewBox="0 0 24 24"><path d="M4 13c.325 2.532 1.881 4.781 4 6m12 -7c-.325 2.532-1.881 4.781-4 6m-4 -14v2m-4 2l-2 -2m12 2l2 -2m-8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/></svg>
                                <span>24/7 Support</span>
                            </div>
                            <div class="trust-bar-item">
                                <svg viewBox="0 0 24 24"><path d="M4 13a8 8 0 0 1 7-7.93V4h2v1.07A8 8 0 0 1 20 13m-8-9v2m-7 7h2m12 0h2"/><path d="M15 12.9a5 5 0 1 0-6 0"/></svg>
                                <span>Fast Growth</span>
                            </div>
                        </div>

                        <!-- Package Grid -->
                        <div class="package-select-grid" id="packageGrid">
                            <?php foreach($realFollowersPacks as $i => $pack): ?>
                            <div class="pkg-card <?php echo $i === 0 ? 'selected' : ''; ?>"
                                 onclick="selectPackage(this, <?php echo $pack['qty']; ?>, <?php echo $pack['price']; ?>)"
                                 data-qty="<?php echo $pack['qty']; ?>" data-price="<?php echo $pack['price']; ?>">
                                <div class="pkg-check">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                                <span class="pkg-qty"><?php echo number_format($pack['qty']); ?></span>
                                <span class="pkg-label-text">Followers</span>
                                <?php if($pack['label'] && strpos($pack['label'], 'Save') !== false): ?>
                                <div style="margin-top:5px;height:25px;">
                                    <span class="pkg-save-badge"><?php echo $pack['label']; ?></span>
                                </div>
                                <?php else: ?>
                                <div style="margin-top:5px;height:25px;"></div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Price & Buy Now -->
                        <div class="order-action">
                            <div class="order-price">
                                <span id="displayPrice">$3.95</span>
                            </div>
                            <a href="javascript:void(0);" onclick="handleBuyNow()" class="buy-now-btn" id="buyNowBtn">Buy Now!</a>
                        </div>

                        <!-- Terms -->
                        <p class="order-terms">By initiating this order, you agree to <a href="terms-of-service.php" target="_blank">terms of service</a> and <a href="privacy-policy.php" target="_blank">privacy policy</a>.</p>
                    </div>
                </div>

                <!-- Payment Footer -->
                <div class="payment-footer">
                    <div class="pay-icon" style="font-size: 1.5rem; font-weight: 700; color: #000;">🍎 Pay</div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.25rem;">
                        <div class="social-proof-text">
                            <span class="dot"></span>
                            <span><strong>24/7</strong> support • <strong>500k+</strong> customers</span>
                        </div>
                    </div>
                    <div class="card-icons">
                        <div class="card-icon">VISA</div>
                        <div class="card-icon">MC</div>
                        <div class="card-icon">AMEX</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- ============================================ -->
<!-- FEATURES SECTION                             -->
<!-- ============================================ -->
<div class="ig-features-section" style="text-align: center;">
    <span class="section-badge">America's #1 Social Media Marketing Agency</span>
    <h2>Start Your Instagram Growth Right Away with Famoid!</h2>
    <p>With Famoid, you can easily purchase Instagram services and boost your account naturally through Ads.</p>
    <div class="ig-features-grid">
        <div class="ig-feature-card">
            <div class="icon">😊</div>
            <h3>Satisfaction Guaranteed</h3>
            <p>Your success is assured with Famoid. We constantly strive to provide the best-in-class service to satisfy our customers.</p>
        </div>
        <div class="ig-feature-card">
            <div class="icon">📊</div>
            <h3>Ad-Based Growth</h3>
            <p>Our Ad-based promotional system will get you high-quality organic engagement by distributing your content to a targeted audience.</p>
        </div>
        <div class="ig-feature-card">
            <div class="icon">🚀</div>
            <h3>Instant Delivery</h3>
            <p>Enjoy Instant delivery of a high-quality audience while protecting your account from getting banned for suspicious activity.</p>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- CATCHY CTA                                   -->
<!-- ============================================ -->
<div class="ig-catchy-section">
    <h2>🥇 Thinking About Buying Instagram Followers?</h2>
    <p>We love helping you turn your Instagram presence into a success.</p>
</div>

<!-- ============================================ -->
<!-- TESTIMONIALS                                 -->
<!-- ============================================ -->
<section class="section testimonials-section" style="max-width: 1200px; margin: 2.5rem auto;">
    <div class="section-inner">
        <div class="testimonials-track-wrapper">
            <div class="testimonials-track">
                <?php
                $testimonials = getFormattedTestimonials();
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

<!-- ============================================ -->
<!-- CMS CONTENT - Why Buy Instagram Followers    -->
<!-- ============================================ -->
<div class="ig-catchy-section">
    <h2>🤔 Why Should You Buy Instagram Followers?</h2>
    <p>There are lots of reasons to purchase Instagram followers through Famoid, here are some.</p>
</div>

<div class="ig-content-section">
    <div class="ck-content">
        <p><strong>Buying Instagram followers</strong> is easy, but knowing why you should buy them in the first place is the most challenging part.</p>
        <p>People are buying Instagram followers right and left, but they mostly don't even know why they are buying them.</p>
        <p>Some users are also confused about whether they should <strong>buy Instagram followers</strong>.</p>
        <p>To clear all this confusion and doubts, we're going to list some of the <strong>crucial reasons</strong> why you should invest your money in buying Instagram followers.</p>

        <h3><strong>Stand Out From The Crowd</strong></h3>
        <p><strong>Let's be real for a moment.</strong></p>
        <p>No one really cares about an <strong>Instagram account</strong> with just a handful of followers.</p>
        <p>No matter <strong>how good your content is</strong>, how well you have structured your profile, or how consistent you are, if you don't have followers, no one trusts you.</p>
        <p>You become just another Instagram profile in the <strong>sea of billions of profiles</strong>.</p>
        <p><strong>Buying Instagram followers</strong> helps you stand out from the crowd by <strong>instantly building your social proof</strong>.</p>
        <p>When you have a few thousand <strong>followers on your IG</strong>, everyone seems to be interested in listening to what you say.</p>
        <p>When your profile looks like it's already a hit, people are far more likely to follow you, engage with your content, and <strong>take you seriously</strong>.</p>

        <h3><strong>Build Social Proof</strong></h3>
        <p><strong>Numbers speak louder</strong> than words.</p>
        <p>People naturally assume that if an account has thousands of followers, <strong>it must be trustworthy,</strong> popular, or worth following.</p>
        <p>Humans always follow the crowd. It's a <strong>basic psychological phenomenon</strong>.</p>
        <p>Buying Instagram followers helps establish strong social proof from the beginning, resulting in <strong>more organic engagement, followers, and growth</strong>.</p>

        <h3><strong>Save Time & Effort</strong></h3>
        <p>Let's be honest, <strong>growing your Instagram</strong> the traditional way can take forever.</p>
        <p>You have to post endlessly, constantly be active on the platform, <strong>create great content</strong>, and still wait for months or even years to get noticed.</p>
        <p><strong>Buying Instagram followers</strong> saves you from all those hassles, while saving your precious time and effort.</p>
        <p>Instead of struggling to get noticed in a <strong>crowded feed</strong>, you'll start with a profile that already appears active and trustworthy.</p>
        <p>This way, you can put <strong>all your energy</strong> into what matters the most...<strong>creating content</strong>.</p>
    </div>
</div>

<!-- ============================================ -->
<!-- FAQ SECTION                                  -->
<!-- ============================================ -->
<div class="ig-faq-section">
    <div class="ig-faq-grid">
        <!-- FAQ Accordion -->
        <div>
            <div class="ig-faq-card">
                <div class="ig-faq-card-header">
                    <div class="faq-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M8 8a3.5 3 0 0 1 3.5-3h1a3.5 3 0 0 1 3.5 3 3 3 0 0 1-2 3 3 4 0 0 0-2 4"/><path d="M12 19v.01"/></svg>
                    </div>
                    <div>
                        <h3>Frequently Asked Questions</h3>
                        <p>Everything you need to know about Instagram Followers</p>
                    </div>
                </div>
                <?php foreach($faqItems as $idx => $faq): ?>
                <div class="ig-faq-item">
                    <button class="ig-faq-btn" onclick="toggleFaq(this)">
                        <div class="num"><?php echo $idx + 1; ?></div>
                        <h4><?php echo htmlspecialchars($faq['q']); ?></h4>
                        <svg class="chevron" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="ig-faq-answer">
                        <div class="ig-faq-answer-inner">
                            <p><?php echo htmlspecialchars($faq['a']); ?></p>
                            <span class="verified">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Verified by Famoid Team
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- FAQ Sidebar -->
        <div class="ig-faq-sidebar">
            <div class="ig-faq-sidebar-card">
                <div style="position: relative;">
                    <div class="ig-faq-sidebar-img-placeholder">❓📸</div>
                    <div class="ig-faq-sidebar-badge" style="position: absolute; top: 10px; right: 10px;">
                        <span><?php echo count($faqItems); ?> Questions Answered</span>
                    </div>
                </div>
                <div class="ig-faq-sidebar-body">
                    <h4>Learn More About Instagram Followers</h4>
                    <p>Browse through our comprehensive FAQ section to understand how Famoid's Instagram Followers service works and how it can benefit your social media growth.</p>
                    <div class="ig-faq-sidebar-tip">
                        <div class="tip-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 18a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2"/><path d="M12 2a7 7 0 0 0-4 12.9V16h8v-1.1A7 7 0 0 0 12 2z"/></svg>
                            Pro Tip:
                        </div>
                        <p>Click on any question to reveal detailed answers from our expert team.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- AUTHOR BIO                                   -->
<!-- ============================================ -->
<div class="ig-author-section">
    <div class="ig-author-card">
        <div class="ig-author-avatar">
            <div class="avatar-circle">👩‍💼</div>
        </div>
        <div class="ig-author-info">
            <div class="written-by">Written By</div>
            <h3>Jennifer Smith</h3>
            <div class="title">Social Media Marketing Specialist</div>
            <p class="bio">Jennifer Smith is a writer at Famoid.com specializing in social media and digital marketing. She likes to make complicated things easily understandable for everyone. Her writing expertise includes how-to guides, social media tips and tricks, and digital marketing. When she's not writing, she is either traveling in some part of the world or painting in her house.</p>
            <div class="ig-author-meta">
                <div class="meta-item">📄 <span>55 Articles</span></div>
                <div class="meta-item">🌐 <a href="#" style="color:#0080ff;text-decoration:none;">Website</a></div>
                <div class="meta-item">📅 <span>Updated: <time datetime="<?php echo date('Y-m-d'); ?>"><?php echo date('F j, Y'); ?></time></span></div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- HOW TO BUY                                   -->
<!-- ============================================ -->
<div class="ig-howto-section">
    <h2>How to Buy Instagram Followers</h2>
    <p>Follow the steps shown below to <b>complete your purchase quickly</b> at Famoid!</p>
</div>
<div style="width:100%;background:#f1f3f5;">
    <div class="ig-howto-steps" style="max-width:1300px;margin:0 auto;padding:1rem 1.25rem 2rem;">
        <div class="ig-howto-step">
            <div class="ig-howto-step-inner">
                <div class="step-head">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M10 10a2 2 0 0 1 4 0v0a2 2 0 0 1-2 2h0v2"/><circle cx="12" cy="12" r="10"/><text x="12" y="16" text-anchor="middle" fill="#0080ff" font-weight="700" font-size="12">1</text></svg>
                    <h3>Choose a Package</h3>
                </div>
                <div class="step-img">📦</div>
            </div>
        </div>
        <div class="ig-howto-step">
            <div class="ig-howto-step-inner">
                <div class="step-head">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><text x="12" y="16" text-anchor="middle" fill="#0080ff" font-weight="700" font-size="12">2</text></svg>
                    <h3>Enter your Username</h3>
                </div>
                <div class="step-img">👤</div>
            </div>
        </div>
        <div class="ig-howto-step">
            <div class="ig-howto-step-inner">
                <div class="step-head">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><text x="12" y="16" text-anchor="middle" fill="#0080ff" font-weight="700" font-size="12">3</text></svg>
                    <h3>Complete Payment</h3>
                </div>
                <div class="step-img">💳</div>
            </div>
        </div>
        <div class="ig-howto-step">
            <div class="ig-howto-step-inner">
                <div class="step-head">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><text x="12" y="16" text-anchor="middle" fill="#0080ff" font-weight="700" font-size="12">4</text></svg>
                    <h3>That's all!</h3>
                </div>
                <div class="step-img">🎉</div>
            </div>
        </div>
    </div>
    <div class="ig-howto-cta">
        <a href="#order">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h3m6-9v3m5.656 2.344l-2.12 2.12M21 12h-3m-2.656 5.656l-2.12-2.12M12 21v-3m-5.656-2.344l2.12-2.12"/><circle cx="12" cy="12" r="3"/></svg>
            Get Started Now
        </a>
    </div>
</div>

<!-- ============================================ -->
<!-- RELATED SERVICES                             -->
<!-- ============================================ -->
<div class="ig-related-section" style="margin-top: 2rem; margin-bottom: 2rem;">
    <h2>Check Out Our Other Instagram Services!</h2>
    <p>We offer a <b>wide range</b> of Instagram services to <b>boost your account</b> and <b>increase engagements!</b></p>
    <div class="ig-related-btns">
        <a href="index.php?p=buy-instagram-followers" class="ig-related-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 7a4 4 0 1 0 8 0 4 4 0 1 0-8 0"/><path d="M6 21v-2a4 4 0 0 1 4-4h0"/><path d="M16 19h6"/><path d="M19 16v6"/></svg>
            Buy Followers
        </a>
        <a href="index.php?p=buy-instagram-likes" class="ig-related-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 11v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1h3a4 4 0 0 0 4-4V6a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1-2 2h-7"/></svg>
            Buy Likes
        </a>
        <a href="index.php?p=buy-instagram-views" class="ig-related-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 4v16l13-8z"/></svg>
            Buy Views
        </a>
        <a href="#" class="ig-related-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 4v16l13-8z"/><path d="M20 4v16"/></svg>
            Buy Reels Views
        </a>
        <a href="#" class="ig-related-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19.5 12.572l-7.5 7.428l-7.5-7.428a5 5 0 1 1 7.5-6.566a5 5 0 1 1 7.5 6.572"/><path d="M20 6v4h-4"/></svg>
            Automatic Likes
        </a>
    </div>
</div>
</main>

<!-- ============================================ -->
<!-- JAVASCRIPT                                   -->
<!-- ============================================ -->
<script>
// Package data for each tab
const tabPackages = {
    real: <?php echo json_encode($realFollowersPacks); ?>,
    managed: <?php echo json_encode($managedGrowthPacks); ?>,
    prestige: <?php echo json_encode($prestigePacks); ?>
};
let currentTab = 'real';
let selectedQty = 100;
let selectedPrice = 3.95;

// Switch tab
function switchTab(tab, btn) {
    currentTab = tab;
    // Update tab buttons
    document.querySelectorAll('.service-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    // Rebuild package grid
    const grid = document.getElementById('packageGrid');
    const packs = tabPackages[tab];
    grid.innerHTML = '';
    packs.forEach((pack, i) => {
        const card = document.createElement('div');
        card.className = 'pkg-card' + (i === 0 ? ' selected' : '');
        card.setAttribute('data-qty', pack.qty);
        card.setAttribute('data-price', pack.price);
        card.onclick = function() { selectPackage(this, pack.qty, pack.price); };
        let saveHtml = '';
        if (pack.label && (pack.label.includes('Save') || pack.label.includes('/month') || pack.label === 'Premium')) {
            saveHtml = '<div style="margin-top:5px;height:25px;"><span class="pkg-save-badge">' + pack.label + '</span></div>';
        } else {
            saveHtml = '<div style="margin-top:5px;height:25px;"></div>';
        }
        card.innerHTML =
            '<div class="pkg-check"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"></polyline></svg></div>' +
            '<span class="pkg-qty">' + pack.qty.toLocaleString() + '</span>' +
            '<span class="pkg-label-text">Followers</span>' + saveHtml;
        grid.appendChild(card);
    });
    // Select first package
    if (packs.length > 0) {
        selectedQty = packs[0].qty;
        selectedPrice = packs[0].price;
        document.getElementById('displayPrice').textContent = '$' + packs[0].price.toFixed(2);
    }
}

// Select package
function selectPackage(el, qty, price) {
    document.querySelectorAll('.pkg-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedQty = qty;
    selectedPrice = price;
    document.getElementById('displayPrice').textContent = '$' + price.toFixed(2);
}

// Buy Now
function handleBuyNow() {
    const orderUrl = 'checkout.php?service=instagram_followers&qty=' + selectedQty + '&price=' + selectedPrice + '&tab=' + currentTab;
    <?php if (isset($loggedInUser) && $loggedInUser): ?>
    window.location.href = orderUrl;
    <?php else: ?>
    if (typeof submitOrderForm === 'function') {
        const fd = new FormData();
        fd.append('service_type', 'instagram_followers');
        fd.append('quantity', selectedQty);
        fd.append('price', selectedPrice);
        fd.append('tab', currentTab);
        submitOrderForm(fd, 'instagram_followers');
    } else {
        window.location.href = orderUrl;
    }
    <?php endif; ?>
}

// FAQ toggle
function toggleFaq(btn) {
    const item = btn.closest('.ig-faq-item');
    const wasActive = item.classList.contains('active');
    // Close all
    document.querySelectorAll('.ig-faq-item').forEach(i => i.classList.remove('active'));
    // Toggle clicked
    if (!wasActive) item.classList.add('active');
}

// Live order notification rotation
(function() {
    const orders = [
        { text: '2,500 likes', time: '8 MINS AGO', flag: '🇬🇧 UK' },
        { text: '1,000 followers', time: '3 MINS AGO', flag: '🇺🇸 US' },
        { text: '5,000 views', time: '12 MINS AGO', flag: '🇩🇪 DE' },
        { text: '500 followers', time: '1 MIN AGO', flag: '🇫🇷 FR' },
        { text: '10,000 likes', time: '5 MINS AGO', flag: '🇧🇷 BR' },
        { text: '3,000 followers', time: '15 MINS AGO', flag: '🇦🇺 AU' },
    ];
    let idx = 0;
    const badge = document.getElementById('liveOrderBadge');
    const textEl = document.getElementById('liveOrderText');
    const timeEl = document.getElementById('liveOrderTime');
    const flagEl = document.getElementById('liveOrderFlag');
    
    // Show badge on desktop
    if (window.innerWidth >= 768 && badge) {
        badge.style.display = 'flex';
    }
    
    setInterval(function() {
        idx = (idx + 1) % orders.length;
        if (badge) badge.style.opacity = '0';
        setTimeout(function() {
            if (textEl) textEl.textContent = orders[idx].text;
            if (timeEl) timeEl.textContent = orders[idx].time;
            if (flagEl) flagEl.textContent = orders[idx].flag;
            if (badge) badge.style.opacity = '1';
        }, 300);
    }, 5000);
    if (badge) badge.style.transition = 'opacity 0.3s';
})();
</script>
