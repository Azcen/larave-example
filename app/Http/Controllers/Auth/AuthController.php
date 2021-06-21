<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AuthRepositoryInterface;


class AuthController extends Controller
{
    /** @var AuthRepositoryInterface */
    private $repository;

    public function __construct(AuthRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function authenticate(Request $request)
    {
        $response = $this->repository->authenticate($request);
        return response()->json($response['res'], $response['code']);
    }

    public function getAuthenticatedUser()
    {
        $response = $this->repository->authenticate($request);
        return response()->json($response['res'], $response['code']);
    }


    public function register(Request $request)
    {
        return response()->json($this->repository->register($request), 201);
    }

    public function logout()
    {
        return response()->json($this->repository->logout(), 200);
    }
}
