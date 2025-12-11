@extends('layouts.app')

@section('title', 'Home - LiveOn')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
        background: #fafbfc;
    }
</style>

<!-- Navigation Bar (Home Page Only) -->
<nav style="background-color: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.06); position: sticky; top: 0; z-index: 1030; padding: 12px 30px; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;">
    <div style="max-width: 1400px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between;">
        <!-- Logo -->
        <a href="#" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
            <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-music" style="color: white; font-size: 0.95rem;"></i>
            </div>
            <span style="font-weight: 700; font-size: 1.1rem; color: #000;">LiveON</span>
        </a>
        
        <!-- Navigation Links -->
        <div id="navLinks" style="display: flex; align-items: center; gap: 16px;">
            <a href="#what-is" style="color: #333; font-weight: 500; padding: 8px 12px; text-decoration: none; border-radius: 6px; transition: 0.3s; font-size: 0.9rem;">What is LiveON?</a>
            <a href="#features" style="color: #333; font-weight: 500; padding: 8px 12px; text-decoration: none; border-radius: 6px; transition: 0.3s; font-size: 0.9rem;">Features</a>
            <a href="#how-it-works" style="color: #333; font-weight: 500; padding: 8px 12px; text-decoration: none; border-radius: 6px; transition: 0.3s; font-size: 0.9rem;">How It Works</a>
            <a href="#about" style="color: #333; font-weight: 500; padding: 8px 12px; text-decoration: none; border-radius: 6px; transition: 0.3s; font-size: 0.9rem;">About Us</a>
            <a href="{{ route('login') }}" style="color: #666; font-weight: 500; padding: 8px 12px; text-decoration: none; border-radius: 6px; transition: 0.3s; font-size: 0.9rem;">Login</a>
            <a href="{{ route('register') }}" style="background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; padding: 8px 18px; font-weight: 600; text-decoration: none; border-radius: 20px; display: inline-block; border: none; font-size: 0.9rem;">Register</a>
        </div>

        <!-- Hamburger Menu Button -->
        <button id="hamburger" style="display: none; background: none; border: none; cursor: pointer; font-size: 1.2rem; color: #333;">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" style="display: none; margin-top: 12px; padding-top: 12px; border-top: 1px solid #f0f0f0;">
        <a href="#what-is" style="display: block; color: #333; font-weight: 500; padding: 10px 0; text-decoration: none; border-bottom: 1px solid #f0f0f0; font-size: 0.9rem;">What is LiveON?</a>
        <a href="#features" style="display: block; color: #333; font-weight: 500; padding: 10px 0; text-decoration: none; border-bottom: 1px solid #f0f0f0; font-size: 0.9rem;">Features</a>
        <a href="#how-it-works" style="display: block; color: #333; font-weight: 500; padding: 10px 0; text-decoration: none; border-bottom: 1px solid #f0f0f0; font-size: 0.9rem;">How It Works</a>
        <a href="#about" style="display: block; color: #333; font-weight: 500; padding: 10px 0; text-decoration: none; border-bottom: 1px solid #f0f0f0; font-size: 0.9rem;">About Us</a>
        <a href="{{ route('login') }}" style="display: block; color: #333; font-weight: 500; padding: 10px 0; text-decoration: none; border-bottom: 1px solid #f0f0f0; font-size: 0.9rem;">Login</a>
        <a href="{{ route('register') }}" style="display: inline-block; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; padding: 8px 18px; font-weight: 600; text-decoration: none; border-radius: 20px; margin-top: 10px; font-size: 0.9rem;">Register</a>
    </div>
</nav>

<style>
    @media (max-width: 1200px) {
        #navLinks {
            display: none !important;
        }
        #hamburger {
            display: block !important;
        }
    }
</style>

<script>
    document.getElementById('hamburger').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenu.style.display = mobileMenu.style.display === 'none' ? 'block' : 'none';
    });

    // Close menu when a link is clicked
    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', function() {
            document.getElementById('mobileMenu').style.display = 'none';
        });
    });
</script>

