<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function getProducts(){
        $products = Product::all();
        return view("/products/list",["products" => $products]);
    }

    public function storeProduct(Request $request){
        $name      = $request->input("name");    
        $product_id = $request->input("product_id");    
        $available_stocks = $request->input("available_stocks");    
        $price = $request->input("price");    
        $tax_percentage = $request->input("tax_percentage");    

        $data = new Product;
        $data->name = $name;
        $data->product_id = $product_id;
        $data->available_stocks = $available_stocks;
        $data->price = $price;
        $data->tax_percentage = $tax_percentage;
        $data->save();

        return redirect()->route('products');        
    }

    public function createProduct(Request $request){
        return view('products.add');
    }
    public function edit($id){
        $data = Product::find($id);
        return view('products.edit',['data' => $data]); 
    }
    public function updateProduct(Request $request, $id){
        $data = Product::find($id);
        $data->name             = $request->input("name");
        $data->product_id       = $request->input("product_id");
        $data->available_stocks = $request->input("available_stocks");
        $data->price            = $request->input("price");  
        $data->save();
        return redirect()->route('products');  
    }

    public function delete($id){
        $data = Product::find($id);
        $data->delete();
        return redirect()->route('products');  
    }
}
