@extends('backend.layouts.admin')

@section('title', 'Edit Previous Work')

@section('content')

<style>
    .previous-work-edit {
        padding: 24px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        margin-bottom: 12px;
        transition: 0.2s;
    }

    .back-link:hover {
        color: #0056b3;
    }

    .page-header h1 {
        margin: 0;
        color: #111827;
        font-size: 26px;
        font-weight: 700;
    }

    .page-header p {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-bottom: 22px;
    }

    .form-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #f8fafc;
    }

    .form-card-header h2 {
        margin: 0;
        color: #111827;
        font-size: 17px;
        font-weight: 700;
    }

    .form-card-header p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 12px;
    }

    .form-body {
        padding: 25px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
    }

    .required {
        color: #dc2626;
        margin-left: 2px;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #ffffff;
        color: #111827;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
    }

    .form-control:focus {
        border-color: #0056b3;
        box-shadow: 0 0 0 3px rgba(0, 86, 179, 0.08);
    }

    textarea.form-control {
        min-height: 130px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-help {
        display: block;
        margin-top: 6px;
        color: #94a3b8;
        font-size: 11px;
        line-height: 1.5;
    }

    .field-error {
        margin-top: 6px;
        color: #dc2626;
        font-size: 12px;
    }

    /* =========================================================
       STATUS
    ========================================================== */

    .status-options {
        display: flex;
        gap: 12px;
    }

    .status-option {
        position: relative;
    }

    .status-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .status-option label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        cursor: pointer;
        color: #475569;
        background: #ffffff;
        font-size: 13px;
        font-weight: 600;
        transition: 0.2s;
    }

    .status-option input:checked + label {
        border-color: #0056b3;
        background: #eff6ff;
        color: #0056b3;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #94a3b8;
    }

    .status-option input:checked + label .status-dot {
        background: #0056b3;
    }

    /* =========================================================
       EXISTING GALLERY
    ========================================================== */

    .gallery-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 14px;
    }

    .gallery-count {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 11px;
        border-radius: 20px;
        background: #eff6ff;
        color: #0056b3;
        font-size: 12px;
        font-weight: 700;
    }

    .existing-gallery {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 11px;
        background: #ffffff;
    }

    .gallery-image-wrapper {
        position: relative;
        width: 100%;
        height: 180px;
        overflow: hidden;
        background: #f1f5f9;
    }

    .gallery-image {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: 0.3s;
    }

    .gallery-item:hover .gallery-image {
        transform: scale(1.04);
    }

    .image-number {
        position: absolute;
        top: 9px;
        left: 9px;
        padding: 5px 8px;
        border-radius: 5px;
        background: rgba(0, 0, 0, 0.68);
        color: #ffffff;
        font-size: 10px;
        font-weight: 700;
    }

    .gallery-actions {
        padding: 11px;
        display: flex;
        gap: 7px;
    }

    .replace-label {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 9px;
        border: 1px solid #bfdbfe;
        border-radius: 7px;
        background: #eff6ff;
        color: #0056b3;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }

    .replace-label:hover {
        background: #dbeafe;
    }

    .replace-input {
        display: none;
    }

    .delete-image-btn {
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        border: 1px solid #fecaca;
        border-radius: 7px;
        background: #fef2f2;
        color: #dc2626;
        cursor: pointer;
        transition: 0.2s;
    }

    .delete-image-btn:hover {
        background: #fee2e2;
    }

    .replacement-name {
        padding: 0 11px 10px;
        color: #64748b;
        font-size: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .no-images {
        padding: 35px 20px;
        text-align: center;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        color: #94a3b8;
        font-size: 12px;
    }

    /* =========================================================
       NEW IMAGE UPLOAD
    ========================================================== */

    .new-upload-section {
        margin-top: 25px;
        padding-top: 25px;
        border-top: 1px solid #e5e7eb;
    }

    .new-upload-title {
        margin-bottom: 12px;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
    }

    .remaining-info {
        margin-bottom: 12px;
        padding: 10px 12px;
        border-radius: 7px;
        background: #f8fafc;
        color: #64748b;
        font-size: 12px;
    }

    .remaining-info strong {
        color: #0056b3;
    }

    .upload-box {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        min-height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        transition: 0.2s;
        cursor: pointer;
    }

    .upload-box:hover {
        border-color: #0056b3;
        background: #f8fbff;
    }

    .upload-box.dragover {
        border-color: #0056b3;
        background: #eff6ff;
    }

    .upload-input {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .upload-content {
        pointer-events: none;
        padding: 20px;
    }

    .upload-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 10px;
        border-radius: 50%;
        background: #eff6ff;
        color: #0056b3;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .upload-content h3 {
        margin: 0 0 4px;
        color: #1e293b;
        font-size: 14px;
        font-weight: 700;
    }

    .upload-content p {
        margin: 0;
        color: #64748b;
        font-size: 11px;
    }

    .upload-content span {
        display: inline-block;
        margin-top: 7px;
        color: #0056b3;
        font-size: 10px;
        font-weight: 600;
    }

    /* =========================================================
       NEW IMAGE PREVIEW
    ========================================================== */

    .new-preview-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
        margin-bottom: 11px;
    }

    .new-preview-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .new-preview-item {
        position: relative;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #ffffff;
    }

    .new-preview-item img {
        width: 100%;
        height: 145px;
        display: block;
        object-fit: cover;
    }

    .new-image-number {
        position: absolute;
        top: 8px;
        left: 8px;
        padding: 4px 7px;
        background: rgba(0, 0, 0, 0.65);
        color: #ffffff;
        border-radius: 4px;
        font-size: 9px;
        font-weight: 700;
    }

    .remove-new-image {
        position: absolute;
        top: 7px;
        right: 7px;
        width: 27px;
        height: 27px;
        border: none;
        border-radius: 50%;
        background: rgba(220, 38, 38, 0.92);
        color: #ffffff;
        cursor: pointer;
    }

    .new-image-name {
        padding: 8px 9px;
        color: #64748b;
        font-size: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* =========================================================
       FOOTER
    ========================================================== */

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 25px;
        border-top: 1px solid #e5e7eb;
        background: #fafafa;
    }

    .cancel-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 18px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #475569;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .cancel-btn:hover {
        background: #f8fafc;
        color: #111827;
    }

    .save-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 20px;
        border: none;
        border-radius: 8px;
        background: #0056b3;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .save-btn:hover {
        background: #003d82;
        transform: translateY(-1px);
    }

    @media (max-width: 850px) {

        .form-grid {
            grid-template-columns: 1fr;
        }

        .full-width {
            grid-column: auto;
        }

        .existing-gallery,
        .new-preview-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 550px) {

        .previous-work-edit {
            padding: 15px;
        }

        .form-body {
            padding: 18px;
        }

        .existing-gallery,
        .new-preview-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .gallery-image-wrapper {
            height: 135px;
        }

        .new-preview-item img {
            height: 120px;
        }

        .form-footer {
            padding: 15px 18px;
        }
    }
