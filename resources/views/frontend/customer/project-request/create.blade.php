<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        New Project Request
    </title>


    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #222;
        }


        /* =========================
           Navbar
        ========================= */

        .navbar {
            background: #1f2937;
            color: white;

            padding: 16px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }


        .navbar h2 {
            font-size: 20px;
        }


        .back-btn {
            color: white;
            text-decoration: none;

            background: #374151;

            padding: 8px 14px;

            border-radius: 6px;

            font-size: 14px;
        }


        .back-btn:hover {
            background: #4b5563;
        }


        /* =========================
           Container
        ========================= */

        .container {
            max-width: 750px;

            margin: 40px auto;

            padding: 0 20px;
        }


        /* =========================
           Card
        ========================= */

        .card {
            background: white;

            padding: 30px;

            border-radius: 12px;

            box-shadow:
                0 3px 18px rgba(
                    0,
                    0,
                    0,
                    0.08
                );
        }


        .card h1 {
            font-size: 25px;

            margin-bottom: 8px;
        }


        .description {
            color: #777;

            margin-bottom: 25px;

            font-size: 14px;

            line-height: 1.6;
        }


        /* =========================
           Customer Info
        ========================= */

        .customer-info {
            background: #f8fafc;

            padding: 15px;

            border-radius: 8px;

            margin-bottom: 25px;
        }


        .customer-info strong {
            display: block;

            margin-bottom: 5px;

            color: #555;

            font-size: 13px;
        }


        .customer-info span {
            font-size: 14px;

            color: #222;
        }


        /* =========================
           Form
        ========================= */

        .form-group {
            margin-bottom: 20px;
        }


        .form-group label {
            display: block;

            margin-bottom: 7px;

            font-weight: 600;

            color: #333;
        }


        .form-group input {
            width: 100%;

            padding: 12px 13px;

            border: 1px solid #d5d9df;

            border-radius: 7px;

            font-size: 15px;

            outline: none;
        }


        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #2563eb;
        }

        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d5d9df;
            border-radius: 7px;
            font-size: 15px;
            outline: none;
            font-family: inherit;
            background: white;
        }

        .form-group textarea {
            min-height: 110px;
            resize: vertical;
        }


        .help-text {
            margin-top: 5px;

            color: #888;

            font-size: 12px;
        }


        /* =========================
           Error
        ========================= */

        .error {
            color: #dc2626;

            font-size: 13px;

            margin-top: 5px;
        }


        /* =========================
           Submit Button
        ========================= */

        .submit-btn {
            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 7px;

            background: #2563eb;

            color: white;

            font-size: 16px;

            font-weight: 600;

            cursor: pointer;
        }


        .submit-btn:hover {
            background: #1d4ed8;
        }


        /* =========================
           Notice
        ========================= */

        .notice {
            margin-top: 18px;

            padding: 12px 15px;

            background: #eff6ff;

            color: #1e40af;

            border-radius: 7px;

            font-size: 13px;

            line-height: 1.5;
        }


        /* =========================
           Responsive
        ========================= */

        @media (
            max-width: 600px
        ) {

            .navbar {
                padding: 15px;

                gap: 10px;
            }


            .navbar h2 {
                font-size: 16px;
            }


            .container {
                margin-top: 20px;

                padding: 0 12px;
            }


            .card {
                padding: 22px 18px;
            }


            .card h1 {
                font-size: 22px;
            }

        }

    </style>

</head>


<body>


<!-- =========================
     Navbar
========================= -->

<div class="navbar">

    <h2>
        Interior Project Management System
    </h2>


    <a
        href="{{ route('customer.dashboard') }}"
        class="back-btn"
    >
        ← Dashboard
    </a>

</div>



<!-- =========================
     Main Container
========================= -->

