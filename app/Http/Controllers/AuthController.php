<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        \Log::debug('Login');
        \Log::debug($request->all());
        // Validate the request input (make sure username and password are present)
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Generate a unique key to track login attempts per user/IP for rate limiting
        $throttleKey = 'login:' . $request->username . '|' . $request->ip();

        // If there have been too many failed attempts, reject login
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'username' => ["Too many login attempts. Please try again in {$seconds} seconds."],
            ]);
        }

        // Try to find the user by username
        $user = User::where('username', $request->username)->first();

        // If user not found or password doesn't match, increment rate limit and fail
        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::increment($throttleKey);
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Login success: clear any rate limiter attempts for this key
        RateLimiter::clear($throttleKey);

        // Log the user in using Laravel's session-based auth
        Auth::login($user);

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Return a success response along with user data
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
        ]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        \Log::debug('Logout');
        \Log::debug($request->all());
        // Log out the user from the current session
        Auth::guard('web')->logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Return a success response
        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Get the currently authenticated user.
     */
    public function user(Request $request)
    {
        // Return the authenticated user (requires auth:sanctum middleware)
        return response()->json($request->user());
    }
}
