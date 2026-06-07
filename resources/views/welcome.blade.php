<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Submission System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 50px;
            max-width: 800px;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        p {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.2em;
        }

        .buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #4CAF50;
            color: white;
        }

        .btn-primary:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #2196F3;
            color: white;
        }

        .btn-secondary:hover {
            background: #0b7dda;
            transform: translateY(-2px);
        }

        .features {
            margin-top: 50px;
            text-align: left;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .feature {
            padding: 15px;
            background: #f5f5f5;
            border-radius: 10px;
        }

        .feature h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .feature p {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 0;
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
                margin: 20px;
            }

            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 Assignment Submission System</h1>
        <p>A complete platform for managing assignments, submissions, and grades</p>

        <div class="buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                @endauth
            @endif
        </div>

        <div class="features">
            <div class="feature">
                <h3>👨‍🏫 For Teachers</h3>
                <p>Create courses, manage assignments, grade submissions, and provide feedback to students.</p>
            </div>
            <div class="feature">
                <h3>👨‍🎓 For Students</h3>
                <p>Submit assignments, track grades, receive feedback, and manage your coursework.</p>
            </div>
            <div class="feature">
                <h3>👑 For Admins</h3>
                <p>Manage users, roles, courses, and generate comprehensive reports.</p>
            </div>
        </div>
    </div>
</body>
</html>
