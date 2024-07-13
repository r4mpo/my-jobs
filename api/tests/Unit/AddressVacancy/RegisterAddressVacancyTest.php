<?php

namespace Tests\Unit\AddressVacancy;

use App\Http\Controllers\Vacancies\VacanciesController;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class RegisterAddressVacancyTest extends TestCase
{
    /**
     * Test create or get data by zip code
     * 
     * @return void
     */
    public function testRegisterAddressVacancy(): void
    {
        $vacancyController = new VacanciesController;
        $response = $vacancyController->registerAddressVacancy('14300148');

        $this->assertIsArray($response);
        $this->assertCount(13, $response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals('SP', $response['uf']);
        $this->assertContains('14300148', $response);
    }
}
