<?php

namespace Tests\Feature\VacanciesUsers;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ToApplyOrUnapplyTest extends TestCase
{
    /**
     * Test endpoint to apply to a vacancy
     * Positive feedback expected
     * 
     * @return void
     */
    public function testToApply(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Cache::get("token_php_unit"),
            'Accept' => 'application/json'
        ])->getJson(route('api.vacancies_user.to_apply_or_unapply', [
            'vacancy_id' => '1', // we tested with the first vacancy created by the seeds
            'action' => 'attach'
        ]));

        $response->assertStatus(200)
            ->assertJson([
                'user PHPUnit User 2 applied to Institutional website development'
            ]);
    }

    /**
     * Test endpoint to disapply to a vacancy
     * Positive feedback expected
     * 
     * @return void
     */
    public function testToUnapply(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Cache::get("token_php_unit"),
            'Accept' => 'application/json'
        ])->getJson(route('api.vacancies_user.to_apply_or_unapply', [
            'vacancy_id' => '1', // we tested with the first vacancy created by the seeds
            'action' => 'detach'
        ]));

        $response->assertStatus(200)
            ->assertJson([
                'user PHPUnit User 2 disappointed to Institutional website development'
            ]);
    }
}
