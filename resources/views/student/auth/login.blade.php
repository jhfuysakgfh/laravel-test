
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Login | AI Smart Teacher</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #eaf3ff, #f5f0ff);
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1000px;
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(20, 40, 80, 0.12);
        }

        .left-panel {
            background: linear-gradient(145deg, #102a49, #2864a8);
            color: #fff;
            padding: 55px 40px;
            min-height: 570px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-panel h1 {
            font-size: 36px;
            font-weight: 700;
        }

        .left-panel p {
            color: #dceaff;
            line-height: 1.7;
        }

        .teacher-icon {
            font-size: 90px;
            margin-bottom: 20px;
        }

        .right-panel {
            padding: 55px 45px;
        }

        .brand {
            color: #102a49;
            font-size: 25px;
            font-weight: 800;
        }

        .form-control {
            padding: 13px 15px;
            border-radius: 10px;
        }

        .form-control:focus {
            border-color: #2864a8;
            box-shadow: 0 0 0 0.2rem rgba(40, 100, 168, 0.12);
        }

        .btn-login {
            background: #102a49;
            color: #fff;
            border: none;
            padding: 13px;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-login:hover {
            background: #2864a8;
            color: #fff;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
        }

        .language-text {
            color: #2864a8;
            font-weight: 600;
        }

        @media(max-width: 767px) {
            .left-panel {
                min-height: auto;
                padding: 35px 25px;
                text-align: center;
            }

            .left-panel h1 {
                font-size: 27px;
            }

            .teacher-icon {
                font-size: 55px;
            }

            .right-panel {
                padding: 35px 25px;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">
    <div class="row g-0">

        <!-- Left Side -->
        <div class="col-md-5">
            <div class="left-panel">

                <div class="teacher-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>

                <h1>Welcome to AI Smart Teacher!</h1>

                <p class="mt-3">
                    Your personal AI teacher is ready to help you
                    learn, explore and grow.
                </p>

                <div class="mt-3">
                    <p><i class="bi bi-check-circle-fill me-2"></i>
                        Learn in Hindi & English
                    </p>

                    <p><i class="bi bi-check-circle-fill me-2"></i>
                        Interactive AI Lessons
                    </p>

                    <p><i class="bi bi-check-circle-fill me-2"></i>
                        Practice and Smart Tests
                    </p>
                </div>

                <div class="mt-4 language-text text-white">
                    सीखो, समझो और आगे बढ़ो!
                </div>

            </div>
        </div>

        <!-- Right Side -->
        <div class="col-md-7">
            <div class="right-panel">

                <div class="text-center mb-4">

                    <div class="brand">
                        <i class="bi bi-stars"></i>
                        AI Smart Teacher
                    </div>

                    <h3 class="mt-4 fw-bold">Student Login</h3>

                    <p class="text-muted">
                        Sign in to continue your learning journey.
                    </p>

                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close"
                                data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('student.login.submit') }}"
                      method="POST">

                    @csrf

                    <!-- Email -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Email Address
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-envelope"></i>
                            </span>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   placeholder="Enter your email"
                                   value="{{ old('email') }}"
                                   autocomplete="username"
                                   required>
                        </div>

                    </div>

                    <!-- Password -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Password
                        </label>

                        <div class="password-wrapper">

                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   placeholder="Enter your password"
                                   autocomplete="current-password"
                                   required>

                            <i class="bi bi-eye password-toggle"
                               id="togglePassword"></i>

                        </div>

                    </div>

                    <!-- Remember Me -->
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="remember"
                                   value="1"
                                   id="remember">

                            <label class="form-check-label"
                                   for="remember">
                                Remember me
                            </label>
                        </div>

                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            class="btn btn-login w-100">

                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login to My Classroom

                    </button>

                </form>

                <div class="text-center mt-4">

                    <p class="text-muted mb-1">
                        Don't have a student account?
                    </p>

                    <a href="{{ url('/register') }}"
                       class="text-decoration-none fw-semibold">
                        Create Account
                    </a>

                </div>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        © {{ date('Y') }} AI Smart Teacher.
                        All Rights Reserved.
                    </small>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Show / Hide Password
    document.getElementById('togglePassword').addEventListener('click', function () {

        const password = document.getElementById('password');

        if (password.type === 'password') {
            password.type = 'text';
            this.classList.remove('bi-eye');
            this.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            this.classList.remove('bi-eye-slash');
            this.classList.add('bi-eye');
        }

    });
</script>

</body>
</html>
