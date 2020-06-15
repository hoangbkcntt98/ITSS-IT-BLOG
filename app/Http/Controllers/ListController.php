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
        $products = DB::table('products')->paginate(12);
        return view('list.index', ['products'=>$products]);
    }

    public function filter(Request $request)
    {
        $product = Product::query()
            ->brand_id($request)
            ->cpu($request)
            ->ram($request)
            ->disk($request)
            ->size($request);
        $products =  $product->paginate(12);
        return view('list.index', ['products' => $products]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = DB::table('products')->where('product_name', 'like', "%$query%")->paginate(12);
        return view('list.index', ['products' => $products]);
    }
}
