@extends('layouts.app')

@section('title', 'Join History - LiveOn')

@section('content')

<div style="padding: 32px 30px; max-width: 1200px; margin: 0 auto; background: #fafbfc; min-height: 100vh; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;">
    <h2 style="font-weight: 700; color: #1a1a1a; margin-bottom: 6px; font-size: 1.6rem;">Join History</h2>
    <p style="color: #999; margin-bottom: 24px; font-size: 0.9rem;">Concerts you've joined through LiveON</p>

    <!-- Total Joined Stats -->
    <div style="background: white; border-radius: 12px; padding: 16px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 14px; border: 1px solid #f0f0f0;">
        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #F5EDFF, #E8D5FF); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-music" style="color: #7C5CEE; font-size: 1.3rem;"></i>
        </div>
        <div>
            <p style="color: #666; font-size: 0.8rem; margin: 0;">Total Joined</p>
            <h3 style="font-weight: 700; color: #1a1a1a; margin: 4px 0 0 0; font-size: 1.6rem;">{{ $totalJoined }}</h3>
        </div>
    </div>

    <!-- Events List -->
    @forelse ($posts as $post)
        <div style="background: white; border-radius: 12px; padding: 18px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; gap: 16px; border: 1px solid #f0f0f0;">
            <!-- Cover Image -->
            <div style="flex-shrink: 0;">
                @if ($post->cover_image)
                    <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->concert_name }}" style="width: 88px; height: 88px; object-fit: cover; border-radius: 8px;">
                @elseif ($post->cover_color)
                    <div style="width: 88px; height: 88px; background: {{ $post->cover_color }}; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-music" style="color: white; font-size: 1.5rem;"></i>
                    </div>
                @else
                    <div style="width: 88px; height: 88px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-music" style="color: white; font-size: 1.5rem;"></i>
                    </div>
                @endif
            </div>

            <!-- Event Details -->
            <div style="flex: 1;">
                <h3 style="font-weight: 700; color: #1a1a1a; margin: 0 0 8px 0; font-size: 1rem;">{{ $post->concert_name }}</h3>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-bottom: 8px;">
                    <p style="color: #666; font-size: 0.8rem; margin: 0;">
                        <i class="fas fa-calendar-alt" style="color: #7C5CEE; margin-right: 6px;"></i> {{ $post->concert_date->format('M d, Y') }}
                    </p>
                    <p style="color: #666; font-size: 0.8rem; margin: 0;">
                        <i class="fas fa-clock" style="color: #7C5CEE; margin-right: 6px;"></i> {{ $post->concert_time->format('H:i') }}
                    </p>
                    <p style="color: #666; font-size: 0.8rem; margin: 0;">
                        <i class="fas fa-map-marker-alt" style="color: #7C5CEE; margin-right: 6px;"></i> {{ $post->location }}
                    </p>
                    <p style="color: #666; font-size: 0.8rem; margin: 0;">
                        <i class="fas fa-user" style="color: #7C5CEE; margin-right: 6px;"></i> {{ $post->user->first_name }}
                    </p>
                </div>
            </div>

            <!-- Action Button -->
            <div style="flex-shrink: 0; display: flex; align-items: center;">
                <a href="{{ route('messages.group', $post) }}" style="padding: 8px 16px; background: white; border: 1px solid #ddd; color: #666; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f5f5f5';" onmouseout="this.style.backgroundColor='white';">View Group</a>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 60px 40px; background: white; border-radius: 12px; border: 1px solid #f0f0f0;">
            <i class="fas fa-history" style="font-size: 3rem; color: #ddd; margin-bottom: 16px;"></i>
            <p style="color: #999; margin: 16px 0; font-size: 0.9rem;">You haven't joined any events yet.</p>
            <a href="{{ route('discover') }}" style="display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, #7C5CEE, #9D4EDD); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; margin-top: 16px; font-size: 0.9rem;">
                <i class="fas fa-compass"></i> Discover Concerts
            </a>
        </div>
    @endforelse
</div>

@endsection
