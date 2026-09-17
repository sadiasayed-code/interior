<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PreviousWork;

class PreviousWorkController extends Controller
{
    public function show(PreviousWork $previousWork)
    {
        /*
        |--------------------------------------------------------------------------
        | Only Active Previous Works
        |--------------------------------------------------------------------------
        */

        if ($previousWork->status !== 'active') {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Load Gallery Images
        |--------------------------------------------------------------------------
        */

        $previousWork->load([
            'images' => function ($query) {
                $query->orderBy('sort_order');
            }
        ]);


        /*
        |--------------------------------------------------------------------------
        | Single Previous Work Page
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.previous-works.show',
            compact('previousWork')
        );
    }
}