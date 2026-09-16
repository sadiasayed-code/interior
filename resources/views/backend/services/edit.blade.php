@extends('backend.layouts.admin')

@section('title', 'Edit Service')

@section('page_title', 'Edit Service')

@section('content')


{{-- =====================================================
    PAGE HEADER
====================================================== --}}

<div class="page-header">

    <div>

        <h1>
            Edit Service
        </h1>

        <p>
            Update service information and availability.
        </p>

    </div>


    <a
        href="{{ route('admin.services.index') }}"
        class="secondary-btn"
    >
        ← Back to Services
    </a>

</div>



{{-- =====================================================
    VALIDATION ERRORS
====================================================== --}}

@if($errors->any())

    <div class="alert alert-danger">

        <strong>
            Please fix the following errors:
        </strong>

        <ul style="margin:10px 0 0 20px;">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif



{{-- =====================================================
    SERVICE INFORMATION PANEL
====================================================== --}}

<div class="panel">


    {{-- =================================================
        PANEL HEADER
    ================================================== --}}

    <div class="panel-header">

        <div>

            <h2>
                Service Information
            </h2>

            <p>
                Update the details of this service.
            </p>

        </div>

    </div>



    {{-- =================================================
        FORM
    ================================================== --}}

    <form
        action="{{ route('admin.services.update', $service) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        <div style="padding:25px;">


            {{-- =========================================
                SERVICE NAME
            ========================================== --}}

            <div class="form-group">

                <label for="name">

                    Service Name

                    <span style="color:red;">
                        *
                    </span>

                </label>


                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $service->name) }}"
                    placeholder="Example: Residential Interior Design"
                    required
                >


                @error('name')

                    <small style="color:red;">
                        {{ $message }}
                    </small>

                @enderror

            </div>



            {{-- =========================================
                SLUG
            ========================================== --}}

            <div class="form-group">

                <label for="slug">
                    Slug
                </label>


                <input
                    type="text"
                    name="slug"
                    id="slug"
                    value="{{ old('slug', $service->slug) }}"
                    placeholder="Example: residential-interior-design"
                >


                <small>
                    Use a unique URL-friendly slug.
                </small>


                @error('slug')

                    <small style="color:red;">
                        {{ $message }}
                    </small>

                @enderror

            </div>



            {{-- =========================================
                SHORT DESCRIPTION
            ========================================== --}}

            <div class="form-group">

                <label for="short_description">
                    Short Description
                </label>


                <textarea
                    name="short_description"
                    id="short_description"
                    rows="3"
                    maxlength="500"
                    placeholder="Write a short description..."
                >{{ old('short_description', $service->short_description) }}</textarea>


                <small>
                    Maximum 500 characters.
                </small>


                @error('short_description')

                    <small style="color:red;">
                        {{ $message }}
                    </small>

                @enderror

            </div>



            {{-- =========================================
                FULL DESCRIPTION
            ========================================== --}}

            <div class="form-group">

                <label for="description">
                    Full Description
                </label>


                <textarea
                    name="description"
                    id="description"
                    rows="6"
                    placeholder="Describe this service in detail..."
                >{{ old('description', $service->description) }}</textarea>


                @error('description')

                    <small style="color:red;">
                        {{ $message }}
                    </small>

                @enderror

            </div>



            {{-- =========================================
                BUDGET + DURATION
            ========================================== --}}

            <div
                style="
                    display:grid;
                    grid-template-columns:repeat(2, 1fr);
                    gap:20px;
                "
            >


                {{-- STARTING BUDGET --}}

                <div class="form-group">

                    <label for="starting_budget">
                        Starting Budget
                    </label>


                    <input
                        type="number"
                        name="starting_budget"
                        id="starting_budget"
                        value="{{ old(
                            'starting_budget',
                            $service->starting_budget
                        ) }}"
                        min="0"
                        step="0.01"
                        placeholder="Example: 50000"
                    >


                    <small>
                        This is only an approximate starting budget.
                    </small>


                    @error('starting_budget')

                        <small style="color:red;">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                {{-- ESTIMATED DURATION --}}

                <div class="form-group">

                    <label for="estimated_duration_days">
                        Estimated Duration
                    </label>


                    <input
                        type="number"
                        name="estimated_duration_days"
                        id="estimated_duration_days"
                        value="{{ old(
                            'estimated_duration_days',
                            $service->estimated_duration_days
                        ) }}"
                        min="1"
                        placeholder="Example: 30"
                    >


                    <small>
                        Estimated number of days required.
                    </small>


                    @error('estimated_duration_days')

                        <small style="color:red;">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


            </div>



            {{-- =========================================
                CURRENT IMAGE
            ========================================== --}}

            @if($service->image)

                <div class="form-group">

                    <label>
                        Current Service Image
                    </label>


                    <div style="margin-top:10px;">

                        <img
                            src="{{ asset('storage/' . $service->image) }}"
                            alt="{{ $service->name }}"
                            style="
                                width:220px;
                                height:140px;
                                object-fit:cover;
                                border-radius:8px;
                                border:1px solid #ddd;
                                display:block;
                            "
                        >

                    </div>

                </div>

            @endif



            {{-- =========================================
                NEW SERVICE IMAGE
            ========================================== --}}

            <div class="form-group">

                <label for="image">
                    Replace Service Image
                </label>


                <input
                    type="file"
                    name="image"
                    id="image"
                    accept="image/jpeg,image/png,image/webp"
                >


                <small>
                    Leave empty to keep the current image.
                    JPG, JPEG, PNG or WEBP. Maximum size: 2MB.
                </small>


                @error('image')

                    <small style="color:red;">
                        {{ $message }}
                    </small>

                @enderror


                {{-- NEW IMAGE PREVIEW --}}

                <div style="margin-top:15px;">

                    <img
                        id="imagePreview"
                        src=""
                        alt="New Image Preview"
                        style="
                            display:none;
                            width:220px;
                            height:140px;
                            object-fit:cover;
                            border-radius:8px;
                            border:1px solid #ddd;
                        "
                    >

                </div>

            </div>



            {{-- =========================================
                STATUS
            ========================================== --}}

            <div class="form-group">

                <label for="status">

                    Status

                    <span style="color:red;">
                        *
                    </span>

                </label>


                <select
                    name="status"
                    id="status"
                    required
                >

                    <option
                        value="active"
                        {{ old(
                            'status',
                            $service->status
                        ) === 'active' ? 'selected' : '' }}
                    >
                        Active
                    </option>


                    <option
                        value="inactive"
                        {{ old(
                            'status',
                            $service->status
                        ) === 'inactive' ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>


                <small>
                    Inactive services will not normally be available
                    to customers.
                </small>


                @error('status')

                    <small style="color:red;">
                        {{ $message }}
                    </small>

                @enderror

            </div>



            {{-- =========================================
                FORM ACTIONS
            ========================================== --}}

            <div
                style="
                    display:flex;
                    gap:10px;
                    margin-top:25px;
                "
            >

                <button
                    type="submit"
                    class="primary-btn"
                >
                    Update Service
                </button>


                <a
                    href="{{ route('admin.services.index') }}"
                    class="secondary-btn"
                >
                    Cancel
                </a>

            </div>


        </div>

    </form>

</div>



{{-- =====================================================
    IMAGE PREVIEW SCRIPT
====================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const imageInput =
        document.getElementById('image');

    const imagePreview =
        document.getElementById('imagePreview');


    if (!imageInput || !imagePreview) {
        return;
    }


    imageInput.addEventListener('change', function (event) {

        const file = event.target.files[0];


        if (!file) {

            imagePreview.style.display = 'none';

            imagePreview.src = '';

            return;
        }


        const reader = new FileReader();


        reader.onload = function (e) {

            imagePreview.src = e.target.result;

            imagePreview.style.display = 'block';

        };


        reader.readAsDataURL(file);

    });

});

</script>


@endsection