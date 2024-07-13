<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Erick',
                'email' => 'erick@myjobs.com',
                'password' => bcrypt('erick123'),
            ],
            [
                'id' => 2,
                'name' => 'Eduardo',
                'email' => 'eduardo@myjobs.com',
                'password' => bcrypt('eduardo123'),
            ],
            [
                'id' => 3,
                'name' => 'Giovana',
                'email' => 'giovana@myjobs.com',
                'password' => bcrypt('giovana123'),
            ],
            [
                'id' => 4,
                'name' => 'User phpunit',
                'email' => 'user_phpunit@example.com',
                'password' => bcrypt('usertEsfww12312dat3#_!.G'),
            ]
        ]);

        $users = User::whereIn('id', [1, 2, 3, 4])->get();

        foreach ($users as $user) {
            $user->assignRole('default');
        }
    }
}
