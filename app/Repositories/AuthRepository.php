<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    public function authenticate($data) 
    {
        $credentials = $data->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                // return response()->json(['error' => 'invalid_credentials'], 400);
                return ['res' => ['error' => 'invalid_credentials'], 'code' => 401];
            }
        } catch (JWTException $e) {
            // return response()->json(['error' => 'could_not_create_token'], 500);
            return ['res' => ['error' => 'could_not_create_token'], 'code' => 500];
        }
        $user = Auth::user();
        return ['res' => ['token' => $token, 'user' => $user], 'code' => 200];
    }
    
    public function getAuthenticatedUser() 
    {
      try {
          if (!$user = JWTAuth::parseToken()->authenticate()) {
                // return response()->json(['user_not_found'], 404);
                return ['res' => 'user_not_found', 'code' => 404];
          }
          } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return ['res' => 'token_expired', 'code' => $e->getStatusCode()];
          } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return ['res' => 'token_invalid', 'code' => $e->getStatusCode()];
          } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                return ['res' => 'token_absent', 'code' => $e->getStatusCode()];
          }
          return ['res' => $user, 'code' => 200];
        }
    
    public function register($data)
    {
      $user = User::create([
          'name'     => $data->get('name'),
          'email'    => $data->get('email'),
          'password' => Hash::make($data->get('password')),
      ]);
      $user->assignRole('Customer');
    
      $token = JWTAuth::fromUser($user);
    
      return ['user' => $user, 'token' => $token];
    }

    public function logout()
    {
      auth()->logout();
      return ['message' => 'Successfully logged out'];
    }
}


