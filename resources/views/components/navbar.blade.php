@if (Auth::check() && !request()->routeIs('discover', 'home', 'login', 'register'))
<nav style="background-color: #ffffff; box-shadow: 0 2px 15px rgba(0,0,0,0.08); padding: 15px 30px; position: sticky; top: 0; z-index: 1020;">
    <div style="max-width: 1400px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between;">
        <!-- Logo -->
        <a href="{{ route('discover') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #7C5CEE, #FF6B9D); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-music" style="color: white; font-size: 1rem;"></i>
            </div>
            <span style="font-weight: 700; font-size: 1.2rem; color: #000;">LiveON</span>
        </a>

        <!-- Navigation Links -->
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="{{ route('discover') }}" style="color: {{ request()->routeIs('discover') ? '#7C5CEE' : '#666' }}; font-weight: {{ request()->routeIs('discover') ? '600' : '500' }}; text-decoration: none; font-size: 0.95rem;">Discover</a>
            <a href="{{ route('myevents') }}" style="color: {{ request()->routeIs('myevents') ? '#7C5CEE' : '#666' }}; font-weight: {{ request()->routeIs('myevents') ? '600' : '500' }}; text-decoration: none; font-size: 0.95rem;">My Events</a>
            <a href="{{ route('joinhistory') }}" style="color: {{ request()->routeIs('joinhistory') ? '#7C5CEE' : '#666' }}; font-weight: {{ request()->routeIs('joinhistory') ? '600' : '500' }}; text-decoration: none; font-size: 0.95rem;">Join History</a>
            <a href="{{ route('messages') }}" style="color: {{ request()->routeIs('messages*') ? '#7C5CEE' : '#666' }}; font-weight: {{ request()->routeIs('messages*') ? '600' : '500' }}; text-decoration: none; font-size: 0.95rem;">Messages</a>
        </div>

        <!-- Actions -->
        <div style="display: flex; align-items: center; gap: 15px;">
            <button type="button" style="background: linear-gradient(135deg, #7C5CEE, #FF6B9D); color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;" data-bs-toggle="modal" data-bs-target="#createPostModal">
                <i class="fas fa-plus"></i> Create Post
            </button>
            @if (Auth::user()->profile_image)
                <a href="{{ route('profile') }}" style="text-decoration: none;">
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="User" style="width: 40px; height: 40px; border-radius: 50%; cursor: pointer; object-fit: cover;">
                </a>
            @else
                <a href="{{ route('profile') }}" style="text-decoration: none;">
                    <div style="width: 40px; height: 40px; background: #00BCD4; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem;">
                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                    </div>
                </a>
            @endif
        </div>
    </div>
</nav>
@endif
