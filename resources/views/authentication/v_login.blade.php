<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ env('APP_NAME') }} | Login Weddora
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #4e73df, #224abe);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .logo-sekolah {
            width: 80px;
        }

        .form-control {
            height: 45px;
        }

        .btn-login {
            height: 45px;
            font-weight: 600;
        }

        .footer-text {
            font-size: 13px;
            color: #777;
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="card login-card mx-auto p-4">
            @if (session('success'))
            <div class="alert alert-success">
                <strong>Berhasil</strong>, {{ session('success') }}
            </div>
            @elseif (session('error'))
            <div class="alert alert-danger">
                <strong>Gagal</strong>, {{ session('error') }}
            </div>
            @endif

            <div class="text-center mb-4">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" class="logo-sekolah mb-3">
                <h4 class="fw-bold">Web Weddora</h4>
                <p class="text-muted">Silakan login untuk melanjutkan</p>
            </div>

            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username"
                        placeholder="Masukkan username">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                        placeholder="Masukkan password">
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-login">
                        LOGIN
                    </button>
                </div>
            </form>

            <div class="text-center">
                <a href="#" class="text-decoration-none">Lupa password?</a>
            </div>

            <hr>

            <div class="text-center footer-text">
                © 2026 Weddora
            </div>
        </div>
    </div>

</body>

</html>