</style>


<div class="previous-work-edit">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="page-header">

        <a
            href="{{ route('admin.previous-works.index') }}"
            class="back-link"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Back to Previous Works

        </a>


        <h1>
            Edit Previous Work
        </h1>


        <p>
            Update project information and manage gallery images.
        </p>

    </div>


    {{-- =========================================================
         SUCCESS MESSAGE
    ========================================================== --}}

    @if(session('success'))

        <div
            style="
                background:#ecfdf5;
                color:#047857;
                border:1px solid #a7f3d0;
                padding:13px 16px;
                border-radius:8px;
                margin-bottom:20px;
                font-size:13px;
            "
        >

            <i class="fa-solid fa-circle-check"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- =========================================================
         VALIDATION ERRORS
    ========================================================== --}}

    @if($errors->any())

        <div
            style="
                background:#fef2f2;
                border:1px solid #fecaca;
                color:#b91c1c;
                padding:15px 18px;
                border-radius:9px;
                margin-bottom:20px;
                font-size:13px;
            "
        >

            <strong>
                Please fix the following errors:
            </strong>


            <ul style="margin:8px 0 0 18px;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =========================================================
         MAIN FORM
    ========================================================== --}}

    <div class="form-card">

        <div class="form-card-header">

            <h2>
                {{ $previousWork->title }}
            </h2>

            <p>
                Update the Previous Work information below.
            </p>

        </div>


        <form
            action="{{ route(
                'admin.previous-works.update',
                $previousWork
            ) }}"
            method="POST"
            enctype="multipart/form-data"
            id="previousWorkEditForm"
        >

            @csrf


            <div class="form-body">

                <div class="form-grid">

                    {{-- =================================================
                         TITLE
                    ================================================== --}}

                    <div class="form-group">

                        <label
                            for="title"
                            class="form-label"
                        >

                            Project Title

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="form-control"
                            value="{{ old(
                                'title',
                                $previousWork->title
                            ) }}"
                            required
                        >


                        @error('title')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                         LOCATION
                    ================================================== --}}

                    <div class="form-group">

                        <label
                            for="location"
                            class="form-label"
                        >

                            Location

                            <span
                                style="
                                    color:#94a3b8;
                                    font-weight:400;
                                "
                            >
                                (Optional)
                            </span>

                        </label>


                        <input
                            type="text"
                            name="location"
                            id="location"
                            class="form-control"
                            value="{{ old(
                                'location',
                                $previousWork->location
                            ) }}"
                            placeholder="e.g. Gulshan, Dhaka"
                        >


                        @error('location')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                         DESCRIPTION
                    ================================================== --}}

                    <div class="form-group full-width">

                        <label
                            for="description"
                            class="form-label"
                        >

                            Description

                            <span
                                style="
                                    color:#94a3b8;
                                    font-weight:400;
                                "
                            >
                                (Optional)
                            </span>

                        </label>


                        <textarea
                            name="description"
                            id="description"
                            class="form-control"
                            placeholder="Describe this project..."
                        >{{ old(
                            'description',
                            $previousWork->description
                        ) }}</textarea>


                        @error('description')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                         STATUS
                    ================================================== --}}

                    <div class="form-group">

                        <label class="form-label">
                            Status
                        </label>


                        <div class="status-options">

                            <div class="status-option">

                                <input
                                    type="radio"
                                    name="status"
                                    id="status_active"
                                    value="active"
                                    {{ old(
                                        'status',
                                        $previousWork->status
                                    ) === 'active'
                                        ? 'checked'
                                        : '' }}
                                >

                                <label for="status_active">

                                    <span class="status-dot"></span>

                                    Active

                                </label>

                            </div>


                            <div class="status-option">

                                <input
                                    type="radio"
                                    name="status"
                                    id="status_inactive"
                                    value="inactive"
                                    {{ old(
                                        'status',
                                        $previousWork->status
                                    ) === 'inactive'
                                        ? 'checked'
                                        : '' }}
                                >

                                <label for="status_inactive">

                                    <span class="status-dot"></span>

                                    Inactive

                                </label>

                            </div>

                        </div>


                        <small class="form-help">

                            Only Active Previous Works will appear on the public website.

                        </small>

                    </div>


                    {{-- =================================================
                         EXISTING GALLERY
                    ================================================== --}}

                    <div class="form-group full-width">

                        <label class="form-label">

                            Current Gallery

                        </label>


                        <div class="gallery-info">

                            <span
                                style="
                                    color:#64748b;
                                    font-size:12px;
                                "
                            >
                                Manage your existing gallery images.
                            </span>


                            <span class="gallery-count">

                                <i class="fa-regular fa-images"></i>

                                {{ $previousWork->images->count() }} / 4

                            </span>

                        </div>


                        @if($previousWork->images->count() > 0)

                            <div class="existing-gallery">

                                @foreach(
                                    $previousWork->images as $image
                                )

                                    <div
                                        class="gallery-item"
                                        id="gallery-item-{{ $image->id }}"
                                    >

                                        <div class="gallery-image-wrapper">

                                            <img
                                                src="{{ asset(
                                                    'storage/' . $image->image
                                                ) }}"
                                                alt="{{ $previousWork->title }}"
                                                class="gallery-image"
                                                id="image-preview-{{ $image->id }}"
                                            >


                                            <span class="image-number">

                                                Image
                                                {{ $image->sort_order }}

                                            </span>

                                        </div>


                                        <div class="gallery-actions">

                                            {{-- =================================
                                                 REPLACE
                                            ================================== --}}

                                            <label
                                                for="replace-{{ $image->id }}"
                                                class="replace-label"
                                            >

                                                <i class="fa-solid fa-rotate"></i>

                                                Replace

                                            </label>


                                            <input
                                                type="file"
                                                name="replace_images[{{ $image->id }}]"
                                                id="replace-{{ $image->id }}"
                                                class="replace-input replace-file"
                                                accept="image/jpeg,image/png,image/webp"
                                                data-image-id="{{ $image->id }}"
                                            >


                                            {{-- =================================
                                                 DELETE
                                            ================================== --}}

                                            <button
                                                type="button"
                                                class="delete-image-btn"
                                                title="Delete Image"
                                                onclick="deleteGalleryImage(
                                                    {{ $previousWork->id }},
                                                    {{ $image->id }}
                                                )"
                                            >

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </div>


                                        <div
                                            class="replacement-name"
                                            id="replacement-name-{{ $image->id }}"
                                        >

                                            Current image

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="no-images">

                                <i
                                    class="fa-regular fa-images"
                                    style="
                                        font-size:20px;
                                        margin-bottom:8px;
                                    "
                                ></i>

                                <br>

                                No gallery images available.

                            </div>

                        @endif


                        {{-- =================================================
                             ADD NEW IMAGES
                        ================================================== --}}

                        <div class="new-upload-section">

                            <div class="new-upload-title">

                                Add New Gallery Images

                            </div>


                            @php
                                $currentImageCount =
                                    $previousWork->images->count();

                                $remainingImages =
                                    4 - $currentImageCount;
                            @endphp


                            <div class="remaining-info">

                                You currently have

                                <strong>
                                    {{ $currentImageCount }}
                                </strong>

                                image(s).

                                You can add

                                <strong>
                                    {{ $remainingImages }}
                                </strong>

                                more image(s).

                            </div>


                            @if($remainingImages > 0)

                                <div
                                    class="upload-box"
                                    id="uploadBox"
                                >

                                    <input
                                        type="file"
                                        name="images[]"
                                        id="newImages"
                                        class="upload-input"
                                        accept="image/jpeg,image/png,image/webp"
                                        multiple
                                    >


                                    <div class="upload-content">

                                        <div class="upload-icon">

                                            <i class="fa-solid fa-cloud-arrow-up"></i>

                                        </div>


                                        <h3>
                                            Add More Images
                                        </h3>


                                        <p>
                                            You can add up to
                                            {{ $remainingImages }}
                                            more image(s)
                                        </p>


                                        <span>
                                            JPG, JPEG, PNG or WEBP • Max 5MB each
                                        </span>

                                    </div>

                                </div>


                                <div
                                    class="new-preview-header"
                                    id="newPreviewHeader"
                                    style="display:none;"
                                >

                                    <span
                                        style="
                                            color:#374151;
                                            font-size:12px;
                                            font-weight:700;
                                        "
                                    >
                                        New Images
                                    </span>


                                    <span
                                        id="newImageCounter"
                                        style="
                                            color:#64748b;
                                            font-size:11px;
                                        "
                                    >
                                        0 / {{ $remainingImages }}
                                    </span>

                                </div>


                                <div
                                    class="new-preview-grid"
                                    id="newPreviewGrid"
                                ></div>

                            @else

                                <div
                                    style="
                                        padding:12px 14px;
                                        background:#fefce8;
                                        border:1px solid #fde68a;
                                        color:#a16207;
                                        border-radius:8px;
                                        font-size:12px;
                                    "
                                >

                                    <i class="fa-solid fa-circle-info"></i>

                                    Gallery limit reached.

                                    Delete an existing image before adding
                                    a new one.

                                </div>

                            @endif

                        </div>


                        @error('images')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror


                        @error('images.*')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- =========================================================
                 FORM FOOTER
            ========================================================== --}}

            <div class="form-footer">

                <a
                    href="{{ route(
                        'admin.previous-works.index'
                    ) }}"
                    class="cancel-btn"
                >

                    Cancel

                </a>


                <button
                    type="submit"
                    class="save-btn"
                >

                    <i class="fa-solid fa-floppy-disk"></i>

                    Update Previous Work

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =============================================================
     DELETE IMAGE FORM
