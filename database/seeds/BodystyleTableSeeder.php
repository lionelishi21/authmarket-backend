<?php

use Illuminate\Database\Seeder;

class BodystyleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bodystyles')->truncate(); 
        DB::table('bodystyles')->insert([
        	'name' =>  'Hatchback',
        ]);
        DB::table('bodystyles')->insert([
        	'name' =>  'SUV',
        ]);
        DB::table('bodystyles')->insert([
        	'name' =>  'Mini Van',
        ]);
        DB::table('bodystyles')->insert([
        	'name' =>  'Van',
        ]);
        DB::table('bodystyles')->insert([
        	'name' =>  'Truck',
        ]);
        DB::table('bodystyles')->insert([
        	'name' =>  'Wagon',
        ]);
        DB::table('bodystyles')->insert([
        	'name' =>  'Coupe',
        ]);
        DB::table('bodystyles')->insert([
        	'name' =>  'Bus',
        ]);
        DB::table('bodystyles')->insert([
        	'name' =>  'Mini',
        ]);
        DB::table('bodystyles')->insert([
        	'name' =>  'Pickup',
        ]);
         DB::table('bodystyles')->insert([
        	'name' =>  'Convertible',
        ]);
        DB::table('bodystyles')->insert([
        	'name' =>  'Motorcycle',
        ]);
        DB::table('bodystyles')->insert([
        	'name' =>  'Commercial',
        ]);
    }
}
