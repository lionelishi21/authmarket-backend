<?php

use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->truncate();
         DB::table('plans')->insert([
         	'name' => 'Basic',
        	'cost' => 1000,
            'slug' => 'basic-plan',
        	'ads_amount' => 1,
        	'duration' => 15,
        	'premium_placement' => true,
        	'alerts' => true,
        ]);
         DB::table('plans')->insert([
        	'name' => 'Dealer',
            'slug' => 'dealer-plan',
        	'cost' => 5000,
        	'ads_amount' => 6,
        	'photos_amount' => 15,
        	'duration' => 150,
        	'premium_placement' => true,
        	'alerts' => true,
        ]);
         DB::table('plans')->insert([
        	'name' => 'Premium',
            'slug' => 'premium-plan',
        	'cost' => 10000,
        	'ads_amount' => 13,
        	'photos_amount' => 100,
        	'duration' => 15,
        	'premium_placement' => true,
        	'alerts' => true,
        ]);
    }
}
