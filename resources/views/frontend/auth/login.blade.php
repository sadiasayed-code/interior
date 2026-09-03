<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Login</title>

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

        .login-container {
            width: 100%;
            max-width: 430px;

            background: #ffffff;

            padding: 35px;

            border-radius: 12px;

            box-shadow:
                0 5px 25px rgba(0, 0, 0, 0.10);
        }

        .login-container h2 {
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

        .form-group input {
            width: 100%;

            padding: 12px 13px;

            border: 1px solid #d5d9df;

            border-radius: 7px;

            font-size: 15px;

            outline: none;
        }

        .form-group input:focus {
            border-color: #2563eb;
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

        .login-btn {
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

        .login-btn:hover {
            background: #1d4ed8;
        }

        .register-link {
            text-align: center;

            margin-top: 20px;

            font-size: 14px;

            color: #666;
        }

        .register-link a {
            color: #2563eb;

            text-decoration: none;

            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="login-container">

    <h2>Customer Login</h2>

    <p class="subtitle">
        Login to manage your interior projects
    </p>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    {{-- Login Form --}}
    <form action="{{ route('customer.login.submit') }}" method="POST">

        @csrf


        {{-- Email --}}
        <div class="form-group">

            <label for="email">
                Email Address
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                required
            >

            @error('email')

                <div class="error">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Password --}}
        <div class="form-group">

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >

            @error('password')

                <div class="error">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <button
            type="submit"
            class="login-btn"
        >
            Login
        </button>

    </form>


    <div class="register-link">

        Don't have an account?

        <a href="{{ route('customer.register') }}">
            Create Account
        </a>

    </div>

</div>

</body>
</html>