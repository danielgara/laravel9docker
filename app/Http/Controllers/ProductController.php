<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public static $products = [
        ["id"=>"1", "name"=>"TV", "description"=>"Best TV"],
        ["id"=>"2", "name"=>"iPhone", "description"=>"Best iPhone"],
        ["id"=>"3", "name"=>"Chromecast", "description"=>"Best Chromecast"],
        ["id"=>"4", "name"=>"Glasses", "description"=>"Best Glasses"]
    ];

    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Products - Online Store";
        $viewData["subtitle"] =  "List of products";
        $viewData["products"] = Product::all();
        return view('product.index')->with("viewData", $viewData);
    }

    public function show($id)
    {
        /*$exists = false;
        foreach (ProductController::$products as $product) {
            if($id == $product["id"]){
                $exists = true;
            }
        }

        if(!$exists){
            return redirect()->route('home.index');
        }*/
        $viewData = [];
        $product = Product::findOrFail($id);
        $viewData["title"] = $product["name"]." - Online Store";
        $viewData["subtitle"] =  $product["name"]." - Product information";
        $viewData["product"] = $product;
        return view('product.show')->with("viewData", $viewData);
    }

    public function create()
    {
        $viewData = []; //to be sent to the view
        $viewData["title"] = "Create product";

        return view('product.create')->with("viewData",$viewData);
    }

    public function save(Request $request)
    {
        $request->validate([
            "name" => "required",
            "price" => "required"
        ]);

        Product::create($request->only(["name","price"]));

        return back()->with('success','Item created successfully!');
    }
}

