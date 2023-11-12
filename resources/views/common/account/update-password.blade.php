<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Update Password</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/sass/app.scss'])
    </head>
    <body>
        <h4>Update Password</h4>
        <form action="{{ route('user-password.update') }}" method="post" id="updatePasswordForm">
            @csrf
            @method('put')
            <label for="current_password">Current Password</label>
            <input type="password" name="current_password">
            <label for="password">New Password</label>
            <input type="password" name="password">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation">
            <button type="submit">Submit</button>
        </form>

        @vite(['resources/ts/app.ts', 'resources/ts/common/account/update-password.ts'])
    </body>
</html>
