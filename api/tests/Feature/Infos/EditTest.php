<?php

namespace Tests\Feature\Infos;

use App\Models\Users\Info;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class EditTest extends TestCase
{
    /**
     * Test job editing endpoint
     * Positive feedback expected
     * 
     * @return void
     */
    public function testEditInfos(): void
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . Cache::get("token_php_unit"), 'Accept' => 'application/json'])->putJson(env('APP_URL') . '/api/infos/' . Cache::get('info_id_php_unit'), [
            'info' => '12994291483',
            'code' => Info::INFO_PHONE_CODE,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data"
        ]);
    }
}