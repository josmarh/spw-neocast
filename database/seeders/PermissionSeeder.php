<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            ['name' => 'front_end', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'traffic_booster', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'agency_setup', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'channel_setup', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'bundle', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'reseller', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'fass_pass', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'affiliate_marketing', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'unlimited_edition', 'guard_name' => 'sanctum', 'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
