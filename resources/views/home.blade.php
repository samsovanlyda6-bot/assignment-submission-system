<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Assignment System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; }
        .container { max-width: 1200px; margin: 50px auto; padding: 20px; }
        .header { background: #4CAF50; color: white; padding: 20px; border-radius: 10px; text-align: center; }
        .content { margin-top: 30px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { margin-bottom: 20px; }
        .links { margin-top: 20px; }
        .links a { margin: 0 10px; text-decoration: none; color: #4CAF50; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome {{ Auth::user()->full_name ?? 'Guest' }}!</h1>
            <p>Assignment Submission System</p>
        </div>
        <div class="content">
            <h2>Dashboard</h2>
            <p>You are logged in to the Assignment Submission System.</p>
            <div class="links">
                <a href="{{ route('dashboard') }}">Go to Dashboard</a>
                <a href="{{ route('profile.index') }}">My Profile</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</body>
</html>
