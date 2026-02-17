<?php
/**
 * Dynamic Service Detail Page - CLEAN URL VERSION
 * Works with parent-child services table
 */

// Include integration functions
require_once __DIR__ . '/../includes/service_integration.php';
require_once __DIR__ . '/../includes/testimonial_integration.php';
require_once __DIR__ . '/../includes/dynamic_service_integration.php';

// Get service slug from URL
$serviceSlug = isset($_GET['p']) ? $_GET['p'] : 'buy-instagram-followers';

// Get service data
$service = getServiceBySlug($serviceSlug);

// If service not found, show 404
if (!$service) {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>Service Not Found</h1>";
    exit;
}

// Get service tags
$serviceTags = getServiceTags($service['id']);

// Get packages for first tag (default)
$firstTag = !empty($serviceTags) ? $serviceTags[0] : null;
$defaultPackages = $firstTag ? getServicePackages($service['id'], $firstTag['id']) : [];

// Format packages for JavaScript - WITH CODES FOR CLEAN URLs
$packagesJS = formatPackagesWithCodes($serviceTags);

// Get FAQs
$faqItems = getServiceFaqs($serviceSlug);

// Get testimonials
$testimonials = getFormattedTestimonials();

// Get first tag features for trust bar (use the first tag's features)
$trustBarFeatures = $firstTag && !empty($firstTag['features']) ? $firstTag['features'] : ['Real Service', 'No Password', '24/7 Support', 'Fast Delivery'];
?>

<link rel="stylesheet" href="<?php echo Config::baseUrl(); ?>/css/service-details.css">

<!-- PAGE TITLE -->
<br clear="both">
<main style="flex: 1;padding-top:10px">
<div class="ig-page-title">
    <h1><?php echo htmlspecialchars($service['page_title']); ?></h1>
    <p><?php echo htmlspecialchars($service['page_subtitle']); ?></p>
</div>

<!-- MAIN ORDER WIDGET -->
<div style="max-width: 100%; margin: 0 auto 2rem; padding: 0 1rem;">
<div class="order-main-card" id="order">
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div style="width: 100%;">
            <div style="max-width: 960px; width: 100%; margin: 0 auto; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

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

                    <!-- Safe Badge -->
                    <div class="safe-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11.46 8.574a1 1 0 0 1 1.08 0l5.178 3.318a1 1 0 0 1 0 1.69l-5.178 3.318a1 1 0 0 1-1.08 0l-5.178-3.318a1 1 0 0 1 0-1.69z" fill="none"/><path d="M12 2l8 4.5v5a11.72 11.72 0 0 1-8 10.5A11.72 11.72 0 0 1 4 11.5V6.5z"/><path d="m9 12 2 2 4-4"/></svg>
                        <span>100% Safe & Secure</span>
                    </div>
                </div>

                <!-- Service Tabs -->
                <?php if (!empty($serviceTags)): ?>
                <div class="order-widget-inner">
                    <div style="overflow: visible; background: transparent; width: 100%;">
                        <div style="display: flex; justify-content: center;">
                            <div class="service-tabs">
                                <?php foreach($serviceTags as $index => $tag): ?>
                                <button class="service-tab <?php echo $index === 0 ? 'active' : ''; ?>" 
                                        onclick="switchTab('<?php echo $tag['tag_slug']; ?>', this)" 
                                        data-tab="<?php echo $tag['tag_slug']; ?>"
                                        data-features='<?php echo htmlspecialchars(json_encode($tag['features'])); ?>'>
                                    <div style="position: relative;">
                                        <?php if ($tag['badge_label']): ?>
                                        <span class="tab-badge" style="background: <?php echo $tag['badge_color']; ?>;"><?php echo htmlspecialchars($tag['badge_label']); ?></span>
                                        <?php endif; ?>
                                        <span style="display:flex;align-items:center;justify-content:center;">
                                            <?php if ($tag['icon']): ?>
                                            <span style="font-size:1.2rem;"><?php echo $tag['icon']; ?></span>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <span style="margin-left:5px;"><?php echo htmlspecialchars($tag['tag_name']); ?></span>
                                </button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Trust Bar (Features) -->
                        <div class="trust-bar" id="trustBar">
                            <?php foreach($trustBarFeatures as $feature): ?>
                            <div class="trust-bar-item">
                                <span><?php echo htmlspecialchars($feature); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Package Grid -->
                        <div class="package-select-grid" id="packageGrid">
                            <?php foreach($defaultPackages as $i => $pack): ?>
                            <div class="pkg-card <?php echo $i === 0 ? 'selected' : ''; ?>"
                                 onclick="selectPackage(this, <?php echo $pack['quantity']; ?>, <?php echo $pack['price']; ?>, '<?php echo $pack['package_code']; ?>', <?php echo $pack['id']; ?>)"
                                 data-qty="<?php echo $pack['quantity']; ?>" 
                                 data-price="<?php echo $pack['price']; ?>"
                                 data-code="<?php echo $pack['package_code']; ?>"
                                 data-id="<?php echo $pack['id']; ?>">
                                <div class="pkg-check">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                                <div style="text-align: center;">
                                    <span class="pkg-qty"><?php echo number_format($pack['quantity']); ?></span>
                                    <span class="pkg-label-text"><?php echo ucfirst(str_replace(['-', '_'], ' ', explode('-', $serviceSlug)[count(explode('-', $serviceSlug)) - 1])); ?></span>
                                </div>
                                <?php if($pack['discount_label'] && (strpos($pack['discount_label'], 'Off') !== false || strpos($pack['discount_label'], 'Save') !== false)): ?>
                                <div style="margin-top:5px;height:25px;">
                                    <span class="pkg-save-badge"><?php echo $pack['discount_label']; ?></span>
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
                                <span id="displayPrice">$<?php echo !empty($defaultPackages) ? number_format($defaultPackages[0]['price'], 2) : '0.00'; ?></span>
                            </div>
                            <a href="javascript:void(0);" onclick="handleBuyNow()" class="buy-now-btn" id="buyNowBtn">Buy Now!</a>
                        </div>

                        <!-- Terms -->
                        <p class="order-terms">By initiating this order, you agree to <a href="terms-of-service.php" target="_blank">terms of service</a> and <a href="privacy-policy.php" target="_blank">privacy policy</a>.</p>
                    </div>
                </div>
                <?php endif; ?>

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

