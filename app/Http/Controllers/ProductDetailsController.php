<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductDetailsController extends Controller
{
    public function index()
    {
        $user = null;
        if (Auth::check()) {
            $id = Auth::id();
            $user = User::findOrFail($id);
        }
        $product_first = DB::table('products')->get();
        $product_article = Product::getArticlesProduct($product_first->get(0)->id);
        $list_articles = DB::select(DB::raw("SELECT users.name, tb1.* FROM users INNER JOIN
                                    (SELECT articles.user_id, articles.title, articles.created_at, articles.updated_at FROM articles
                                    INNER JOIN products ON products.id = articles.product_id WHERE products.id = :value ) AS tb1
                                    ON users.id = tb1.user_id"), array("value"=>$product_first->get(0)->id));
        return view('product-details.index', ['products' => $product_first, 'articles' => $product_article, 'list_articles' => $list_articles, 'user' => $user]);
    }

    public function show($id)
    {
        $user = null;
        if (Auth::check()) {
            $id_a = Auth::id();
            $user = User::findOrFail($id_a);
        }
        $product = Product::findProductById($id);
        $product_article = Product::getArticlesProduct($id);
        $list_articles = DB::select(DB::raw("SELECT users.name, tb1.* FROM users INNER JOIN
                                    (SELECT articles.user_id, articles.id, articles.title, articles.created_at, articles.updated_at FROM articles
                                    INNER JOIN products ON products.id = articles.product_id WHERE products.id = :value ) AS tb1
                                    ON users.id = tb1.user_id"), array("value"=>$id));
//        dd($list_articles);
        return view('product-details.index', ['products' => $product, 'articles' => $product_article, 'list_articles' => $list_articles, 'user' => $user]);
    }

    public function edit($id)
    {
        $product = Product::findProductById($id);
        $product_article = Product::getArticlesProduct($id);
        $list_articles = DB::select(DB::raw("SELECT users.name, tb1.* FROM users INNER JOIN
                                    (SELECT articles.user_id, articles.id, articles.title, articles.created_at, articles.updated_at FROM articles
                                    INNER JOIN products ON products.id = articles.product_id WHERE products.id = :value ) AS tb1
                                    ON users.id = tb1.user_id"), array("value"=>$id));
        return view('product-details.edit', ['products' => $product, 'articles' => $product_article, 'list_articles' => $list_articles]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->product_name = $request->input('name');
        $product->price = $request->input('price');
        $product->cpu = $request->input('cpu');
        $product->ram = $request->input('ram');
        $product->disk = $request->input('disk');
        $product->graphic_card = $request->input('graphic_card');
        $product->os = $request->input('os');
        $product->size = $request->input('size');
        $product->save();
        return redirect()->route('show_product_details', ['id' => $id]);
    }

    public function rate(Request $request)
    {
        $data = $request->all();
        $productID = $data['prod_id'];
        $rate = $data['rate'];
        $product = Product::findOrFail($productID);
        $product->stars_rate = ($product->stars_rate * $product->count_rates + $rate) / ($product->count_rates + 1);
        $product->stars_rate = round($product->stars_rate, 2);
        $product->count_rates = $product->count_rates + 1;
        $product->save();
        return $product;
    }
}
