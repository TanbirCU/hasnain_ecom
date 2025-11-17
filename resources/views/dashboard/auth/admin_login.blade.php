<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: #fff;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            max-width: 420px;
            width: 100%;
        }

        .login-card h3 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: bold;
            color: #1e3c72;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-login {
            background-color: #1e3c72;
            color: #fff;
            font-weight: 500;
            border-radius: 0.5rem;
        }

        .btn-login:hover {
            background-color: #163366;
        }

        .logo {
            text-align: center;
            margin-bottom: 1rem;
        }

        .logo img {
            width: 80px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo">
            <!-- Optional Logo -->
            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828479.png" alt="Admin Logo">
        </div>
        <h3>Admin Login</h3>
         @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif


        <form method="POST" action="{{ route('admin.login_store') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-login">Login</button>
            </div>

            <div class="text-center">
                <a href="#" class="text-decoration-none text-muted">Forgot Password?</a>
            </div>
        </form>
    </div>

</body>
</html>
