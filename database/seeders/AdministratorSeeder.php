<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan user admin

        $administrator = new \App\Models\User;
        $administrator->name = "Admin";
        $administrator->email = "admin@gmail.com";
        $administrator->password = \Hash::make("admin");
        $administrator->level = "admin";
        
        
        $administrator->save();
        $this->command->info("User Admin berhasil diinsert");


    }
}
