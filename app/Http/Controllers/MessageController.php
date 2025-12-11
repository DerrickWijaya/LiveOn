<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Post;
use App\Models\PostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get posts created by the user (as organizer)
        $createdPosts = $user->posts()
            ->select('posts.id', 'posts.concert_name', 'posts.user_id')
            ->with(['requests' => function ($q) {
                $q->where('status', 'accepted');
            }])
            ->get();

        // Get posts where user has accepted request (as member)
        $joinedPostIds = PostRequest::where('user_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('post_id');

        $joinedPosts = Post::whereIn('id', $joinedPostIds)
            ->select('posts.id', 'posts.concert_name', 'posts.user_id')
            ->with(['requests' => function ($q) {
                $q->where('status', 'accepted');
            }])
            ->get();

        // Combine and add type
        $groupChats = $createdPosts->merge($joinedPosts)
            ->unique('id')
            ->map(function ($post) {
                $post->type = 'group';
                return $post;
            });

        // Get direct message conversations
        $directMessages = Message::where('post_id', null)
            ->where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->get()
            ->map(function($message) use ($user) {
                // Get the other user (not the current user)
                return $message->sender_id === $user->id 
                    ? $message->receiver 
                    : $message->sender;
            })
            ->unique('id') // Remove duplicate users
            ->values(); // Re-index array

        return view('messages', compact('groupChats', 'directMessages'));
    }

    public function viewGroupChat(Post $post)
    {
        $user = Auth::user();

        // Get all accepted members for this post (excluding the organizer)
        $memberIds = $post->requests()
            ->where('status', 'accepted')
            ->pluck('user_id')
            ->toArray();

        // Don't include the post creator in the members list
        $members = User::whereIn('id', $memberIds)->get();

        $messages = $post->messages()
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->reverse();

        // Get group chats and direct messages for sidebar
        $createdPosts = $user->posts()
            ->select('posts.id', 'posts.concert_name', 'posts.user_id')
            ->with(['requests' => function ($q) {
                $q->where('status', 'accepted');
            }])
            ->get();

        $joinedPostIds = PostRequest::where('user_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('post_id');

        $joinedPosts = Post::whereIn('id', $joinedPostIds)
            ->select('posts.id', 'posts.concert_name', 'posts.user_id')
            ->with(['requests' => function ($q) {
                $q->where('status', 'accepted');
            }])
            ->get();

        $groupChats = $createdPosts->merge($joinedPosts)
            ->unique('id')
            ->map(function ($post) {
                $post->type = 'group';
                return $post;
            });

        $directMessages = Message::where('post_id', null)
            ->where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->get()
            ->map(function($message) use ($user) {
                return $message->sender_id === $user->id 
                    ? $message->receiver 
                    : $message->sender;
            })
            ->unique('id')
            ->values();

        return view('messages.group', compact('post', 'members', 'messages', 'groupChats', 'directMessages'));
    }

    public function sendGroupMessage(Request $request, Post $post)
    {
        $user = Auth::user();

        // Check if user is authorized (either post creator or accepted member)
        $isCreator = $post->user_id === $user->id;
        $isAcceptedMember = PostRequest::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->where('status', 'accepted')
            ->exists();

        if (!$isCreator && !$isAcceptedMember) {
            return back()->with('error', 'You are not authorized to send messages in this group.');
        }

        $request->validate([
            'message' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        // Validate that either message or image is provided
        if (empty($request->message) && !$request->hasFile('image')) {
            return back()->with('error', 'Please enter a message or select an image.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('messages', 'public');
        }

        Message::create([
            'post_id' => $post->id,
            'sender_id' => Auth::id(),
            'message' => $request->message ?? '',
            'image_path' => $imagePath,
        ]);

        return back()->with('success', 'Message sent!');
    }

    public function directMessage(User $user)
    {
        $currentUser = Auth::user();
        $otherUser = $user;

        // Get direct messages between these two users (where post_id is null)
        $messages = Message::where('post_id', null)
            ->where(function($query) use ($currentUser, $otherUser) {
                $query->where(function($q) use ($currentUser, $otherUser) {
                    $q->where('sender_id', $currentUser->id)
                      ->where('receiver_id', $otherUser->id);
                })->orWhere(function($q) use ($currentUser, $otherUser) {
                    $q->where('sender_id', $otherUser->id)
                      ->where('receiver_id', $currentUser->id);
                });
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Get group chats and direct messages for sidebar
        $createdPosts = $currentUser->posts()
            ->select('posts.id', 'posts.concert_name', 'posts.user_id')
            ->with(['requests' => function ($q) {
                $q->where('status', 'accepted');
            }])
            ->get();

        $joinedPostIds = PostRequest::where('user_id', $currentUser->id)
            ->where('status', 'accepted')
            ->pluck('post_id');

        $joinedPosts = Post::whereIn('id', $joinedPostIds)
            ->select('posts.id', 'posts.concert_name', 'posts.user_id')
            ->with(['requests' => function ($q) {
                $q->where('status', 'accepted');
            }])
            ->get();

        $groupChats = $createdPosts->merge($joinedPosts)
            ->unique('id')
            ->map(function ($post) {
                $post->type = 'group';
                return $post;
            });

        $directMessages = Message::where('post_id', null)
            ->where(function($query) use ($currentUser) {
                $query->where('sender_id', $currentUser->id)
                      ->orWhere('receiver_id', $currentUser->id);
            })
            ->with(['sender', 'receiver'])
            ->get()
            ->map(function($message) use ($currentUser) {
                return $message->sender_id === $currentUser->id 
                    ? $message->receiver 
                    : $message->sender;
            })
            ->unique('id')
            ->values();

        return view('messages.direct', compact('otherUser', 'messages', 'groupChats', 'directMessages'));
    }

    // public function sendDirectMessage(Request $request, User $user)
    // {
    //     $validated = $request->validate([
    //         'message' => 'nullable|string',
    //         'image' => 'nullable|image|max:2048',
    //     ]);

    //     // Validate that at least message or image is provided
    //     if (empty($validated['message']) && !$request->hasFile('image')) {
    //         return back()->with('error', 'Please provide a message or image.');
    //     }

    //     $imagePath = null;
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('messages', 'public');
    //     }

    //     Message::create([
    //         'post_id' => null,
    //         'sender_id' => Auth::id(),
    //         'receiver_id' => $user->id,
    //         'message' => $validated['message'] ?? '',
    //         'image_path' => $imagePath,
    //     ]);

    //     return back()->with('success', 'Message sent!');
    // }

    public function sendDirectMessage(Request $request, User $user)
    {
        $request->validate([
            'message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        // Validate that at least message or image is provided
        if (empty($request->message) && !$request->hasFile('image')) {
            return back()->with('error', 'Please provide a message or image.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('messages', 'public');
        }

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'message' => $request->message ?? '',
            'image_path' => $imagePath,
        ]);

        return redirect()->back();
    }

}
