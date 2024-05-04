<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Spatie\Permission\Models\Role::create(['name'=>'superadmin']);
        \Spatie\Permission\Models\Role::create(['name'=>'admin']);
        \Spatie\Permission\Models\Role::create(['name'=>'superdistributor']);
        \Spatie\Permission\Models\Role::create(['name'=>'distributor']);
        \Spatie\Permission\Models\Role::create(['name'=>'retailer']);
        \Spatie\Permission\Models\Role::create(['name'=>'user']);
        \Spatie\Permission\Models\Role::create(['name'=>'businessmanager']);
        \Spatie\Permission\Models\Role::create(['name'=>'agentmanager']);
        \Spatie\Permission\Models\Role::create(['name'=>'agentuser']);
    }
}
