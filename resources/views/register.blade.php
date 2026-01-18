<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - IIUM Sports Centre</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f4; }
        .login-card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        .login-card h1 { color: #003366; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .btn-login { background-color: #003366; color: white; border: none; padding: 10px; width: 100%; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 10px; }
        .btn-login:hover { background-color: #002244; }
        .error-msg { color: red; font-size: 14px; margin-bottom: 15px; }
        .link-text { margin-top: 15px; font-size: 14px; }
    </style>
</head>
<body>

    <div class="login-card">
        <h1>Sign Up</h1>
        <p style="margin-bottom: 20px; color: gray;">Create your account</p>

        @if($errors->any())
            <div class="error-msg">
                <ul style="list-style: none; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" required placeholder="Name">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="student@gmail.com">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Create a password">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required placeholder="Repeat password">
            </div>

            <button type="submit" class="btn-login">Register</button>
        </form>

        <div class="link-text">
            Already have an account? <a href="{{ route('login') }}" style="color: #003366; font-weight: bold;">Login here</a>
        </div>
    </div>

</body>
</html>