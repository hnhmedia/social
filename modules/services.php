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
$serviceSlug = isset($_GET['slug']) ? $_GET['slug'] : 'buy-instagram-followers';

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


// ✅ FIX: Get packages for first tag OR all packages if no tags exist
$firstTag = !empty($serviceTags) ? $serviceTags[0] : null;
$defaultPackages = $firstTag ? getServicePackages($service['id'], $firstTag['id']) : getServicePackages($service['id'], null);

// ✅ FIX: Format packages for JavaScript - handle both tagged and non-tagged services
$packagesJS = !empty($serviceTags) ? formatPackagesWithCodes($serviceTags) : formatAllPackages($service['id']);

// Get FAQs
$faqItems = getServiceFaqs($serviceSlug);

// Get testimonials
$testimonials = getFormattedTestimonials();

// Get first tag features for trust bar (use the first tag's features)
$trustBarFeatures = $firstTag && !empty($firstTag['features']) ? $firstTag['features'] : ['Real Service', 'No Password', '24/7 Support', 'Fast Delivery'];

// First package price data for initial render
$fp         = !empty($defaultPackages) ? $defaultPackages[0] : null;
$fpPrice    = $fp ? (float)$fp['price'] : 0;
$fpOrig     = ($fp && !empty($fp['original_price'])) ? (float)$fp['original_price'] : null;
$fpSaving   = ($fpOrig && $fpOrig > $fpPrice) ? round($fpOrig - $fpPrice, 2) : 0;

// Last word of slug for package label (e.g. "followers" from "buy-instagram-followers")
$slugParts     = explode('-', $serviceSlug);
$pkgLabelWord  = ucfirst(str_replace(['-', '_'], ' ', end($slugParts)));
?>

<link rel="stylesheet" href="<?php echo Config::baseUrl(); ?>/css/service-details.css">

<!-- PAGE TITLE -->
<br clear="both">
<main style="flex: 1;padding-top:60px">
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

                <!-- ✅ UPDATED: Show widget whether tags exist or not -->
                <div class="order-widget-inner">
                    <div style="overflow: visible; background: transparent;">
                        
                        <!-- Service Tabs - only show if tags exist -->
                        <?php if (!empty($serviceTags)): ?>
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
                        <?php endif; ?>

                        <!-- Trust Bar (Features) -->
                        <div class="trust-bar" id="trustBar">
                            <?php foreach($trustBarFeatures as $feature): ?>
                            <div class="trust-bar-item">
                                <span><?php echo htmlspecialchars($feature); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Package Grid - show whether tags exist or not -->
                        <?php if (!empty($defaultPackages)): ?>
                        <div class="package-select-grid" id="packageGrid">
                            <?php foreach($defaultPackages as $i => $pack): ?>
                            <?php $packOrig = !empty($pack['original_price']) ? (float)$pack['original_price'] : 'null'; ?>
                            <div class="pkg-card <?php echo $i === 0 ? 'selected' : ''; ?>"
                                 onclick="selectPackage(this, <?php echo $pack['quantity']; ?>, <?php echo $pack['price']; ?>, '<?php echo $pack['package_code']; ?>', <?php echo $pack['id']; ?>, <?php echo $packOrig; ?>)"
                                 data-qty="<?php echo $pack['quantity']; ?>" 
                                 data-price="<?php echo $pack['price']; ?>"
                                 data-orig="<?php echo !empty($pack['original_price']) ? $pack['original_price'] : ''; ?>"
                                 data-code="<?php echo $pack['package_code']; ?>"
                                 data-id="<?php echo $pack['id']; ?>">
                                <div class="pkg-check">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                                <div style="text-align: center;">
                                    <span class="pkg-qty"><?php echo number_format($pack['quantity']); ?></span>
                                    <span class="pkg-label-text"><?php echo $pkgLabelWord; ?></span>
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
                        <?php else: ?>
                        <div style="padding: 2rem; text-align: center; color: #64748b;">
                            <p>No packages available for this service yet.</p>
                        </div>
                        <?php endif; ?>

                        <!-- Price & Buy Now -->
                        <?php if (!empty($defaultPackages)): ?>
                        <div class="order-action">
                            <div style="display:flex;align-items:baseline;flex-wrap:wrap;justify-content:center;gap:0.5rem;margin-bottom:0.75rem;">
                                <span id="displayPrice" style="font-size:1.18rem;font-weight:800;color:#111827;letter-spacing:-0.03em;">$<?php echo number_format($fpPrice, 2); ?></span>
                                <span id="displayOriginalPrice" style="font-size:1.15rem;font-weight:400;color:#9ca3af;text-decoration:line-through;<?php echo $fpOrig ? '' : 'display:none;'; ?>">
                                    $<?php echo $fpOrig ? number_format($fpOrig, 2) : '0.00'; ?>
                                </span>
                                <span id="displaySaving" style="font-size:1.05rem;font-weight:700;color:#16a34a;<?php echo $fpSaving > 0 ? '' : 'display:none;'; ?>">
                                    You Save $<?php echo number_format($fpSaving, 2); ?>
                                </span>
                            </div>
                            <a href="javascript:void(0);" onclick="handleBuyNow()" class="buy-now-btn" id="buyNowBtn">Buy Now!</a>
                        </div>
                        <?php endif; ?>

                        <!-- Terms -->
                        <p class="order-terms">By initiating this order, you agree to <a href="<?php echo Config::baseUrl('terms-of-service'); ?>" target="_blank">terms of service</a> and <a href="<?php echo Config::baseUrl('privacy-policy'); ?>" target="_blank">privacy policy</a>.</p>
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

