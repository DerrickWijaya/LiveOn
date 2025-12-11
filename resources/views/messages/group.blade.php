@extends('layouts.app')

@section('title', $post->concert_name . ' - Messages')

@section('content')

<div style="display: flex; height: calc(100vh - 80px); background: #f5f5f5; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;">
    <!-- Left Sidebar - Members -->
    <div style="width: 300px; background: #fafbfc; border-right: 1px solid #eee; display: flex; flex-direction: column; overflow: hidden;">
        <!-- Members Header -->
        <div style="padding: 16px 18px; border-bottom: 1px solid #eee;">
            <p style="font-weight: 700; color: #1a1a1a; margin: 0; font-size: 0.95rem;">
                <i class="fas fa-users" style="margin-right: 8px; font-size: 0.9rem;"></i> {{ count($members) + 1 }} Members
            </p>
        </div>

        <!-- Members List -->
        <div style="flex: 1; overflow-y: auto; padding: 10px;">
            <!-- Post Creator -->
            @if ($post->user_id !== Auth::id())
                <a href="{{ route('messages.direct', $post->user->id) }}" style="text-decoration: none; display: flex;">
                    <div style="padding: 10px; border-radius: 8px; margin-bottom: 6px; background: white; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.2s ease; border: 1px solid #f0f0f0; width: 100%;" onmouseover="this.style.backgroundColor='#f5f5f5'; this.style.borderColor='#ddd';" onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#f0f0f0';">
                        @if ($post->user->profile_image)
                            <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div style="width: 36px; height: 36px; background: #7C5CEE; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; flex-shrink: 0; font-size: 0.85rem;">
                                {{ strtoupper(substr($post->user->first_name, 0, 1)) }}
                            </div>
                        @endif
                        <div style="flex: 1; min-width: 0;">
                            <p style="font-weight: 600; color: #1a1a1a; margin: 0; font-size: 0.8rem;">{{ $post->user->first_name }}</p>
                            <span style="display: inline-block; background: #7C5CEE; color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.7rem; font-weight: 600; margin-top: 4px;">Organizer</span>
                        </div>
                    </div>
                </a>
            @else
                <div style="padding: 10px; border-radius: 8px; margin-bottom: 6px; background: white; display: flex; align-items: center; gap: 10px; border: 1px solid #f0f0f0;">
                    @if ($post->user->profile_image)
                        <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                    @else
                        <div style="width: 36px; height: 36px; background: #7C5CEE; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; flex-shrink: 0; font-size: 0.85rem;">
                            {{ strtoupper(substr($post->user->first_name, 0, 1)) }}
                        </div>
                    @endif
                    <div style="flex: 1; min-width: 0;">
                        <p style="font-weight: 600; color: #1a1a1a; margin: 0; font-size: 0.8rem;">{{ $post->user->first_name }}</p>
                        <div style="display: flex; gap: 6px; margin-top: 4px;">
                            <span style="display: inline-block; background: #7C5CEE; color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.7rem; font-weight: 600;">Organizer</span>
                            <span style="display: inline-block; color: #999; font-size: 0.7rem; font-weight: 600; padding: 2px 0;">You</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Accepted Members -->
            @foreach ($members as $member)
                @if ($member->id !== Auth::id())
                    <a href="{{ route('messages.direct', $member->id) }}" style="text-decoration: none; display: flex;">
                        <div style="padding: 10px; border-radius: 8px; margin-bottom: 6px; background: white; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.2s ease; border: 1px solid #f0f0f0; width: 100%;" onmouseover="this.style.backgroundColor='#f5f5f5'; this.style.borderColor='#ddd';" onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#f0f0f0';">
                            @if ($member->profile_image)
                                <img src="{{ asset('storage/' . $member->profile_image) }}" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                            @else
                                <div style="width: 36px; height: 36px; background: #00BCD4; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; flex-shrink: 0; font-size: 0.85rem;">
                                    {{ strtoupper(substr($member->first_name, 0, 1)) }}
                                </div>
                            @endif
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 600; color: #1a1a1a; margin: 0; font-size: 0.8rem;">{{ $member->first_name }}</p>
                            </div>
                        </div>
                    </a>
                @else
                    <div style="padding: 10px; border-radius: 8px; margin-bottom: 6px; background: white; display: flex; align-items: center; gap: 10px; border: 1px solid #f0f0f0; width: 100%;">
                        @if ($member->profile_image)
                            <img src="{{ asset('storage/' . $member->profile_image) }}" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div style="width: 36px; height: 36px; background: #00BCD4; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; flex-shrink: 0; font-size: 0.85rem;">
                                {{ strtoupper(substr($member->first_name, 0, 1)) }}
                            </div>
                        @endif
                        <div style="flex: 1; min-width: 0;">
                            <p style="font-weight: 600; color: #1a1a1a; margin: 0; font-size: 0.8rem;">{{ $member->first_name }}</p>
                            <p style="color: #999; font-size: 0.75rem; margin: 4px 0 0 0;">You</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Right Side - Chat Area -->
    <div style="flex: 1; display: flex; flex-direction: column; overflow: hidden;">
        <!-- Header -->
        <div style="background: white; padding: 16px 20px; border-bottom: 1px solid #eee;">
            <h3 style="font-weight: 700; color: #1a1a1a; margin: 0 0 6px 0; font-size: 1.05rem;">
                <i class="fas fa-music" style="margin-right: 8px; color: #7C5CEE;"></i> {{ $post->concert_name }}
            </h3>
            <p style="color: #999; font-size: 0.85rem; margin: 0;">
                <i class="fas fa-calendar-alt" style="color: #7C5CEE; margin-right: 6px;"></i> {{ $post->concert_date->format('M d, Y') }} • {{ $post->concert_time->format('H:i') }}
            </p>
        </div>

        <!-- Messages Container -->
        <div style="flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column;">
            @forelse ($messages as $message)
                @php
                    $isOwn = $message->sender_id === Auth::id();
                @endphp

                <!-- Date Separator -->
                @if (isset($previousDate) && $previousDate !== $message->created_at->format('Y-m-d'))
                    <div style="text-align: center; margin: 20px 0 10px 0;">
                        <span style="background: #e0e0e0; color: #666; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem;">{{ $message->created_at->format('M d, Y') }}</span>
                    </div>
                @endif

                <!-- Message Group -->
                <div style="display: flex; {{ $isOwn ? 'justify-content: flex-end;' : 'justify-content: flex-start;' }} margin-bottom: 12px;">
                    <div style="display: flex; gap: 10px; max-width: 70%; {{ $isOwn ? 'flex-direction: row-reverse;' : '' }}">
                        <!-- Avatar -->
                        @if ($message->sender->profile_image)
                            <img src="{{ asset('storage/' . $message->sender->profile_image) }}" alt="Profile" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                        @else
                            <div style="width: 28px; height: 28px; {{ $isOwn ? 'background: #7C5CEE;' : 'background: #00BCD4;' }} color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.8rem; flex-shrink: 0;">
                                {{ strtoupper(substr($message->sender->first_name, 0, 1)) }}
                            </div>
                        @endif

                        <!-- Message Bubble with Info -->
                        <div>
                            <!-- Name (always show for first message or different sender) -->
                            @if (!isset($previousSender) || $previousSender !== $message->sender_id)
                                <div style="margin-bottom: 4px;">
                                    <span style="font-weight: 600; color: #1a1a1a; font-size: 0.8rem;">{{ $message->sender->first_name }}</span>
                                </div>
                            @endif

                            <!-- Message Content -->
                            <div>
                                @if ($message->image_path)
                                    <img src="{{ asset('storage/' . $message->image_path) }}" alt="Image" style="max-width: 300px; max-height: 300px; border-radius: 10px; margin-bottom: 6px; display: block; object-fit: cover;">
                                @endif
                                
                                @if ($message->message)
                                    <div style="background: {{ $isOwn ? 'linear-gradient(135deg, #7C5CEE, #9D4EDD)' : '#ffffff' }}; color: {{ $isOwn ? '#ffffff' : '#1a1a1a' }}; padding: 10px 14px; border-radius: 10px; word-break: break-word; box-shadow: 0 2px 4px rgba(0,0,0,0.08); font-size: 0.9rem; {{ $message->image_path ? 'margin-top: 6px;' : '' }}">
                                        {{ $message->message }}
                                    </div>
                                @endif
                                
                                <!-- Always show timestamp for this specific message -->
                                <span style="color: #999; font-size: 0.7rem; display: block; margin-top: 4px; {{ $isOwn ? 'text-align: right;' : '' }}">
                                    {{ $message->created_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $previousSender = $message->sender_id;
                    $previousDate = $message->created_at->format('Y-m-d');
                @endphp
            @empty
                <div style="text-align: center; padding: 40px 20px; color: #999;">
                    <i class="fas fa-comments" style="font-size: 2.5rem; color: #ddd; margin-bottom: 12px; display: block;"></i>
                    <p style="font-size: 0.9rem;">No messages yet. Start the conversation!</p>
                </div>
            @endforelse

            <!-- Spacer -->
            <div style="flex: 1;"></div>
        </div>

        <!-- Message Input -->
        <form id="messageForm{{ $post->id }}" action="{{ route('messages.group.send', $post) }}" method="POST" enctype="multipart/form-data" style="background: white; padding: 12px 16px; border-top: 1px solid #eee;">
            @csrf
            <!-- Image Preview -->
            <div id="imagePreviewContainer{{ $post->id }}" style="display: none; padding: 10px; background: #f5f5f5; border-radius: 8px; margin-bottom: 10px; position: relative;">
                <img id="imagePreview{{ $post->id }}" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 8px; display: block;">
                <button type="button" onclick="clearImagePreview{{ $post->id }}()" style="position: absolute; top: 5px; right: 5px; width: 24px; height: 24px; background: rgba(0,0,0,0.6); color: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times" style="font-size: 0.8rem;"></i>
                </button>
            </div>
            
            <div style="display: flex; gap: 10px; align-items: flex-end;">
                <button type="button" onclick="document.getElementById('imageInput{{ $post->id }}').click();" style="width: 36px; height: 36px; background: white; border: 1px solid #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #7C5CEE; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f5f5f5';" onmouseout="this.style.backgroundColor='white';">
                    <i class="fas fa-image" style="font-size: 1rem;"></i>
                </button>
                <input type="file" name="image" id="imageInput{{ $post->id }}" accept="image/*" style="display: none;" onchange="handleImageSelect{{ $post->id }}(this)">
                
                <input type="text" name="message" id="messageInput{{ $post->id }}" placeholder="Type a message..." style="flex: 1; padding: 9px 14px; border: 1px solid #ddd; border-radius: 20px; font-size: 0.9rem; outline: none; transition: all 0.2s ease;" onfocus="this.style.borderColor='#7C5CEE';" onblur="this.style.borderColor='#ddd';">
                
                <button type="submit" style="width: 36px; height: 36px; background: linear-gradient(135deg, #7C5CEE, #9D4EDD); color: white; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                    <i class="fas fa-paper-plane" style="font-size: 0.95rem;"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Handle image selection and preview for post {{ $post->id }}
function handleImageSelect{{ $post->id }}(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview{{ $post->id }}').src = e.target.result;
            document.getElementById('imagePreviewContainer{{ $post->id }}').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Clear image preview
function clearImagePreview{{ $post->id }}() {
    document.getElementById('imageInput{{ $post->id }}').value = '';
    document.getElementById('imagePreviewContainer{{ $post->id }}').style.display = 'none';
    document.getElementById('imagePreview{{ $post->id }}').src = '';
}

// Form validation removed - backend handles validation

// Auto-scroll to bottom on page load
window.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.querySelector('[style*="flex: 1; overflow-y: auto"]');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});
</script>

@endsection
