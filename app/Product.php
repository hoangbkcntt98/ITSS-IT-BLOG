<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model {
    /**
     * Find Product By Id
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    protected function findProductById($id) {
        return DB::table('product')->where('id', $id)->get();
    }

    /**
     * Get all Articles for Product
     * @param $product_id
     */
    protected function getArticlesProduct($product_id){
        return DB::table('articles')->where('product_id', $product_id)->get();
    }

    protected function findAll(){
        return DB::table('product')->get();
    }

    public function scopeName($query, $request)
    {
        if ($request->has('product_name')) {
            $query->where('product_name', 'LIKE', '%' . $request->product_name . '%');
        }

        return $query;
    }

    public function scopeCpu($query, $request)
    {
        if ($request->has('cpu')) {
            $query->where('cpu', $request->cpu);
        }

        return $query;
    }

    public function scopeRam($query, $request)
    {
        if ($request->has('ram')) {
            $query->where('ram', $request->ram);
        }

        return $query;
    }

    public function scopePrice($query, $request)
    {
        if ($request->has('price')) {
            $query->where('price', $request->price);
        }

        return $query;
    }
}
