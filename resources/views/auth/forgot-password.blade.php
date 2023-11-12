<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Forgot Password</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/sass/app.scss'])
    </head>
    <body>
        <h4>Forgot Password</h4>
        <form action="{{ route('password.email') }}" method="post" id="forgotPasswordForm">
            @csrf
            <input type="email" name="email">
            <button type="submit">Submit</button>
        </form>

        @vite(['resources/ts/app.ts', 'resources/ts/auth/forgot-password.ts'])
    </body>
</html>
