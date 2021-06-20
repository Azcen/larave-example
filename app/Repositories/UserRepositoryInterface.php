<?php

namespace App\Repositories;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function authenticate($data);

    public function getAuthenticatedUser();

    public function register($data);
}