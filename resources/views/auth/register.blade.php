@extends('layouts.app')

@section('title', 'Register - LiveOn')

@section('content')
<div style="display: flex; min-height: 100vh; background: #ffffff; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;">
    <!-- Left Side - Purple Gradient -->
    <div style="flex: 1; background: linear-gradient(135deg, #7C5CEE 0%, #6B4ACC 100%); display: flex; align-items: center; justify-content: center; padding: 40px; color: white; min-height: 100vh;">
        <div style="text-align: center;">
            <h2 style="font-size: 2.4rem; font-weight: 700; margin-bottom: 16px;">Join the community.</h2>
            <p style="font-size: 1rem; opacity: 0.9; line-height: 1.6;">Never go to a concert alone again.</p>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px; background: #ffffff;">
        <div style="width: 100%; max-width: 420px;">
            <div style="text-align: center; margin-bottom: 32px;">
                <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 18px;">
                    <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-music" style="color: white; font-size: 1rem;"></i>
                    </div>
                    <span style="font-size: 1.3rem; font-weight: 700; color: #7C5CEE;">LiveON</span>
                </div>
                <h1 style="font-size: 1.6rem; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">Create your account</h1>
                <p style="color: #666; font-size: 0.9rem;">It only takes a minute to start finding concert buddies.</p>
            </div>

            @if ($errors->any())
                <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 18px; font-size: 0.85rem;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; color: #333; margin-bottom: 6px; font-size: 0.85rem;">Full Name</label>
                    <input type="text" name="first_name" id="first_name" placeholder="John Doe" class="form-control @error('first_name') is-invalid @enderror" 
                        value="{{ old('first_name') }}" required style="padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; width: 100%; background: #fafbfc;">
                    @error('first_name')
                        <small style="color: #d32f2f; font-size: 0.8rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; color: #333; margin-bottom: 6px; font-size: 0.85rem;">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="john@example.com" class="form-control @error('email') is-invalid @enderror" 
                        value="{{ old('email') }}" required style="padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; width: 100%; background: #fafbfc;">
                    @error('email')
                        <small style="color: #d32f2f; font-size: 0.8rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; color: #333; margin-bottom: 6px; font-size: 0.85rem;">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password" style="padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; width: 100%; background: #fafbfc;">
                    <small style="color: #999; display: block; margin-top: 4px; font-size: 0.8rem;">Minimum 8 characters</small>
                    @error('password')
                        <small style="color: #d32f2f; font-size: 0.8rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; color: #333; margin-bottom: 6px; font-size: 0.85rem;">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password" class="form-control" required autocomplete="new-password" style="padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; width: 100%; background: #fafbfc;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; color: #333; margin-bottom: 6px; font-size: 0.85rem;">Location</label>
                    <input type="text" name="location" id="location" placeholder="City, Country" class="form-control @error('location') is-invalid @enderror" 
                        value="{{ old('location') }}" style="padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; width: 100%; background: #fafbfc;">
                    @error('location')
                        <small style="color: #d32f2f; font-size: 0.8rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: flex; align-items: flex-start; gap: 6px; cursor: pointer; font-size: 0.8rem;">
                        <input type="checkbox" name="terms" required style="margin-top: 2px;">
                        <span style="color: #666;">I agree to the <a href="#" style="color: #7C5CEE; text-decoration: none;">Terms of Service</a> and <a href="#" style="color: #7C5CEE; text-decoration: none;">Privacy Policy</a></span>
                    </label>
                </div>

                <button type="submit" style="width: 100%; padding: 11px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: 0.3s;">
                    Create Account
                </button>
            </form>

            <p style="text-align: center; color: #666; margin-top: 18px; font-size: 0.85rem;">
                Already have an account? 
                <a href="{{ route('login') }}" style="color: #7C5CEE; font-weight: 600; text-decoration: none;">Log In</a>
            </p>
        </div>
    </div>
</div>
@endsection
