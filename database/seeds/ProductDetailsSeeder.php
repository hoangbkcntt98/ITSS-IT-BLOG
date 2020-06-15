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
        $cpu = [ "Core i3","Core i5","Core i7","Core i7","Ryzen 3","Ryzen 5","Ryzen 7"];
        $ram = ['4','8','16','32'];
        $disk = ['128','256','512'];
        $size = [12,14.5,14,15.6,17];
        for($i = 0; $i < $products_count; $i++){

            DB::table('products')->insert([
                'product_name' => $fake->name,
                'image' => $fake->unique()->imageUrl(),
                'CPU' => $fake->randomElement($cpu),
                'RAM' => $fake->randomElement($ram),
                'disk' => $fake->randomElement($disk),
                'graphic_card' => $fake->text(30),
                'OS' => $fake->text(10),
                'size' => $fake->randomElement($size),
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
