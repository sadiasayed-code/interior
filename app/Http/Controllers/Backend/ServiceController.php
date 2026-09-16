<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    /**
     * Display all services.
     */
    public function index()
    {
        $services = Service::latest()->get();

        return view('backend.services.index', compact('services'));
    }

    /**
     * Show create service form.
     */
    public function create()
    {
        return view('backend.services.create');
    }

    /**
     * Store a new service.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:services,slug',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'starting_budget' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'estimated_duration_days' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate slug automatically if admin leaves it empty
        |--------------------------------------------------------------------------
        */
        $slug = $validated['slug'] ?? null;

        if (!$slug) {
            $slug = Str::slug($validated['name']);
        }

        /*
        |--------------------------------------------------------------------------
        | Make sure generated slug is unique
        |--------------------------------------------------------------------------
        */
        $originalSlug = $slug;
        $counter = 1;

        while (Service::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;

        /*
        |--------------------------------------------------------------------------
        | Upload image
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('services', 'public');
        }

        Service::create($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Show a single service.
     */
    public function show(Service $service)
    {
        $service->loadCount('projects');

        return view('backend.services.show', compact('service'));
    }

    /**
     * Show edit service form.
     */
    public function edit(Service $service)
    {
        return view('backend.services.edit', compact('service'));
    }

    /**
     * Update an existing service.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($service->id),
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'starting_budget' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'estimated_duration_days' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate slug if empty
        |--------------------------------------------------------------------------
        */
        if (empty($validated['slug'])) {
            $slug = Str::slug($validated['name']);

            $originalSlug = $slug;
            $counter = 1;

            while (
                Service::where('slug', $slug)
                    ->where('id', '!=', $service->id)
                    ->exists()
            ) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $validated['slug'] = $slug;
        }

        /*
        |--------------------------------------------------------------------------
        | Replace old image if a new image is uploaded
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('image')) {

            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('services', 'public');
        }

        $service->update($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Delete a service.
     */
    public function destroy(Service $service)
    {
        /*
        |--------------------------------------------------------------------------
        | Do not delete a service if projects already use it.
        |--------------------------------------------------------------------------
        */
        if ($service->projects()->exists()) {
            return back()->withErrors([
                'service' => 'This service cannot be deleted because it is already associated with one or more projects. You can make it inactive instead.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Delete service image
        |--------------------------------------------------------------------------
        */
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    /**
     * Toggle service active/inactive status.
     */
    public function toggleStatus(Service $service)
    {
        $service->update([
            'status' => $service->status === 'active'
                ? 'inactive'
                : 'active',
        ]);

        return back()->with(
            'success',
            'Service status updated successfully.'
        );
    }
}