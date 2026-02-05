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

        .info-card h3 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-card h3::first-letter {
            color: var(--primary-purple);
        }

        .info-card p {
            font-size: 0.95rem;
            color: var(--text-gray);
            line-height: 1.7;
        }

        /* Testimonials */
        .testimonials-section {
            background: var(--bg-gray);
            overflow: hidden;
        }

        .testimonials-track-wrapper {
            overflow: hidden;
            margin: 0 -1.5rem;
            padding: 0 1.5rem;
        }

        .testimonials-track {
            display: flex;
            gap: 1.5rem;
            animation: scrollTestimonials 40s linear infinite;
        }

        @keyframes scrollTestimonials {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .testimonial-card {
            flex-shrink: 0;
            width: 350px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .testimonial-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .testimonial-info {
            flex: 1;
        }

        .testimonial-info h4 {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .testimonial-info span {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .testimonial-verified {
            color: #22c55e;
            font-size: 1.1rem;
        }

        .testimonial-text {
            font-size: 0.9rem;
            color: var(--text-gray);
            line-height: 1.6;
        }

        /* Services Grid */
        .services-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.15) 0%, rgba(236, 72, 153, 0.15) 100%);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--primary-purple);
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.1);
        }

        .services-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .services-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--text-dark) 0%, var(--primary-purple-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .services-header p {
            color: var(--text-gray);
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        .services-avatars {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .avatar-stack {
            display: flex;
        }

        .avatar-stack img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 3px solid white;
            margin-left: -10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .avatar-stack img:first-child {
            margin-left: 0;
        }

        .avatar-stack img:hover {
            transform: translateY(-3px);
            z-index: 1;
        }

        .services-avatars span {
            font-size: 0.9rem;
            color: var(--text-gray);
            font-weight: 500;
        }

        .services-avatars span strong {
            color: var(--primary-purple);
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .service-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 1.75rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .service-card:hover {
            border-color: transparent;
            box-shadow: 0 20px 40px rgba(124, 58, 237, 0.15), 0 0 0 1px rgba(124, 58, 237, 0.1);
            transform: translateY(-8px);
        }

        .service-card:hover::before {
            opacity: 1;
        }

        .service-badge {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            padding: 0.375rem 0.875rem;
            background: var(--gradient-primary);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
        }

        .service-badge.trending {
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }

        .service-badge.creator {
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.4);
        }

        .service-emoji {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .service-card:hover .service-emoji {
            animation: bounce 0.5s ease;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .service-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.375rem;
            color: var(--text-dark);
        }

        .service-card .subtitle {
            font-size: 0.9rem;
            color: var(--text-gray);
            margin-bottom: 1rem;
        }

        .service-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 0.5rem 0.75rem;
            background: #fefce8;
            border-radius: 8px;
            width: fit-content;
        }

        .service-rating .stars {
            color: #fbbf24;
            font-size: 0.9rem;
            letter-spacing: -1px;
        }

        .service-rating span {
            font-size: 0.8rem;
            color: #a16207;
            font-weight: 500;
        }

        .service-users {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
            padding: 0.75rem;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(236, 72, 153, 0.05) 100%);
            border-radius: 10px;
        }

        .service-users .avatar-stack img {
            width: 28px;
            height: 28px;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .service-users span {
            font-size: 0.85rem;
            color: var(--primary-purple);
            font-weight: 600;
        }

        .service-features {
            list-style: none;
            margin-bottom: 1.25rem;
        }

        .service-features li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
            font-size: 0.9rem;
            color: var(--text-gray);
        }

        .service-features li::before {
            content: '✓';
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            background: #dcfce7;
            color: #16a34a;
            font-weight: 700;
            font-size: 0.7rem;
            border-radius: 50%;
        }

        .service-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border-color);
            margin-bottom: 1.25rem;
        }

        .service-delivery {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .service-delivery strong {
            color: var(--text-gray);
        }

        .service-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #16a34a;
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            background: #dcfce7;
            border-radius: 50px;
        }

        .service-status::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #16a34a;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .service-card .btn {
            width: 100%;
            padding: 1rem;
            font-size: 0.95rem;
            font-weight: 700;
            border-radius: 12px;
            background: var(--gradient-primary);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
            transition: all 0.3s;
        }

        .service-card .btn:hover {
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
            transform: translateY(-2px);
        }

        /* Stats Banner */
        .stats-banner {
            display: flex;
            justify-content: center;
            gap: 3rem;
            padding: 4rem 1.5rem;
            background: linear-gradient(135deg, #faf5ff 0%, #ffffff 50%, #fdf2f8 100%);
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .stats-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%237c3aed' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .stat-item {
            text-align: center;
            padding: 1.5rem 2.5rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: 1px solid var(--border-color);
            transition: all 0.3s;
            position: relative;
            z-index: 1;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(124, 58, 237, 0.1);
            border-color: rgba(124, 58, 237, 0.2);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.375rem;
        }

        .stat-label {
            font-size: 0.95rem;
            color: var(--text-gray);
            font-weight: 500;
        }

        /* FAQ Section */
        .faq-section {
            background: var(--bg-gray);
        }

        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 0.75rem;
            overflow: hidden;
        }

        .faq-question {
            width: 100%;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: none;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            cursor: pointer;
            text-align: left;
            font-family: inherit;
        }

        .faq-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--bg-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--text-gray);
            transition: transform 0.2s;
        }

        .faq-item.active .faq-icon {
            transform: rotate(45deg);
            background: var(--primary-purple);
            color: white;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .faq-item.active .faq-answer {
            max-height: 200px;
        }

        .faq-answer-inner {
            padding: 0 1.5rem 1.25rem;
            font-size: 0.95rem;
            color: var(--text-gray);
            line-height: 1.7;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #faf5ff 0%, #fdf2f8 50%, #fff7ed 100%);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.05) 0%, transparent 50%);
            animation: rotateBg 30s linear infinite;
        }

        @keyframes rotateBg {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .cta-inner {
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .cta-inner h2 {
            font-size: 2.75rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--text-dark) 0%, var(--primary-purple) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cta-inner p {
            font-size: 1.15rem;
            color: var(--text-gray);
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .cta-buttons .btn-primary {
            padding: 1rem 2.5rem;
            font-size: 1.05rem;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(124, 58, 237, 0.4);
            position: relative;
            overflow: hidden;
        }

        .cta-buttons .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .cta-buttons .btn-primary:hover::before {
            left: 100%;
        }

        .cta-buttons .btn-outline {
            padding: 1rem 2.5rem;
            font-size: 1.05rem;
            border-radius: 14px;
            border: 2px solid var(--border-color);
        }

        .cta-buttons .btn-outline:hover {
            border-color: var(--primary-purple);
            color: var(--primary-purple);
        }

        .cta-avatars {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 1rem 2rem;
            background: white;
            border-radius: 60px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            width: fit-content;
            margin: 0 auto;
        }

        .cta-avatars .avatar-stack img {
            width: 36px;
            height: 36px;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .cta-trust {
            font-size: 0.95rem;
            color: var(--text-gray);
            font-weight: 500;
        }

        .cta-trust strong {
            color: var(--primary-purple);
        }

        .cta-badges {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .cta-badges span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Stats in CTA */
        .cta-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-bottom: 2.5rem;
        }

        .cta-stat {
            text-align: center;
            padding: 1.5rem 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            min-width: 140px;
        }

        .cta-stat-value {
            font-size: 2rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.25rem;
        }

        .cta-stat-label {
            font-size: 0.85rem;
            color: var(--text-gray);
        }

        /* Testimonial Mini Section */
        .testimonial-mini-section {
            background: white;
            border-top: 1px solid var(--border-color);
        }

        .testimonial-mini-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            align-items: center;
        }

        .testimonial-mini-stats {
            text-align: center;
        }

        .testimonial-mini-stats .rating-value {
            font-size: 2rem;
            font-weight: 700;
        }

        .testimonial-mini-stats .rating-label {
            font-size: 0.85rem;
            color: var(--text-gray);
        }

        .testimonial-mini-card {
            background: var(--bg-gray);
            border-radius: 12px;
            padding: 1.5rem;
        }

        .testimonial-mini-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .testimonial-mini-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .testimonial-mini-header h4 {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .testimonial-mini-header span {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .testimonial-mini-card p {
            font-size: 0.85rem;
            color: var(--text-gray);
        }

        /* Footer */
        .footer {
            background: var(--bg-dark);
            color: white;
            padding: 4rem 1.5rem 2rem;
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr repeat(4, 1fr);
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-brand {
            max-width: 300px;
        }

        .footer-brand .logo {
            display: inline-block;
            margin-bottom: 1rem;
        }

        .footer-brand p {
            font-size: 0.9rem;
            color: #94a3b8;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .footer-newsletter {
            display: flex;
            gap: 0.5rem;
        }

        .footer-newsletter input {
            flex: 1;
            padding: 0.625rem 1rem;
            border: 1px solid #334155;
            border-radius: 8px;
            background: #1e293b;
            color: white;
            font-size: 0.9rem;
        }

        .footer-newsletter input::placeholder {
            color: #64748b;
        }

        .footer-newsletter button {
            padding: 0.625rem 1rem;
            background: var(--gradient-primary);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }

        .footer-column h4 {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            color: white;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column li {
            margin-bottom: 0.625rem;
        }

        .footer-column a {
            font-size: 0.85rem;
            color: #94a3b8;
            transition: color 0.2s;
        }

        .footer-column a:hover {
            color: white;
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 2rem;
            border-top: 1px solid #334155;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-badges-row {
            display: flex;
            gap: 1rem;
        }

        .footer-badges-row img {
            height: 32px;
            opacity: 0.8;
        }

        .footer-social {
            display: flex;
            gap: 0.5rem;
        }

        .footer-social a {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            transition: all 0.2s;
        }

        .footer-social a:hover {
            background: var(--primary-purple);
            color: white;
        }

        .footer-copyright {
            width: 100%;
            text-align: center;
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 1rem;
        }

        .footer-location {
            font-size: 0.8rem;
            color: #64748b;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .stats-banner {
                flex-wrap: wrap;
                gap: 2rem;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .testimonial-mini-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .platform-cards {
                flex-direction: column;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .cta-buttons {
                flex-direction: column;
            }
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
                <a href="#" class="service-link">BUY INSTAGRAM FOLLOWERS</a>
                <a href="#" class="service-link">BUY INSTAGRAM LIKES</a>
                <a href="#" class="service-link">BUY INSTAGRAM VIEWS</a>
                <a href="#" class="service-link">BUY REELS LIKES & VIEWS</a>
                <a href="#" class="service-link">AUTOMATIC LIKES</a>
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
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/96?img=12" alt="David Smith" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>David Smith</h4>
                                <span>21 October 2024</span>
                            </div>
                            <span class="testimonial-verified">✓</span>
                        </div>
                        <p class="testimonial-text">Real quality likes in real quick time. I will definitely go with Famoid again in future. 100% recommended.</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/96?img=47" alt="Janae Stofer" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Janae Stofer</h4>
                                <span>17 October 2024</span>
                            </div>
                            <span class="testimonial-verified">✓</span>
                        </div>
                        <p class="testimonial-text">Famoid has promoted a number of my YouTube videos and always delivers the results I need. Amazing service!</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/96?img=32" alt="Pamela Keefer" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Pamela Keefer</h4>
                                <span>15 October 2024</span>
                            </div>
                            <span class="testimonial-verified">✓</span>
                        </div>
                        <p class="testimonial-text">I was confused about Famoid service. But I can see the result now. They did great job for my profile. My profile was getting 70 to 150 new followers daily.</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/96?img=68" alt="Junior Dala" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Junior Dala</h4>
                                <span>9 October 2024</span>
                            </div>
                            <span class="testimonial-verified">✓</span>
                        </div>
                        <p class="testimonial-text">2nd time buying from them. I'm happy to work with them and would highly recommend their product. Both purchases exceeded expectations!</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/96?img=23" alt="Sarah Mitchell" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Sarah Mitchell</h4>
                                <span>5 October 2024</span>
                            </div>
                            <span class="testimonial-verified">✓</span>
                        </div>
                        <p class="testimonial-text">Amazing service! Got my Instagram followers within hours. The quality is outstanding and customer support was very helpful throughout.</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/96?img=53" alt="Marcus Johnson" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Marcus Johnson</h4>
                                <span>28 September 2024</span>
                            </div>
                            <span class="testimonial-verified">✓</span>
                        </div>
                        <p class="testimonial-text">Best investment I made for my brand. Famoid delivered exactly what they promised with real quality followers. Will order again!</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/96?img=44" alt="Emily Chen" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Emily Chen</h4>
                                <span>22 September 2024</span>
                            </div>
                            <span class="testimonial-verified">✓</span>
                        </div>
                        <p class="testimonial-text">Super fast delivery and great quality followers. My engagement rate has improved significantly since using Famoid. Highly recommend!</p>
                    </div>
                    <!-- Duplicate for infinite scroll -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/96?img=12" alt="David Smith" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>David Smith</h4>
                                <span>21 October 2024</span>
                            </div>
                            <span class="testimonial-verified">✓</span>
                        </div>
                        <p class="testimonial-text">Real quality likes in real quick time. I will definitely go with Famoid again in future. 100% recommended.</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/96?img=47" alt="Janae Stofer" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Janae Stofer</h4>
                                <span>17 October 2024</span>
                            </div>
                            <span class="testimonial-verified">✓</span>
                        </div>
                        <p class="testimonial-text">Famoid has promoted a number of my YouTube videos and always delivers the results I need. Amazing service!</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="https://i.pravatar.cc/96?img=32" alt="Pamela Keefer" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Pamela Keefer</h4>
                                <span>15 October 2024</span>
                            </div>
                            <span class="testimonial-verified">✓</span>
                        </div>
                        <p class="testimonial-text">I was confused about Famoid service. But I can see the result now. They did great job for my profile. My profile was getting 70 to 150 new followers daily.</p>
                    </div>
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
                <!-- Instagram Followers -->
                <div class="service-card">
                    <span class="service-badge">Most Popular</span>
                    <div class="service-emoji">👥</div>
                    <h3>Buy Instagram Followers</h3>
                    <p class="subtitle">Get real followers fast</p>
                    <div class="service-rating">
                        <span class="stars">★★★★★</span>
                        <span>5.0 (10,450+)</span>
                    </div>
                    <div class="service-users">
                        <div class="avatar-stack">
                            <img src="https://i.pravatar.cc/32?img=56" alt="">
                            <img src="https://i.pravatar.cc/32?img=41" alt="">
                            <img src="https://i.pravatar.cc/32?img=26" alt="">
                        </div>
                        <span>+847 today</span>
                    </div>
                    <ul class="service-features">
                        <li>Real followers (not bots)</li>
                        <li>Starts in literally 60 seconds</li>
                        <li>Choose from 100 to 100,000+</li>
                        <li>We never ask for your password</li>
                    </ul>
                    <div class="service-footer">
                        <span class="service-delivery">Avg. delivery: <strong>30 min</strong></span>
                        <span class="service-status">In stock</span>
                    </div>
                    <a href="#" class="btn btn-primary">Buy Instagram Followers →</a>
                </div>

                <!-- Instagram Likes -->
                <div class="service-card">
                    <span class="service-badge">Best Value</span>
                    <div class="service-emoji">❤️</div>
                    <h3>Buy Instagram Likes</h3>
                    <p class="subtitle">Make your posts pop</p>
                    <div class="service-rating">
                        <span class="stars">★★★★★</span>
                        <span>5.0 (8,700+)</span>
                    </div>
                    <div class="service-users">
                        <div class="avatar-stack">
                            <img src="https://i.pravatar.cc/32?img=7" alt="">
                            <img src="https://i.pravatar.cc/32?img=13" alt="">
                            <img src="https://i.pravatar.cc/32?img=19" alt="">
                        </div>
                        <span>+623 today</span>
                    </div>
                    <ul class="service-features">
                        <li>Real people, real likes</li>
                        <li>Works on posts, reels, videos</li>
                        <li>50 to 100,000+ available</li>
                        <li>You pick the delivery speed</li>
                    </ul>
                    <div class="service-footer">
                        <span class="service-delivery">Avg. delivery: <strong>30 min</strong></span>
                        <span class="service-status">In stock</span>
                    </div>
                    <a href="#" class="btn btn-primary">Buy Instagram Likes →</a>
                </div>

                <!-- Instagram Views -->
                <div class="service-card">
                    <span class="service-badge">Fast Delivery</span>
                    <div class="service-emoji">▶️</div>
                    <h3>Buy Instagram Views</h3>
                    <p class="subtitle">Boost your video reach</p>
                    <div class="service-rating">
                        <span class="stars">★★★★★</span>
                        <span>4.9 (7,200+)</span>
                    </div>
                    <div class="service-users">
                        <div class="avatar-stack">
                            <img src="https://i.pravatar.cc/32?img=65" alt="">
                            <img src="https://i.pravatar.cc/32?img=59" alt="">
                            <img src="https://i.pravatar.cc/32?img=53" alt="">
                        </div>
                        <span>+412 today</span>
                    </div>
                    <ul class="service-features">
                        <li>Real video views</li>
                        <li>Instant delivery</li>
                        <li>Boosts algorithm ranking</li>
                        <li>No password required</li>
                    </ul>
                    <div class="service-footer">
                        <span class="service-delivery">Avg. delivery: <strong>30 min</strong></span>
                        <span class="service-status">In stock</span>
                    </div>
                    <a href="#" class="btn btn-primary">Buy Instagram Views →</a>
                </div>

                <!-- Instagram Reels -->
                <div class="service-card">
                    <span class="service-badge trending">Trending</span>
                    <div class="service-emoji">🎬</div>
                    <h3>Instagram Reels</h3>
                    <p class="subtitle">Likes & Views for Reels</p>
                    <div class="service-rating">
                        <span class="stars">★★★★★</span>
                        <span>4.9 (5,800+)</span>
                    </div>
                    <div class="service-users">
                        <div class="avatar-stack">
                            <img src="https://i.pravatar.cc/32?img=60" alt="">
                            <img src="https://i.pravatar.cc/32?img=49" alt="">
                            <img src="https://i.pravatar.cc/32?img=38" alt="">
                        </div>
                        <span>+389 today</span>
                    </div>
                    <ul class="service-features">
                        <li>Real Reels engagement</li>
                        <li>Go viral faster</li>
                        <li>Reach Explore page</li>
                        <li>Safe & secure delivery</li>
                    </ul>
                    <div class="service-footer">
                        <span class="service-delivery">Avg. delivery: <strong>30 min</strong></span>
                        <span class="service-status">In stock</span>
                    </div>
                    <a href="#" class="btn btn-primary">Instagram Reels →</a>
                </div>

                <!-- TikTok Followers -->
                <div class="service-card">
                    <span class="service-badge creator">Creator Pick</span>
                    <div class="service-emoji">🎵</div>
                    <h3>Buy TikTok Followers</h3>
                    <p class="subtitle">Go viral on TikTok</p>
                    <div class="service-rating">
                        <span class="stars">★★★★★</span>
                        <span>4.9 (6,200+)</span>
                    </div>
                    <div class="service-users">
                        <div class="avatar-stack">
                            <img src="https://i.pravatar.cc/32?img=68" alt="">
                            <img src="https://i.pravatar.cc/32?img=65" alt="">
                            <img src="https://i.pravatar.cc/32?img=62" alt="">
                        </div>
                        <span>+531 today</span>
                    </div>
                    <ul class="service-features">
                        <li>Quality TikTok followers</li>
                        <li>Helps you hit the For You page</li>
                        <li>100 to 50,000+ followers</li>
                        <li>Natural-looking growth</li>
                    </ul>
                    <div class="service-footer">
                        <span class="service-delivery">Avg. delivery: <strong>30 min</strong></span>
                        <span class="service-status">In stock</span>
                    </div>
                    <a href="#" class="btn btn-primary">Buy TikTok Followers →</a>
                </div>

                <!-- TikTok Views -->
                <div class="service-card">
                    <div class="service-emoji">👀</div>
                    <h3>Buy TikTok Views</h3>
                    <p class="subtitle">Get your videos seen</p>
                    <div class="service-rating">
                        <span class="stars">★★★★★</span>
                        <span>4.9 (5,500+)</span>
                    </div>
                    <div class="service-users">
                        <div class="avatar-stack">
                            <img src="https://i.pravatar.cc/32?img=45" alt="">
                            <img src="https://i.pravatar.cc/32?img=19" alt="">
                            <img src="https://i.pravatar.cc/32?img=63" alt="">
                        </div>
                        <span>+298 today</span>
                    </div>
                    <ul class="service-features">
                        <li>Real people watching</li>
                        <li>Helps with TikTok SEO</li>
                        <li>1,000 to 1M+ views</li>
                        <li>Increases your watch time</li>
                    </ul>
                    <div class="service-footer">
                        <span class="service-delivery">Avg. delivery: <strong>30 min</strong></span>
                        <span class="service-status">In stock</span>
                    </div>
                    <a href="#" class="btn btn-primary">Buy TikTok Views →</a>
                </div>
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

    <!-- FAQ Section -->
    <section class="section faq-section">
        <div class="section-inner">
            <div class="section-header">
                <h2>Frequently Asked Questions</h2>
                <p>Everything you need to know about Famoid's social media services</p>
            </div>
            <div class="faq-container">
                <div class="faq-item active">
                    <button class="faq-question">
                        What is Famoid?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Famoid is a leading social media marketing agency established in 2017. We provide high-quality Instagram followers, likes, views, and engagement services for TikTok, Facebook, and other platforms using ad-based delivery methods.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        Is it safe to buy Instagram followers from Famoid?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Yes, buying followers from Famoid is completely safe. We use ad-based delivery methods that comply with platform guidelines. Your account information remains secure, and we never require your password.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        How fast will I receive my order?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Most orders begin processing within minutes of purchase. Depending on the package size, delivery typically completes within 1-24 hours. We offer instant delivery on most services.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        Do you offer a money-back guarantee?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Yes, Famoid offers a 30-day money-back guarantee. If you are not satisfied with our services or experience any issues, we provide full refunds or free refills.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        What payment methods do you accept?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            We accept all major credit cards, debit cards, Apple Pay, Google Pay, and various other secure payment methods. All transactions are encrypted and secure.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        Will the followers drop after I buy them?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Famoid provides high-quality followers with minimal drop rates. We also offer a 30-day refill guarantee, so if any followers drop within 30 days, we will replace them for free.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        Are the likes from real accounts?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Yes, all likes from Famoid come from real, active accounts. We use ad-based delivery to ensure genuine engagement that helps boost your content visibility and algorithm ranking.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        Can I buy automatic likes for future posts?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Absolutely! Famoid offers automatic likes packages that deliver likes to your new posts automatically. This ensures consistent engagement on all your content without manual ordering each time.
                        </div>
                    </div>
                </div>
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
                <div class="testimonial-mini-card">
                    <div class="testimonial-mini-header">
                        <img src="https://i.pravatar.cc/48?img=12" alt="">
                        <div>
                            <h4>Sarah M.</h4>
                            <span>Content Creator</span>
                        </div>
                    </div>
                    <p>"Famoid helped me grow from 5K to 50K followers. The quality is unmatched!"</p>
                </div>
                <div class="testimonial-mini-card">
                    <div class="testimonial-mini-header">
                        <img src="https://i.pravatar.cc/48?img=33" alt="">
                        <div>
                            <h4>James R.</h4>
                            <span>Business Owner</span>
                        </div>
                    </div>
                    <p>"Fast delivery and real engagement. My business visibility increased dramatically."</p>
                </div>
                <div class="testimonial-mini-card">
                    <div class="testimonial-mini-header">
                        <img src="https://i.pravatar.cc/48?img=45" alt="">
                        <div>
                            <h4>Emma L.</h4>
                            <span>Influencer</span>
                        </div>
                    </div>
                    <p>"Best investment for my social media presence. Highly recommend!"</p>
                </div>
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
                    <a href="#" class="btn btn-outline btn-lg">💬 Talk to Us</a>
                </div>
                <div class="cta-badges">
                    <span>🔒 SSL Secured</span>
                    <span>🚫 No Password</span>
                    <span>💰 Money Back Guarantee</span>
                </div>
            </div>
        </div>
    </section>

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
