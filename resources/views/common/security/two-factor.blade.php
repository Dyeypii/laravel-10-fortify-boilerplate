<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Two Factor</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/sass/app.scss'])
    </head>
    <body>
        <h4>Enable Two Factor Authentication</h4>
        <form action="{{ !auth()->user()->two_factor_secret ? route('two-factor.enable') : route('two-factor.disable')}}" method="post" id="enableDisableTwoFactorForm">
            @csrf
            @if (auth()->user()->two_factor_secret)
                @method('delete')
            @endif
            <button type="submit">{{ !auth()->user()->two_factor_secret ? 'Enable' : 'Disable' }}</button>
        </form>

        @if (auth()->user()->two_factor_secret && !auth()->user()->two_factor_confirmed_at)
            Please finish configuring two factor authentication.
            <p>Scan QR Code</p>
            <div id="twoFactorQRCodeDiv">
                {!! request()->user()->twoFactorQrCodeSvg() !!}
            </div>
            <div>
                <form action="{{ route('two-factor.confirm') }}" method="post" id="confirmTwoFactorForm">
                    @csrf
                    <ol>
                        <li>Open the TOTP compatible authenticator app such as Google Authenticator.</li>
                        <li>Scan the QR code.</li>
                        <li>Enter the generated code below.</li>
                    </ol>
                    <input type="text" name="code">
                    <button type="submit">Confirm Authentication Code</button>
                </form>
                
            </div>
            
        @endif
        {{ session('status')}}
        
        @if (auth()->user()->two_factor_confirmed_at)    
            <div id="recoveryCodesDiv">
                @if (session('status') == 'two-factor-authentication-confirmed')
                    @foreach (request()->user()->recoveryCodes() as $code)
                        <span>{{ $code }} </span> <br>
                    @endforeach
                @endif
            </div>
            <form action="{{ route('two-factor.recovery-codes') }}" method="post" id="regenerateRecoveryCodesForm">
                @csrf
                <button type="submit">ReGenerate Recovery Codes</button>
            </form>
        @endif

        {{ session()->forget('status') }}
        @vite(['resources/ts/app.ts', 'resources/ts/common/security/two-factor.ts'])
    </body>
</html>
