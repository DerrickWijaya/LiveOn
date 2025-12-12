<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Cloudinary\Cloudinary as CloudinarySDK;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $recentActivity = $user->posts()->latest()->take(5)->get();

        return view('myprofile', compact('user', 'recentActivity'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:1|max:150',
            'profile_image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $cloudinary = new CloudinarySDK([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ]
        ]);

        if ($request->hasFile('profile_image')) {
            $result = $cloudinary->uploadApi()->upload($request->file('profile_image')->getRealPath(), [
                'folder' => 'liveon/profiles'
            ]);
            $validated['profile_image'] = $result['secure_url'];
        }

        if ($request->hasFile('cover_image')) {
            $result = $cloudinary->uploadApi()->upload($request->file('cover_image')->getRealPath(), [
                'folder' => 'liveon/covers'
            ]);
            $validated['cover_image'] = $result['secure_url'];
        }

        // Update first_name and last_name from name
        $nameParts = explode(' ', $validated['name'], 2);
        $validated['first_name'] = $nameParts[0];
        $validated['last_name'] = isset($nameParts[1]) ? $nameParts[1] : '';

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }
}
