<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $brands = DB::table('brand')->get()->pluck('id')->toArray();
        $categories = DB::table('category')->get()->pluck('id')->toArray();
        for($i = 0; $i < $products_count; $i++){
            DB::table('products')->insert([
                'product_name' => $fake->name,
                'image' => $fake->unique()->imageUrl(),
                'CPU' => $fake->text(20),
                'RAM' => $fake->text(20),
                'disk' => $fake->text(25),
                'graphic_card' => $fake->text(30),
                'OS' => $fake->text(10),
                'size' => $fake->numberBetween(0,60),
                'price' => $fake->numberBetween(1000, 5000),
                'created_at' => $fake->dateTime,
                'updated_at' => $fake->dateTime,
                //add brand and category
                'brand_id' => $fake->randomElement($brands),
                'category_id' =>$fake->randomElement($categories)
            ]);
        }
    }
}
