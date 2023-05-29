<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoriesParam = [];
        $brandsParam = [];

        if(isset($request->categories)){
            $decodedFilterCategories = urldecode(urldecode($request->categories));
            $categoriesParam = explode('|', $decodedFilterCategories);
        }
        if(isset($request->brands)){
            $decodedFilterBrands = urldecode(urldecode($request->brands));
            $brandsParam = explode('|', $decodedFilterBrands);
        }


        $products = Product::paginate(10);
        $categories = Category::all();
        $brands = Brand::all();
        $queryParams = $request->query();

        return view('home', compact('products','categories','brands','categoriesParam','brandsParam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }
}
