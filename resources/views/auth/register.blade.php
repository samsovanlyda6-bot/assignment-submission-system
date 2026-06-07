<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Assignment System</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Arial,sans-serif;background:#f0f2f5;display:flex;justify-content:center;align-items:center;min-height:100vh}
        .register-container{background:white;padding:40px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1);width:100%;max-width:500px}
        h2{text-align:center;margin-bottom:30px;color:#333}
        .form-group{margin-bottom:15px}
        label{display:block;margin-bottom:5px;color:#666}
        input, select{width:100%;padding:10px;border:1px solid #ddd;border-radius:5px;font-size:16px}
        button{width:100%;padding:12px;background:#4CAF50;color:white;border:none;border-radius:5px;font-size:16px;cursor:pointer}
        button:hover{background:#45a049}
        .error{color:red;font-size:12px;margin-top:5px}
        .login-link{text-align:center;margin-top:20px}
        .login-link a{color:#4CAF50;text-decoration:none}
        .alert-danger{background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-bottom:20px}
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register as Student</h2>
        
        @if($errors->any())
            <div class="alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" required autofocus>
                @error('full_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required>
                @error('username')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Phone Number (Optional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
            
            <button type="submit">Register</button>
        </form>
        
        <div class="login-link">
            <a href="{{ route('login') }}">Already have an account? Login here</a>
        </div>
    </div>
</body>
</html>