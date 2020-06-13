<?php

use Illuminate\Database\Seeder;

class ProductDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = \Faker\Factory::create();
        $products_count = 25;

        for($i = 0; $i < $products_count; $i++){
            DB::table('product')->insert([
                'name' => $fake->name,
                'image' => $fake->unique()->imageUrl(),
                'CPU' => $fake->text(20),
                'RAM' => $fake->text(20),
                'disk' => $fake->text(25),
                'graphic_card' => $fake->text(30),
                'OS' => $fake->text(10),
                'size' => $fake->numberBetween(0,60),
                'price' => $fake->numberBetween(1000, 5000),
                'created_at' => $fake->dateTime,
                'updated_at' => $fake->dateTime
            ]);
        }
    }
}
