<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Product;
class ListController extends Controller
{
    public function index()
    {
        $products = DB::table('product')->paginate(9);
        return view('list.index', ['products'=>$products]);
    }

    public function filter(Request $request)
    {
        $product = Product::query();
        $product->product_name($request)->price($request)->cpu($request)->ram($request);

        $products =  $product->get();
        return view('list.index', ['products' => $products]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = DB::table('product')->where('product_name', 'like', "%$query%")->paginate(9);
        return view('list.index', ['products' => $products]);
    }
}
