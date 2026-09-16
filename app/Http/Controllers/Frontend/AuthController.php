<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CUSTOMER REGISTER FORM
    |--------------------------------------------------------------------------
    */

    public function showRegister(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Remember Selected Service
        |--------------------------------------------------------------------------
        |
        | Example:
        | /customer/register?service=modern-bedroom
        |
        */

        if ($request->filled('service')) {

            $service = Service::where('slug', $request->service)
                ->where('status', 'active')
                ->first();

            if ($service) {
                session()->put(
                    'selected_service_slug',
                    $service->slug
                );
            }
        }

        return view('frontend.auth.register');
    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER REGISTER
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email',

            'phone' => 'required|string|max:30',

            'address' => 'nullable|string|max:1000',

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | REMEMBER SELECTED SERVICE BEFORE SESSION REGENERATION
        |--------------------------------------------------------------------------
        */

        $selectedServiceSlug = session(
            'selected_service_slug'
        );


        /*
        |--------------------------------------------------------------------------
        | CREATE CUSTOMER USER
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' => $validated['name'],

            'email' => $validated['email'],

            'password' => Hash::make(
                $validated['password']
            ),

            'role' => 'customer',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CREATE CLIENT PROFILE
        |--------------------------------------------------------------------------
        */

        Client::create([
            'user_id' => $user->id,

            'name' => $validated['name'],

            'phone' => $validated['phone'],

            'email' => $validated['email'],

            'address' => $validated['address'] ?? null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | LOGIN CUSTOMER AFTER REGISTRATION
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        $request->session()->put(
            'customer_user_id',
            $user->id
        );


        /*
        |--------------------------------------------------------------------------
        | REDIRECT TO PROJECT REQUEST
        |--------------------------------------------------------------------------
        |
        | If customer came from a Service Show Page,
        | send them directly to the Project Request form
        | with that service selected.
        |
        */

        if ($selectedServiceSlug) {

            /*
            | Remove temporary service session
            */

            $request->session()->forget(
                'selected_service_slug'
            );

            return redirect()->route(
                'customer.project-request.create',
                [
                    'service' => $selectedServiceSlug
                ]
            )->with(
                'success',
                'Account created successfully. Please complete your project request.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL REGISTRATION
        |--------------------------------------------------------------------------
        |
        | If customer registered directly without selecting
        | a service first, go to dashboard.
        |
        */

        return redirect()
            ->route('customer.dashboard')
            ->with(
                'success',
                'Account created successfully. Welcome!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER LOGIN FORM
    |--------------------------------------------------------------------------
    */

    public function showLogin(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Remember Selected Service
        |--------------------------------------------------------------------------
        */

        if ($request->filled('service')) {

            $service = Service::where(
                'slug',
                $request->service
            )
                ->where(
                    'status',
                    'active'
                )
                ->first();

            if ($service) {

                session()->put(
                    'selected_service_slug',
                    $service->slug
                );
            }
        }

        return view(
            'frontend.auth.login'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $credentials = $request->validate([
            'email' => 'required|email',

            'password' => 'required|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | FIND CUSTOMER
        |--------------------------------------------------------------------------
        */

        $user = User::where(
            'email',
            $credentials['email']
        )
            ->where(
                'role',
                'customer'
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | CHECK CUSTOMER AND PASSWORD
        |--------------------------------------------------------------------------
        */

        if (
            !$user ||
            !Hash::check(
                $credentials['password'],
                $user->password
            )
        ) {

            return back()
                ->withInput(
                    $request->only('email')
                )
                ->withErrors([
                    'email' =>
                        'Invalid customer email or password.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | GET SELECTED SERVICE BEFORE SESSION REGENERATION
        |--------------------------------------------------------------------------
        */

        $selectedServiceSlug = session(
            'selected_service_slug'
        );


        /*
        |--------------------------------------------------------------------------
        | REGENERATE SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | STORE CUSTOMER SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'customer_user_id',
            $user->id
        );


        /*
        |--------------------------------------------------------------------------
        | REDIRECT TO PROJECT REQUEST IF SERVICE WAS SELECTED
        |--------------------------------------------------------------------------
        */

        if ($selectedServiceSlug) {

            $request->session()->forget(
                'selected_service_slug'
            );

            return redirect()->route(
                'customer.project-request.create',
                [
                    'service' => $selectedServiceSlug
                ]
            )->with(
                'success',
                'Welcome back! Please complete your project request.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL CUSTOMER LOGIN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('customer.dashboard')
            ->with(
                'success',
                'Welcome back!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | REMOVE CUSTOMER SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->forget(
            'customer_user_id'
        );

        $request->session()->forget(
            'selected_service_slug'
        );


        /*
        |--------------------------------------------------------------------------
        | INVALIDATE SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();


        /*
        |--------------------------------------------------------------------------
        | REGENERATE CSRF TOKEN
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT TO CUSTOMER LOGIN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('customer.login')
            ->with(
                'success',
                'You have been logged out.'
            );
    }
}