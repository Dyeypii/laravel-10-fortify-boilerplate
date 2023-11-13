<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Two Factor Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/sass/app.scss'])
    </head>
    <body>
        <h4>Two Factor Login</h4>
        <p>Verify Your Identity - 
            {{ !request()->use_recovery_code 
                ? 'Enter the two-factor authentication code from your app.'
                : 'Enter your recovery code.'}}
        </p>
        <form action="{{ route('two-factor.login') }}" method="post" id="twoFactorLoginForm">
            @csrf
            @if (!request()->use_recovery_code)
                <label for="code">Code</label>
                <input type="text" name="code">
            @else
                <label for="code">Recovery Code</label>
                <input type="text" name="recovery_code">
            @endif

            <button type="submit">Verify</button>
        </form>

        <div >
            @if (request()->use_recovery_code)
                <a href="{{ route('two-factor.login')}}">
                    Use code from app?</a>
            @else
                <a href="{{ route('two-factor.login') }}?use_recovery_code=true">
                    Use recovery code?</a>
            @endif
        </div>

        @vite(['resources/ts/app.ts', 'resources/ts/auth/two-factor-login.ts'])
    </body>
</html>
