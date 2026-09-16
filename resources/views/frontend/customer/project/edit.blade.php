{{-- resources/views/frontend/customer/project/edit.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>

<style>
    .edit-project-wrapper {
        max-width: 950px;
        margin: 40px auto;
        padding: 0 15px;
    }

    .edit-project-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 8px 35px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .edit-project-header {
        background: linear-gradient(135deg, #111827, #1f2937);
        color: #fff;
        padding: 28px 30px;
    }

    .edit-project-header h2 {
        margin: 0 0 7px;
        font-size: 26px;
        font-weight: 700;
    }

    .edit-project-header p {
        margin: 0;
        color: #d1d5db;
        font-size: 14px;
    }

    .edit-project-body {
        padding: 30px;
    }

    .alert {
        padding: 14px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
    }

    .required {
        color: #dc2626;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        background: #fff;
        color: #111827;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #111827;
        box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.08);
    }

    textarea.form-control {
        min-height: 130px;
        resize: vertical;
    }

    .form-help {
        display: block;
        margin-top: 6px;
        color: #6b7280;
        font-size: 12px;
    }

    .field-error {
        margin-top: 6px;
        color: #dc2626;
        font-size: 12px;
    }

    .current-info {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 25px;
    }

    .current-info-title {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .info-item {
        background: #fff;
        border-radius: 9px;
        padding: 12px;
        border: 1px solid #e5e7eb;
    }

    .info-label {
        display: block;
        color: #6b7280;
        font-size: 11px;
        margin-bottom: 4px;
    }

    .info-value {
        color: #111827;
        font-size: 13px;
        font-weight: 600;
        word-break: break-word;
    }

    .notice {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        background: #fffbeb;
        border: 1px solid #fde68a;
        color: #92400e;
        padding: 14px 16px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-size: 13px;
        line-height: 1.6;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 10px;
        padding-top: 25px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 11px 18px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .btn-primary {
        background: #111827;
        color: #fff;
    }

    .btn-primary:hover {
        background: #000;
    }

    @media (max-width: 768px) {

        .edit-project-wrapper {
            margin: 20px auto;
        }

        .edit-project-header {
            padding: 22px 20px;
        }

        .edit-project-header h2 {
            font-size: 22px;
        }

        .edit-project-body {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-group.full {
            grid-column: auto;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-group {
            width: 100%;
        }

        .btn {
            width: 100%;
        }
    }
</style>


<div class="edit-project-wrapper">

    <div class="edit-project-card">

        {{-- Header --}}
        <div class="edit-project-header">
            <h2>Edit Project Request</h2>
            <p>
                আপনার Project Request-এর তথ্য পরিবর্তন করুন
            </p>
        </div>


        <div class="edit-project-body">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


            {{-- Error Message --}}
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following errors:</strong>

                    <ul style="margin: 8px 0 0 18px; padding: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Current Request Information --}}
            <div class="current-info">

                <div class="current-info-title">
                    Current Request Information
                </div>

                <div class="info-grid">

                    <div class="info-item">
                        <span class="info-label">
                            Current Service
                        </span>

                        <span class="info-value">
                            {{ $project->service?->name ?? 'Not Selected' }}
                        </span>
                    </div>


                    <div class="info-item">
                        <span class="info-label">
                            Request Status
                        </span>

                        <span class="info-value">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </div>


                    <div class="info-item">
                        <span class="info-label">
                            Request Date
                        </span>

                        <span class="info-value">
                            {{ $project->created_at?->format('d M Y') ?? '-' }}
                        </span>
                    </div>

                </div>

            </div>


            {{-- Notice --}}
            <div class="notice">
                <div>
                    ℹ️
                </div>

                <div>
                    আপনি শুধুমাত্র <strong>Admin Review শুরু হওয়ার আগে</strong>
                    Project Request-এর তথ্য পরিবর্তন করতে পারবেন।
                    Admin Review শুরু হয়ে গেলে এই Request আর Edit করা যাবে না।
                </div>
            </div>


            {{-- Edit Form --}}
            <form
                action="{{ route('customer.project.update', $project) }}"
                method="POST"
            >

                @csrf


                <div class="form-row">

                    {{-- Service --}}
                    <div class="form-group">

                        <label for="service_id" class="form-label">
                            Service
                            <span class="required">*</span>
                        </label>

                        <select
                            name="service_id"
                            id="service_id"
                            class="form-select @error('service_id') is-invalid @enderror"
                            required
                        >

                            <option value="">
                                -- Select Service --
                            </option>

                            @foreach($services as $service)

                                <option
                                    value="{{ $service->id }}"
                                    {{ old('service_id', $project->service_id) == $service->id ? 'selected' : '' }}
                                >
                                    {{ $service->name }}
                                </option>

                            @endforeach

                        </select>

                        @error('service_id')
                            <div class="field-error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Location --}}
                    <div class="form-group">

                        <label for="location" class="form-label">
                            Project Location
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="location"
                            id="location"
                            class="form-control"
                            value="{{ old('location', $project->location) }}"
                            placeholder="Enter project location"
                            required
                        >

                        @error('location')
                            <div class="field-error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>


                {{-- Description --}}
                <div class="form-group">

                    <label for="description" class="form-label">
                        Project Description
                        <span class="required">*</span>
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        placeholder="Describe your interior project..."
                        required
                    >{{ old('description', $project->description) }}</textarea>

                    <span class="form-help">
                        আপনার Project-এর কাজ, প্রয়োজনীয়তা, room/space এবং অন্যান্য গুরুত্বপূর্ণ তথ্য লিখুন।
                    </span>

                    @error('description')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Approximate Budget --}}
                <div class="form-group">

                    <label for="approximate_budget" class="form-label">
                        Approximate Budget
                    </label>

                    <input
                        type="number"
                        name="approximate_budget"
                        id="approximate_budget"
                        class="form-control"
                        value="{{ old('approximate_budget', $project->approximate_budget) }}"
                        placeholder="Enter your approximate budget"
                        min="0"
                        step="0.01"
                    >

                    <span class="form-help">
                        এটি আপনার দেওয়া আনুমানিক Budget। Final Budget Admin Proposal-এর মাধ্যমে নির্ধারণ করবে।
                    </span>

                    @error('approximate_budget')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Customer Note --}}
                <div class="form-group">

                    <label for="customer_note" class="form-label">
                        Additional Note
                    </label>

                    <textarea
                        name="customer_note"
                        id="customer_note"
                        class="form-control"
                        placeholder="Any additional information or special requirements..."
                    >{{ old('customer_note', $project->customer_note) }}</textarea>

                    @error('customer_note')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Start / End Date --}}
                <div class="form-row">

                    {{-- Start Date --}}
                    <div class="form-group">

                        <label for="start_date" class="form-label">
                            Expected Start Date
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            class="form-control"
                            value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                        >

                        @error('start_date')
                            <div class="field-error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- End Date --}}
                    <div class="form-group">

                        <label for="end_date" class="form-label">
                            Expected End Date
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            class="form-control"
                            value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}"
                        >

                        @error('end_date')
                            <div class="field-error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="actions">

                    <div class="btn-group">

                        <a
                            href="{{ route('customer.project.show', $project) }}"
                            class="btn btn-secondary"
                        >
                            ← Back to Project
                        </a>

                    </div>


                    <div class="btn-group">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            💾 Update Request
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

