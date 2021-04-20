<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::table('roles')->insert([
        	'id' => 1,
        	'name' => 'buyer',
        ]);
        DB::table('roles')->insert([
        	'id' => 2,
        	'name' => 'dealer',
        ]);
        DB::table('roles')->insert([
        	'id' => 3,
        	'name' => 'rep',
        ]);
         DB::table('roles')->insert([
            'id' => 4,
            'name' => 'admin',
        ]);
    }
}
