<?php
$siteName    = Config::siteName();
$siteUrl     = Config::baseUrl();
$supportEmail = Config::supportEmail();
?>

<!-- Hero -->
<section class="contact-hero">
    <div class="hero-inner">
        <h1>Privacy Policy</h1>
    </div>
</section>

<!-- Content -->
<main style="max-width:860px;margin:0 auto;padding:2.5rem 1.25rem 4rem;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#374151;line-height:1.8;">

    <h1 style="font-size:2rem;font-weight:800;color:#111827;margin-bottom:0.5rem;">Privacy Policy</h1>
    <p style="color:#6b7280;font-size:0.9rem;margin-bottom:2rem;">Last updated: January 1, 2025</p>

    <p><?php echo htmlspecialchars($siteName); ?> ("we", "us", or "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit <a href="<?php echo $siteUrl; ?>" style="color:#fc481c;"><?php echo $siteUrl; ?></a> and use our services. Please read this policy carefully. If you disagree with its terms, please discontinue use of the site.</p>

    <?php
    $sections = [
        [
            'title' => '1. Information We Collect',
            'content' => '
                <p>We may collect information about you in a variety of ways. The information we may collect on the Site includes:</p>
                <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:1.25rem 0 0.5rem;">Personal Data</h3>
                <p>When you place an order or contact us, we collect personally identifiable information such as your name and email address. We do <strong>not</strong> require or store your social media passwords under any circumstances.</p>
                <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:1.25rem 0 0.5rem;">Order Information</h3>
                <p>To fulfil your order we collect your social media username or profile/post URL, the service package selected, and your order details. This is the minimum information required to deliver the service you purchased.</p>
                <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:1.25rem 0 0.5rem;">Payment Information</h3>
                <p>Payment processing is handled by our trusted third-party payment providers (such as Stripe and Nuvei). We do not store your full credit card numbers on our servers. Our payment processors are PCI-DSS compliant and use industry-standard encryption to protect your financial data.</p>
                <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:1.25rem 0 0.5rem;">Automatically Collected Data</h3>
                <p>When you visit our site, our servers automatically log standard information such as your IP address, browser type, referring/exit pages, and the date and time of your visit. This data is used to diagnose technical problems and administer the site.</p>
                <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:1.25rem 0 0.5rem;">Cookies and Tracking Technologies</h3>
                <p>We use cookies, web beacons, and similar tracking technologies to enhance your experience, analyse site traffic, and understand where our visitors are coming from. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.</p>
            '
        ],
        [
            'title' => '2. How We Use Your Information',
            'content' => '
                <p>Having accurate information about you permits us to provide you with a smooth, efficient, and customised experience. Specifically, we may use information collected about you via the Site to:</p>
                <ul style="padding-left:1.5rem;margin:0.75rem 0;">
                    <li>Process and fulfil your orders and send you related information, including purchase confirmations and invoices.</li>
                    <li>Send you administrative information, such as updates to our terms, conditions, and policies.</li>
                    <li>Respond to your comments, questions, and requests and provide customer support.</li>
                    <li>Monitor and analyse usage and activity trends to improve your experience on the site.</li>
                    <li>Detect, prevent, and address technical issues, fraud, or illegal activity.</li>
                    <li>Send you promotional communications (where you have opted in) about our services, special offers, and new features.</li>
                    <li>Comply with our legal obligations.</li>
                </ul>
            '
        ],
        [
            'title' => '3. Disclosure of Your Information',
            'content' => '
                <p>We may share information we have collected about you in certain situations. Your information may be disclosed as follows:</p>
                <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:1.25rem 0 0.5rem;">By Law or to Protect Rights</h3>
                <p>If we believe the release of information about you is necessary to respond to legal process, to investigate or remedy potential violations of our policies, or to protect the rights, property, and safety of others, we may share your information as permitted or required by any applicable law, rule, or regulation.</p>
                <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:1.25rem 0 0.5rem;">Third-Party Service Providers</h3>
                <p>We may share your information with third parties that perform services for us or on our behalf, including payment processing, data analysis, email delivery, hosting services, and customer support.</p>
                <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:1.25rem 0 0.5rem;">Business Transfers</h3>
                <p>We may share or transfer your information in connection with, or during negotiations of, any merger, sale of company assets, financing, or acquisition of all or a portion of our business to another company.</p>
                <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:1.25rem 0 0.5rem;">We Do Not Sell Your Data</h3>
                <p>We do <strong>not</strong> sell, trade, or otherwise transfer your personally identifiable information to outside parties for their marketing purposes.</p>
            '
        ],
        [
            'title' => '4. Security of Your Information',
            'content' => '
                <p>We use administrative, technical, and physical security measures to help protect your personal information. All transactions on our platform are encrypted using Secure Socket Layer (SSL) technology. Our trusted payment platforms (Checkout & Nuvei) ensure your financial transactions are secure.</p>
                <p>While we have taken reasonable steps to secure the personal information you provide to us, please be aware that despite our efforts, no security measures are perfect or impenetrable, and no method of data transmission can be guaranteed against any interception or other type of misuse.</p>
            '
        ],
        [
            'title' => '5. Data Retention',
            'content' => '
                <p>We will retain your personal information only for as long as is necessary for the purposes set out in this Privacy Policy, or as required by law. Order records may be retained for accounting and legal compliance purposes. You may request deletion of your personal data at any time by contacting us.</p>
            '
        ],
        [
            'title' => '6. Your Rights',
            'content' => '
                <p>Depending on your location, you may have the following rights regarding your personal data:</p>
                <ul style="padding-left:1.5rem;margin:0.75rem 0;">
                    <li><strong>Access:</strong> You can request a copy of the personal data we hold about you.</li>
                    <li><strong>Rectification:</strong> You can request that we correct any inaccurate or incomplete data.</li>
                    <li><strong>Erasure:</strong> You can request that we delete your personal data, subject to certain legal obligations.</li>
                    <li><strong>Restriction:</strong> You can request that we restrict the processing of your data in certain circumstances.</li>
                    <li><strong>Portability:</strong> You can request a copy of your data in a structured, commonly used, machine-readable format.</li>
                    <li><strong>Objection:</strong> You can object to the processing of your personal data for direct marketing purposes.</li>
                    <li><strong>Opt-Out:</strong> You may opt out of receiving promotional emails from us by following the unsubscribe link in those emails.</li>
                </ul>
                <p>To exercise any of these rights, please contact us using the details in Section 10.</p>
            '
        ],
        [
            'title' => '7. Cookies Policy',
            'content' => '
                <p>We use cookies and similar tracking technologies to track activity on our site and hold certain information. Cookies are files with a small amount of data which may include an anonymous unique identifier. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, some portions of our site may not function properly.</p>
                <p>We use the following types of cookies:</p>
                <ul style="padding-left:1.5rem;margin:0.75rem 0;">
                    <li><strong>Essential Cookies:</strong> Necessary for the website to function and cannot be switched off.</li>
                    <li><strong>Analytics Cookies:</strong> Allow us to count visits and traffic sources so we can measure and improve the performance of our site.</li>
                    <li><strong>Preference Cookies:</strong> Enable the website to remember information that changes the way the website behaves or looks.</li>
                    <li><strong>Marketing Cookies:</strong> May be set through our site by our advertising partners to build a profile of your interests.</li>
                </ul>
            '
        ],
        [
            'title' => '8. Third-Party Websites',
            'content' => '
                <p>Our site may contain links to third-party websites. Once you leave our site or are redirected to a third-party website, you are no longer governed by this Privacy Policy. We encourage you to review the privacy policy of every site you visit. We have no control over, and assume no responsibility for, the content, privacy policies, or practices of any third-party sites or services.</p>
            '
        ],
        [
            'title' => '9. Children\'s Privacy',
            'content' => '
                <p>Our services are not directed to children under the age of 13, and we do not knowingly collect personal information from children under 13. If we become aware that a child under 13 has provided us with personal information, we will take steps to delete such information. If you are a parent or guardian and believe your child has provided us with personal information, please contact us.</p>
            '
        ],
        [
            'title' => '10. Changes to This Privacy Policy',
            'content' => '
                <p>We reserve the right to make changes to this Privacy Policy at any time and for any reason. We will alert you about any changes by updating the "Last updated" date at the top of this page. You are encouraged to periodically review this Privacy Policy to stay informed of updates. Your continued use of the site after any changes constitutes your acceptance of the updated policy.</p>
            '
        ],
        [
            'title' => '11. Contact Us',
            'content' => '
                <p>If you have questions or comments about this Privacy Policy, or wish to exercise any of your rights, please contact us at:</p>
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:0.75rem;padding:1.25rem 1.5rem;margin-top:1rem;display:inline-block;">
                    <p style="margin:0 0 0.5rem;font-weight:700;color:#111827;"><?php echo htmlspecialchars($siteName); ?></p>
                    <p style="margin:0;">Email: <a href="mailto:<?php echo htmlspecialchars($supportEmail); ?>" style="color:#fc481c;"><?php echo htmlspecialchars($supportEmail); ?></a></p>
                    <p style="margin:0.25rem 0 0;">Website: <a href="<?php echo $siteUrl; ?>" style="color:#fc481c;"><?php echo $siteUrl; ?></a></p>
                </div>
            '
        ],
    ];

    foreach ($sections as $section):
    ?>
    <div style="margin-bottom:2.25rem;">
        <h2 style="font-size:1.2rem;font-weight:700;color:#111827;border-bottom:2px solid #fee2e2;padding-bottom:0.5rem;margin-bottom:1rem;">
            <?php echo htmlspecialchars($section['title']); ?>
        </h2>
        <?php echo $section['content']; ?>
    </div>
    <?php endforeach; ?>

</main>
