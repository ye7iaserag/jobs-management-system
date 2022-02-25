<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table('role')->insert([
            'id' => 1,
            'title' => 'Manager'
        ]);
        DB::table('role')->insert([
            'id' => 2,
            'title' => 'Regular'
        ]);

        DB::table('user')->insert([
            'id' => $faker->uuid,
            'name' => 'Manager',
            'email' => 'manager@jms.com',
            'password' => Hash::make('12345678'),
            'role' => 1
        ]);
        DB::table('user')->insert([
            'id' => $faker->uuid,
            'name' => 'Regular',
            'email' => 'regular@jms.com',
            'password' => Hash::make('12345678'),
            'role' => 2
        ]);
    }
}
