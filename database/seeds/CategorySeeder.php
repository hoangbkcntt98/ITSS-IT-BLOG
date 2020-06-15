<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            ['name'=>'Laptop'],['name'=>'PC'],['name'=>'Tablet']
        ];
        foreach ($category as $cat) {
            DB::table('category')->insert($cat);
        }
    }
}