<!-- FEATURES SECTION -->
<div class="ig-features-section" style="text-align: center;">
    <span class="section-badge">Ad-backed, human-first delivery</span>
    <h2>Start your growth with Genuine Socials</h2>
    <p>Get services that feel organic. We combine ad distribution with gradual delivery so results look real.</p>
    <div class="ig-features-grid">
        <div class="ig-feature-card">
            <div class="icon">😊</div>
            <h3>Satisfaction Guaranteed</h3>
            <p>Your success is our priority. If something slips, we fix it immediately.</p>
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
const tabPackages = <?php echo json_encode($packagesJS, JSON_HEX_TAG | JSON_HEX_APOS); ?>;
let currentTab          = '<?php echo !empty($serviceTags) ? $serviceTags[0]['tag_slug'] : 'default'; ?>';
let selectedQty         = <?php echo !empty($defaultPackages) ? $defaultPackages[0]['quantity'] : 0; ?>;
let selectedPrice       = <?php echo !empty($defaultPackages) ? $defaultPackages[0]['price'] : 0; ?>;
let selectedPackageCode = '<?php echo !empty($defaultPackages) ? $defaultPackages[0]['package_code'] : ''; ?>';
let selectedPackageId   = <?php echo !empty($defaultPackages) ? $defaultPackages[0]['id'] : 0; ?>;
const pkgLabelWord      = '<?php echo $pkgLabelWord; ?>';

/* -------------------------------------------------------
   updatePriceDisplay(price, originalPrice)
   Shows:  $8.95  $19.75  You Save $10.80
   Or just: $15.95  (when no original price)
------------------------------------------------------- */
function updatePriceDisplay(price, originalPrice) {
    var elPrice  = document.getElementById('displayPrice');
    var elOrig   = document.getElementById('displayOriginalPrice');
    var elSaving = document.getElementById('displaySaving');
    if (!elPrice) return;

    elPrice.textContent = '$' + price.toFixed(2);

    if (originalPrice && originalPrice > price) {
        var saving = (originalPrice - price).toFixed(2);
        elOrig.textContent     = '$' + originalPrice.toFixed(2);
        elOrig.style.display   = '';
        elSaving.textContent   = 'You Save $' + saving;
        elSaving.style.display = '';
    } else {
        elOrig.style.display   = 'none';
        elSaving.style.display = 'none';
    }
}

