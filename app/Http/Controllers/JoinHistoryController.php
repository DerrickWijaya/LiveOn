<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoinHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $joinedPostIds = PostRequest::where('user_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('post_id')
            ->toArray();

        $ownedPostIds = $user->posts()->pluck('id')->toArray();

        $allPostIds = array_merge($joinedPostIds, $ownedPostIds);

        $posts = Post::whereIn('id', $allPostIds)
            ->with('user')
            ->latest()
            ->get();

        $totalJoined = count($allPostIds);

        return view('joinhistory', compact('posts', 'totalJoined'));
    }
}
