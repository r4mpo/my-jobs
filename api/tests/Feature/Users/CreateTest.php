<?php

namespace Tests\Feature\Users;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * Test user creation endpoint
     * In this specific case, we pass valid data
     * Positive feedback expected
     * 
     * @return void
     */
    public function testCreateUsersWithValidFields(): void
    {
        $response = $this->postJson(route("api.auth.create"), [
            'name' => 'PHPUnit User 2',
            'email' => 'user_phpunit2@example.com',
            'password' => 'usertEsfww12312dat3#_!.G2',
        ]);

        Cache::put('user_php_unit', ['email' => 'user_phpunit2@example.com', 'password' => 'usertEsfww12312dat3#_!.G2']);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'data',
                'message',
                'success',
            ]);
    }


    /**
     * Test user creation endpoint
     * In this specific case, we passed invalid data
     * Negative feedback is expected
     * 
     * @return void
     */
    public function testCreateUsersWithInvalidFields(): void
    {
        $response = $this->postJson(route("api.auth.create"), [
            'name' => 'PHPUnit User',
            'email' => 'user_phpunit',
            'password' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }
}
