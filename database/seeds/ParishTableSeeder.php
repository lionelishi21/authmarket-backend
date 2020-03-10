<?php

use Illuminate\Database\Seeder;

class ParishTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parishes')->truncate();
        DB::table('parishes')->insert([
        	'name' => 'St. Andrew',
        ]);
        DB::table('parishes')->insert([
        	'name' => 'Kingston',
        ]);
        DB::table('parishes')->insert([
        	'name' => 'St. Thomas'
        ]);
        DB::table('parishes')->insert([
            'name' => 'St. Catherine'
        ]); 
        DB::table('parishes')->insert([
            'name' => 'St. Mary'
        ]);   
         DB::table('parishes')->insert([
            'name' => 'St. Ann'
        ]); 
        DB::table('parishes')->insert([
            'name' => 'Manchester'
        ]); 
        DB::table('parishes')->insert([
            'name' => 'Clarendon'
        ]); 
        DB::table('parishes')->insert([
            'name' => 'Hanover'
        ]); 
        DB::table('parishes')->insert([
            'name' => 'Westmoreland'
        ]); 
        DB::table('parishes')->insert([
           'name' => 'St. James'
        ]); 
        DB::table('parishes')->insert([
            'name' => 'Trelawny'
        ]); 
        DB::table('parishes')->insert([
            'name' => 'St. Elizabeth'
        ]); 
    }
}
