<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
        |--------------------------------------------------------------------------
        | CHECK CUSTOMER SESSION
        |--------------------------------------------------------------------------
        */

        $customerUserId = $request->session()->get('customer_user_id');


        /*
        |--------------------------------------------------------------------------
        | NO CUSTOMER SESSION
        |--------------------------------------------------------------------------
        */

        if (!$customerUserId) {

            return redirect()
                ->route('customer.login')
                ->withErrors([
                    'email' => 'Please login as a customer first.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | FIND USER
        |--------------------------------------------------------------------------
        */

        $user = User::find($customerUserId);


        /*
        |--------------------------------------------------------------------------
        | INVALID CUSTOMER
        |--------------------------------------------------------------------------
        */

        if (!$user || $user->role !== 'customer') {

            $request->session()->forget('customer_user_id');

            return redirect()
                ->route('customer.login')
                ->withErrors([
                    'email' => 'Customer access is not authorized.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER IS AUTHORIZED
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}