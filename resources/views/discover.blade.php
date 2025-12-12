@extends('layouts.app')

@section('title', 'Discover - LiveOn')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
    }
</style>

<!-- Custom Header for Discover with Search -->
<nav style="background-color: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.06); padding: 12px 30px; position: sticky; top: 0; z-index: 1020; margin: 0;">
    <div style="max-width: 1400px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between;">
        <!-- Logo -->
        <a href="#" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
            <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-music" style="color: white; font-size: 0.95rem;"></i>
            </div>
            <span style="font-weight: 700; font-size: 1.1rem; color: #000;">LiveON</span>
        </a>

        <!-- Navigation Links -->
        <div style="display: flex; align-items: center; gap: 18px;">
            <a href="{{ route('discover') }}" style="color: #7C5CEE; font-weight: 600; text-decoration: none; font-size: 0.9rem;">Discover</a>
            <a href="{{ route('myevents') }}" style="color: #666; font-weight: 500; text-decoration: none; font-size: 0.9rem;">My Events</a>
            <a href="{{ route('joinhistory') }}" style="color: #666; font-weight: 500; text-decoration: none; font-size: 0.9rem;">Join History</a>
            <a href="{{ route('messages') }}" style="color: #666; font-weight: 500; text-decoration: none; font-size: 0.9rem;">Messages</a>
        </div>

        <!-- Search Bar and Actions -->
        <div style="display: flex; align-items: center; gap: 12px;">
            <form action="{{ route('discover') }}" method="GET" style="position: relative;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search concerts..." style="padding: 9px 36px 9px 14px; border: 1px solid #ddd; border-radius: 20px; width: 220px; font-size: 0.85rem; background: #fafbfc;">
                <button type="submit" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #999; padding: 4px 8px;">
                    <i class="fas fa-search" style="font-size: 0.9rem;"></i>
                </button>
            </form>
            <button type="button" style="background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; border: none; padding: 9px 18px; border-radius: 20px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; font-size: 0.9rem;" data-bs-toggle="modal" data-bs-target="#createPostModal">
                <i class="fas fa-plus" style="font-size: 0.8rem;"></i> Create
            </button>
            @if (Auth::user()->profile_image)
                <a href="{{ route('profile') }}" style="text-decoration: none;">
                    <img src="{{ str_starts_with(Auth::user()->profile_image, 'http') ? Auth::user()->profile_image : asset('storage/' . Auth::user()->profile_image) }}" alt="User" style="width: 36px; height: 36px; border-radius: 50%; cursor: pointer; object-fit: cover;">
                </a>
            @else
                <a href="{{ route('profile') }}" style="text-decoration: none;">
                    <div style="width: 36px; height: 36px; background: #00BCD4; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem;">
                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                    </div>
                </a>
            @endif
        </div>
    </div>
</nav>