<!-- Hero Section -->
<div style="background: linear-gradient(135deg, #f5f1ff 0%, #e6f2ff 100%); padding: 80px 20px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 style="font-size: 3.2rem; font-weight: 700; color: #1a1a1a; line-height: 1.2; margin-bottom: 18px;">
                    Find Your Companion
                    <span style="color: #7C5CEE;">Concert</span>
                </h1>
                <p style="font-size: 1rem; color: #666; line-height: 1.6; margin-bottom: 28px;">
                    Connect with music lovers who share your passion. Create posts for concerts you're attending or join others. Make every concert safer, more exciting, and unforgettable!
                </p>
                <a href="{{ route('register') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border: none; padding: 10px 28px; font-size: 0.95rem; font-weight: 600;">
                    Get Started
                </a>

                <div style="margin-top: 40px; display: flex; gap: 32px;">
                    <div>
                        <h4 style="font-size: 1.6rem; font-weight: 700; color: #1a1a1a;">10K+</h4>
                        <p style="color: #999; font-size: 0.85rem;">Active Users</p>
                    </div>
                    <div>
                        <h4 style="font-size: 1.6rem; font-weight: 700; color: #1a1a1a;">500+</h4>
                        <p style="color: #999; font-size: 0.85rem;">Events Monthly</p>
                    </div>
                    <div>
                        <h4 style="font-size: 1.6rem; font-weight: 700; color: #1a1a1a;">50+</h4>
                        <p style="color: #999; font-size: 0.85rem;">Cities</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/find your companion.png') }}" alt="Concert" style="width: 100%; height: auto; object-fit: cover; border-radius: 20px;">
            </div>
        </div>
    </div>
</div>

<!-- What is LiveON Section -->
<div id="what-is" style="padding: 80px 20px; background: #fff;">
    <div class="container">
        <h2 style="text-align: center; font-size: 2.2rem; font-weight: 700; color: #1a1a1a; margin-bottom: 12px;">What is LiveON?</h2>
        <p style="text-align: center; color: #666; font-size: 0.95rem; max-width: 700px; margin: 0 auto 52px;">
            LiveON is the ultimate platform for music enthusiasts to connect, share experiences, and attend concerts together safely.
        </p>

        <div class="row" style="justify-content: center;">
            <div class="col-md-4 mb-4">
                <div style="background: linear-gradient(135deg, #e6f2ff 0%, #f5f1ff 100%); padding: 36px 28px; border-radius: 12px; text-align: center; height: 100%; display: flex; flex-direction: column; justify-content: center; border: 1px solid #f0f0f0;">
                    <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 12px; margin: 0 auto 18px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users" style="font-size: 1.8rem; color: white;"></i>
                    </div>
                    <h4 style="font-weight: 700; color: #1a1a1a; margin-bottom: 8px; min-height: 50px; font-size: 1rem;">Connect with Music Lovers</h4>
                    <p style="color: #666; font-size: 0.85rem;">Find like-minded people who share your musical taste and passion for live performances.</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div style="background: linear-gradient(135deg, #ffe6f0 0%, #fff5e6 100%); padding: 36px 28px; border-radius: 12px; text-align: center; height: 100%; display: flex; flex-direction: column; justify-content: center; border: 1px solid #f0f0f0;">
                    <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #FF6B9D, #FFB84D); border-radius: 12px; margin: 0 auto 18px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-shield-alt" style="font-size: 1.8rem; color: white;"></i>
                    </div>
                    <h4 style="font-weight: 700; color: #1a1a1a; margin-bottom: 8px; min-height: 50px; font-size: 1rem;">Safe Concert Experience</h4>
                    <p style="color: #666; font-size: 0.85rem;">Attend concerts with verified users and enjoy a safer, more secure event experience.</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div style="background: linear-gradient(135deg, #e6ffe6 0%, #fff9e6 100%); padding: 36px 28px; border-radius: 12px; text-align: center; height: 100%; display: flex; flex-direction: column; justify-content: center; border: 1px solid #f0f0f0;">
                    <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #FFB84D, #4CAF50); border-radius: 12px; margin: 0 auto 18px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-calendar-check" style="font-size: 1.8rem; color: white;"></i>
                    </div>
                    <h4 style="font-weight: 700; color: #1a1a1a; margin-bottom: 8px; min-height: 50px; font-size: 1rem;">Create & Join Events</h4>
                    <p style="color: #666; font-size: 0.85rem;">Post concerts you're attending or join existing groups going to the same events.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- How It Works Section -->
