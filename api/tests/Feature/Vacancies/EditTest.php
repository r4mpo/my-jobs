<?php

namespace Tests\Feature\Vacancies;

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
    public function testEditVacancies(): void
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . Cache::get("token_php_unit"), 'Accept' => 'application/json'])->putJson(env('APP_URL') . '/api/vacancies/' . Cache::get('vacancy_id_php_unit'), [
            'short_description' => 'Edited with php unit',
            'long_description' => 'Edited example generated with phpunit of long descriptions'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data"
        ]);
    }
}