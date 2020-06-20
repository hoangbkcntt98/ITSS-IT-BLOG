<?php
namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductDetailsController extends Controller {
    public function index(){
        $user = null;
        if(Auth::check()) {
            $id = Auth::id();
            $user = User::findOrFail($id);
        }
        $product_first = DB::table('products')->get();
        $product_article = Product::getArticlesProduct($product_first->get(0)->id);
        $users = User::all();
        return view('product-details.index', ['products'=>$product_first, 'articles'=>$product_article, 'users'=>$users, 'user' => $user]);
    }

    public function show($id){
        $user = null;
        if(Auth::check()) {
            $id_a = Auth::id();
            $user = User::findOrFail($id_a);
        }
        $product = Product::findProductById($id);
        $product_article = Product::getArticlesProduct($id);
        $users = User::all();
        return view('product-details.index', ['products'=>$product, 'articles'=>$product_article, 'users'=>$users, 'user'=>$user]);
    }

    public function edit($id) {
        $product = Product::findProductById($id);
        $product_article = Product::getArticlesProduct($id);
        $users = User::all();
        return view('product-details.edit', ['products'=>$product, 'articles'=>$product_article, 'users'=>$users]);
    }

    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        $product->product_name = $request->input('name');
        $product->price = $request->input('price');
        $product->cpu = $request->input('cpu');
        $product->ram = $request->input('ram');
        $product->disk = $request->input('disk');
        $product->graphic_card = $request->input('graphic_card');
        $product->os = $request->input('os');
        $product->size= $request->input('size');
        $product->save();
        return redirect()->route('show_product_details', ['id' => $id]);
    }

    public function rate(Request $request){
        $data = $request->all();
        $productID = $data['prod_id'];
        $rate = $data['rate'];
        $product = Product::findOrFail($productID);
        $product->stars_rate = ($product->stars_rate * $product->count_rates + $rate)/($product->count_rates+1);

        $product->count_rates = $product->count_rates+1;
        $product->save();
        return $product;
    }
}
