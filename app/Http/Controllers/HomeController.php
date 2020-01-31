<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ['categories' => Category::withCount('products')->get()]);
    }

    public function product(Product $product)
    {
        return view('product', ['product' => $product]);
    }

    public function products(Category $category)
    {

        return view('products', ['products' => $category->products, 'prices' => $category->ordered_prices]);
    }
}
