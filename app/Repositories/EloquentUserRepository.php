<?php
namespace App\Repositories;

use App\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function updatePassword(User $user, $password)
    {
        $user->update(['password' => bcrypt($password)]);
    }
}