============================================================== --}}

<form
    method="POST"
    id="deleteImageForm"
    style="display:none;"
>
    @csrf
</form>


<script>

    /*
    |--------------------------------------------------------------------------
    | Delete Individual Gallery Image
    |--------------------------------------------------------------------------
    */

    function deleteGalleryImage(
        previousWorkId,
        imageId
    ) {

        const confirmed = confirm(
            'Are you sure you want to delete this gallery image?'
        );


        if (!confirmed) {
            return;
        }


        const form =
            document.getElementById(
                'deleteImageForm'
            );


        form.action =
            `/admin/previous-works/${previousWorkId}/images/${imageId}/delete`;


        form.submit();
    }


    /*
    |--------------------------------------------------------------------------
    | New Image Upload Preview
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const fileInput =
                document.getElementById(
                    'newImages'
                );

            const uploadBox =
                document.getElementById(
                    'uploadBox'
                );

            const previewGrid =
                document.getElementById(
                    'newPreviewGrid'
                );

            const previewHeader =
                document.getElementById(
                    'newPreviewHeader'
                );

            const imageCounter =
                document.getElementById(
                    'newImageCounter'
                );


            /*
            |--------------------------------------------------------------------------
            | If no upload area exists
            |--------------------------------------------------------------------------
            */

            if (!fileInput) {
                return;
            }


            let selectedFiles = [];

            const remainingLimit =
                {{ $remainingImages }};


            /*
            |--------------------------------------------------------------------------
            | File Input Change
            |--------------------------------------------------------------------------
            */

            fileInput.addEventListener(
                'change',
                function (event) {

                    const files =
                        Array.from(
                            event.target.files
                        );


                    addFiles(files);

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Add Files
            |--------------------------------------------------------------------------
            */

            function addFiles(files) {

                files.forEach(
                    function (file) {

                        if (
                            selectedFiles.length
                            >= remainingLimit
                        ) {

                            return;

                        }


                        const allowedTypes = [
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ];


                        if (
                            !allowedTypes.includes(
                                file.type
                            )
                        ) {

                            alert(
                                'Only JPG, JPEG, PNG and WEBP images are allowed.'
                            );

                            return;

                        }


                        if (
                            file.size
                            > 5 * 1024 * 1024
                        ) {

                            alert(
                                file.name +
                                ' is larger than 5MB.'
                            );

                            return;

                        }


                        const duplicate =
                            selectedFiles.some(
                                function (existingFile) {

                                    return (
                                        existingFile.name
                                        === file.name
                                        &&
                                        existingFile.size
                                        === file.size
                                    );

                                }
                            );


                        if (!duplicate) {

                            selectedFiles.push(
                                file
                            );

                        }

                    }
                );


                updateFileInput();

                renderPreviews();

            }


            /*
            |--------------------------------------------------------------------------
            | Update Input
            |--------------------------------------------------------------------------
            */

            function updateFileInput() {

                const dataTransfer =
                    new DataTransfer();


                selectedFiles.forEach(
                    function (file) {

                        dataTransfer.items.add(
                            file
                        );

                    }
                );


                fileInput.files =
                    dataTransfer.files;

            }


            /*
            |--------------------------------------------------------------------------
            | Render Preview
            |--------------------------------------------------------------------------
            */

            function renderPreviews() {

                previewGrid.innerHTML = '';


                if (
                    selectedFiles.length === 0
                ) {

                    previewHeader.style.display =
                        'none';

                    imageCounter.textContent =
                        '0 / ' + remainingLimit;

                    return;

                }


                previewHeader.style.display =
                    'flex';


                imageCounter.textContent =
                    selectedFiles.length +
                    ' / ' +
                    remainingLimit;


                selectedFiles.forEach(
                    function (file, index) {

                        const reader =
                            new FileReader();


                        reader.onload =
                            function (event) {

                                const item =
                                    document.createElement(
                                        'div'
                                    );


                                item.className =
                                    'new-preview-item';


                                item.innerHTML = `

                                    <img
                                        src="${event.target.result}"
                                        alt="New Image ${index + 1}"
                                    >

                                    <span class="new-image-number">
                                        New ${index + 1}
                                    </span>

                                    <button
                                        type="button"
                                        class="remove-new-image"
                                        data-index="${index}"
                                    >
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                    <div class="new-image-name">
                                        ${file.name}
                                    </div>

                                `;


                                previewGrid.appendChild(
                                    item
                                );

                            };


                        reader.readAsDataURL(
                            file
                        );

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Remove New Image
            |--------------------------------------------------------------------------
            */

            previewGrid.addEventListener(
                'click',
                function (event) {

                    const button =
                        event.target.closest(
                            '.remove-new-image'
                        );


                    if (!button) {
                        return;
                    }


                    const index =
                        parseInt(
                            button.dataset.index
                        );


                    selectedFiles.splice(
                        index,
                        1
                    );


                    updateFileInput();

                    renderPreviews();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Drag & Drop
            |--------------------------------------------------------------------------
            */

            if (uploadBox) {

                uploadBox.addEventListener(
                    'dragover',
                    function (event) {

                        event.preventDefault();

                        uploadBox.classList.add(
                            'dragover'
                        );

                    }
                );


                uploadBox.addEventListener(
                    'dragleave',
                    function () {

                        uploadBox.classList.remove(
                            'dragover'
                        );

                    }
                );


                uploadBox.addEventListener(
                    'drop',
                    function (event) {

                        event.preventDefault();

                        uploadBox.classList.remove(
                            'dragover'
                        );


                        const files =
                            Array.from(
                                event.dataTransfer.files
                            );


                        addFiles(files);

                    }
                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Existing Image Replacement Preview
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'change',
        function (event) {

            if (
                !event.target.classList.contains(
                    'replace-file'
                )
            ) {

                return;

            }


            const input =
                event.target;

            const imageId =
                input.dataset.imageId;

            const file =
                input.files[0];


            if (!file) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Validate Type
            |--------------------------------------------------------------------------
            */

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];


            if (
                !allowedTypes.includes(
                    file.type
                )
            ) {

                alert(
                    'Only JPG, JPEG, PNG and WEBP images are allowed.'
                );

                input.value = '';

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Validate Size
            |--------------------------------------------------------------------------
            */

            if (
                file.size >
                5 * 1024 * 1024
            ) {

                alert(
                    'Image must be smaller than 5MB.'
                );

                input.value = '';

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Preview New Replacement
            |--------------------------------------------------------------------------
            */

            const reader =
                new FileReader();


            reader.onload =
                function (event) {

                    const image =
                        document.getElementById(
                            'image-preview-' +
                            imageId
                        );


                    if (image) {

                        image.src =
                            event.target.result;

                    }


                    const fileName =
                        document.getElementById(
                            'replacement-name-' +
                            imageId
                        );


                    if (fileName) {

                        fileName.textContent =
                            'New: ' +
                            file.name;

                        fileName.style.color =
                            '#0056b3';

                        fileName.style.fontWeight =
                            '600';

                    }

                };


            reader.readAsDataURL(
                file
            );

        }
    );

</script>

@endsection