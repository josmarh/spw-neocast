<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IPNProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Products::truncate();
        Products::insert([
            ['product_id' => '410003', 'name' => 'FE', 'funnel' => 'FE', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410177', 'name' => 'DFY Traffic Booster', 'funnel' => 'DFY Traffic Booster', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410179', 'name' => 'DFY Traffic Booster - DS', 'funnel' => 'DFY Traffic Booster', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410163', 'name' => 'DFY Online TV Channel Agency Setup', 'funnel' => 'DFY Online TV Channel Agency Setup', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410167', 'name' => 'DFY Online TV Channel Agency Setup - DS', 'funnel' => 'DFY Online TV Channel Agency Setup', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410159', 'name' => '10 DFY TV Channel Setup', 'funnel' => '10 DFY TV Channel Setup', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410161', 'name' => '10 DFY TV Channel Setup - DS', 'funnel' => '10 DFY TV Channel Setup', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410005', 'name' => 'Most Wanted Bundle Deal', 'funnel' => 'Bundle', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410169', 'name' => 'Unlimited Reseller License', 'funnel' => 'Reseller', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410171', 'name' => 'Unlimited Reseller License - DS', 'funnel' => 'Reseller', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410173', 'name' => '100 Reseller License', 'funnel' => 'Reseller', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410175', 'name' => '100 Reseller License - DS', 'funnel' => 'Reseller', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410151', 'name' => 'Fast-Pass Deal', 'funnel' => 'Fast-Pass Deal', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410153', 'name' => 'Fast-Pass Deal - DS', 'funnel' => 'Fast-Pass Deal', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410185', 'name' => 'Affiliate Marketing Coaching Program', 'funnel' => 'Affiliate Marketing Coaching Program', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410187', 'name' => 'Affiliate Marketing Coaching Program - DS', 'funnel' => 'Affiliate Marketing Coaching Program', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410155', 'name' => 'Unlimited Edition', 'funnel' => 'Unlimited Edition', 'created_at'=>now(),'updated_at'=>now()],
            ['product_id' => '410157', 'name' => 'Unlimited Edition - DS', 'funnel' => 'Unlimited Edition', 'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
