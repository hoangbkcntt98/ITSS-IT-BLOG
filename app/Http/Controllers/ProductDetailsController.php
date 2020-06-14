<?php
namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProductDetailsController extends Controller {
    public function index(){
        $product_first = DB::table('product')->get();
        $product_article = Product::getArticlesProduct($product_first->get(0)->id);
        $users = User::all();
        return view('product-details.index', ['products'=>$product_first, 'articles'=>$product_article, 'users'=>$users]);
    }

    public function show($id){
        $product = Product::findProductById($id);
        $product_article = Product::getArticlesProduct($id);
        $users = User::all();
        return view('product-details.index', ['products'=>$product, 'articles'=>$product_article, 'users'=>$users]);
    }
}
