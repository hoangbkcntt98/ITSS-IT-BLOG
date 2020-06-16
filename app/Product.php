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
        return DB::table('products')->join('brand','products.brand_id','=','brand.id')->where('products.id', $id)->get();
    }

    /**
     * Get all Articles for Product
     * @param $product_id
     */
    protected function getArticlesProduct($product_id){
        return DB::table('articles')->where('product_id', $product_id)->get();
    }

    protected function findAll(){
        return DB::table('products')->get();
    }

    public function scopeBrand_Id($query, $request)
    {
        if ($request->has('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        return $query;
    }

    public function scopeCpu($query, $request)
    {
        if ($request->has('cpu')) {
            $query->where('cpu', 'like', '%' . $request->cpu . '%');
        }

        return $query;
    }

    public function scopeRam($query, $request)
    {
        if ($request->has('ram')) {
            $query->where('ram', 'like', '%' . $request->ram . '%');
        }

        return $query;
    }

    public function scopeDisk($query, $request)
    {
        if ($request->has('disk')) {
            $query->where('disk', 'like', '%' . $request->disk . '%');
        }

        return $query;
    }

    public function scopeSize($query, $request)
    {
        if ($request->has('size')) {
            $query->where('size', 'like', '%' . $request->size . '%');
        }

        return $query;
    }
}
