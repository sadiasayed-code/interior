<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLogin()
    {
        return view('backend.auth.login');
    }


    /**
     * Process admin login.
     */
    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATE LOGIN
        |--------------------------------------------------------------------------
        */

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | FIND USER
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $credentials['email'])->first();


        /*
        |--------------------------------------------------------------------------
        | CHECK USER, PASSWORD AND ROLE
        |--------------------------------------------------------------------------
        |
        | Only users with role = admin can enter the Admin Panel.
        |
        */

        if (
            !$user ||
            !Hash::check($credentials['password'], $user->password) ||
            $user->role !== 'admin'
        ) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Invalid admin email or password.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | REGENERATE SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | STORE ADMIN SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->put('admin_user_id', $user->id);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT TO ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Welcome back, Admin!');
    }


    /**
     * Logout admin user.
     */
    public function logout(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | REMOVE ADMIN SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->forget('admin_user_id');


        /*
        |--------------------------------------------------------------------------
        | DESTROY CURRENT SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();


        /*
        |--------------------------------------------------------------------------
        | GENERATE NEW CSRF TOKEN
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | RETURN TO LOGIN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out.');
    }
}