<div id="how-it-works" style="padding: 80px 20px; background: linear-gradient(135deg, #f5f1ff 0%, #e6f2ff 100%);">
    <div class="container">
        <h2 style="text-align: center; font-size: 2.5rem; font-weight: 700; color: #000; margin-bottom: 15px;">How It Works</h2>
        <p style="text-align: center; color: #666; font-size: 1.05rem; margin-bottom: 60px;">Get started in just a few simple steps</p>

        <div class="row" style="justify-content: center;">
            <div class="col-md-5 col-lg-3 mb-4 text-center">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <span style="font-size: 2rem; color: white; font-weight: 700;">1</span>
                </div>
                <h5 style="font-weight: 700; color: #000; margin-bottom: 10px;">Sign Up & Create Profile</h5>
                <p style="color: #666; font-size: 0.95rem;">Create your account and tell us about your music preferences and interests.</p>
            </div>

            <div class="col-md-5 col-lg-3 mb-4 text-center">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <span style="font-size: 2rem; color: white; font-weight: 700;">2</span>
                </div>
                <h5 style="font-weight: 700; color: #000; margin-bottom: 10px;">Find or Create Events</h5>
                <p style="color: #666; font-size: 0.95rem;">Browse existing concert posts or create your own for events you're planning to attend.</p>
            </div>

            <div class="col-md-5 col-lg-3 mb-4 text-center">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <span style="font-size: 2rem; color: white; font-weight: 700;">3</span>
                </div>
                <h5 style="font-weight: 700; color: #000; margin-bottom: 10px;">Connect & Attend</h5>
                <p style="color: #666; font-size: 0.95rem;">Meet your concert companions and enjoy an amazing live music experience together!</p>
            </div>
        </div>
    </div>
</div>

<!-- Why Choose LiveON Section -->
<div id="features" style="padding: 80px 20px; background: #fff;">
    <div class="container">
        <h2 style="text-align: center; font-size: 2.5rem; font-weight: 700; color: #000; margin-bottom: 60px;">Why Choose LiveON?</h2>

        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div style="margin-bottom: 30px;">
                    <div style="display: flex; align-items: flex-start; gap: 20px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-check" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h5 style="font-weight: 700; color: #000; margin-bottom: 8px;">Verified User Profiles</h5>
                            <p style="color: #666; margin: 0;">All users go through verification to ensure a safe community.</p>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 30px;">
                    <div style="display: flex; align-items: flex-start; gap: 20px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-check" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h5 style="font-weight: 700; color: #000; margin-bottom: 8px;">Smart Matching</h5>
                            <p style="color: #666; margin: 0;">Our algorithm matches you with people who share similar music tastes.</p>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 30px;">
                    <div style="display: flex; align-items: flex-start; gap: 20px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-check" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h5 style="font-weight: 700; color: #000; margin-bottom: 8px;">Real-time Chat</h5>
                            <p style="color: #666; margin: 0;">Coordinate with your group through our integrated messaging system.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; align-items: flex-start; gap: 20px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-check" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h5 style="font-weight: 700; color: #000; margin-bottom: 8px;">Event Discovery</h5>
                            <p style="color: #666; margin: 0;">Discover new concerts and events happening in your area.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 text-center" style="display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('images/why choose liveon.png') }}" alt="Concert Lights" style="width: 100%; max-width: 500px; height: auto; object-fit: cover; border-radius: 15px;">
            </div>
        </div>
    </div>
</div>

