<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Assignment System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .content {
            padding: 30px;
        }
        
        .section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        
        .section h3 {
            margin-bottom: 15px;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        input:focus {
            outline: none;
            border-color: #4CAF50;
        }
        
        button {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        
        button:hover {
            background: #45a049;
        }
        
        .btn-danger {
            background: #f44336;
        }
        
        .btn-danger:hover {
            background: #da190b;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .info-text {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        
        .nav-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .nav-links a {
            color: #4CAF50;
            text-decoration: none;
            margin: 0 10px;
        }
        
        .nav-links a:hover {
            text-decoration: underline;
        }
        
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>My Profile</h1>
            <p>Manage your account information</p>
        </div>
        
        <div class="content">
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            
            <!-- Profile Information Section -->
            <div class="section">
                <h3>Profile Information</h3>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                    
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" value="{{ $user->role->role_name ?? 'N/A' }}" disabled>
                        <div class="info-text">Role cannot be changed</div>
                    </div>
                    
                    <button type="submit">Update Profile</button>
                </form>
            </div>
            
            <!-- Password Update Section -->
            <div class="section">
                <h3>Change Password</h3>
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" required>
                        <div class="info-text">Minimum 8 characters</div>
                    </div>
                    
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation" required>
                    </div>
                    
                    <button type="submit">Change Password</button>
                </form>
            </div>
            
            <!-- Account Statistics Section -->
            <div class="section">
                <h3>Account Statistics</h3>
                <div class="row">
                    <div class="form-group">
                        <label>Member Since</label>
                        <input type="text" value="{{ $user->created_at->format('F d, Y') }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Account Status</label>
                        <input type="text" value="{{ ucfirst($user->status) }}" disabled>
                    </div>
                </div>
                
                @if($user->role_id == 3) {{-- Student --}}
                <div class="row">
                    <div class="form-group">
                        <label>Enrolled Courses</label>
                        <input type="text" value="{{ $user->enrollments->count() }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Submissions Made</label>
                        <input type="text" value="{{ $user->submissions->count() }}" disabled>
                    </div>
                </div>
                @elseif($user->role_id == 2) {{-- Teacher --}}
                <div class="row">
                    <div class="form-group">
                        <label>Courses Created</label>
                        <input type="text" value="{{ $user->createdCourses->count() }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Assignments Created</label>
                        <input type="text" value="{{ $user->createdAssignments->count() }}" disabled>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="nav-links">
                <a href="{{ url('/dashboard') }}">← Back to Dashboard</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </div>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</body>
</html>