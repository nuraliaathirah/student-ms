<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bs-blue: #007bff;
            --bs-indigo: #6610f2;
            --bs-purple: #6f42c1;
            --bs-pink: #e83e8c;
            --bs-red: #d9534f;
            --bs-orange: #fd7e14;
            --bs-yellow: #f0ad4e;
            --bs-green: #4bbf73;
            --bs-teal: #20c997;
            --bs-cyan: #1f9bcf;
            --bs-white: #fff;
            --bs-gray: #919aa1;
            --bs-gray-dark: #343a40;
            --bs-primary: #1a1a1a;
            --bs-secondary: #fff;
            --bs-success: #4bbf73;
            --bs-light: #f0f1f2;
            --bs-dark: #343a40;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 1rem;
            font-weight: 300;
            line-height: 1.5;
            color: #55595c;
            background-color: #fff;
            letter-spacing: 1px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            background-color: #fff;
            border: 1px solid #e0e1e2;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            padding: 2.5rem 2rem;
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 0.5rem;
        }

        .logo p {
            font-size: 0.875rem;
            color: #919aa1;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #55595c;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 300;
            line-height: 1.5;
            color: #55595c;
            background-color: #f0f1f2;
            border: 1px solid #e0e1e2;
            border-radius: 0;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            color: #55595c;
            background-color: #f0f1f2;
            border-color: #8d8d8d;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(26, 26, 26, 0.25);
        }

        .form-control::placeholder {
            color: rgba(85, 89, 92, 0.5);
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .form-check-input {
            width: 1em;
            height: 1em;
            margin-top: 0;
            margin-right: 0.5rem;
            background-color: #f0f1f2;
            border: 1px solid #e0e1e2;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #1a1a1a;
            border-color: #1a1a1a;
        }

        .form-check-label {
            font-size: 0.875rem;
            color: #55595c;
            cursor: pointer;
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 0.75rem 1.5rem;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1.5rem;
            color: #fff;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
            background-color: #1a1a1a;
            border: 1px solid #1a1a1a;
            cursor: pointer;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn:hover {
            background-color: #000;
            border-color: #000;
        }

        .btn:focus {
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(26, 26, 26, 0.5);
        }

        .text-center {
            text-align: center;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e1e2;
        }

        .divider span {
            padding: 0 1rem;
            font-size: 0.875rem;
            color: #919aa1;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .link {
            color: #1a1a1a;
            text-decoration: underline;
            font-size: 0.875rem;
            transition: color 0.15s ease-in-out;
        }

        .link:hover {
            color: #151515;
        }

        .social-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn-outline {
            background-color: transparent;
            color: #1a1a1a;
            border: 2px solid #1a1a1a;
            padding: 0.5rem 1rem;
        }

        .btn-outline:hover {
            background-color: #1a1a1a;
            color: #fff;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #f7dddc;
            border: 1px solid #f0bab9;
            color: #572120;
            font-size: 0.875rem;
            display: none;
        }

        .alert.show {
            display: block;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
            }

            .social-buttons {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <h1>Welcome Back</h1>
                <p>Log in</p>
            </div>

            <div id="errorAlert" class="alert {{ $errors->any() ? 'show' : '' }}">
                @if ($errors->any())
                    {{ $errors->first() }}
                @else
                    Invalid email or password
                @endif
            </div>

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn mt-3">Log In</button>
            </form>

            <div class="text-center mt-3">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link">Forgot your password?</a>
                @else
                    <a href="#" class="link">Forgot your password?</a>
                @endif
            </div>

            <div class="divider">
                <span>Or continue with</span>
            </div>

            <div class="social-buttons">
                <button type="button" class="btn btn-outline">Google</button>
                <button type="button" class="btn btn-outline">GitHub</button>
            </div>

            <div class="text-center mt-4">
                <span style="font-size: 0.875rem; color: #55595c;">Don't have an account? </span>
                <a href="{{ route('register') }}" class="link">Sign up</a>
            </div>
        </div>
    </div>

    <script>
        const errorAlert = document.getElementById('errorAlert');

        document.getElementById('email').addEventListener('input', () => {
            errorAlert.classList.remove('show');
        });
        document.getElementById('password').addEventListener('input', () => {
            errorAlert.classList.remove('show');
        });    
        
    </script>
</body>
</html>