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
            'slug' => 'starter-plan',
        	'cost' => 'free',
        	'ads_amount' => 1,
        	'photos_amount' => 5,
        	'duration' => 20,
        	'premium_placement' => false,
        	'alerts' => false,
        ]);
         DB::table('plans')->insert([
         	'name' => 'Basic',
        	'cost' => 1000,
            'slug' => 'basic-plan',
        	'ads_amount' => 5,
        	'photos_amount' => 15,
        	'duration' => 30,
        	'premium_placement' => true,
        	'alerts' => false,
        ]);
         DB::table('plans')->insert([
        	'name' => 'Dealer',
            'slug' => 'dealer-plan',
        	'cost' => 5000,
        	'ads_amount' => 5,
        	'photos_amount' => 15,
        	'duration' => 30,
        	'premium_placement' => true,
        	'alerts' => false,
        ]);
         DB::table('plans')->insert([
        	'name' => 'Premium Deails',
            'slug' => 'premium-dealer-plan',
        	'cost' => 10000,
        	'ads_amount' => 100,
        	'photos_amount' => 100,
        	'duration' => 30,
        	'premium_placement' => true,
        	'alerts' => false,
        ]);
    }
}
