<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        DB::table('users')->insert([
            'username' => 'User1',
            'name' => 'John Doe',
            'email' => 'user1@email.com',
            'password' => bcrypt('password'),
        ]);
    }
}
