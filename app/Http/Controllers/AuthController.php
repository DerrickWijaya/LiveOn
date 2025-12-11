<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showHome()
    {
        return view('home');
    }

    public function showRegister()
    {
        // If user is already logged in, redirect to discover
        if (Auth::check()) {
            return redirect()->route('discover');
        }
        
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'location' => 'nullable|string|max:255',
        ]);

        // Split the full name into first and last name
        $nameParts = explode(' ', $validated['first_name'], 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        $user = User::create([
            'name' => $validated['first_name'],
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'location' => $validated['location'] ?? null,
        ]);

        Auth::login($user);

        return redirect()->route('discover');
    }

    public function showLogin()
    {
        // If user is already logged in, redirect to discover
        if (Auth::check()) {
            return redirect()->route('discover');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid email address.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid password.']);
        }

        Auth::login($user);

        return redirect()->route('discover');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
