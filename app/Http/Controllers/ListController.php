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
        $products = DB::table('products')->orderBy('products.id')->paginate(12);
        return view('list.index', ['products'=>$products]);
    }

    public function filter(Request $request)
    {
        // $product = Product::query()
        //     ->brand_id($request)
        //     ->cpu($request)
        //     ->ram($request)
        //     ->disk($request)
        //     ->size($request);
        $brand_id = $request->input('brand_id');
        $cpu= $request->input('cpu');
        $ram= $request->input('ram');
        $disk= $request->input('disk');
        $size= $request->input('size');
        $product = Product::query();
        if($brand_id!=null){
            $product = $product->brand_id($request);
        }
        if($cpu!=null){
            $product = $product->cpu($request);
        }
        if($ram!=null){
            $product = $product->ram($request);
        }
        if($disk!=null){
            $product = $product->disk($request);
        }
        if($size!=null){
            $product = $product->size($request);
        }
        
        $products =  $product->paginate(12);

        return view('list.index', ['products' => $products]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = DB::table('products')->where('product_name', 'like', "%$query%")->paginate(12);
        return view('list.index', ['products' => $products]);
    }

    function auto_complete(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = DB::table('products')
        ->where('product_name', 'LIKE', "%{$query}%")
        ->limit('5')
        ->get();
      $output = '<ul class="dropdown-menu suggest-list" style="display:block; position:absolute">';
      foreach($data as $row)
      {
       $output .= '
       <li><a href="/product-details/'.$row->id.'"><img src="'.$row->image.'" alt="product">'.$row->product_name.'</a></li>
       ';
      }
      $output .= '</ul>';
      return $output;
     }
    }
}
