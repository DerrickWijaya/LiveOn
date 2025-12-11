@extends('layouts.app')

@section('title', 'Direct Message - LiveOn')

@section('content')

<div style="display: flex; height: calc(100vh - 80px); background: #fafbfc;">

    {{-- LEFT SIDEBAR (LIST CHAT) --}}
    @include('messages.sidebar')

    {{-- RIGHT CHAT AREA --}}
    <div style="flex: 1; display: flex; flex-direction: column;">

        {{-- HEADER --}}
        <div style="padding: 16px; border-bottom: 1px solid #eee; background: white;">
            <div style="display: flex; align-items: center; gap: 12px;">
                @if ($otherUser->profile_image)
                    <img src="{{ asset('storage/' . $otherUser->profile_image) }}"
                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                @else
                    <div style="width: 40px; height: 40px; background: #00BCD4; color: white;
                                border-radius: 50%; display: flex; align-items: center;
                                justify-content: center; font-weight: 600;">
                        {{ strtoupper(substr($otherUser->first_name, 0, 1)) }}
                    </div>
                @endif

                <div>
                    <p style="margin: 0; font-weight: 700; font-size: 0.95rem;">
                        {{ $otherUser->first_name }} {{ $otherUser->last_name }}
                    </p>
                    <span style="font-size: 0.75rem; color: #999;">Direct Chat</span>
                </div>
            </div>
        </div>

        {{-- MESSAGE LIST --}}
        <div id="chat-box" style="flex: 1; overflow-y: auto; padding: 20px;">

            @foreach ($messages as $msg)
                @php
                    $isMe = $msg->sender_id == auth()->id();
                @endphp

                <div style="text-align: {{ $isMe ? 'right' : 'left' }}; margin-bottom: 14px;">

                    <div style="
                        display: inline-block;
                        background: {{ $isMe ? '#4CAF50' : 'white' }};
                        color: {{ $isMe ? 'white' : 'black' }};
                        border: {{ $isMe ? 'none' : '1px solid #eee' }};
                        padding: 10px 14px;
                        border-radius: 12px;
                        max-width: 60%;
                        text-align: left;
                    ">

                        {{-- SHOW TEXT MESSAGE --}}
                        @if ($msg->message)
                            <div style="font-size: 0.85rem;">
                                {{ $msg->message }}
                            </div>
                        @endif

                        {{-- SHOW IMAGE MESSAGE --}}
                        @if ($msg->image_path)
                            <div style="margin-top: 6px;">
                                <img src="{{ asset('storage/' . $msg->image_path) }}"
                                     style="max-width: 100%; border-radius: 10px;">
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach

        </div>

        {{-- SEND BAR --}}
        <form action="{{ route('messages.direct.send', $otherUser->id) }}"
              method="POST" enctype="multipart/form-data" id="directMessageForm"
              style="padding: 16px; background: white; border-top: 1px solid #eee;">
            @csrf

            <!-- Image Preview -->
            <div id="imagePreviewDirect" style="display: none; padding: 10px; background: #f5f5f5; border-radius: 8px; margin-bottom: 10px; position: relative;">
                <img id="imagePreviewImgDirect" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 8px; display: block;">
                <button type="button" onclick="clearImageDirect()" style="position: absolute; top: 5px; right: 5px; width: 24px; height: 24px; background: rgba(0,0,0,0.6); color: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times" style="font-size: 0.8rem;"></i>
                </button>
            </div>

            <div style="display: flex; gap: 10px; align-items: center;">

                {{-- IMAGE BUTTON --}}
                <button type="button" onclick="document.getElementById('directImageInput').click();" style="width: 36px; height: 36px; background: white; border: 1px solid #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #4CAF50; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f5f5f5';" onmouseout="this.style.backgroundColor='white';">
                    <i class="fas fa-image" style="font-size: 1rem;"></i>
                </button>
                <input type="file" name="image" id="directImageInput" accept="image/*" style="display: none;" onchange="handleImageDirect(this)">

                {{-- TEXT INPUT --}}
                <input
                    type="text"
                    name="message"
                    id="directMessageInput"
                    placeholder="Type your message..."
                    style="
                        flex: 1;
                        padding: 10px 14px;
                        border-radius: 20px;
                        border: 1px solid #ddd;
                        font-size: 0.9rem;
                        outline: none;
                    "
                    onfocus="this.style.borderColor='#4CAF50';"
                    onblur="this.style.borderColor='#ddd';"
                >

                <button type="submit" style="
                    width: 36px;
                    height: 36px;
                    background: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 50%;
                    cursor: pointer;
                    font-weight: 600;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: all 0.2s ease;
                " onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                    <i class="fas fa-paper-plane" style="font-size: 0.95rem;"></i>
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    // auto scroll to bottom
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;

    // Handle image selection and preview for direct messages
    function handleImageDirect(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreviewImgDirect').src = e.target.result;
                document.getElementById('imagePreviewDirect').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Clear image preview for direct messages
    function clearImageDirect() {
        document.getElementById('directImageInput').value = '';
        document.getElementById('imagePreviewDirect').style.display = 'none';
        document.getElementById('imagePreviewImgDirect').src = '';
    }
</script>

@endsection
