<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create($data)
    {
        $user = $this->model->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
        $user->assignRole($data->role);

        return $user; 
    }

    public function update($data, $id)
    {
        $user = $this->model->find($id);
        $user->update([
          'name' => $data->name,
          'email' => $data->email,
          'password' => Hash::make($data->password),
        ]);
        return $user;
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id)
    {
        if (null == $user = $this->model->find($id)) {
            throw new ModelNotFoundException("User not found");
        }

        return $user;
    }

    public function authenticate($data) 
    {
        $credentials = $data->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return $token;
    }
    
    public function getAuthenticatedUser() 
    {
      try {
          if (!$user = JWTAuth::parseToken()->authenticate()) {
                  return response()->json(['user_not_found'], 404);
          }
          } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                  return response()->json(['token_expired'], $e->getStatusCode());
          } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                  return response()->json(['token_invalid'], $e->getStatusCode());
          } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                  return response()->json(['token_absent'], $e->getStatusCode());
          }
          return $user;
    
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
}


