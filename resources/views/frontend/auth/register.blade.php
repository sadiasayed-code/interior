<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Registration</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.10);
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 8px;
            color: #222;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d5d9df;
            border-radius: 7px;
            font-size: 15px;
            outline: none;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #2563eb;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 10px 12px;
            border-radius: 7px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .register-btn {
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

        .register-btn:hover {
            background: #1d4ed8;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .login-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="register-container">

    <h2>Create Customer Account</h2>

    <p class="subtitle">
        Register to manage your interior projects
    </p>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('customer.register.submit') }}" method="POST">

        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">Full Name</label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter your full name"
                required
            >

            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>


        <!-- Email -->
        <div class="form-group">
            <label for="email">Email Address</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                required
            >

            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>


        <!-- Phone -->
        <div class="form-group">
            <label for="phone">Phone Number</label>

            <input
                type="text"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="Enter your phone number"
                required
            >

            @error('phone')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>


        <!-- Address -->
        <div class="form-group">
            <label for="address">Address</label>

            <textarea
                id="address"
                name="address"
                placeholder="Enter your address"
            >{{ old('address') }}</textarea>

            @error('address')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>


        <!-- Password -->
        <div class="form-group">
            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Create a password"
                required
            >

            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>


        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Confirm your password"
                required
            >
        </div>


        <button type="submit" class="register-btn">
            Create Account
        </button>

    </form>


    <div class="login-link">
        Already have an account?
        <a href="{{ route('customer.login') }}">
            Login here
        </a>
    </div>

</div>

</body>
</html>