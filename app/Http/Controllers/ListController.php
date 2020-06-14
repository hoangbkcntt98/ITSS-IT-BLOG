<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
class ListController extends Controller
{
    public function index()
    {
        $products = DB::table('product')->paginate(9);
        return view('list.index', ['products'=>$products]);
    }
}