<div class="container">


    <div class="card">


        <!-- =========================
             Heading
        ========================= -->

        <h1>
            Request a New Project
        </h1>


        <p class="description">

            Submit your interior project details below.
            Our admin team will review your request and
            prepare a project proposal for you.

        </p>



        <!-- =========================
             Customer Information
        ========================= -->

        <div class="customer-info">


            <strong>
                Customer
            </strong>


            <span>
                {{ $client->name }}
            </span>


            <br>


            <strong
                style="margin-top: 10px;"
            >
                Phone
            </strong>


            <span>
                {{ $client->phone }}
            </span>


        </div>



        <!-- =========================
             Project Request Form
        ========================= -->

        <form
            action="{{ route('customer.project-request.store') }}"
            method="POST"
        >

            @csrf



            <!-- =========================
                 Service
            ========================= -->

            <div class="form-group">

                <label for="service_id">
                    Interior Service
                </label>

                <select id="service_id" name="service_id" required>
                    <option value="">-- Select a Service --</option>

                    @foreach($services as $service)
                        <option
                            value="{{ $service->id }}"
                            {{ old('service_id', optional($selectedService)->id) == $service->id ? 'selected' : '' }}
                        >
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>

                @error('service_id')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>





            <!-- =========================
                 Location
            ========================= -->

            <div class="form-group">

                <label
                    for="location"
                >
                    Project Location
                </label>


                <input
                    type="text"
                    id="location"
                    name="location"
                    value="{{ old('location') }}"
                    placeholder="Enter project location"
                    required
                >


                @error('location')

                    <div class="error">

                        {{ $message }}

                    </div>

                @enderror

            </div>



            <!-- =========================
                 Project Description
            ========================= -->

            <div class="form-group">

                <label for="description">
                    Project Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Describe your interior project requirements..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- =========================
                 Approximate Budget
            ========================= -->

            <div class="form-group">

                <label for="approximate_budget">
                    Approximate Budget
                </label>

                <input
                    type="number"
                    id="approximate_budget"
                    name="approximate_budget"
                    value="{{ old('approximate_budget') }}"
                    placeholder="Example: 500000"
                    min="0"
                    step="0.01"
                >

                <div class="help-text">
                    Optional. Enter your approximate budget in BDT.
                </div>

                @error('approximate_budget')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- =========================
                 Customer Note
            ========================= -->

            <div class="form-group">

                <label for="customer_note">
                    Additional Note
                </label>

                <textarea
                    id="customer_note"
                    name="customer_note"
                    placeholder="Any additional requirements or notes..."
                >{{ old('customer_note') }}</textarea>

                @error('customer_note')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- =========================
                 Start Date
            ========================= -->

            <div class="form-group">

                <label
                    for="start_date"
                >
                    Expected Start Date
                </label>


                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    value="{{ old('start_date') }}"
                    min="{{ now()->format('Y-m-d') }}"
                    required
                >


                <div class="help-text">

                    Past dates cannot be selected.

                </div>


                @error('start_date')

                    <div class="error">

                        {{ $message }}

                    </div>

                @enderror

            </div>



            <!-- =========================
                 End Date
            ========================= -->

            <div class="form-group">

                <label
                    for="end_date"
                >
                    Expected End Date
                </label>


                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    value="{{ old('end_date') }}"
                    min="{{ old(
                        'start_date',
                        now()->format('Y-m-d')
                    ) }}"
                >


                <div class="help-text">

                    Optional.
                    End date cannot be earlier than
                    the expected start date.

                </div>


                @error('end_date')

                    <div class="error">

                        {{ $message }}

                    </div>

                @enderror

            </div>



            <!-- =========================
                 Submit Button
            ========================= -->

            <button
                type="submit"
                class="submit-btn"
            >

                Submit Project Request

            </button>


        </form>



        <!-- =========================
             Notice
        ========================= -->

        <div class="notice">

            <strong>
                Note:
            </strong>

            Your project request will first be reviewed by
            the administrator. After review, the final budget,
            project steps and payment plan will be prepared
            and sent to your dashboard for approval.

        </div>


    </div>


</div>



<!-- =========================
     Date Validation JavaScript
========================= -->

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {


            /*
            |--------------------------------------------------------------------------
            | ELEMENTS
            |--------------------------------------------------------------------------
            */

            const startDate =
                document.getElementById(
                    'start_date'
                );


            const endDate =
                document.getElementById(
                    'end_date'
                );


            /*
            |--------------------------------------------------------------------------
            | GET TODAY DATE
            |--------------------------------------------------------------------------
            */

            const today =
                new Date();


            today.setHours(
                0,
                0,
                0,
                0
            );


            /*
            |--------------------------------------------------------------------------
            | FORMAT TODAY
            |--------------------------------------------------------------------------
            */

            const year =
                today.getFullYear();


            const month =
                String(
                    today.getMonth() + 1
                ).padStart(
                    2,
                    '0'
                );


            const day =
                String(
                    today.getDate()
                ).padStart(
                    2,
                    '0'
                );


            const formattedToday =
                `${year}-${month}-${day}`;


            /*
            |--------------------------------------------------------------------------
            | START DATE MINIMUM
            |--------------------------------------------------------------------------
            |
            | Prevent selecting any date before today.
            |
            */

            startDate.min =
                formattedToday;



            /*
            |--------------------------------------------------------------------------
            | UPDATE END DATE MINIMUM
            |--------------------------------------------------------------------------
            */

            function updateEndDateMinimum() {


                /*
                |--------------------------------------------------------------------------
                | SELECTED START DATE
                |--------------------------------------------------------------------------
                */

                const selectedStartDate =
                    startDate.value;


                /*
                |--------------------------------------------------------------------------
                | SET END DATE MINIMUM
                |--------------------------------------------------------------------------
                */

                if (
                    selectedStartDate
                ) {

                    endDate.min =
                        selectedStartDate;

                } else {

                    endDate.min =
                        formattedToday;

                }



                /*
                |--------------------------------------------------------------------------
                | REMOVE INVALID END DATE
                |--------------------------------------------------------------------------
                */

                if (
                    endDate.value &&
                    endDate.value <
                    endDate.min
                ) {

                    endDate.value =
                        '';

                }

            }



            /*
            |--------------------------------------------------------------------------
            | START DATE CHANGE EVENT
            |--------------------------------------------------------------------------
            */

            startDate.addEventListener(
                'change',
                function () {

                    updateEndDateMinimum();

                }
            );



            /*
            |--------------------------------------------------------------------------
            | INITIAL LOAD
            |--------------------------------------------------------------------------
            */

            updateEndDateMinimum();


        }
    );

</script>


</body>

</html>