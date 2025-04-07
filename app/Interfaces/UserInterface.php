<?php

namespace App\Interfaces;

interface UserInterface
{
    public function register(array $credentials);

    public function login(array $credentials);

    public function logout(int $userId);

    public function updateUserProfile(int $userId, array $data);
}
