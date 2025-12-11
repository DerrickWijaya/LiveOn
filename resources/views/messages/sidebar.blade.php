<div style="width: 320px; background: white; border-right: 1px solid #eee; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">

    {{-- HEADER --}}
    <div style="padding: 16px 18px; border-bottom: 1px solid #eee;">
        <p style="font-weight: 700; color: #1a1a1a; margin: 0; font-size: 0.95rem;">
            <i class="fas fa-comments" style="margin-right: 8px; font-size: 0.9rem;"></i> Messages
        </p>
    </div>

    {{-- MESSAGES LIST --}}
    <div style="flex: 1; overflow-y: auto; padding: 10px;">

        {{-- DIRECT MESSAGES --}}
        @if ($directMessages->isNotEmpty())
            <div style="margin-bottom: 16px;">
                <p style="font-size: 0.75rem; color: #999; font-weight: 600; text-transform: uppercase; margin: 0 0 8px 12px;">
                    Direct Messages
                </p>

                @foreach ($directMessages as $otherUser)
                    <a href="{{ route('messages.direct', $otherUser) }}" style="text-decoration: none;">
                        <div style="
                            padding: 12px;
                            border-radius: 10px;
                            margin-bottom: 6px;
                            background: white;
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            cursor: pointer;
                            transition: all 0.2s ease;
                            border: 1px solid #f0f0f0;
                        "
                        onmouseover="this.style.backgroundColor='#f5f5f5'; this.style.borderColor='#ddd';"
                        onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#f0f0f0';"
                        >

                            {{-- PROFILE IMAGE --}}
                            @if ($otherUser->profile_image)
                                <img src="{{ asset('storage/' . $otherUser->profile_image) }}"
                                     style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                            @else
                                <div style="
                                    width: 36px;
                                    height: 36px;
                                    background: #00BCD4;
                                    color: white;
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-weight: 600;
                                    font-size: 0.85rem;
                                ">
                                    {{ strtoupper(substr($otherUser->first_name, 0, 1)) }}
                                </div>
                            @endif

                            {{-- USER NAME --}}
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 600; color: #1a1a1a; margin: 0; font-size: 0.85rem;">
                                    {{ $otherUser->first_name }} {{ $otherUser->last_name }}
                                </p>
                                <p style="color: #999; font-size: 0.75rem; margin: 4px 0 0 0;">
                                    Direct Message
                                </p>
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- GROUP CHATS --}}
        @if ($groupChats->isNotEmpty())
            <div>
                <p style="font-size: 0.75rem; color: #999; font-weight: 600; text-transform: uppercase; margin: 0 0 8px 12px;">
                    Group Chats
                </p>

                @foreach ($groupChats as $chat)
                    <a href="{{ route('messages.group', $chat) }}" style="text-decoration: none;">
                        <div style="
                            padding: 12px;
                            border-radius: 10px;
                            margin-bottom: 6px;
                            background: white;
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            cursor: pointer;
                            transition: all 0.2s ease;
                            border: 1px solid #f0f0f0;
                        "
                        onmouseover="this.style.backgroundColor='#f5f5f5'; this.style.borderColor='#ddd';"
                        onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#f0f0f0';"
                        >

                            {{-- ICON --}}
                            <div style="
                                width: 36px;
                                height: 36px;
                                background: linear-gradient(135deg, #7C5CEE, #FF6B9D);
                                border-radius: 8px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            ">
                                <i class="fas fa-music" style="color: white; font-size: 0.85rem;"></i>
                            </div>

                            {{-- INFO --}}
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 600; color: #1a1a1a; margin: 0; font-size: 0.85rem;">
                                    {{ $chat->concert_name }}
                                </p>
                                <p style="color: #999; font-size: 0.75rem; margin: 4px 0 0 0;">
                                    {{ $chat->requests->count() + 1 }} members
                                </p>
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- EMPTY STATE --}}
        @if ($directMessages->isEmpty() && $groupChats->isEmpty())
            <div style="text-align: center; padding: 40px 20px; color: #999;">
                <i class="fas fa-comments" style="font-size: 2.5rem; color: #ddd; margin-bottom: 12px;"></i>
                <p style="font-size: 0.85rem;">No messages yet.</p>
            </div>
        @endif

    </div>
</div>
