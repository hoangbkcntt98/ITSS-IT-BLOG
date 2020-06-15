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
            ['name'=>'ASUS'],['name'=>'DELL'],['name'=>'APPLE'],['name'=>'HP'],['name'=>'LENOVO']
        ];
        foreach ($brands as $brand) {
            DB::table('brand')->insert($brand);
        }
    }
}
