<?php
namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findByEmail($email);
    public function create(array $data);
    public function updatePassword(User $user, $password);
}