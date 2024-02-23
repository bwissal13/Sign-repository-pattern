<?php
namespace App\Services;

use Illuminate\Auth\Events\Verified;

class VerifyEmailService
{
    public function verify($user)
    {
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
            return true;
        }

        return false;
    }
}