/* -------------------------------------------------------
   switchTab — handles tab click, rebuilds package grid
------------------------------------------------------- */
function switchTab(tab, btn) {
    currentTab = tab;
    document.querySelectorAll('.service-tab').forEach(function(t) { t.classList.remove('active'); });
    btn.classList.add('active');

    // Update trust bar
    var features = JSON.parse(btn.getAttribute('data-features') || '[]');
    var trustBar = document.getElementById('trustBar');
    if (trustBar && features.length > 0) {
        trustBar.innerHTML = features.map(function(f) {
            return '<div class="trust-bar-item"><span>' + f + '</span></div>';
        }).join('');
    }

    // Rebuild package grid
    var grid  = document.getElementById('packageGrid');
    var packs = tabPackages[tab] || [];
    grid.innerHTML = '';

    packs.forEach(function(pack, i) {
        var card = document.createElement('div');
        card.className = 'pkg-card' + (i === 0 ? ' selected' : '');
        card.setAttribute('data-qty',   pack.qty);
        card.setAttribute('data-price', pack.price);
        card.setAttribute('data-orig',  pack.original_price || '');
        card.setAttribute('data-code',  pack.code);
        card.setAttribute('data-id',    pack.id);

        var origArg = pack.original_price ? pack.original_price : 'null';
        card.setAttribute('onclick', 'selectPackage(this,' + pack.qty + ',' + pack.price + ',"' + pack.code + '",' + pack.id + ',' + origArg + ')');

        var saveHtml = '';
        if (pack.label && (pack.label.indexOf('Off') !== -1 || pack.label.indexOf('Save') !== -1 || pack.label === 'Premium' || pack.label.indexOf('/month') !== -1)) {
            saveHtml = '<div style="margin-top:5px;height:25px;"><span class="pkg-save-badge">' + pack.label + '</span></div>';
        } else {
            saveHtml = '<div style="margin-top:5px;height:25px;"></div>';
        }

        card.innerHTML =
            '<div class="pkg-check"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg></div>' +
            '<div style="text-align:center;"><span class="pkg-qty">' + pack.qty.toLocaleString() + '</span>' +
            '<span class="pkg-label-text">' + pkgLabelWord + '</span></div>' +
            saveHtml;

        grid.appendChild(card);
    });

    if (packs.length > 0) {
        selectedQty         = packs[0].qty;
        selectedPrice       = packs[0].price;
        selectedPackageCode = packs[0].code;
        selectedPackageId   = packs[0].id;
        updatePriceDisplay(packs[0].price, packs[0].original_price || null);
    }
}

/* -------------------------------------------------------
   selectPackage — called when user clicks a package card
------------------------------------------------------- */
function selectPackage(el, qty, price, code, id, originalPrice) {
    document.querySelectorAll('.pkg-card').forEach(function(c) { c.classList.remove('selected'); });
    el.classList.add('selected');
    selectedQty         = qty;
    selectedPrice       = price;
    selectedPackageCode = code;
    selectedPackageId   = id;
    updatePriceDisplay(price, originalPrice || null);
}

/* -------------------------------------------------------
   handleBuyNow — redirect to order clean URL
------------------------------------------------------- */
function handleBuyNow() {
    if (!selectedPackageCode) {
        alert('Please select a package');
        return;
    }
    window.location.href = '<?php echo Config::baseUrl(); ?>order/' + selectedPackageCode + '/';
}

/* -------------------------------------------------------
   toggleFaq
------------------------------------------------------- */
function toggleFaq(btn) {
    var item     = btn.closest('.ig-faq-item');
    var wasActive = item.classList.contains('active');
    document.querySelectorAll('.ig-faq-item').forEach(function(i) { i.classList.remove('active'); });
    if (!wasActive) item.classList.add('active');
}
</script>
