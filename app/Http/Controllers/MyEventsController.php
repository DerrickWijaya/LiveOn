<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyEventsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $posts = $user->posts()->latest()->get();

        $totalPosts = $posts->count();
        $totalPendingRequests = $posts->sum(function ($post) {
            return $post->requests()->where('status', 'pending')->count();
        });

        return view('myevents', compact('posts', 'totalPosts', 'totalPendingRequests'));
    }

    public function viewGroupRequests(Post $post)
    {
        $this->authorize('update', $post);

        $pendingRequests = $post->requests()->where('status', 'pending')->with('user')->get();

        return view('myevents.requests', compact('post', 'pendingRequests'));
    }

    public function acceptRequest(PostRequest $request)
    {
        $post = $request->post;
        
        // Check if current user is the post owner
        if ($post->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Check if there are still spots available
        if ($post->spotsLeftCount() <= 0) {
            return back()->with('error', 'No spots available.');
        }

        $request->update(['status' => 'accepted']);

        return back()->with('success', 'Request accepted! ' . $request->user->first_name . ' has been added to your group.');
    }

    public function rejectRequest(PostRequest $request)
    {
        $post = $request->post;
        
        // Check if current user is the post owner
        if ($post->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->update(['status' => 'rejected']);

        return back()->with('success', $request->user->first_name . ' ' . $request->user->last_name . ' has been rejected and removed from the request list.');
    }
}
