<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reset Password</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/sass/app.scss'])
    </head>
    <body>
        <h4>Reset Password</h4>
        <form action="{{ route('password.update') }}" method="post" id="resetPasswordForm">
            @csrf
            <input type="text" name="token" value="{{ $request->token }}">
            <input type="email" name="email" value="{{ $request->email }}" readonly>
            <input type="password" name="password" value="password">
            <input type="password" name="password_confirmation" value="password">
            <button type="submit">Submit</button>
        </form>

        @vite(['resources/ts/app.ts', 'resources/ts/auth/reset-password.ts'])
    </body>
</html>
