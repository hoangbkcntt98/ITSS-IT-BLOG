<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $fake = \Faker\Factory::create();
        $users_count = 25;
        for($i = 0; $i < $users_count; $i++) {
            DB::table('users')->insert([
                'name' => $fake->name,
                'email' => $fake->unique()->email,
                'password' => $fake->text(255),
                'phone' => $fake->phoneNumber,
                // 'about' => $fake->text(255),
                'is_admin' => $fake->boolean,
                'remember_token' => $fake->text(100),
                'created_at' => $fake->dateTime,
                'updated_at' => $fake->dateTime
            ]);
        }
    }
}
