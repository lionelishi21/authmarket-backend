<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VehicleTablesSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PlanTableSeeder::class);
        $this->call(BodystyleTableSeeder::class);
        $this->call(ParishTableSeeder::class);
        $this->call(RoleTableSeeder::class);
    }
}