<!-- FEATURES SECTION -->
<div class="ig-features-section" style="text-align: center;">
    <span class="section-badge">Ad-backed, human-first delivery</span>
    <h2>Start your Instagram growth with Genuine Socials</h2>
    <p>Purchase services that look organic. We blend ad distribution with gradual delivery so results feel real.</p>
    <div class="ig-features-grid">
        <div class="ig-feature-card">
            <div class="icon">😊</div>
            <h3>Satisfaction Guaranteed</h3>
            <p>Your success is our north star. If something slips, we make it right fast.</p>
        </div>
        <div class="ig-feature-card">
            <div class="icon">📊</div>
            <h3>Ad-Based Growth</h3>
            <p>Our promotional system gets you high-quality organic engagement by distributing your content.</p>
        </div>
        <div class="ig-feature-card">
            <div class="icon">🚀</div>
            <h3>Instant Delivery</h3>
            <p>Enjoy instant delivery while protecting your account from suspicious activity.</p>
        </div>
    </div>
</div>

<!-- TESTIMONIALS -->
<section class="section testimonials-section" style="max-width: 1200px; margin: 2.5rem auto;">
    <div class="section-inner">
        <div class="testimonials-track-wrapper">
            <div class="testimonials-track">
                <?php
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

<!-- FAQ SECTION -->
<?php if (!empty($faqItems)): ?>
<div class="ig-faq-section">
    <div class="ig-faq-grid">
        <div>
            <div class="ig-faq-card">
                <div class="ig-faq-card-header">
                    <div class="faq-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M8 8a3.5 3 0 0 1 3.5-3h1a3.5 3 0 0 1 3.5 3 3 3 0 0 1-2 3 3 4 0 0 0-2 4"/><path d="M12 19v.01"/></svg>
                    </div>
                    <div>
                        <h3>Frequently Asked Questions</h3>
                        <p>Everything you need to know about <?php echo htmlspecialchars($service['name']); ?></p>
                    </div>
                </div>
                <?php foreach($faqItems as $idx => $faq): ?>
                <div class="ig-faq-item">
                    <button class="ig-faq-btn" onclick="toggleFaq(this)" type="button">
                        <div class="num"><?php echo $idx + 1; ?></div>
                        <h4><?php echo htmlspecialchars($faq['q']); ?></h4>
                        <svg class="chevron" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="ig-faq-answer">
                        <div class="ig-faq-answer-inner">
                            <p><?php echo htmlspecialchars($faq['a']); ?></p>
                            <span class="verified">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Verified by Genuine Socials Team
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="ig-faq-sidebar">
            <div class="ig-faq-sidebar-card">
                <div style="position: relative;">
                    <div class="ig-faq-sidebar-img-placeholder"><?php echo $service['icon'] ?: '❓'; ?>📸</div>
                    <div class="ig-faq-sidebar-badge" style="position: absolute; top: 10px; right: 10px;">
                        <span><?php echo count($faqItems); ?> Questions Answered</span>
                    </div>
                </div>
                <div class="ig-faq-sidebar-body">
                    <h4>Learn More</h4>
                    <p>Browse our comprehensive FAQ section to understand how this service works.</p>
                    <div class="ig-faq-sidebar-tip">
                        <div class="tip-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 18a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2"/><path d="M12 2a7 7 0 0 0-4 12.9V16h8v-1.1A7 7 0 0 0 12 2z"/></svg>
                            Pro Tip:
                        </div>
                        <p>Click any question to reveal detailed answers from our expert team.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

