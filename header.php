<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Famoid: Buy Instagram Followers, Likes & Views | #1 Agency</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-purple: #7c3aed;
            --primary-purple-dark: #6d28d9;
            --primary-pink: #ec4899;
            --bg-white: #ffffff;
            --bg-gray: #f8fafc;
            --bg-dark: #0f172a;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --gradient-primary: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-white);
            color: var(--text-dark);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 1.5rem;
        }

        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-gray);
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--text-dark);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .lang-select {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--text-gray);
            cursor: pointer;
            background: white;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-outline {
            background: white;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }

        .btn-outline:hover {
            background: var(--bg-gray);
        }

        /* Account Dropdown */
        .account-dropdown {
            position: relative;
        }

        .account-btn {
            cursor: pointer;
        }

        .account-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 200px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            z-index: 1001;
            overflow: hidden;
        }

        .account-dropdown:hover .account-menu,
        .account-dropdown.active .account-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .account-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.25rem;
            font-size: 0.9rem;
            color: var(--text-dark);
            transition: background 0.2s;
        }

        .account-menu a:hover {
            background: var(--bg-gray);
            color: var(--primary-purple);
        }

        .menu-divider {
            height: 1px;
            background: var(--border-color);
            margin: 0.5rem 0;
        }

        /* Language Dropdown */
        .lang-dropdown {
            position: relative;
        }

        .lang-select {
            cursor: pointer;
        }

        .lang-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 160px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            z-index: 1001;
            overflow: hidden;
        }

        .lang-dropdown:hover .lang-menu,
        .lang-dropdown.active .lang-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .lang-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            color: var(--text-dark);
            transition: background 0.2s;
        }

        .lang-menu a:hover {
            background: var(--bg-gray);
        }

        .lang-menu a.active {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(236, 72, 153, 0.1) 100%);
            color: var(--primary-purple);
        }

        .btn-dark {
            background: var(--bg-dark);
            color: white;
        }

        .btn-dark:hover {
            background: #1e293b;
        }

        .btn-lg {
            padding: 0.875rem 1.75rem;
            font-size: 1rem;
        }

        /* Hero Section */
        .hero {
            padding: 8rem 1.5rem 4rem;
            text-align: center;
            background: linear-gradient(180deg, #faf5ff 0%, #ffffff 100%);
        }

        .hero-inner {
            max-width: 900px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--text-dark);
        }

        .hero h1 .emoji {
            display: inline;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-gray);
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Platform Cards */
        .platform-cards {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .platform-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.5rem;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .platform-card:hover {
            border-color: var(--primary-purple);
            box-shadow: var(--shadow-md);
        }

        .platform-card.active {
            border-color: var(--primary-purple);
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(236, 72, 153, 0.05) 100%);
        }

        .platform-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .platform-icon.instagram {
            background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            color: white;
        }

        .platform-icon.tiktok {
            background: #000;
            color: white;
        }

        .platform-icon.facebook {
            background: #1877f2;
            color: white;
        }

        .platform-card-info h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .platform-card-info .rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.8rem;
            color: var(--text-gray);
        }

        .rating .stars {
            color: #fbbf24;
        }

        /* Service Links */
        .service-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 3rem;
        }

        .service-link {
            padding: 0.625rem 1.25rem;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.2s;
        }

        .service-link:hover {
            border-color: var(--primary-purple);
            color: var(--primary-purple);
        }

        /* Live Notification */
        .live-notification {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: #22c55e;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .live-notification .stars {
            color: #fbbf24;
            font-size: 0.9rem;
        }

        .live-notification span {
            font-size: 0.9rem;
            color: var(--text-gray);
        }

        .live-notification .time {
            color: var(--text-light);
            font-size: 0.8rem;
        }

        /* Trust Badges */
        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 2rem;
            padding: 1rem;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-gray);
        }

        .trust-badge svg {
            width: 20px;
            height: 20px;
        }

        /* Section Styles */
        .section {
            padding: 5rem 1.5rem;
        }

        .section-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--text-gray);
            max-width: 600px;
            margin: 0 auto;
        }

        .section-emoji {
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }

        /* Features Grid */
        .features-section {
            background: var(--bg-gray);
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .features-content h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .features-content p {
            color: var(--text-gray);
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }

        .features-image {
            text-align: center;
        }

        .features-image img {
            max-width: 100%;
            border-radius: 16px;
            box-shadow: var(--shadow-xl);
        }

        /* Info Cards */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .info-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(124, 58, 237, 0.1);
            border-color: rgba(124, 58, 237, 0.2);
        }

        .info-card:hover::before {
            transform: scaleX(1);
        }
    </style>
</head>
<body>
<!-- Navigation -->
<nav class="navbar">
    <div class="navbar-inner">
        <a href="#" class="logo">Famoid</a>
        <ul class="nav-links">
            <li><a href="#">Services</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
        <div class="nav-right">
            <div class="lang-dropdown">
                <div class="lang-select">🇺🇸 EN ▾</div>
                <div class="lang-menu">
                    <a href="#" class="active">🇺🇸 English</a>
                    <a href="#">🇩🇪 Deutsch</a>
                    <a href="#">🇫🇷 Français</a>
                    <a href="#">🇪🇸 Español</a>
                    <a href="#">🇦🇪 Arabic</a>
                    <a href="#">🇧🇷 Português (BR)</a>
                </div>
            </div>
            <div class="account-dropdown">
                <button class="btn btn-outline account-btn">My Account ▾</button>
                <div class="account-menu">
                    <a href="#">🔐 Login</a>
                    <a href="#">📝 Register</a>
                    <a href="#">📦 Track Order</a>
                    <div class="menu-divider"></div>
                    <a href="#">❓ Help Center</a>
                    <a href="#">💬 Contact Support</a>
                </div>
            </div>
        </div>
    </div>
</nav>