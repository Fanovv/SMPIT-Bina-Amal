<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Aultan',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345'), // password
                'level' => "admin",
            ],
            [
                'name' => 'Fanov',
                'email' => 'wali@gmail.com',
                'password' => bcrypt('12345'), // password
                'level' => "wali",
            ],
            [
                'name' => 'Inong',
                'email' => 'tu@gmail.com',
                'password' => bcrypt('12345'), // password
                'level' => "tu",
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
