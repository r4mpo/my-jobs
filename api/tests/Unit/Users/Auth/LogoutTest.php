<?php

namespace Tests\Unit\Users\Auth;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * Log out a logged in user
     * At this endpoint, it is necessary to pass the token
     * 
     * @return void
     */
    public function testLogout(): void
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . Cache::get("token_php_unit"), 'Accept' => 'application/json'])->postJson(route("api.auth.logout"));

        $response->assertStatus(200)
            ->assertJsonStructure([
                "message",
            ]);

        // Cache clear
        Cache::forget("token_php_unit");
        Cache::forget("user_php_unit");
        Cache::forget("vacancy_id_php_unit");
    }
}
