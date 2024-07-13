<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VacanciesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vacancies')->insert([
            [
                'short_description' => 'Institutional website development',
                'long_description' => 'We need a developer to create a responsive institutional website using HTML, CSS and JavaScript. Must be delivered within 2 weeks.',
                'wage' => 1500,
                'zip_code' => '12345678',
                'user_id' => 1,
            ],
            [
                'short_description' => 'Logo design for company',
                'long_description' => 'We are looking for a graphic designer to create a modern and creative logo for our technology company. Preferably with experience in Adobe Illustrator.',
                'wage' => 500,
                'zip_code' => '87654321',
                'user_id' => 2,
            ],
            [
                'short_description' => 'Writing an article about digital marketing',
                'long_description' => 'We need an experienced writer to write a blog article on digital marketing strategies. The article must be at least 1000 words long and optimized for SEO.',
                'wage' => 300,
                'zip_code' => '56789012',
                'user_id' => 3,
            ],
            [
                'short_description' => 'Waiter for wedding event',
                'long_description' => 'We need a waiter to serve drinks and appetizers during a wedding event for 50 people. Previous experience in similar events is preferable.',
                'wage' => 200,
                'zip_code' => '13579024',
                'user_id' => 1,
            ],
            [
                'short_description' => 'Night shift caregiver for the elderly',
                'long_description' => 'We are looking for an elderly caregiver to care for a patient overnight. The candidate must be patient, responsible and have experience in caring for the elderly.',
                'wage' => 250,
                'zip_code' => '98765432',
                'user_id' => 2,
            ],
            // Add more vacancies as needed
        ]);
    }
}
