<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nurse Management System</title>
</head>
<body>
    <div>
        <h2>Login</h2>

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div style="margin-top: 10px;">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div style="margin-top: 15px;">
                <button type="submit">Log in</button>
            </div>
        </form>
    </div>
</body>
</html>
