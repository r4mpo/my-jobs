<?php

namespace Tests\Feature\Vacancies;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /**
     * Test job search endpoint
     * Positive feedback expected
     * 
     * @return void
     */
    public function testSearchVacancies(): void
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . Cache::get("token_php_unit"), 'Accept' => 'application/json'])->getJson(env('APP_URL') . '/api/vacancies', [
            'short_description' => 'Example with php unit',
            'long_description' => 'Example generated with phpunit of long descriptions',
            'wage' => '120000',
            'zip_code' => '11674771',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data",
                "pages"
            ]);
    }
}
