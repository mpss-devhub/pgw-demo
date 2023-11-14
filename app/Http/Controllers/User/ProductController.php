<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productQuery = Product::query();
        $categoriesParam = [];
        $brandsParam = [];
        $openedFilterTabs = [];

        if(isset($request->categories)){
            $decodedFilterCategories = urldecode(urldecode($request->categories));
            $categoriesParam = explode('|', $decodedFilterCategories);
            if(count($categoriesParam)>0){
                $productQuery = $productQuery->whereHas('categories', function ($query) use ($categoriesParam) {
                    $query->whereIn('name', $categoriesParam);
                });
                array_push($openedFilterTabs, 'categories');
            }
        }
        if(isset($request->brands)){
            $decodedFilterBrands = urldecode(urldecode($request->brands));
            $brandsParam = explode('|', $decodedFilterBrands);
            if(count($brandsParam)>0){
                $productQuery = $productQuery->whereHas('brand', function ($query) use ($brandsParam) {
                    $query->whereIn('name', $brandsParam);
                });
                array_push($openedFilterTabs, 'brands');
            }
        }


        $products = $productQuery->with(['brand','categories'])->paginate(8);
        $cartProducts = Auth::user()->cart->groupBy('id');

        $cartTotalPrice = $cartProducts->sum(function ($group) {
            return $group->sum('price');
        });

        $categories = Category::all();
        $brands = Brand::all();

        session()->flash('success', 'Operation successful!');

        return view('home', compact(
                'products', 'categories',
                'brands','categoriesParam','brandsParam',
                'openedFilterTabs','cartProducts', 'cartTotalPrice',
        ))->with('success','hi');
    }

    public function addToCart(AddToCartRequest $request)
    {
        //
        $product = Product::findOrFail($request->product_id);
        $product->users()->attach(Auth::user()->id, ['created_at' => now(), 'updated_at' => now()]);
        $cartItemsCount = Auth::user()->cart->count();

        return redirect()->back()->with('isCartShown',$cartItemsCount>0);
    }
    public function removeFromCart(AddToCartRequest $request)
    {
        //
        $product = Product::findOrFail($request->product_id);
        $product->users()->detach([Auth::user()->id]);

        $cartItemsCount = Auth::user()->cart->count();

        return redirect()->back()->with('isCartShown',$cartItemsCount>0);
    }
    public function cart()
    {
        $cartProducts = Auth::user()->cart;
        return view('cart',compact('cartProducts'));
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
