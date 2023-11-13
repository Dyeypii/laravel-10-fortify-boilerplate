<?php
namespace App\Actions\Fortify;

use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;

class CustomRedirectIfTwoFactorAuthenticatable extends RedirectIfTwoFactorAuthenticatable
{
    protected function twoFactorChallengeResponse($request, $user)
    {
        $request->session()->put([
            'login.id' => $user->getKey(),
            'login.remember' => $request->boolean('remember'),
        ]);

        TwoFactorAuthenticationChallenged::dispatch($user);

        return $request->wantsJson()
                    ? response()->json([
                        'success' => true, 
                        'data' => [
                            'two_factor' => true,
                            'redirect_url' => route('two-factor.login')
                        ]
                    ])
                    : redirect()->route('two-factor.login');
    }
}