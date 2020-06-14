<?php

use App\Product;
use App\User;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
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
        $articles_count = 30;
        $users = User::all()->pluck('id')->toArray();
        $products = Product::findAll()->pluck('id')->toArray();
        for($i = 0; $i < $articles_count; $i++){
            DB::table('articles')->insert([
                'user_id' => $fake->randomElement($users),
                'product_id' => $fake->randomElement($products),
                'title' => $fake->text(20),
                'description' => $fake->text(255),
                'content' => $fake->text(255),
                'published' => $fake->boolean,
                'published_at' => $fake->dateTime,
                'image' => $fake->imageUrl(),
                'deleted_at' => $fake->dateTime,
                'created_at' => $fake->dateTime,
                'updated_at' => $fake->dateTime
            ]);
        }
    }
}
