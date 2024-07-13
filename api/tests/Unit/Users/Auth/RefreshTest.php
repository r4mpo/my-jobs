<?php

namespace Tests\Unit\Users\Auth;

use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class RefreshTest extends TestCase
{
    /**
     * Recreates a logged in user's token
     * At this endpoint, it is necessary to pass the token
     * 
     * @return void
     */
    public function testRefresh(): void
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . Cache::get("token_php_unit"), 'Accept' => 'application/json'])->postJson(route("api.auth.refresh"));

        $response->assertStatus(200)
            ->assertJsonStructure([
                "access_token",
                "token_type",
                "expires_in"
            ]);

        $result = $response->json();
        Cache::put('token_php_unit', $result["access_token"]);
    }
}
