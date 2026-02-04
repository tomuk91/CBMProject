<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Car Service - Expert Auto Care & Maintenance</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1a1a1a;
            text-decoration: none;
        }

        .logo span {
            color: #667eea;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: #666;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #667eea;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        /* Language Toggle */
        .lang-toggle {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            background: #f3f4f6;
            padding: 0.25rem;
            border-radius: 6px;
        }

        .lang-toggle a {
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            color: #666;
            transition: all 0.2s;
        }

        .lang-toggle a.active {
            background: #667eea;
            color: white;
        }

        .lang-toggle a:hover:not(.active) {
            background: #e5e7eb;
            color: #333;
        }

        /* Hero Section */
        .hero {
            min-height: 50vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            padding: 8rem 5% 4rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-text p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.3);
        }

        /* Services Section */
        .services {
            padding: 6rem 5%;
            background: #f8f9fa;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 1rem;
        }

        .section-header p {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .services-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .service-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }

        .service-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1rem;
        }

        .service-card p {
            color: #666;
            line-height: 1.7;
        }

        /* Why Choose Us */
        .why-us {
            padding: 6rem 5%;
            background: white;
        }

        .why-us-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .features-list {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .feature-item {
            display: flex;
            gap: 1.5rem;
        }

        .feature-icon {
            font-size: 2rem;
            color: #667eea;
            flex-shrink: 0;
        }

        .feature-text h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .feature-text p {
            color: #666;
        }

        /* CTA Section */
        .cta {
            padding: 6rem 5%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            text-align: center;
            color: white;
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }

        .cta p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background: #1a1a1a;
            color: white;
            padding: 3rem 5% 1.5rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-section p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
        }

        @media (max-width: 768px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .why-us-content {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }

            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <a href="{{ route('home') }}" class="logo">Car<span>Service</span></a>
        <div class="nav-links">
            <a href="#services">{{ __('messages.nav_services') }}</a>
            <a href="#why-us">{{ __('messages.nav_about') }}</a>
            <a href="#contact">{{ __('messages.nav_contact') }}</a>
            
            <!-- Language Toggle -->
            <div class="lang-toggle">
                <a href="{{ route('language.switch', 'hu') }}" class="{{ app()->getLocale() === 'hu' ? 'active' : '' }}">HU</a>
                <a href="{{ route('language.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            </div>
            
            @auth
                <a href="{{ route('appointments.index') }}" class="btn-primary">{{ __('messages.nav_book') }}</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary">{{ __('messages.nav_login') }}</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>{{ __('messages.hero_title') }}</h1>
                <p>{{ __('messages.hero_description') }}</p>
                <div class="hero-buttons">
                    @auth
                        <a href="{{ route('appointments.index') }}" class="btn-secondary">{{ __('messages.hero_cta_primary') }}</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-secondary">{{ __('messages.hero_cta_primary') }}</a>
                        <a href="{{ route('login') }}" class="btn-primary">{{ __('messages.nav_login') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="section-header">
            <h2>{{ __('messages.services_title') }}</h2>
            <p>{{ __('messages.services_subtitle') }}</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">🔧</div>
                <h3>{{ __('messages.service_oil_title') }}</h3>
                <p>{{ __('messages.service_oil_desc') }}</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🛞</div>
                <h3>{{ __('messages.service_brake_title') }}</h3>
                <p>{{ __('messages.service_brake_desc') }}</p>
            </div>
            <div class="service-card">
                <div class="service-icon">⚙️</div>
                <h3>{{ __('messages.service_engine_title') }}</h3>
                <p>{{ __('messages.service_engine_desc') }}</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🔄</div>
                <h3>{{ __('messages.service_tire_title') }}</h3>
                <p>{{ __('messages.service_tire_desc') }}</p>
            </div>
            <div class="service-card">
                <div class="service-icon">❄️</div>
                <h3>{{ __('messages.service_ac_title') }}</h3>
                <p>{{ __('messages.service_ac_desc') }}</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🔩</div>
                <h3>{{ __('messages.service_transmission_title') }}</h3>
                <p>{{ __('messages.service_transmission_desc') }}</p>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-us" id="why-us">
        <div class="why-us-content">
            <div>
                <div class="section-header" style="text-align: left;">
                    <h2>{{ __('messages.features_title') }}</h2>
                    <p style="margin: 0;">Experience the difference with our professional service</p>
                </div>
            </div>
            <div class="features-list">
                <div class="feature-item">
                    <div class="feature-icon">✅</div>
                    <div class="feature-text">
                        <h3>Expert Technicians</h3>
                        <p>ASE-certified mechanics with years of experience in automotive repair and maintenance.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">💰</div>
                    <div class="feature-text">
                        <h3>Transparent Pricing</h3>
                        <p>No hidden fees. Clear quotes before any work begins. Fair and competitive rates.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">⚡</div>
                    <div class="feature-text">
                        <h3>Quick Turnaround</h3>
                        <p>Efficient service without compromising quality. We respect your time and schedule.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🛡️</div>
                    <div class="feature-text">
                        <h3>Quality Guarantee</h3>
                        <p>All work backed by our satisfaction guarantee. Premium parts and workmanship.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="contact">
        <h2>Ready to Service Your Vehicle?</h2>
        <p>Book your appointment online in minutes</p>
        @auth
            <a href="{{ route('appointments.index') }}" class="btn-secondary">Book Appointment Now</a>
        @else
            <a href="{{ route('register') }}" class="btn-secondary">Create Account & Book</a>
        @endauth
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Car<span style="color: #667eea;">Service</span></h3>
                <p>Premium automotive care and maintenance services. Trusted by thousands of customers for reliable, professional service.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="#services">Services</a></li>
                    <li><a href="#why-us">Why Us</a></li>
                    @auth
                        <li><a href="{{ route('appointments.index') }}">Book Appointment</a></li>
                    @else
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
            <div class="footer-section">
                <h3>Services</h3>
                <ul class="footer-links">
                    <li><a href="#">Oil Change</a></li>
                    <li><a href="#">Brake Service</a></li>
                    <li><a href="#">Engine Diagnostics</a></li>
                    <li><a href="#">Tire Rotation</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <ul class="footer-links">
                    <li>Email: info@carservice.com</li>
                    <li>Phone: (555) 123-4567</li>
                    <li>Hours: Mon-Fri 8AM-6PM</li>
                    <li>Sat 9AM-4PM</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 CarService. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
