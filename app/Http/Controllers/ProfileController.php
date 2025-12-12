<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

        if ($request->hasFile('profile_image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('profile_image')->getRealPath(), [
                'folder' => 'liveon/profiles'
            ])->getSecurePath();
            $validated['profile_image'] = $uploadedFileUrl;
        }

        if ($request->hasFile('cover_image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('cover_image')->getRealPath(), [
                'folder' => 'liveon/covers'
            ])->getSecurePath();
            $validated['cover_image'] = $uploadedFileUrl;
        }

        // Update first_name and last_name from name
        $nameParts = explode(' ', $validated['name'], 2);
        $validated['first_name'] = $nameParts[0];
        $validated['last_name'] = isset($nameParts[1]) ? $nameParts[1] : '';

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }
}
