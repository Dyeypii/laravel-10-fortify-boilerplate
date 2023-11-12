<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LockoutResponse;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\PasswordResetResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse;
use Laravel\Fortify\Contracts\EmailVerificationNotificationSentResponse;
use Laravel\Fortify\Contracts\PasswordConfirmedResponse;
use Laravel\Fortify\Contracts\PasswordUpdateResponse;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /* Custom Responses */
        /* Register */
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

        /* Forgot Password */
        $this->app->bind(
            SuccessfulPasswordResetLinkRequestResponse::class,
            function () {
                return new class implements SuccessfulPasswordResetLinkRequestResponse {
                    public function toResponse($request)
                    {
                        if ($request->wantsJson()) {
                            return response()->json([
                                'success' => true,
                                'message' => 'A password reset link has been emailed to you!',
                                'data' => null
                            ]);
                        }
                    }
                };
            }
        );

        /* Reset Password */
        $this->app->bind(
            PasswordResetResponse::class,
            function () {
                return new class implements PasswordResetResponse {
                    public function toResponse($request)
                    {
                        if ($request->wantsJson()) {
                            return response()->json([
                                'success' => true,
                                'message' => 'You have successfully updated your password.',
                                'data' => [
                                    'redirect_url' => route('login')
                                ],
                            ]);
                        }
                    }
                };
            }
        );

        /* Update Profile Information */
        $this->app->instance(ProfileInformationUpdatedResponse::class, new class implements ProfileInformationUpdatedResponse {
            public function toResponse($request)
            {
                $emailVerifiedAt = auth()->user()->email_verified_at;
                $verifyEmailMessage =  !$emailVerifiedAt ? ' Please verify your new email.': '';
                $redirectUrl = !$emailVerifiedAt ? route('verification.notice') : route('update-profile-information');
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'You have successfully updated your information.' . $verifyEmailMessage, 
                        'data' => [
                            'redirectUrl' => $redirectUrl
                        ],
                    ]);
                }
            }
        });

        /* Update Password */
        $this->app->instance(PasswordUpdateResponse::class, new class implements PasswordUpdateResponse {
            public function toResponse($request)
            {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'You have successfully updated your password.', 
                        'data' => null,
                    ]);
                }
            }
        });

        /* Confirm Password */
        $this->app->instance(PasswordConfirmedResponse::class, new class implements PasswordConfirmedResponse {
            public function toResponse($request)
            {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'You have successfully confirmed your password.', 
                        'data' => [
                            'redirectUrl' => $request->session()->get('url.intended')
                        ],
                    ]);
                }
            }
        });
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

        /* Views */
        /* Registration */
        Fortify::registerView(function () {
            return view('auth.register', ['title' => 'Register']);
        });

        /* Email Verification */
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        /* Login */
        Fortify::loginView(function () {
            return view('auth.login', ['title' => 'Login']);
        });

        /* Forgot Password */
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password', ['title' => 'Forgot Password']);
        });

        /* Reset Password */
        Fortify::resetPasswordView(function (Request $request) {
            return view('auth.reset-password', ['title' => 'Reset Password', 'request' => $request]);
        });

        /* Confirm Password */
        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password', ['title' => 'Confirm Password']);
        });
    }
}
