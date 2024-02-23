<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function attempt(array $credentials)
    {
        return Auth::attempt($credentials);
    }
}