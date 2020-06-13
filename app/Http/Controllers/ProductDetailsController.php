<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class ProductDetailsController extends Controller {
    public function index(){
        return view('product-details.index');
    }
}
