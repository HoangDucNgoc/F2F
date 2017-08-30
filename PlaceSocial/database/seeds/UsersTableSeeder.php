<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $faker = \Faker\Factory::create();

        $password = Hash::make('123456');

        User::create([
        	'name' => 'Administrator',
        	'email' => 'admin@api.com',
        	'password' => $password,
        ]);

        for($i = 0; $i < 10; $i++) 
        {
        	User::create([
        		'name' => $faker->name,
        		'email' => $faker->email,
        		'password' => $password,
        	]);
        }
    }
}
