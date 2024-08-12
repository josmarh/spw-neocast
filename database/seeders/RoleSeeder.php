<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'DFY Traffic Booster', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'DFY Online TV Channel Agency Setup', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => '10 DFY TV Channel Setup', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Reseller', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Fast-Pass Deal', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Affiliate Marketing Coaching Program', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Unlimited Edition', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