</main>

<!-- JAVASCRIPT - CLEAN URL VERSION -->
<script>
const tabPackages = <?php echo json_encode($packagesJS); ?>;
let currentTab = '<?php echo !empty($serviceTags) ? $serviceTags[0]['tag_slug'] : ''; ?>';
let selectedQty = <?php echo !empty($defaultPackages) ? $defaultPackages[0]['quantity'] : 0; ?>;
let selectedPrice = <?php echo !empty($defaultPackages) ? $defaultPackages[0]['price'] : 0; ?>;
let selectedPackageCode = '<?php echo !empty($defaultPackages) ? $defaultPackages[0]['package_code'] : ''; ?>';
let selectedPackageId = <?php echo !empty($defaultPackages) ? $defaultPackages[0]['id'] : 0; ?>;

// Switch tab
function switchTab(tab, btn) {
    currentTab = tab;
    document.querySelectorAll('.service-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    
    // Update trust bar with features from selected tab
    const features = JSON.parse(btn.getAttribute('data-features') || '[]');
    const trustBar = document.getElementById('trustBar');
    if (trustBar && features.length > 0) {
        trustBar.innerHTML = features.map(f => 
            `<div class="trust-bar-item"><span>${f}</span></div>`
        ).join('');
    }
    
    // Update packages
    const grid = document.getElementById('packageGrid');
    const packs = tabPackages[tab] || [];
    grid.innerHTML = '';
    
    packs.forEach((pack, i) => {
        const card = document.createElement('div');
        card.className = 'pkg-card' + (i === 0 ? ' selected' : '');
        card.setAttribute('data-qty', pack.qty);
        card.setAttribute('data-price', pack.price);
        card.setAttribute('data-code', pack.code);
        card.setAttribute('data-id', pack.id);
        card.onclick = function() { selectPackage(this, pack.qty, pack.price, pack.code, pack.id); };
        
        let saveHtml = '';
        if (pack.label && (pack.label.includes('Save') || pack.label.includes('/month') || pack.label === 'Premium' || pack.label.includes('Off'))) {
            saveHtml = '<div style="margin-top:5px;height:25px;"><span class="pkg-save-badge">' + pack.label + '</span></div>';
        } else {
            saveHtml = '<div style="margin-top:5px;height:25px;"></div>';
        }
        
        card.innerHTML =
        '<div class="pkg-check"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg></div>' +
        '<div style="text-align: center;"><span class="pkg-qty">' + pack.qty.toLocaleString() + '</span>' +
        '<span class="pkg-label-text"><?php echo ucfirst(str_replace(["-", "_"], " ", explode("-", $serviceSlug)[count(explode("-", $serviceSlug)) - 1])); ?></span></div>' + saveHtml;
        
        grid.appendChild(card);
    });
    
    if (packs.length > 0) {
        selectedQty = packs[0].qty;
        selectedPrice = packs[0].price;
        selectedPackageCode = packs[0].code;
        selectedPackageId = packs[0].id;
        document.getElementById('displayPrice').textContent = '$' + packs[0].price.toFixed(2);
    }
}

// Select package - CLEAN URL VERSION
function selectPackage(el, qty, price, code, id) {
    document.querySelectorAll('.pkg-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedQty = qty;
    selectedPrice = price;
    selectedPackageCode = code;
    selectedPackageId = id;
    document.getElementById('displayPrice').textContent = '$' + price.toFixed(2);
}

// Buy Now - CLEAN URL VERSION
function handleBuyNow() {
    if (!selectedPackageCode) {
        alert('Please select a package');
        return;
    }
    // Redirect to clean URL: /order/2IGF/
    window.location.href = '<?php echo Config::baseUrl(); ?>order/' + selectedPackageCode + '/';
}

// FAQ toggle
function toggleFaq(btn) {
    const item = btn.closest('.ig-faq-item');
    const wasActive = item.classList.contains('active');
    document.querySelectorAll('.ig-faq-item').forEach(i => i.classList.remove('active'));
    if (!wasActive) item.classList.add('active');
}
</script>
