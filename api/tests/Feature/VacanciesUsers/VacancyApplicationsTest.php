<?php

namespace Tests\Feature\VacanciesUsers;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class VacancyApplicationsTest extends TestCase
{
    /**
     * Test search endpoint for users who have applied to a job
     * Positive feedback expected
     * 
     * @return void
     */
    public function testVacancyApplications(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Cache::get("token_php_unit"),
            'Accept' => 'application/json'
        ])->getJson(route('api.vacancies_user.vacancy_applications', ['vacancy_id' => '1']));

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data"
            ]);
    }
}
