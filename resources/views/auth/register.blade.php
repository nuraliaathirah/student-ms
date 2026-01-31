<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        * { margin: 0; padding: 0; box-sizing: border-box; }

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

        .login-container { width: 100%; max-width: 480px; }

        .login-card {
            background-color: #fff;
            border: 1px solid #e0e1e2;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            padding: 2.5rem 2rem;
        }

        .logo { text-align: center; margin-bottom: 2rem; }

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

        .form-group { margin-bottom: 1.25rem; }

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

        .form-control::placeholder { color: rgba(85, 89, 92, 0.5); }

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

        .btn:hover { background-color: #000; border-color: #000; }

        .btn:focus { outline: 0; box-shadow: 0 0 0 0.25rem rgba(26, 26, 26, 0.5); }

        .text-center { text-align: center; }
        .mt-3 { margin-top: 1rem; }
        .mt-4 { margin-top: 1.5rem; }

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

        .link:hover { color: #151515; }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid;
            font-size: 0.875rem;
            display: none;
        }

        .alert.show { display: block; }

        .alert-danger {
            background-color: #f7dddc;
            border-color: #f0bab9;
            color: #572120;
        }

        .alert-info {
            background-color: #d9edf7;
            border-color: #bce8f1;
            color: #31708f;
        }

        /* ✅ Password Requirements Info Box */
        .requirements-box {
            background-color: #e8f4fd;
            border: 1px solid #b8daff;
            padding: 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.8125rem;
        }

        .requirements-box .title {
            font-weight: 600;
            color: #004085;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .requirements-box ul {
            margin: 0;
            padding-left: 1.25rem;
            color: #004085;
        }

        .requirements-box li {
            margin-bottom: 0.25rem;
        }

        .helper-text {
            font-size: 0.75rem;
            color: #919aa1;
            margin-top: 0.25rem;
        }

        .form-control.error {
            border-color: #d9534f;
        }

        @media (max-width: 576px) {
            .login-card { padding: 2rem 1.5rem; }
            .login-container { max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <h1>Create Account</h1>
                <p>Sign up to get started</p>
            </div>

            {{-- Error Alert --}}
            <div id="errorAlert" class="alert alert-danger {{ $errors->any() ? 'show' : '' }}">
                @if ($errors->any())
                    <ul style="margin: 0; padding-left: 1.25rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @else
                    Please check your input.
                @endif
            </div>

            {{-- Registration Form --}}
            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Hidden role field - defaults to student --}}
                <input type="hidden" name="role" value="student">

                {{-- Full Name --}}
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input
                        type="text"
                        class="form-control {{ $errors->has('name') ? 'error' : '' }}"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Your full name"
                        required
                        autocomplete="name"
                        autofocus
                    >
                </div>

                {{-- Email Address --}}
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        type="email"
                        class="form-control {{ $errors->has('email') ? 'error' : '' }}"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required
                        autocomplete="username"
                    >
                </div>

                {{-- ✅ FUNCTION e) Password Requirements Info --}}
                <div class="requirements-box">
                    <div class="title">✅ Password Requirements:</div>
                    <ul>
                        <li>At least 8 characters long</li>
                        <li>Contains uppercase and lowercase letters</li>
                        <li>Contains at least one number</li>
                        <li>Contains at least one symbol (!@#$%^&*)</li>
                    </ul>
                </div>

                {{-- ✅ FUNCTION e) Password (First Field) --}}
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        class="form-control {{ $errors->has('password') ? 'error' : '' }}"
                        id="password"
                        name="password"
                        placeholder="Create a strong password"
                        required
                        autocomplete="new-password"
                    >
                </div>

                {{-- ✅ FUNCTION e) Confirm Password (Second Field - Double Check) --}}
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input
                        type="password"
                        class="form-control {{ $errors->has('password_confirmation') ? 'error' : '' }}"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Re-enter your password"
                        required
                        autocomplete="new-password"
                    >
                    <div class="helper-text">⚠️ Please re-enter your password to confirm</div>
                </div>

                <button type="submit" class="btn mt-3">Sign Up</button>
            </form>

            {{-- ✅ FUNCTION b) Email Verification Notice --}}
            <div class="alert alert-info show" style="margin-top: 1rem;">
                By registering, you will receive an email verification link. Please verify your email to activate your account.
            </div>

            <div class="divider">
                <span>Already have an account?</span>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="link">Back to Login</a>
            </div>
        </div>
    </div>

    <script>
        const errorAlert = document.getElementById('errorAlert');
        ['name','email','password','password_confirmation'].forEach((id) => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', () => {
                    errorAlert.classList.remove('show');
                    el.classList.remove('error');
                });
            }
        });

        // ✅ Client-side password match validation
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        
        passwordConfirmation.addEventListener('input', function() {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.style.borderColor = '#d9534f';
            } else {
                passwordConfirmation.style.borderColor = '#4bbf73';
            }
        });
    </script>
</body>
</html>