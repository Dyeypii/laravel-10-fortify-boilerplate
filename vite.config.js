import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', 
                'resources/ts/app.ts',
                'resources/ts/auth/register.ts',
                'resources/ts/auth/login.ts',
                'resources/ts/auth/verify-email.ts',
                'resources/ts/auth/forgot-password.ts',
                'resources/ts/auth/reset-password.ts',
                'resources/ts/common/account/update-profile-information.ts',
                'resources/ts/common/account/update-password.ts',
            ],
            refresh: true,
        }),
    ],
});
