<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome - Student Management System</title>

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
            background: linear-gradient(135deg, #f0f1f2 0%, #ffffff 100%);
            letter-spacing: 1px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 460px;
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

        .auth-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #e0e1e2;
        }

        .auth-tab {
            flex: 1;
            padding: 1rem;
            background: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #919aa1;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: -2px;
        }

        .auth-tab.active {
            color: #1a1a1a;
            border-bottom-color: #1a1a1a;
        }

        .auth-tab:hover {
            color: #1a1a1a;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .form-group {
            margin-bottom: 1.25rem;
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

        .link {
            color: #1a1a1a;
            text-decoration: underline;
            font-size: 0.875rem;
            transition: color 0.15s ease-in-out;
        }

        .link:hover {
            color: #151515;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #f7dddc;
            border: 1px solid #f0bab9;
            color: #572120;
            font-size: 0.875rem;
        }

        .alert-success {
            background-color: #dbf2e3;
            border-color: #b7e5c7;
            color: #1e4c2e;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <h1>Welcome</h1>
                <p>Log In/Register</p>
            </div>

            <!-- Tabs -->
            <div class="auth-tabs">
                <button class="auth-tab active" onclick="switchTab('login')">Login</button>
                <button class="auth-tab" onclick="switchTab('register')">Register</button>
            </div>

            <!-- Login Tab -->
            <div id="login-tab" class="tab-content active">
                @if ($errors->any() && !old('name'))
                    <div class="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="login-email" class="form-label">Email Address</label>
                        <input
                            type="email"
                            class="form-control"
                            id="login-email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                            required
                            autofocus
                            autocomplete="username"
                        >
                    </div>

                    <div class="form-group">
                        <label for="login-password" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="login-password"
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
                    @endif
                </div>
            </div>

            <!-- Register Tab -->
            <div id="register-tab" class="tab-content">
                @if ($errors->any() && old('name'))
                    <div class="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="role" value="student">
                    
                    <div class="form-group">
                        <label for="register-name" class="form-label">Full Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="register-name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Your full name"
                            required
                            autocomplete="name"
                        >
                    </div>

                    <div class="form-group">
                        <label for="register-email" class="form-label">Email Address</label>
                        <input
                            type="email"
                            class="form-control"
                            id="register-email"
                            name="email"
                            value="{{ old('email', old('name') ? old('email') : '') }}"
                            placeholder="you@example.com"
                            required
                            autocomplete="username"
                        >
                    </div>

                    <div class="form-group">
                        <label for="register-password" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="register-password"
                            name="password"
                            placeholder="Create a password (min 8 characters)"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    <div class="form-group">
                        <label for="register-password-confirmation" class="form-label">Confirm Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="register-password-confirmation"
                            name="password_confirmation"
                            placeholder="Re-enter your password"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    <button type="submit" class="btn mt-3">Create Account</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Remove active class from all tabs and content
            document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            
            // Add active class to selected tab
            if (tab === 'login') {
                document.querySelectorAll('.auth-tab')[0].classList.add('active');
                document.getElementById('login-tab').classList.add('active');
            } else {
                document.querySelectorAll('.auth-tab')[1].classList.add('active');
                document.getElementById('register-tab').classList.add('active');
            }
        }

        // Auto-switch to register tab if there are registration errors or old name exists
        @if(old('name'))
            switchTab('register');
        @endif

        // Hide error alerts on input
        const loginEmail = document.getElementById('login-email');
        const loginPassword = document.getElementById('login-password');
        const registerName = document.getElementById('register-name');
        const registerEmail = document.getElementById('register-email');
        const registerPassword = document.getElementById('register-password');
        const registerPasswordConfirmation = document.getElementById('register-password-confirmation');

        function hideAlerts() {
            document.querySelectorAll('.alert:not(.alert-success)').forEach(alert => {
                alert.style.display = 'none';
            });
        }

        [loginEmail, loginPassword, registerName, registerEmail, registerPassword, registerPasswordConfirmation].forEach(input => {
            if (input) {
                input.addEventListener('input', hideAlerts);
            }
        });
    </script>
</body>
</html>