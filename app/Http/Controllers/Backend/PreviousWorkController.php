<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PreviousWork;
use App\Models\PreviousWorkImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PreviousWorkController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $previousWorks = PreviousWork::with('images')
            ->latest()
            ->get();

        return view(
            'backend.previous-works.index',
            compact('previousWorks')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'backend.previous-works.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],

            'images' => [
                'required',
                'array',
                'min:1',
                'max:4',
            ],

            'images.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        DB::transaction(function () use ($request, $validated) {

            /*
            |--------------------------------------------------------------------------
            | Generate Unique Slug
            |--------------------------------------------------------------------------
            */

            $slug = Str::slug(
                $validated['title']
            );

            $originalSlug = $slug;

            $counter = 1;


            while (
                PreviousWork::where(
                    'slug',
                    $slug
                )->exists()
            ) {

                $slug =
                    $originalSlug .
                    '-' .
                    $counter;

                $counter++;
            }


            /*
            |--------------------------------------------------------------------------
            | Create Previous Work
            |--------------------------------------------------------------------------
            */

            $previousWork = PreviousWork::create([

                'title' =>
                    $validated['title'],

                'slug' =>
                    $slug,

                'description' =>
                    $validated['description'] ?? null,

                'location' =>
                    $validated['location'] ?? null,

                'status' =>
                    $validated['status'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | Upload Gallery Images
            |--------------------------------------------------------------------------
            */

            foreach (
                $request->file('images')
                as $index => $image
            ) {

                $path = $image->store(
                    'previous-works',
                    'public'
                );


                PreviousWorkImage::create([

                    'previous_work_id' =>
                        $previousWork->id,

                    'image' =>
                        $path,

                    'sort_order' =>
                        $index + 1,
                ]);
            }
        });


        return redirect()
            ->route(
                'admin.previous-works.index'
            )
            ->with(
                'success',
                'Previous Work created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(
        PreviousWork $previousWork
    ) {

        $previousWork->load(
            'images'
        );


        return view(
            'backend.previous-works.show',
            compact('previousWork')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(
        PreviousWork $previousWork
    ) {

        $previousWork->load(
            'images'
        );


        return view(
            'backend.previous-works.edit',
            compact('previousWork')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        PreviousWork $previousWork
    ) {

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],

            /*
            |--------------------------------------------------------------------------
            | New Images
            |--------------------------------------------------------------------------
            */

            'images' => [
                'nullable',
                'array',
                'max:4',
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            /*
            |--------------------------------------------------------------------------
            | Replacement Images
            |--------------------------------------------------------------------------
            */

            'replace_images' => [
                'nullable',
                'array',
            ],

            'replace_images.*' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Update Basic Information
        |--------------------------------------------------------------------------
        */

        $previousWork->update([

            'title' =>
                $validated['title'],

            'description' =>
                $validated['description'] ?? null,

            'location' =>
                $validated['location'] ?? null,

            'status' =>
                $validated['status'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Update Slug
        |--------------------------------------------------------------------------
        */

        $newSlug = Str::slug(
            $validated['title']
        );

        $originalSlug = $newSlug;

        $counter = 1;


        while (
            PreviousWork::where(
                'slug',
                $newSlug
            )
            ->where(
                'id',
                '!=',
                $previousWork->id
            )
            ->exists()
        ) {

            $newSlug =
                $originalSlug .
                '-' .
                $counter;

            $counter++;
        }


        $previousWork->update([
            'slug' => $newSlug,
        ]);


        /*
        |--------------------------------------------------------------------------
        | REPLACE EXISTING GALLERY IMAGES
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile(
                'replace_images'
            )
        ) {

            foreach (
                $request->file('replace_images')
                as $imageId => $newImage
            ) {

                /*
                |--------------------------------------------------------------------------
                | Find Image
                |--------------------------------------------------------------------------
                */

                $oldImage =
                    PreviousWorkImage::where(
                        'id',
                        $imageId
                    )
                    ->where(
                        'previous_work_id',
                        $previousWork->id
                    )
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | Security Check
                |--------------------------------------------------------------------------
                */

                if (!$oldImage) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Delete Old Physical Image
                |--------------------------------------------------------------------------
                */

                if (
                    $oldImage->image
                ) {

                    Storage::disk('public')
                        ->delete(
                            $oldImage->image
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | Store New Image
                |--------------------------------------------------------------------------
                */

                $newImagePath =
                    $newImage->store(
                        'previous-works',
                        'public'
                    );


                /*
                |--------------------------------------------------------------------------
                | Update Database
                |--------------------------------------------------------------------------
                */

                $oldImage->update([

                    'image' =>
                        $newImagePath,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ADD NEW GALLERY IMAGES
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile('images')
        ) {

            /*
            |--------------------------------------------------------------------------
            | Current Image Count
            |--------------------------------------------------------------------------
            */

            $currentImageCount =
                $previousWork
                    ->images()
                    ->count();


            /*
            |--------------------------------------------------------------------------
            | New Images
            |--------------------------------------------------------------------------
            */

            $newImages =
                $request->file('images');


            /*
            |--------------------------------------------------------------------------
            | Total Images
            |--------------------------------------------------------------------------
            */

            $totalImages =
                $currentImageCount +
                count($newImages);


            /*
            |--------------------------------------------------------------------------
            | Maximum 4 Images
            |--------------------------------------------------------------------------
            */

            if (
                $totalImages > 4
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'images' =>
                            'A Previous Work can have maximum 4 images.',
                    ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Find Next Sort Order
            |--------------------------------------------------------------------------
            */

            $nextSortOrder =
                (
                    $previousWork
                        ->images()
                        ->max('sort_order')
                    ?? 0
                ) + 1;


            /*
            |--------------------------------------------------------------------------
            | Store New Images
            |--------------------------------------------------------------------------
            */

            foreach (
                $newImages as $image
            ) {

                $path =
                    $image->store(
                        'previous-works',
                        'public'
                    );


                PreviousWorkImage::create([

                    'previous_work_id' =>
                        $previousWork->id,

                    'image' =>
                        $path,

                    'sort_order' =>
                        $nextSortOrder,
                ]);


                $nextSortOrder++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.previous-works.edit',
                $previousWork
            )
            ->with(
                'success',
                'Previous Work updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE PREVIOUS WORK
    |--------------------------------------------------------------------------
    */

    public function destroy(
        PreviousWork $previousWork
    ) {

        /*
        |--------------------------------------------------------------------------
        | Delete Previous Work
        |--------------------------------------------------------------------------
        |
        | PreviousWork model booted() method will
        | delete all physical gallery images.
        |
        */

        $previousWork->delete();


        return redirect()
            ->route(
                'admin.previous-works.index'
            )
            ->with(
                'success',
                'Previous Work deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE SINGLE GALLERY IMAGE
    |--------------------------------------------------------------------------
    */

    public function destroyImage(
        PreviousWork $previousWork,
        PreviousWorkImage $image
    ) {

        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        |
        | Make sure this image belongs to
        | the selected Previous Work.
        |
        */

        if (
            $image->previous_work_id
            !== $previousWork->id
        ) {

            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        |
        | PreviousWorkImage model booted()
        | automatically deletes physical file.
        |
        */

        $image->delete();


        return back()
            ->with(
                'success',
                'Gallery image deleted successfully.'
            );
    }
}