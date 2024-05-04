<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SuperadminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            "name" => "Superadmin",
            "email" => "superadmin@gmail.com",
            "password" => bcrypt("123456")
        ]);
        $user->assignRole("superadmin");
    }
}
