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
         	'name' => 'Starter',
        	'cost' => 'free',
            'slug' => 'basic-plan',
        	'ads_amount' => 1,
        	'duration' => 15,
        	'premium_placement' => true,
        	'alerts' => true,
        ]);
          DB::table('plans')->insert([
            'name' => 'Basic',
            'cost' => 800,
            'slug' => 'basic-plan',
            'ads_amount' => 2,
            'duration' => 15,
            'premium_placement' => true,
            'alerts' => true,
        ]);
         DB::table('plans')->insert([
        	'name' => 'Dealer',
            'slug' => 'dealer-plan',
        	'cost' => 600,
        	'ads_amount' => 5,
        	'photos_amount' => 15,
        	'duration' => 15,
        	'premium_placement' => true,
        	'alerts' => true,
        ]);
         DB::table('plans')->insert([
        	'name' => 'Premium',
            'slug' => 'premium-plan',
        	'cost' => 400,
        	'ads_amount' => 10,
        	'photos_amount' => 100,
        	'duration' => 15,
        	'premium_placement' => true,
        	'alerts' => true,
        ]);
    }
}
