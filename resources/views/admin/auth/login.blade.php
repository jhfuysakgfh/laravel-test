
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | AI Teacher</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #101638, #30236b, #5542a8);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
            color: #202544;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1050px;
            min-height: 610px;
            display: grid;
            grid-template-columns: 1fr 0.85fr;
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
        }

        /* Left section */

        .welcome-section {
            background: linear-gradient(145deg, #e9e9ff, #dce7ff);
            padding: 55px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            color: #4436a0;
            margin-bottom: 55px;
        }

        .brand span {
            color: #7864e8;
        }

        .robot {
            width: 175px;
            height: 175px;
            background: linear-gradient(145deg, #8876ff, #5142c9);
            border-radius: 45px;
            margin: 0 auto 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 95px;
            box-shadow: 0 18px 35px rgba(80, 65, 190, 0.25);
            transform: rotate(-5deg);
        }

        .welcome-section h1 {
            font-size: 32px;
            color: #24265a;
            text-align: center;
            line-height: 1.3;
            margin-bottom: 15px;
        }

        .welcome-section p {
            text-align: center;
            color: #626887;
            font-size: 15px;
            line-height: 1.8;
            max-width: 360px;
            margin: 0 auto;
        }

        .features {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 30px;
        }

        .feature {
            background: rgba(255, 255, 255, 0.8);
            color: #5142a7;
            padding: 9px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Right section */

        .form-section {
            padding: 65px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-section h2 {
            font-size: 29px;
            color: #25264b;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #85899f;
            font-size: 14px;
            margin-bottom: 35px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #424563;
            margin-bottom: 9px;
        }

        .form-group input {
            width: 100%;
            height: 50px;
            border: 1px solid #e1e3ed;
            border-radius: 10px;
            padding: 0 15px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
            color: #30334f;
        }

        .form-group input:focus {
            border-color: #7464dc;
            box-shadow: 0 0 0 3px rgba(116, 100, 220, 0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 65px;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: #7464dc;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
        }

        .login-button {
            width: 100%;
            height: 51px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(100deg, #6251d5, #8872ed);
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(98, 81, 213, 0.25);
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 7px;
        }

        .alert-error {
            background: #fff0f0;
            border: 1px solid #ffd4d4;
            color: #c62828;
            padding: 12px;
            border-radius: 9px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .footer-text {
            text-align: center;
            margin-top: 35px;
            color: #9a9db0;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                max-width: 480px;
                grid-template-columns: 1fr;
            }

            .welcome-section {
                padding: 30px 25px;
            }

            .brand {
                margin-bottom: 25px;
            }

            .robot {
                width: 110px;
                height: 110px;
                font-size: 65px;
                border-radius: 30px;
                margin-bottom: 20px;
            }

            .welcome-section h1 {
                font-size: 24px;
            }

            .form-section {
                padding: 40px 28px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- Welcome Section -->
        <div class="welcome-section">

            <div class="brand">
                AI <span>Teacher.</span>
            </div>

            <div class="robot">🤖</div>

            <h1>Welcome to the Future of Learning!</h1>

            <p>
                Manage AI-powered books, interactive lessons,
                educational content and student learning
                from one intelligent platform.
            </p>

            <div class="features">
                <div class="feature">📚 Smart Books</div>
                <div class="feature">🤖 AI Learning</div>
                <div class="feature">🎨 Interactive Lessons</div>
            </div>

        </div>

        <!-- Login Section -->
        <div class="form-section">

            <h2>Admin Login</h2>

            <p class="subtitle">
                Sign in to manage your learning platform.
            </p>

            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">

                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your admin email"
                        autocomplete="username"
                        required
                    >

                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword()"
                            id="toggleButton"
                        >
                            Show
                        </button>
                    </div>

                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="login-button">
                    Sign In to Admin Panel →
                </button>

            </form>

            <div class="footer-text">
                © {{ date('Y') }} AI Teacher. All rights reserved.
                <br><br>
                Secure Administrator Access
            </div>

        </div>

    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const button = document.getElementById('toggleButton');

            if (password.type === 'password') {
                password.type = 'text';
                button.textContent = 'Hide';
            } else {
                password.type = 'password';
                button.textContent = 'Show';
            }
        }
    </script>

</body>
</html>
