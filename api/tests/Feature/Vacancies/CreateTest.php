<?php

namespace Tests\Feature\Vacancies;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * Test job creation endpoint
     * Positive feedback expected
     * 
     * @return void
     */
    public function testCreateVacancies(): void
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . Cache::get("token_php_unit"), 'Accept' => 'application/json'])->postJson(env('APP_URL') . '/api/vacancies', [
            'short_description' => 'Example with php unit',
            'long_description' => 'Example generated with phpunit of long descriptions',
            'wage' => '120000',
            'zip_code' => '11674771',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data"
        ]);

        $result = $response->json();
        Cache::put('vacancy_id_php_unit', $result["data"]["id"]);
    }
}