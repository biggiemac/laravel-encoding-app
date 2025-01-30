<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    // Show Registration Form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user); // Log the user in immediately

        return redirect()->route('dashboard');
    }

    // Dashboard View (Show Jobs & API Keys)
    public function dashboard()
    {
        $jobs = auth()->user()->encodingJobs;  // Fetch jobs submitted by the logged-in user
        return view('dashboard', compact('jobs'));
    }

    // Generate API Key for the user
    public function generateApiKey()
    {
        $apiKey = auth()->user()->createToken('JobSubmissionToken')->plainTextToken;
        // Optionally, store it in the session to display it after redirecting
        //session()->flash('api_key', $apiKey);
        //return response()->json(['api_key' => $apiKey]);
        // try 3
        // Store the API key in the database
        auth()->user()->apiKeys()->create([
        'api_key' => $apiKey,
        ]);
        // After key is created, redirect back to the dashboard page
        return redirect()->route('dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
    // Log the user out
    Auth::logout();

    // Invalidate the session
    $request->session()->invalidate();

    // Regenerate the session token
    $request->session()->regenerateToken();

    // Redirect the user to the login page or any other page
    return redirect()->route('login');
    }

    // login goodness
    public function showLoginForm()
    {
    return view('auth.login'); // Make sure you have a login.blade.php file in the resources/views/auth directory
    }

    public function login(Request $request)
    {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($credentials)) {
        return redirect()->intended('dashboard'); // Redirect to dashboard after successful login
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
    }

    // remove API key
    public function deleteApiKey($id)
    {
        $user = Auth::user();

        // Find the token and ensure it belongs to the authenticated user
        $token = $user->tokens()->where('id', $id)->first();

        if (!$token) {
            return response()->json(['message' => 'API Key not found'], 404);
        }

        // Delete the token
        $token->delete();

        return response()->json(['message' => 'API Key deleted successfully']);
    }
}
