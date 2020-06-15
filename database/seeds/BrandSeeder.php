<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            ['name'=>'ACER'],['name'=>'APPLE'],['name'=>'ASUS'],['name'=>'DELL'],['name'=>'HP'],['name'=>'LENOVO']
        ];
        foreach ($brands as $brand) {
            DB::table('brand')->insert($brand);
        }
    }
}
