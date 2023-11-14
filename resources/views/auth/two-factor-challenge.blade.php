<!DOCTYPE html>
<html class="h-full bg-white" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Two Factor Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/sass/app.scss'])
    </head>
    <body class="h-full">
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                    alt="Your Company">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Two Factor Authentication</h2>
            </div>
    
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="{{ route('two-factor.login') }}" method="post" id="twoFactorLoginForm">
                    @csrf
                    <div>
                        
                        @if (!request()->use_recovery_code)
                            <div class="flex items-center justify-between">
                                <label for="code" class="block text-sm font-medium leading-6 text-gray-900">Code</label>
                                <div class="text-sm">
                                    <a href="{{ route('two-factor.login') }}?use_recovery_code=true" class="font-semibold text-indigo-600 hover:text-indigo-500">
                                        Use recovery code?</a>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input type="text" id="code" name="code" inputmode="numeric"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        @else
                            <div class="flex items-center justify-between">
                                <label for="code" class="block text-sm font-medium leading-6 text-gray-900">Recovery Code</label>
                                <div class="text-sm">
                                    <a href="{{ route('two-factor.login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">
                                        Use code from authenticator?</a>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input type="text" id="recovery_code" name="recovery_code" inputmode="numeric"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        @endif
                    </div>
                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Verify</button>
                    </div>
                </form>
            </div>
        </div>
        @vite(['resources/ts/app.ts', 'resources/ts/auth/two-factor-login.ts'])
    </body>
</html>
