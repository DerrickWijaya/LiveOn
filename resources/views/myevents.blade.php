@extends('layouts.app')

@section('title', 'My Events - LiveOn')

@section('content')

<div style="display: grid; grid-template-columns: 250px 1fr; gap: 28px; padding: 32px 30px; max-width: 1400px; margin: 0 auto; background: #fafbfc; min-height: 100vh; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;">
    
    @if (session('success'))
        <div style="grid-column: 1 / -1; background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div style="grid-column: 1 / -1; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-exclamation-circle" style="font-size: 1.2rem;"></i>
            <span style="font-weight: 500;">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Left Sidebar - Summary -->
    <div>
        <h3 style="font-weight: 700; color: #1a1a1a; margin-bottom: 20px; font-size: 0.95rem;">Summary</h3>
        
        <!-- Total Posts Card -->
        <div style="background: white; border-radius: 12px; padding: 16px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f0f0f0;">
            <p style="color: #666; font-size: 0.8rem; margin-bottom: 6px;">Total Posts</p>
            <div style="display: flex; align-items: center; gap: 10px;">
                <h2 style="font-weight: 700; color: #1a1a1a; margin: 0; font-size: 2rem;">{{ $totalPosts }}</h2>
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #F5EDFF, #E8D5FF); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-music" style="color: #7C5CEE; font-size: 1rem;"></i>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card -->
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f0f0f0;">
            <p style="color: #666; font-size: 0.8rem; margin-bottom: 6px;">Pending Requests</p>
            <div style="display: flex; align-items: center; gap: 10px;">
                <h2 style="font-weight: 700; color: #1a1a1a; margin: 0; font-size: 2rem;">{{ $totalPendingRequests }}</h2>
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #FFF5ED, #FFE8D5); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-exclamation" style="color: #FFB84D; font-size: 1rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Main Content -->
    <div>
        <h2 style="font-weight: 700; color: #1a1a1a; margin-bottom: 6px; font-size: 1.6rem;">My Events</h2>
        <p style="color: #999; margin-bottom: 20px; font-size: 0.9rem;">Manage your posts and view join requests.</p>

        @forelse ($posts as $post)
            <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; gap: 16px; border: 1px solid #f0f0f0;">
                <!-- Cover Image -->
                <div style="flex-shrink: 0;">
                    @if ($post->cover_image)
                        <img src="{{ str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset('storage/' . $post->cover_image) }}" alt="{{ $post->concert_name }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                    @elseif ($post->cover_color)
                        <div style="width: 100px; height: 100px; background: {{ $post->cover_color }}; border-radius: 8px;"></div>
                    @else
                        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-music" style="color: white; font-size: 1.8rem;"></i>
                        </div>
                    @endif
                </div>

                <!-- Event Details -->
                <div style="flex: 1;">
                    <h3 style="font-weight: 700; color: #1a1a1a; margin: 0 0 10px 0; font-size: 1rem;">{{ $post->concert_name }}</h3>
                    
                    <p style="color: #666; font-size: 0.85rem; margin: 0 0 6px 0;">
                        <i class="fas fa-map-marker-alt" style="color: #7C5CEE; margin-right: 6px;"></i> {{ $post->location }} • {{ $post->city }}
                    </p>
                    
                    <p style="color: #666; font-size: 0.85rem; margin: 0;">
                        <i class="fas fa-calendar-alt" style="color: #7C5CEE; margin-right: 6px;"></i> {{ $post->concert_date->format('M d, Y') }} • {{ $post->concert_time->format('H:i') }}
                    </p>

                    <!-- Badges -->
                    <div style="display: flex; gap: 6px; margin-top: 10px; flex-wrap: wrap;">
                        <span style="background: #f0f0f0; color: #666; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem;">Looking for {{ $post->spots_available - $post->spotsFilledCount() }} people</span>
                        @php
                            $pendingCount = $post->requests()->where('status', 'pending')->count();
                        @endphp
                        @if ($pendingCount > 0)
                            <span style="background: #FFF0F0; color: #FF6B9D; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">{{ $pendingCount }} new request{{ $pendingCount > 1 ? 's' : '' }}</span>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="flex-shrink: 0; display: flex; flex-direction: column; gap: 6px;">
                    <a href="{{ route('messages.group', $post) }}" style="padding: 8px 14px; background: white; border: 1px solid #ddd; color: #666; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.8rem; text-align: center; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f5f5f5';" onmouseout="this.style.backgroundColor='white';">View Group</a>
                    <button type="button" style="padding: 8px 14px; background: linear-gradient(135deg, #7C5CEE, #9D4EDD); color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: all 0.2s ease;" data-bs-toggle="modal" data-bs-target="#requestsModal{{ $post->id }}" onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">Manage Requests</button>
                </div>
            </div>

            <!-- Requests Modal -->
            <div class="modal fade" id="requestsModal{{ $post->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                        <div class="modal-header" style="border: none; padding: 20px; background: linear-gradient(135deg, #7C5CEE, #9D4EDD);">
                            <h5 class="modal-title" style="font-weight: 700; color: white; font-size: 1.05rem;">Requests for {{ $post->concert_name }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="padding: 0 20px; background: white;">
                            @php
                                $pendingRequests = $post->requests()->where('status', 'pending')->with('user')->get();
                                $acceptedRequests = $post->requests()->where('status', 'accepted')->with('user')->get();
                                $isFull = $post->spotsLeftCount() <= 0;
                            @endphp

                            @if ($pendingRequests->isEmpty() && $acceptedRequests->isEmpty())
                                <p style="color: #999; text-align: center; padding: 40px 0; font-size: 0.9rem;">No requests yet</p>
                            @else
                                @if ($pendingRequests->isNotEmpty())
                                    <h6 style="font-weight: 700; color: #1a1a1a; margin: 20px 0 12px 0; font-size: 0.9rem;">
                                        Pending Requests
                                        @if ($isFull)
                                            <span style="color: #dc3545; font-size: 0.8rem; font-weight: 600; margin-left: 8px;">(Event Full - Cannot Accept More)</span>
                                        @endif
                                    </h6>
                                    @foreach ($pendingRequests as $request)
                                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #fafbfc; border-radius: 8px; margin-bottom: 10px; border: 1px solid #f0f0f0; {{ $isFull ? 'opacity: 0.6;' : '' }}">
                                            <div style="display: flex; align-items: center; gap: 12px; flex: 1; cursor: pointer;" onclick="window.location.href='{{ route('messages.direct', $request->user->id) }}';" onmouseover="this.style.opacity='0.7';" onmouseout="this.style.opacity='1';">
                                                @if ($request->user->profile_image)
                                                    <img src="{{ str_starts_with($request->user->profile_image, 'http') ? $request->user->profile_image : asset('storage/' . $request->user->profile_image) }}" alt="User" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                                                @else
                                                    <div style="width: 36px; height: 36px; background: #00BCD4; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.8rem;">
                                                        {{ strtoupper(substr($request->user->first_name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <p style="font-weight: 600; color: #1a1a1a; margin: 0; text-decoration: underline; text-decoration-color: #7C5CEE; text-decoration-thickness: 2px; text-underline-offset: 4px; font-size: 0.9rem;">{{ $request->user->first_name }} {{ $request->user->last_name }}</p>
                                                    <p style="color: #999; font-size: 0.8rem; margin: 2px 0 0 0;">{{ $request->user->email }}</p>
                                                </div>
                                            </div>
                                            <div style="display: flex; gap: 8px;">
                                                @if ($isFull)
                                                    <button type="button" disabled style="padding: 6px 12px; background: #6c757d; color: white; border: none; border-radius: 6px; cursor: not-allowed; font-size: 0.85rem; font-weight: 600; opacity: 0.6;">Accept</button>
                                                @else
                                                    <form action="{{ route('myevents.accept', $request) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" style="padding: 6px 12px; background: #4CAF50; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">Accept</button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('myevents.reject', $request) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" style="padding: 6px 12px; background: #FF6B9D; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">Reject</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                    <hr style="margin: 20px 0; border: none; border-top: 1px solid #eee;">
                                @endif

                                @if ($acceptedRequests->isNotEmpty())
                                    <h6 style="font-weight: 700; color: #1a1a1a; margin-bottom: 16px;">Accepted Members</h6>
                                    @foreach ($acceptedRequests as $request)
                                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f9f9f9; border-radius: 8px; margin-bottom: 12px;">
                                            <div style="display: flex; align-items: center; gap: 12px; flex: 1; cursor: pointer;" onclick="window.location.href='{{ route('messages.direct', $request->user->id) }}';" onmouseover="this.style.opacity='0.7';" onmouseout="this.style.opacity='1';">
                                                @if ($request->user->profile_image)
                                                    <img src="{{ str_starts_with($request->user->profile_image, 'http') ? $request->user->profile_image : asset('storage/' . $request->user->profile_image) }}" alt="User" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                                @else
                                                    <div style="width: 40px; height: 40px; background: #00BCD4; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                                        {{ strtoupper(substr($request->user->first_name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <p style="font-weight: 600; color: #1a1a1a; margin: 0; text-decoration: underline; text-decoration-color: #7C5CEE; text-decoration-thickness: 2px; text-underline-offset: 4px;">{{ $request->user->first_name }} {{ $request->user->last_name }}</p>
                                                    <p style="color: #999; font-size: 0.9rem; margin: 4px 0 0 0;">{{ $request->user->email }}</p>
                                                </div>
                                            </div>
                                            <span style="background: #E8F5E9; color: #4CAF50; padding: 4px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">Accepted</span>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #eee; padding: 12px 20px; background: white;">
                            <button type="button" class="btn" style="background: linear-gradient(135deg, #7C5CEE, #9D4EDD); color: white; border: none; font-size: 0.9rem;" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 60px 40px; background: white; border-radius: 12px;">
                <i class="fas fa-calendar" style="font-size: 3rem; color: #ddd; margin-bottom: 16px;"></i>
                <p style="color: #999; margin: 16px 0;">You haven't created any posts yet.</p>
                <a href="{{ route('discover') }}" style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #7C5CEE, #9D4EDD); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; margin-top: 16px;">
                    <i class="fas fa-plus"></i> Create Your First Post
                </a>
            </div>
        @endforelse
    </div>
</div>

@endsection
