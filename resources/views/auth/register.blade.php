<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Register</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/sass/app.scss'])
    </head>
    <body>
        <h4>Register</h4>
        <form action="{{ route('register') }}" method="post" id="registerForm">
            @csrf
            <input type="text" name="name" value="{{ fake()->name() }}">
            <input type="email" name="email">
            <input type="password" name="password" value="password">
            <input type="password" name="password_confirmation" value="password">
            <button type="submit">Submit</button>
        </form>

        @vite(['resources/ts/app.ts', 'resources/ts/auth/register.ts'])
    </body>
</html>
