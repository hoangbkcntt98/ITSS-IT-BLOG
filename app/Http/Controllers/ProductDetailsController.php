<?php
namespace App\Http\Controllers;

use App\Product;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProductDetailsController extends Controller {
    public function index(){
        $product_first = DB::table('product')->get();
        $product_article = Product::getArticlesProduct($product_first->get(0)->id);
        return view('product-details.index', ['products'=>$product_first, 'articles'=>$product_article]);
    }

    public function show($id){
        $product = Product::findProductById($id);
        $product_article = Product::getArticlesProduct($id);
        return view('product-details.index', ['products'=>$product, 'articles'=>$product_article]);
    }
}