<!-- About Us Section -->
<div id="about" style="padding: 80px 20px; background: linear-gradient(135deg, #f5f1ff 0%, #e6f2ff 100%);">
    <div class="container">
        <h2 style="text-align: center; font-size: 2.5rem; font-weight: 700; color: #000; margin-bottom: 20px;">About Us</h2>
        <p style="text-align: center; color: #666; font-size: 1.05rem; max-width: 700px; margin: 0 auto 60px;">
            We're passionate music lovers who believe that live music experiences are better when shared with others who truly understand the magic of live performances.
        </p>

        <div class="row">
            <div class="col-lg-6 mb-5">
                <h4 style="font-weight: 700; color: #000; margin-bottom: 20px;">Our Mission</h4>
                <p style="color: #666; line-height: 1.8; margin-bottom: 15px;">
                    LiveON was born from the simple idea that concerts are more enjoyable when experienced with others who share your passion for music. We've created a platform that not only connects music lovers but also prioritizes safety and genuine connections.
                </p>
                <p style="color: #666; line-height: 1.8; margin-bottom: 30px;">
                    Our team consists of music enthusiasts, safety experts, and technology professionals who are committed to making live music experiences accessible, safe, and unforgettable for everyone.
                </p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <div>
                        <div style="font-size: 2.5rem; font-weight: 700; color: #7C5CEE; margin-bottom: 5px;">2025</div>
                        <p style="color: #666; font-size: 0.9rem;">Founded</p>
                    </div>
                    <div>
                        <div style="font-size: 2.5rem; font-weight: 700; color: #FF6B9D; margin-bottom: 5px;">10K+</div>
                        <p style="color: #666; font-size: 0.9rem;">Happy Users</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-5">
                <div style="margin-top: 30px;">
                    <img src="https://images.unsplash.com/photo-1459749411175-04bf5292ceea?w=400&h=500&fit=crop" alt="About Us" style="width: 100%; height: auto; object-fit: cover; border-radius: 15px;">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div style="background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; padding: 80px 20px; text-align: center;">
    <div class="container">
        <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 20px;">Ready to Find Your Concert Crew?</h2>
        <p style="font-size: 1.1rem; margin-bottom: 40px; opacity: 0.95;">
            Join thousands of music lovers who have already discovered their perfect concert companions on LiveON.
        </p>
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('register') }}" class="btn btn-light" style="padding: 12px 35px; font-weight: 600; color: #7C5CEE;">Register Now</a>
            <a href="{{ route('login') }}" class="btn btn-outline-light" style="padding: 12px 35px; font-weight: 600;">Login</a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer style="background: #1a1a1a; color: white; padding: 60px 20px 30px;">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-3 mb-4 mb-md-0">
                <div style="margin-bottom: 20px;">
                    <i class="fas fa-music" style="color: #7C5CEE; font-size: 1.8rem;"></i>
                    <span style="font-weight: 700; font-size: 1.2rem; margin-left: 10px;">LiveON</span>
                </div>
                <p style="color: #aaa; font-size: 0.9rem;">Connecting music lovers worldwide for unforgettable concert experiences.</p>
                <div style="display: flex; gap: 15px; margin-top: 15px;">
                    <a href="#" style="color: #7C5CEE; text-decoration: none;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="color: #7C5CEE; text-decoration: none;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: #7C5CEE; text-decoration: none;"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <div class="col-md-3 mb-4 mb-md-0">
                <h6 style="font-weight: 700; color: white; margin-bottom: 20px;">Platform</h6>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 10px;"><a href="#how-it-works" style="color: #aaa; text-decoration: none;">How It Works</a></li>
                    <li style="margin-bottom: 10px;"><a href="#features" style="color: #aaa; text-decoration: none;">Features</a></li>
                    <li style="margin-bottom: 10px;"><a href="#" style="color: #aaa; text-decoration: none;">Pricing</a></li>
                    <li><a href="#" style="color: #aaa; text-decoration: none;">Safety</a></li>
                </ul>
            </div>

            <div class="col-md-3 mb-4 mb-md-0">
                <h6 style="font-weight: 700; color: white; margin-bottom: 20px;">Company</h6>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 10px;"><a href="#about" style="color: #aaa; text-decoration: none;">About Us</a></li>
                    <li style="margin-bottom: 10px;"><a href="#" style="color: #aaa; text-decoration: none;">Careers</a></li>
                    <li style="margin-bottom: 10px;"><a href="#" style="color: #aaa; text-decoration: none;">Contact</a></li>
                    <li><a href="#" style="color: #aaa; text-decoration: none;">Blog</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h6 style="font-weight: 700; color: white; margin-bottom: 20px;">Support</h6>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 10px;"><a href="#" style="color: #aaa; text-decoration: none;">Help Center</a></li>
                    <li style="margin-bottom: 10px;"><a href="#" style="color: #aaa; text-decoration: none;">Privacy Policy</a></li>
                    <li style="margin-bottom: 10px;"><a href="#" style="color: #aaa; text-decoration: none;">Terms of Service</a></li>
                    <li><a href="#" style="color: #aaa; text-decoration: none;">Community Guidelines</a></li>
                </ul>
            </div>
        </div>

        <hr style="background-color: #333;">

        <div style="text-align: center; color: #aaa; font-size: 0.9rem;">
            <p>&copy; 2025 LiveON. All rights reserved.</p>
        </div>
    </div>
</footer>
@endsection
