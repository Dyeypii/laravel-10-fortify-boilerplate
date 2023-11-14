<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Two Factor</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/sass/app.scss'])
</head>

<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto">
            <div class="space-y-12">
                <div class="pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Two Factor Authentication</h2>
                    <div class="mt-3 flex items-center">
                        <form
                            action="{{ !auth()->user()->two_factor_secret ? route('two-factor.enable') : route('two-factor.disable') }}"
                            method="post" id="enableDisableTwoFactorForm">
                            @csrf
                            @if (auth()->user()->two_factor_secret)
                                @method('delete')
                            @endif
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ !auth()->user()->two_factor_secret ? 'Enable' : 'Disable' }}</button>
                        </form>
                    </div>

                    @if (auth()->user()->two_factor_secret && !auth()->user()->two_factor_confirmed_at)
                        <div class="mt-3 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-12">
                                <h3 class="text-base font-semibold leading-7 text-gray-900">Please finish configuring
                                    two factor authentication.</h3>
                                <p>Scan QR Code</p>
                                <div id="twoFactorQRCodeDiv">
                                    {!! request()->user()->twoFactorQrCodeSvg() !!}
                                </div>
                                <div>
                                    <form action="{{ route('two-factor.confirm') }}" method="post"
                                        id="confirmTwoFactorForm">
                                        @csrf
                                        <ol>
                                            <li>Open the TOTP compatible authenticator app such as Google Authenticator.
                                            </li>
                                            <li>Scan the QR code.</li>
                                            <li>Enter the generated code below.</li>
                                        </ol>
                                        <div class="mt-2">
                                            <input type="text" id="code" name="code"
                                                inputmode="numeric"
                                                class="rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <button type="submit"
                                                class="rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                Confirm Authentication Code</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->two_factor_confirmed_at)
                        <div id="recoveryCodesDiv" class="mt-3 border-t">
                            @if (session('status') == 'two-factor-authentication-confirmed')
                                <p>Please store these recovery codes in a secure location.</p>
                                @foreach (request()->user()->recoveryCodes() as $code)
                                    <span>{{ $code }} </span> <br>
                                @endforeach
                            @endif
                        </div>
                        <form class="mt-3" action="{{ route('two-factor.recovery-codes') }}" method="post"
                            id="regenerateRecoveryCodesForm">
                            @csrf
                            <button type="submit"
                                                class="rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                New Recovery Codes</button>
                        </form>
                    @endif

                    {{ session()->forget('status') }}
                </div>
            </div>
        </div>
    </div>

    {{-- <h4>Enable Two Factor Authentication</h4>
    <form action="{{ !auth()->user()->two_factor_secret ? route('two-factor.enable') : route('two-factor.disable') }}"
        method="post" id="enableDisableTwoFactorForm">
        @csrf
        @if (auth()->user()->two_factor_secret)
            @method('delete')
        @endif
        <button type="submit">{{ !auth()->user()->two_factor_secret ? 'Enable' : 'Disable' }}</button>
    </form> --}}

    {{-- @if (auth()->user()->two_factor_secret && !auth()->user()->two_factor_confirmed_at)
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
    @endif --}}

    {{-- @if (auth()->user()->two_factor_confirmed_at)
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

    {{ session()->forget('status') }} --}}
    @vite(['resources/ts/app.ts', 'resources/ts/common/security/two-factor.ts'])
</body>

</html>
