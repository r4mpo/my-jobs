<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'name' => 'api.vacancies.index', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.vacancies.store', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.vacancies.show', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.vacancies.update', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.vacancies.destroy', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.profiles.index', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.profiles.store', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.profiles.show', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.profiles.update', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.profiles.destroy', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.profiles.assign_role_for_user', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.infos.index', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.infos.store', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.infos.show', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.infos.update', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.infos.destroy', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.auth.login', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.auth.create', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.auth.logout', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.auth.refresh', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.auth.me', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.auth.infos', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.vacancies_user.my_published_vacancies', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.vacancies_user.my_applications_vacancies', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.vacancies_user.to_apply_or_unapply', // route name
                'guard_name' => 'api'
            ],
            [
                'name' => 'api.vacancies_user.vacancy_applications', // route name
                'guard_name' => 'api'
            ],
        ]);
    }
}