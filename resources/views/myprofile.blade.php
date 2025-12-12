@extends('layouts.app')

@section('title', 'My Profile - LiveOn')

@section('content')

<div style="padding: 32px 30px; max-width: 1200px; margin: 0 auto; background: #fafbfc; min-height: 100vh; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;">
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

    <!-- Profile Header with Cover -->
    <div style="background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 12px; padding: 32px; margin-bottom: 24px; position: relative; min-height: 200px; display: flex; align-items: flex-end;">
        @if ($user->cover_image)
            <img src="{{ str_starts_with($user->cover_image, 'http') ? $user->cover_image : asset('storage/' . $user->cover_image) }}" alt="Cover" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
        @endif
        
        <div style="position: relative; z-index: 1; display: flex; align-items: flex-end; gap: 20px; width: 100%;">
            <!-- Profile Picture -->
            <div style="position: relative;">
                @if ($user->profile_image)
                    <img src="{{ str_starts_with($user->profile_image, 'http') ? $user->profile_image : asset('storage/' . $user->profile_image) }}" alt="Profile" style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid white; object-fit: cover;">
                @else
                    <div style="width: 120px; height: 120px; background: white; border-radius: 50%; border: 4px solid white; display: flex; align-items: center; justify-content: center; color: #7C5CEE; font-weight: 700; font-size: 2.5rem;">
                        {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                    </div>
                @endif
                <button type="button" style="position: absolute; bottom: 0; right: 0; background: #7C5CEE; color: white; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; border: 3px solid white;" data-bs-toggle="modal" data-bs-target="#editProfileModal" title="Change Profile Picture">
                    <i class="fas fa-camera" style="font-size: 0.85rem;"></i>
                </button>
            </div>

            <!-- Name and Info -->
            <div style="color: white; flex: 1;">
                <h2 style="margin: 0 0 8px 0; font-size: 1.8rem; font-weight: 700;">{{ $user->name }}</h2>
                @if($user->location)
                <p style="margin: 0 0 8px 0; font-size: 0.9rem; opacity: 0.95;">
                    <i class="fas fa-map-marker-alt" style="margin-right: 6px;"></i>
                    {{ $user->location }}
                </p>
                @endif
                <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">
                    <i class="fas fa-calendar" style="margin-right: 6px;"></i>Joined {{ $user->created_at->format('M Y') }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 12px;">
                <button type="button" style="background: white; color: #7C5CEE; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" onclick="return confirm('Are you sure you want to logout?')" style="background: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
        <!-- Bio Card -->
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f0f0f0;">
            <h5 style="font-weight: 700; color: #1a1a1a; margin-bottom: 12px; font-size: 0.95rem;">
                <i class="fas fa-quote-left" style="color: #7C5CEE; margin-right: 8px;"></i>Bio
            </h5>
            <p style="color: #666; font-size: 0.9rem; line-height: 1.6; margin: 0;">
                {{ $user->bio ?? 'No bio added yet. Click edit to add one!' }}
            </p>
        </div>

        <!-- Info Card -->
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f0f0f0;">
            <h5 style="font-weight: 700; color: #1a1a1a; margin-bottom: 12px; font-size: 0.95rem;">
                <i class="fas fa-user-circle" style="color: #7C5CEE; margin-right: 8px;"></i>Personal Info
            </h5>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div>
                    <p style="color: #999; font-size: 0.8rem; margin: 0 0 4px 0;">Email</p>
                    <p style="color: #1a1a1a; font-size: 0.9rem; margin: 0;">{{ $user->email }}</p>
                </div>
                <div>
                    <p style="color: #999; font-size: 0.8rem; margin: 0 0 4px 0;">Age</p>
                    <p style="color: #1a1a1a; font-size: 0.9rem; margin: 0;">{{ $user->age ?? 'Not specified' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f0f0f0;">
        <h5 style="font-weight: 700; color: #1a1a1a; margin-bottom: 16px; font-size: 0.95rem;">
            <i class="fas fa-history" style="color: #7C5CEE; margin-right: 8px;"></i>Recent Concert Activity
        </h5>
        @forelse ($recentActivity as $activity)
            <div style="display: flex; align-items: center; gap: 16px; padding: 12px; border-radius: 8px; margin-bottom: 12px; border-left: 4px solid #7C5CEE; background: #fafbfc;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-music" style="color: white; font-size: 1.2rem;"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <h6 style="margin: 0 0 4px 0; font-weight: 600; color: #1a1a1a; font-size: 0.9rem;">{{ $activity->concert_name }}</h6>
                    <p style="margin: 0; color: #999; font-size: 0.8rem;">{{ $activity->concert_date->format('M d, Y') }}</p>
                </div>
                <span style="background: #e8f5e9; color: #2e7d32; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Posted</span>
            </div>
        @empty
            <p style="color: #999; font-size: 0.9rem; text-align: center; padding: 20px;">No recent activity. Start posting concerts to share your events!</p>
        @endforelse
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="margin-top: 40px;">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
            <div style="padding: 24px; background: linear-gradient(135deg, #FF6B9D, #FF8AB8); display: flex; align-items: center; justify-content: space-between; border-radius: 12px 12px 0 0;">
                <h5 style="margin: 0; font-weight: 700; color: white; font-size: 1.2rem;">
                    Edit Profile
                </h5>
                <button type="button" style="background: none; border: none; color: white; cursor: pointer; font-size: 1.8rem; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">×</button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="padding: 24px;">
                    <div style="margin-bottom: 18px;">
                        <label style="display: block; color: #7C5CEE; font-weight: 600; font-size: 0.85rem; margin-bottom: 8px;">Name</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; font-family: inherit;" />
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; color: #7C5CEE; font-weight: 600; font-size: 0.85rem; margin-bottom: 8px;">Bio</label>
                        <textarea name="bio" id="bio" rows="4" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; font-family: inherit; resize: vertical;">{{ $user->bio }}</textarea>
                        <small style="color: #999; display: block; margin-top: 6px;">Max 500 characters</small>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                        <div>
                            <label style="display: block; color: #7C5CEE; font-weight: 600; font-size: 0.85rem; margin-bottom: 8px;">Location</label>
                            <input type="text" name="location" id="location" value="{{ $user->location }}" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; font-family: inherit;" />
                        </div>
                        <div>
                            <label style="display: block; color: #7C5CEE; font-weight: 600; font-size: 0.85rem; margin-bottom: 8px;">Age</label>
                            <input type="number" name="age" id="age" value="{{ $user->age }}" min="1" max="150" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; font-family: inherit;" />
                        </div>
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; color: #7C5CEE; font-weight: 600; font-size: 0.85rem; margin-bottom: 8px;">Profile Picture</label>
                        <input type="file" name="profile_image" id="profile_image" accept="image/*" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem;" />
                        <small style="color: #999; display: block; margin-top: 6px;">Max 2MB</small>
                    </div>
                </div>
                <div style="padding: 16px 24px; border-top: 1px solid #f0f0f0; display: flex; gap: 12px; justify-content: flex-end; background: #fafbfc;">
                    <button type="button" style="background: white; color: #7C5CEE; border: 2px solid #7C5CEE; padding: 10px 24px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.9rem; transition: all 0.2s;" data-bs-dismiss="modal" onmouseover="this.style.backgroundColor='#f5f3ff';" onmouseout="this.style.backgroundColor='white';">Cancel</button>
                    <button type="submit" style="background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; border: none; padding: 10px 24px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(124,92,238,0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Cover Modal -->
<div class="modal fade" id="editCoverModal" tabindex="-1" aria-labelledby="editCoverLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 40px;">
        <div class="modal-content" style="border-radius: 12px; border: 1px solid #f0f0f0; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
            <div style="padding: 20px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between;">
                <h5 style="margin: 0; font-weight: 700; color: #1a1a1a; font-size: 1.1rem;">
                    <i class="fas fa-image" style="color: #7C5CEE; margin-right: 8px;"></i>Edit Cover Image
                </h5>
                <button type="button" style="background: none; border: none; color: #999; cursor: pointer; font-size: 1.5rem;" data-bs-dismiss="modal" aria-label="Close">×</button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="padding: 20px;">
                    <div>
                        <label style="display: block; color: #7C5CEE; font-weight: 600; font-size: 0.85rem; margin-bottom: 6px;">Cover Image</label>
                        <input type="file" name="cover_image" id="cover_image" accept="image/*" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem;" />
                        <small style="color: #999; display: block; margin-top: 4px;">Max 2MB. JPG, PNG, GIF accepted</small>
                    </div>
                </div>
                <div style="padding: 16px 20px; border-top: 1px solid #f0f0f0; display: flex; gap: 12px; justify-content: flex-end;">
                    <button type="button" style="background: #f5f5f5; color: #1a1a1a; border: 1px solid #ddd; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.9rem;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" style="background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.9rem;">
                        <i class="fas fa-save"></i> Save Cover
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection




