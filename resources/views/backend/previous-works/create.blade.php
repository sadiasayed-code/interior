@extends('backend.layouts.admin')

@section('title', 'Add Previous Work')

@section('content')

<style>
    .previous-work-create {
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

    .status-option label:hover {
        border-color: #0056b3;
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
       IMAGE UPLOAD
    ========================================================== */

    .upload-section {
        margin-top: 5px;
    }

    /*
    |--------------------------------------------------------------------------
    | CLICKABLE UPLOAD BOX
    |--------------------------------------------------------------------------
    */

    .upload-box {
        position: relative;

        display: flex;
        align-items: center;
        justify-content: center;

        width: 100%;
        min-height: 180px;

        box-sizing: border-box;

        border: 2px dashed #cbd5e1;
        border-radius: 12px;

        background: #f8fafc;

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


    /*
    |--------------------------------------------------------------------------
    | Hidden File Input
    |--------------------------------------------------------------------------
    */

    .upload-input {
        position: absolute;

        width: 1px;
        height: 1px;

        padding: 0;
        margin: -1px;

        overflow: hidden;

        clip: rect(0, 0, 0, 0);
        clip-path: inset(50%);

        white-space: nowrap;

        border: 0;
    }


    /*
    |--------------------------------------------------------------------------
    | Upload Content
    |--------------------------------------------------------------------------
    */

    .upload-content {
        padding: 25px;
        pointer-events: none;
    }

    .upload-icon {
        width: 54px;
        height: 54px;

        margin: 0 auto 12px;

        border-radius: 50%;

        background: #eff6ff;
        color: #0056b3;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 22px;
    }

    .upload-content h3 {
        margin: 0 0 5px;

        color: #1e293b;

        font-size: 15px;
        font-weight: 700;
    }

    .upload-content p {
        margin: 0;

        color: #64748b;

        font-size: 12px;
    }

    .upload-content span {
        display: inline-block;

        margin-top: 8px;

        color: #0056b3;

        font-size: 11px;
        font-weight: 600;
    }


    /* =========================================================
       IMAGE PREVIEW
    ========================================================== */

    .preview-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        margin-top: 20px;
        margin-bottom: 12px;
    }

    .preview-title {
        color: #374151;
        font-size: 13px;
        font-weight: 700;
    }

    .image-counter {
        color: #64748b;
        font-size: 11px;
    }

    .preview-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .preview-item {
        position: relative;

        border: 1px solid #e5e7eb;
        border-radius: 10px;

        overflow: hidden;

        background: #f8fafc;
    }

    .preview-item img {
        display: block;

        width: 100%;
        height: 150px;

        object-fit: cover;
    }

    .preview-number {
        position: absolute;

        top: 8px;
        left: 8px;

        padding: 4px 8px;

        border-radius: 5px;

        background: rgba(0, 0, 0, 0.65);

        color: #ffffff;

        font-size: 10px;
        font-weight: 700;
    }

    .remove-preview {
        position: absolute;

        top: 7px;
        right: 7px;

        width: 28px;
        height: 28px;

        border: none;
        border-radius: 50%;

        background: rgba(220, 38, 38, 0.92);

        color: #ffffff;

        cursor: pointer;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 11px;

        transition: 0.2s;
    }

    .remove-preview:hover {
        background: #b91c1c;
        transform: scale(1.05);
    }

    .empty-preview {
        padding: 18px;

        text-align: center;

        color: #94a3b8;

        background: #f8fafc;

        border: 1px solid #e5e7eb;

        border-radius: 9px;

        font-size: 12px;
    }


    /* =========================================================
       FORM FOOTER
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

        transition: 0.2s;
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


    /* =========================================================
       RESPONSIVE
    ========================================================== */

    @media (max-width: 800px) {

        .previous-work-create {
            padding: 15px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .full-width {
            grid-column: auto;
        }

        .preview-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }


    @media (max-width: 500px) {

        .page-header h1 {
            font-size: 22px;
        }

        .form-body {
            padding: 18px;
        }

        .form-footer {
            padding: 15px 18px;
        }

        .status-options {
            flex-direction: column;
        }

        .status-option label {
            width: 100%;
            box-sizing: border-box;
        }

        .preview-grid {
            grid-template-columns: 1fr 1fr;
        }

        .preview-item img {
            height: 120px;
        }

        .upload-box {
            min-height: 170px;
        }

        .upload-content {
            padding: 20px;
        }
    }
</style>


<div class="previous-work-create">


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
            Add Previous Work
        </h1>


        <p>
            Add a completed interior project with up to 4 gallery images.
        </p>

    </div>



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
         FORM CARD
    ========================================================== --}}

    <div class="form-card">


        <div class="form-card-header">

            <h2>
                Previous Work Information
            </h2>

            <p>
                Provide the project information and gallery images.
            </p>

        </div>



        <form
            action="{{ route('admin.previous-works.store') }}"
            method="POST"
            enctype="multipart/form-data"
            id="previousWorkForm"
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
                            value="{{ old('title') }}"
                            placeholder="e.g. Modern Luxury Apartment"
                            required
                        >


                        <small class="form-help">
                            Enter the title of this Previous Work.
                        </small>


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
                            value="{{ old('location') }}"
                            placeholder="e.g. Gulshan, Dhaka"
                        >


                        <small class="form-help">
                            Example: Gulshan, Banani, Dhanmondi.
                        </small>


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
                            placeholder="Describe the project, design concept, materials, transformation, etc."
                        >{{ old('description') }}</textarea>


                        <small class="form-help">
                            This description will be displayed with the Previous Work on your website.
                        </small>


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


                            {{-- ACTIVE --}}

                            <div class="status-option">

                                <input
                                    type="radio"
                                    name="status"
                                    id="status_active"
                                    value="active"
                                    {{ old('status', 'active') === 'active' ? 'checked' : '' }}
                                >

                                <label for="status_active">

                                    <span class="status-dot"></span>

                                    Active

                                </label>

                            </div>



                            {{-- INACTIVE --}}

                            <div class="status-option">

                                <input
                                    type="radio"
                                    name="status"
                                    id="status_inactive"
                                    value="inactive"
                                    {{ old('status') === 'inactive' ? 'checked' : '' }}
                                >

                                <label for="status_inactive">

                                    <span class="status-dot"></span>

                                    Inactive

                                </label>

                            </div>

                        </div>


                        <small class="form-help">
                            Only Active Previous Works will be displayed on the public website.
                        </small>


                        @error('status')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- =================================================
                         IMAGE UPLOAD
                    ================================================== --}}

                    <div class="form-group full-width upload-section">

                        <label class="form-label">

                            Gallery Images

                            <span class="required">
                                *
                            </span>

                        </label>



                        <!-- =================================================
                             CLICKABLE UPLOAD AREA
                        ================================================== -->

                        <label
                            for="images"
                            class="upload-box"
                            id="uploadBox"
                        >

                            <input
                                type="file"
                                name="images[]"
                                id="images"
                                class="upload-input"
                                accept="image/jpeg,image/png,image/webp"
                                multiple
                            >


                            <div class="upload-content">

                                <div class="upload-icon">

                                    <i class="fa-solid fa-cloud-arrow-up"></i>

                                </div>


                                <h3>
                                    Upload Gallery Images
                                </h3>


                                <p>
                                    Click here to select images
                                </p>


                                <span>
                                    Select 1 to 4 images
                                </span>


                                <br>


                                <span>
                                    JPG, JPEG, PNG or WEBP • Max 5MB each
                                </span>

                            </div>

                        </label>



                        <small class="form-help">

                            You can upload maximum 4 images for one Previous Work.

                        </small>



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



                        {{-- =================================================
                             PREVIEW HEADER
                        ================================================== --}}

                        <div
                            class="preview-header"
                            id="previewHeader"
                            style="display:none;"
                        >

                            <span class="preview-title">
                                Selected Images
                            </span>


                            <span
                                class="image-counter"
                                id="imageCounter"
                            >
                                0 / 4
                            </span>

                        </div>



                        {{-- =================================================
                             PREVIEW GRID
                        ================================================== --}}

                        <div
                            class="preview-grid"
                            id="previewGrid"
                        ></div>


                        <div
                            class="empty-preview"
                            id="emptyPreview"
                        >
                            No images selected yet.
                        </div>

                    </div>

                </div>

            </div>



            {{-- =========================================================
                 FORM FOOTER
            ========================================================== --}}

            <div class="form-footer">

                <a
                    href="{{ route('admin.previous-works.index') }}"
                    class="cancel-btn"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="save-btn"
                >

                    <i class="fa-solid fa-floppy-disk"></i>

                    Save Previous Work

                </button>

            </div>

        </form>

    </div>

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const fileInput =
        document.getElementById('images');

    const uploadBox =
        document.getElementById('uploadBox');

    const previewGrid =
        document.getElementById('previewGrid');

    const previewHeader =
        document.getElementById('previewHeader');

    const imageCounter =
        document.getElementById('imageCounter');

    const emptyPreview =
        document.getElementById('emptyPreview');

    const form =
        document.getElementById('previousWorkForm');


    /*
    |--------------------------------------------------------------------------
    | Selected Files
    |--------------------------------------------------------------------------
    */

    let selectedFiles = [];


    /*
    |--------------------------------------------------------------------------
    | File Input Change
    |--------------------------------------------------------------------------
    */

    fileInput.addEventListener(
        'change',
        function (event) {

            const files =
                Array.from(event.target.files);

            addFiles(files);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Add Files
    |--------------------------------------------------------------------------
    */

    function addFiles(files) {

        files.forEach(function (file) {

            /*
            |--------------------------------------------------------------------------
            | Maximum 4 Files
            |--------------------------------------------------------------------------
            */

            if (selectedFiles.length >= 4) {

                alert(
                    'Maximum 4 images are allowed.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | File Type
            |--------------------------------------------------------------------------
            */

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];


            if (!allowedTypes.includes(file.type)) {

                alert(
                    'Only JPG, JPEG, PNG and WEBP images are allowed.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | File Size
            |--------------------------------------------------------------------------
            */

            if (file.size > 5 * 1024 * 1024) {

                alert(
                    file.name +
                    ' is larger than 5MB.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate
            |--------------------------------------------------------------------------
            */

            const alreadyExists =
                selectedFiles.some(function (existingFile) {

                    return (
                        existingFile.name === file.name &&
                        existingFile.size === file.size &&
                        existingFile.lastModified === file.lastModified
                    );

                });


            if (!alreadyExists) {

                selectedFiles.push(file);

            }

        });


        updateFileInput();

        renderPreviews();

    }


    /*
    |--------------------------------------------------------------------------
    | Update Actual File Input
    |--------------------------------------------------------------------------
    */

    function updateFileInput() {

        const dataTransfer =
            new DataTransfer();


        selectedFiles.forEach(function (file) {

            dataTransfer.items.add(file);

        });


        fileInput.files =
            dataTransfer.files;

    }


    /*
    |--------------------------------------------------------------------------
    | Render Previews
    |--------------------------------------------------------------------------
    */

    function renderPreviews() {

        previewGrid.innerHTML = '';


        /*
        |--------------------------------------------------------------------------
        | No Images
        |--------------------------------------------------------------------------
        */

        if (selectedFiles.length === 0) {

            previewHeader.style.display =
                'none';

            emptyPreview.style.display =
                'block';

            imageCounter.textContent =
                '0 / 4';

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Show Preview Header
        |--------------------------------------------------------------------------
        */

        previewHeader.style.display =
            'flex';

        emptyPreview.style.display =
            'none';


        imageCounter.textContent =
            selectedFiles.length + ' / 4';


        /*
        |--------------------------------------------------------------------------
        | Generate Preview
        |--------------------------------------------------------------------------
        */

        selectedFiles.forEach(
            function (file, index) {

                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        const item =
                            document.createElement('div');

                        item.className =
                            'preview-item';


                        item.innerHTML = `

                            <img
                                src="${event.target.result}"
                                alt="Preview ${index + 1}"
                            >

                            <span class="preview-number">
                                Image ${index + 1}
                            </span>

                            <button
                                type="button"
                                class="remove-preview"
                                data-index="${index}"
                                title="Remove"
                                aria-label="Remove image"
                            >
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                        `;


                        previewGrid.appendChild(item);

                    };


                reader.readAsDataURL(file);

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Remove Preview
    |--------------------------------------------------------------------------
    */

    previewGrid.addEventListener(
        'click',
        function (event) {

            const button =
                event.target.closest(
                    '.remove-preview'
                );


            if (!button) {
                return;
            }


            const index =
                parseInt(
                    button.dataset.index,
                    10
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


    /*
    |--------------------------------------------------------------------------
    | Form Submit Validation
    |--------------------------------------------------------------------------
    */

    form.addEventListener(
        'submit',
        function (event) {

            if (selectedFiles.length === 0) {

                event.preventDefault();

                alert(
                    'Please select at least one gallery image.'
                );

                return;
            }


            if (selectedFiles.length > 4) {

                event.preventDefault();

                alert(
                    'Maximum 4 images are allowed.'
                );

                return;
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Initial State
    |--------------------------------------------------------------------------
    */

    renderPreviews();

});

</script>

@endsection