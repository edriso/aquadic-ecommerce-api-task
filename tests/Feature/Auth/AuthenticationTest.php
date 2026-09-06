<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_and_receive_an_api_token(): void
    {
        $user = User::factory()->create();
        $user->createToken('old-token');
        $this->postJson('/api/login', ['email' => $user->email, 'password' => 'password'])
            ->assertOk()->assertJsonStructure(['data' => ['token', 'user' => ['name']]]);
        $this->assertCount(1, $user->tokens()->get());
    }

    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();
        $this->postJson('/api/login', ['email' => $user->email, 'password' => 'wrong-password'])
            ->assertUnprocessable()->assertJsonValidationErrors('email');
        $this->assertCount(0, $user->tokens()->get());
    }

    public function test_logout_revokes_the_current_api_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token');
        $this->withToken($token->plainTextToken)->postJson('/api/logout')->assertNoContent();
        $this->assertCount(0, $user->tokens()->get());
    }
}
