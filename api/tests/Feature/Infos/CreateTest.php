<?php

namespace Tests\Feature\Infos;

use App\Models\Users\Info;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * Test user-infos creation endpoint
     * Positive feedback expected
     * 
     * @return void
     */
    public function testCreateInfos(): void
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . Cache::get("token_php_unit"), 'Accept' => 'application/json'])->postJson(env('APP_URL') . '/api/infos', [
            'info' => 'extra.mail@jobs.com',
            'code' => Info::INFO_EMAIL_CODE,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data"
        ]);

        $result = $response->json();
        Cache::put('info_id_php_unit', $result["data"]["id"]);
    }
}