<div style="background: #fafbfc; min-height: 100vh; padding: 20px 0;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto;">
        <div style="display: flex; gap: 20px;">
            
            <!-- Left Sidebar - Filters -->
            <div style="flex: 0 0 200px;">
                <div style="background: white; padding: 18px; border-radius: 12px; position: sticky; top: 80px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <h5 style="font-weight: 700; margin-bottom: 16px; color: #1a1a1a; font-size: 0.95rem;">Filters</h5>
                    
                    <form id="filterForm" method="GET" action="{{ route('discover') }}">
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #333; margin-bottom: 8px; font-size: 0.85rem;">Date</label>
                            <select name="date_filter" id="dateFilter" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.85rem; color: #666; background: #fafbfc;" onchange="this.form.submit()">
                                <option value="">Any date</option>
                                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                                <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #333; margin-bottom: 8px; font-size: 0.85rem;">Location</label>
                            <input type="text" name="location_filter" id="locationFilter" value="{{ request('location_filter') }}" placeholder="City or country" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.85rem; color: #666; background: #fafbfc;" oninput="debounceSubmit()">
                            @if(request('location_filter'))
                                <button type="button" onclick="document.getElementById('locationFilter').value=''; document.getElementById('filterForm').submit();" style="margin-top: 6px; padding: 4px 10px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 4px; font-size: 0.75rem; color: #666; cursor: pointer;">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            @endif
                        </div>
                    </form>


                </div>
            </div>

            <!-- Center Content - Concert Posts -->
            <div style="flex: 1;">
                <!-- Header -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <h2 style="font-size: 2rem; font-weight: 700; color: #000; margin: 0;">Concert Posts</h2>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <button type="button" class="btn" style="background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#createPostModal">
                            <i class="fas fa-plus"></i> Create Post
                        </button>
                    </div>
                </div>

                @if ($errors->any())
                    <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Concert Posts -->
                @forelse ($posts as $post)
                    <div style="background: white; border-radius: 10px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <!-- Colored Header with Cover Image -->
                        @php
                            $headerBackground = 'linear-gradient(135deg, #7C5CEE, #FF6B9D)';
                            if ($post->cover_image) {
                                $imageUrl = str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset('storage/' . $post->cover_image);
                                $headerBackground = 'linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url(' . $imageUrl . ')';
                            } elseif ($post->cover_color) {
                                $headerBackground = $post->cover_color;
                            }
                        @endphp
                        <div style="background: {{ $headerBackground }}; background-size: cover; background-position: center; padding: 15px; color: white; display: flex; align-items: center; gap: 15px; min-height: 100px;">
                            <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-music" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h5 style="margin: 0 0 5px 0; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $post->concert_name }}</h5>
                                <p style="margin: 0; font-size: 0.9rem; opacity: 0.9; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">{{ $post->location }} • {{ $post->concert_date->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Content -->
                        <div style="padding: 20px;">
                            <div style="display: flex; gap: 20px;">
                                <!-- Left - Info -->
                                <div style="flex: 1;">
                                    <p style="color: #666; line-height: 1.6; margin-bottom: 15px;">{{ Str::limit($post->description, 200) }}</p>

                                    <div style="display: flex; align-items: center; gap: 20px; font-size: 0.9rem; color: #999;">
                                        <span><i class="fas fa-users"></i> {{ $post->spotsFilledCount() }}/{{ $post->spots_available }} spots filled</span>
                                        <span><i class="fas fa-map-marker-alt"></i> {{ $post->city }}</span>
                                    </div>

                                    <div style="margin-top: 15px;">
                                        <p style="margin: 0; font-size: 0.85rem; color: #999;">
                                            <strong>Posted by:</strong> {{ $post->user->first_name }} {{ $post->user->last_name }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Right - Action -->
                                <div style="flex: 0 0 120px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px;">
                                    @php
                                        $userRequest = $post->requests()->where('user_id', Auth::id())->first();
                                        $isFull = $post->spotsLeftCount() <= 0;
                                    @endphp

                                    @if (!$userRequest && $post->user_id !== Auth::id() && !$isFull)
                                        <form action="{{ route('discover.join', $post) }}" method="POST" style="width: 100%;">
                                            @csrf
                                            <button type="submit" style="width: 100%; padding: 10px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">
                                                <i class="fas fa-plus"></i> Join
                                            </button>
                                        </form>
                                    @elseif (!$userRequest && $post->user_id !== Auth::id() && $isFull)
                                        <button style="width: 100%; padding: 10px; background: #6c757d; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: not-allowed;" disabled>
                                            <i class="fas fa-ban"></i> Full
                                        </button>
                                    @elseif ($userRequest && $userRequest->status === 'pending' && $isFull)
                                        <button style="width: 100%; padding: 10px; background: #6c757d; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: not-allowed;" disabled>
                                            <i class="fas fa-ban"></i> Full
                                        </button>
                                    @elseif ($userRequest && $userRequest->status === 'pending' && !$isFull)
                                        <button style="width: 100%; padding: 10px; background: #ffc107; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: not-allowed;" disabled>
                                            <i class="fas fa-hourglass-half"></i> Pending
                                        </button>
                                    @elseif ($userRequest && $userRequest->status === 'accepted')
                                        <button style="width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: not-allowed;" disabled>
                                            <i class="fas fa-check"></i> Joined
                                        </button>
                                    @elseif ($post->user_id === Auth::id())
                                        <button style="width: 100%; padding: 10px; background: #17a2b8; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: not-allowed;" disabled>
                                            <i class="fas fa-crown"></i> Your Event
                                        </button>
                                    @endif

                                    @if ($post->spotsLeftCount() > 0)
                                        <small style="color: #28a745; font-weight: 600;">{{ $post->spotsLeftCount() }} spot{{ $post->spotsLeftCount() > 1 ? 's' : '' }} left</small>
                                    @else
                                        <small style="color: #dc3545; font-weight: 600;">Full</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="background: white; padding: 60px 20px; border-radius: 10px; text-align: center;">
                        <i class="fas fa-search" style="font-size: 3rem; color: #ccc;"></i>
                        <p style="color: #999; margin-top: 20px;">No concerts found. Try adjusting your filters or create your own post!</p>
                    </div>
                @endforelse

                <!-- Pagination -->
                @if ($posts->hasPages())
                    <div style="margin-top: 30px;">
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

            <!-- Right Sidebar - Upcoming Events -->
            <div style="flex: 0 0 220px;">
                <div style="background: white; padding: 20px; border-radius: 10px; position: sticky; top: 80px;">
                    <h5 style="font-weight: 700; margin-bottom: 20px; color: #000; display: flex; align-items: center; gap: 10px;">
                        <span style="background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.8rem;">Upcoming</span>
                    </h5>

                    <!-- Sample upcoming events -->
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="padding-bottom: 15px; border-bottom: 1px solid #f0f0f0;">
                            <p style="margin: 0 0 5px 0; font-weight: 600; color: #000; font-size: 0.9rem;">BB Rising</p>
                            <p style="margin: 0; font-size: 0.8rem; color: #999;"><i class="fas fa-music"></i> Dec 18 • GBK Arena</p>
                        </div>

                        <div style="padding-bottom: 15px; border-bottom: 1px solid #f0f0f0;">
                            <p style="margin: 0 0 5px 0; font-weight: 600; color: #000; font-size: 0.9rem;">Coachella 2025</p>
                            <p style="margin: 0; font-size: 0.8rem; color: #999;"><i class="fas fa-music"></i> Apr 12-14 • TBA</p>
                        </div>

                        <div>
                            <p style="margin: 0 0 5px 0; font-weight: 600; color: #000; font-size: 0.9rem;">Summer Fest</p>
                            <p style="margin: 0; font-size: 0.8rem; color: #999;"><i class="fas fa-music"></i> Jun 20-22 • City Park</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Post Modal -->
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: none; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <form action="{{ route('discover.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="padding: 40px;">
                    <!-- Title Section -->
                    <div style="margin-bottom: 30px;">
                        <h2 style="font-weight: 700; color: #1a1a1a; font-size: 1.8rem; margin-bottom: 8px;">Create a New Post</h2>
                        <p style="color: #999; font-size: 0.95rem;">Share your concert plans and find companions</p>
                    </div>

                    <!-- Which concert are you going to? -->
                    <div style="margin-bottom: 24px;">
                        <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">Which concert are you going to? *</label>
                        <div style="position: relative;">
                            <input type="text" name="concert_name" id="concert_name" placeholder="Search concerts, artists (e.g., Arctic Monkeys, Mariah Carey)" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem;" required>
                            <i class="fas fa-search" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #ccc;"></i>
                        </div>
                    </div>

                    <!-- Date and Time Row -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                        <div>
                            <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">Date *</label>
                            <input type="date" name="concert_date" id="concert_date" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem;" required>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">Time *</label>
                            <input type="time" name="concert_time" id="concert_time" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem;" required>
                        </div>
                    </div>

                    <!-- Venue and City Row -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                        <div>
                            <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">Venue *</label>
                            <div style="position: relative;">
                                <input type="text" name="location" id="location" placeholder="e.g., ICE BSD, Gelora Bung Karno Stadium" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem;" required>
                                <i class="fas fa-map-marker-alt" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #ccc;"></i>
                            </div>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">City, Region *</label>
                            <div style="position: relative;">
                                <input type="text" name="city" id="city" placeholder="e.g., Jakarta, Indonesia" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem;" required>
                                <i class="fas fa-map-marker-alt" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #ccc;"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Looking For Section -->
                    <div style="background-color: #f5f3ff; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                        <p style="font-weight: 600; color: #1a1a1a; margin-bottom: 16px;">Looking For</p>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 16px;">Number of spots available</p>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <button type="button" style="width: 36px; height: 36px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer; font-size: 1.2rem; color: #999;" onclick="document.getElementById('spots_available').value = Math.max(1, parseInt(document.getElementById('spots_available').value) - 1);">−</button>
                            <input type="number" name="spots_available" id="spots_available" value="1" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; text-align: center; width: 60px; font-size: 0.95rem;" min="1" required>
                            <button type="button" style="width: 36px; height: 36px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer; font-size: 1.2rem; color: #999;" onclick="document.getElementById('spots_available').value = parseInt(document.getElementById('spots_available').value) + 1;">+</button>
                        </div>
                    </div>

                    <!-- Tell others about your plan -->
                    <div style="margin-bottom: 24px;">
                        <label style="font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 10px;">Tell others about your plan *</label>
                        <textarea name="description" id="description" placeholder="Looking for someone to watch Keshi together!" class="form-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 0.95rem; min-height: 120px; resize: vertical;" required></textarea>
                        <div style="text-align: right; margin-top: 8px; color: #999; font-size: 0.85rem;">
                            <span id="charCount">0</span> / 500
                        </div>
                    </div>

                    <!-- Cover Image Section -->
                    <div style="margin-bottom: 24px;">
                        <p style="font-weight: 600; color: #1a1a1a; margin-bottom: 16px;">Cover Image</p>
                        
                        <!-- Image Preview -->
                        <div id="coverImagePreviewContainer" style="display: none; margin-bottom: 16px; position: relative;">
                            <img id="coverImagePreview" src="" alt="Preview" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                            <button type="button" onclick="clearCoverImage()" style="position: absolute; top: 8px; right: 8px; width: 28px; height: 28px; background: rgba(0,0,0,0.6); color: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-times" style="font-size: 0.8rem;"></i>
                            </button>
                        </div>
                        
                        <div id="colorPresets" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 16px;">
                            <div class="color-preset" data-color="linear-gradient(135deg, #D75BA8, #9D4EDD)" style="width: 100%; height: 60px; background: linear-gradient(135deg, #D75BA8, #9D4EDD); border-radius: 8px; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;" onclick="setColorImage(this)" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"></div>
                            <div class="color-preset" data-color="linear-gradient(135deg, #00D9FF, #0081CF)" style="width: 100%; height: 60px; background: linear-gradient(135deg, #00D9FF, #0081CF); border-radius: 8px; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;" onclick="setColorImage(this)" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"></div>
                            <div class="color-preset" data-color="linear-gradient(135deg, #FF6B9D, #FF9975)" style="width: 100%; height: 60px; background: linear-gradient(135deg, #FF6B9D, #FF9975); border-radius: 8px; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;" onclick="setColorImage(this)" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"></div>
                            <div class="color-preset" data-color="linear-gradient(135deg, #7C5CEE, #5A3FBD)" style="width: 100%; height: 60px; background: linear-gradient(135deg, #7C5CEE, #5A3FBD); border-radius: 8px; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;" onclick="setColorImage(this)" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"></div>
                        </div>
                        <input type="hidden" id="selectedColor" name="cover_color" value="">
                        <button type="button" style="width: 100%; padding: 12px 16px; border: 2px dashed #ddd; background: white; border-radius: 8px; cursor: pointer; font-weight: 600; color: #666; display: flex; align-items: center; gap: 8px; justify-content: center; font-size: 0.95rem;" onclick="document.getElementById('cover_image').click();">
                            <i class="fas fa-upload"></i> Upload Custom Image
                        </button>
                        <input type="file" name="cover_image" id="cover_image" accept="image/*" style="display: none;" onchange="handleCoverImageSelect(this)">
                    </div>

                    <!-- Buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <button type="button" class="btn" style="padding: 12px 24px; border: 1px solid #ddd; background: white; color: #666; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" style="padding: 12px 24px; background: linear-gradient(135deg, #7C5CEE, #9D4EDD); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; gap: 8px; justify-content: center;">
                            <i class="fas fa-music"></i> Post Event
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Character counter for description
document.getElementById('description').addEventListener('input', function() {
    document.getElementById('charCount').textContent = this.value.length;
});

// Color selection function with visual feedback
function setColorImage(element) {
    // Remove border from all presets
    document.querySelectorAll('.color-preset').forEach(preset => {
        preset.style.borderColor = 'transparent';
    });
    
    // Add border to selected preset
    element.style.borderColor = '#333';
    
    // Set the hidden input value
    document.getElementById('selectedColor').value = element.getAttribute('data-color');
    
    // Clear file input when selecting a color preset
    document.getElementById('cover_image').value = '';
    document.getElementById('coverImagePreviewContainer').style.display = 'none';
}

// Handle cover image selection and preview
function handleCoverImageSelect(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('coverImagePreview').src = e.target.result;
            document.getElementById('coverImagePreviewContainer').style.display = 'block';
            
            // Clear color selection when uploading an image
            document.querySelectorAll('.color-preset').forEach(preset => {
                preset.style.borderColor = 'transparent';
            });
            document.getElementById('selectedColor').value = '';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Clear cover image
function clearCoverImage() {
    document.getElementById('cover_image').value = '';
    document.getElementById('coverImagePreviewContainer').style.display = 'none';
    document.getElementById('coverImagePreview').src = '';
}

// Debounce function for location filter
let debounceTimer;
function debounceSubmit() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(function() {
        document.getElementById('filterForm').submit();
    }, 500);
}
</script>

@endsection
