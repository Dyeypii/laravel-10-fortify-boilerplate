<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Update Profile Information</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/sass/app.scss'])
    </head>
    <body>
        <h4>Update Profile Information</h4>
        <form action="{{ route('user-profile-information.update') }}" method="post" id="updateProfileInformationForm">
            @csrf
            @method('put')
            <label for="name">Name</label>
            <input type="text" name="name">
            <label for="email">Email</label>
            <input type="email" name="email">
            <button type="submit">Submit</button>
        </form>

        @vite(['resources/ts/app.ts', 'resources/ts/common/account/update-profile-information.ts'])
    </body>
</html>
