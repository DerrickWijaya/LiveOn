<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Cloudinary as CloudinarySDK;

class DiscoverController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('user', 'requests');

        // Date filter - based on when post was created
        if ($request->filled('date_filter')) {
            $dateFilter = $request->date_filter;
            $now = now();
            
            switch ($dateFilter) {
                case 'today':
                    // Posts created today
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'this_week':
                    // Posts created in the last 7 days
                    $query->where('created_at', '>=', $now->copy()->subDays(7)->startOfDay());
                    break;
                case 'this_month':
                    // Posts created this month
                    $query->whereMonth('created_at', $now->month)
                          ->whereYear('created_at', $now->year);
                    break;
            }
        }

        // Location filter (search in both city and venue/location fields)
        if ($request->filled('location_filter')) {
            $location = trim($request->location_filter);
            if (!empty($location)) {
                $query->where(function($q) use ($location) {
                    // Search in city field (e.g., "Jakarta, Indonesia")
                    $q->where('city', 'like', '%' . $location . '%')
                      // Search in venue/location field (e.g., "ICE BSD")
                      ->orWhere('location', 'like', '%' . $location . '%');
                });
            }
        }

        // Search by concert name
        if ($request->filled('search')) {
            $query->where('concert_name', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(10);

        return view('discover', compact('posts'));
    }

    public function createPost(Request $request)
    {
        $validated = $request->validate([
            'concert_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'required|string',
            'concert_date' => 'required|date',
            'concert_time' => 'required',
            'spots_available' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|max:2048',
            'cover_color' => 'nullable|string',
        ]);

        if ($request->hasFile('cover_image')) {
            $cloudinary = new CloudinarySDK([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ]
            ]);
            $result = $cloudinary->uploadApi()->upload($request->file('cover_image')->getRealPath(), [
                'folder' => 'liveon/posts'
            ]);
            $validated['cover_image'] = $result['secure_url'];
        }

        $validated['user_id'] = Auth::id();
        Post::create($validated);

        return redirect()->route('discover')->with('success', 'Post created successfully!');
    }

    public function joinPost(Post $post)
    {
        $user = Auth::user();

        // Check if post is full
        if ($post->spotsLeftCount() <= 0) {
            return back()->with('error', 'This event is full. No more spots available.');
        }

        // Check if user is the post creator
        if ($post->user_id === $user->id) {
            return back()->with('error', 'You cannot join your own event.');
        }

        PostRequest::firstOrCreate(
            ['post_id' => $post->id, 'user_id' => $user->id],
            ['status' => 'pending']
        );

        return back()->with('success', 'Join request sent!');
    }
}
