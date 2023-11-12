<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Contracts\EmailVerificationNotificationSentResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        /* Registration */
        Fortify::registerView(function () {
            return view('auth.register', ['title' => 'Register']);
        });

        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true, 
                        'message' => 'You have successfully created your account.', 
                        'data' => [
                            'user' => auth()->user(),
                            'redirect_url' => route('home')
                        ]
                    ], 201);
                }
            }
        });

        /* Email Verification */
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        $this->app->instance(EmailVerificationNotificationSentResponse::class, new class implements EmailVerificationNotificationSentResponse {
            public function toResponse($request)
            {

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true, 
                        'message' => 'A new email verification link has been emailed to you!', 
                        'data' => null
                    ]);
                }
            }
        });

        /* Login */
        Fortify::loginView(function () {
            return view('auth.login', ['title' => 'Login']);
        });

        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'You have successfully logged in your account.', 
                        'data' => [
                            'redirect_url' => route('home')
                        ],
                    ]);
                }
            }
        });

        /* Logout */
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'You have successfully logged out your account.', 
                        'data' => [
                            'redirect_url' => route('login')
                        ],
                    ]);
                }
            }
        });
    }
}
