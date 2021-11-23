<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductsController extends Controller
{


    public function index()
    {
        $products = Product::all();
        return response($products, 200);
    }


    public function show(int $id)
    {
        $product = Product::find($id);
        return response(null, 200)->json($product);
    }
}
