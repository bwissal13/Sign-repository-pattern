<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Password;

class PasswordResetService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendResetLink(array $credentials)
    {
        return Password::sendResetLink($credentials);
    }

    public function resetPassword(array $credentials, $password)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if ($user) {
            $this->userRepository->updatePassword($user, $password);
            Password::deleteToken($user);
            return true;
        }

        return false;
    }
}