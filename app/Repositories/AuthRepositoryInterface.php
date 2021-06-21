<?php

namespace App\Repositories;

interface AuthRepositoryInterface
{
    public function authenticate($data);

    public function getAuthenticatedUser();

    public function register($data);

    public function logout();
}