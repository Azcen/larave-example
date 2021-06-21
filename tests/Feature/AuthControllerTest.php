<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminToken;
    protected $factory;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
      parent::setUp();

      $this->setupPermissions();

      $admin = User::factory()->create();
      $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
      $admin->assignRole('Admin');
      $user = [
        'email' => $admin->email,
        'password' => 'password',
      ];
      $this->adminToken = JWTAuth::attempt($user);
      
      $this->factory = User::factory()->make()->toArray();
    }

    protected function setupPermissions()
    {
      Permission::create(['name' => 'users.index']);
      Permission::create(['name' => 'users.store']);
      Permission::create(['name' => 'users.update']);
      Permission::create(['name' => 'users.destroy']);

      Role::create(['name' => 'Admin'])->givePermissionTo(Permission::all());
      Role::create(['name' => 'Customer'])->givePermissionTo(Permission::all());

      $this->app->make(PermissionRegistrar::class)->registerPermissions();
    }

    public function testRegisterUser() 
    {
        $this->withoutExceptionHandling();

        $factory = $this->factory;
        $factory['password'] = 'secret';
        $factory['password_confirmation'] = 'secret';

        $response = $this->withHeaders([])
            ->json(
                'POST',
                '/api/auth/register/',
                $factory
            )
            ->assertStatus(201);
        unset($factory['password']);
        unset($factory['password_confirmation']);
        unset($factory['email_verified_at']);
        $response->assertJsonStructure([
            'user' => [
                'name',
                'email',
            ],
            'token',
        ]);
    }

    public function testLoginUser() 
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->withHeaders([])
            ->json(
                'POST',
                '/api/auth/login/',
                $credentials
            )
            ->assertStatus(200);
    }

    public function testFAILLoginUser() 
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email,
            'password' => 'failTest',
        ];

        $response = $this->withHeaders([])
            ->json(
                'POST',
                '/api/auth/login/',
                $credentials
            )
            ->assertStatus(401);
    }
}
