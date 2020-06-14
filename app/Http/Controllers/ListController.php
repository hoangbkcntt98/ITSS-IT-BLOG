<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Routing\Controller;

class ListController extends Controller
{
    public function index()
    {
        $products = Product::findAll();
        return view('list', ['products'=>$products]);
    }
}
