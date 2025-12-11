@extends('layouts.app')

@section('title', 'Login - LiveOn')

@section('content')
<div style="display: flex; min-height: 100vh; background: #ffffff; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;">
    <!-- Left Side - Dark with Concert Image -->
    <div style="flex: 1; background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(80,20,80,0.8) 100%), url('https://images.unsplash.com/photo-1459749411175-04bf5292ceea?w=700&h=900&fit=crop'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; padding: 40px; color: white; min-height: 100vh;">
        <div style="text-align: center;">
            <h2 style="font-size: 2.8rem; font-weight: 700; margin-bottom: 16px; line-height: 1.2;">Find Your Concert<br>Buddy</h2>
            <p style="font-size: 1rem; opacity: 0.9; line-height: 1.6;">Connect with music lovers and make every concert unforgettable</p>
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
                <h1 style="font-size: 1.6rem; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">Welcome Back!</h1>
                <p style="color: #666; font-size: 0.9rem;">Ready for the next gig?</p>
            </div>

            @if ($errors->any())
                <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 18px; font-size: 0.85rem;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; color: #333; margin-bottom: 6px; font-size: 0.85rem;">Email Address</label>
                    <input type="text" name="email" id="email" placeholder="Enter your email" class="form-control @error('email') is-invalid @enderror" 
                        required autocomplete="new-password" style="padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; width: 100%; background: #fafbfc;">
                    @error('email')
                        <small style="color: #d32f2f; font-size: 0.8rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="font-weight: 600; color: #333; font-size: 0.85rem; display: block; margin-bottom: 6px;">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" class="form-control @error('password') is-invalid @enderror" 
                        required autocomplete="new-password" style="padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; width: 100%; background: #fafbfc;">
                    @error('password')
                        <small style="color: #d32f2f; font-size: 0.8rem;">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" style="width: 100%; padding: 11px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: 0.3s; margin-top: 4px;">
                    Log In
                </button>
            </form>

            <p style="text-align: center; color: #666; margin-top: 18px; font-size: 0.85rem;">
                Don't have an account? 
                <a href="{{ route('register') }}" style="color: #7C5CEE; font-weight: 600; text-decoration: none;">Sign Up</a>
            </p>
        </div>
    </div>
</div>
@endsection
