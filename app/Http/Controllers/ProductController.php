<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller{

	// functions
	public function formProduct(){
		return view('products.formProduct');
	}


    public function store(Request $request){
    	$name = $request->input('name');
    	$descripcion = $request->input('descripcion');
    	$precio = $request->input('precio');
        Product::create([	
            'name' => $name,
            'descripcion' => $descripcion,
            'precio' => $precio
        ]);
        return 200;
	}

	public function allProducts(){
		$products = Product::orderBy('name','asc')->paginate(10);
		return $products;
	}
}
