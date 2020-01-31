<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index', [
            'products' => Product::with('category')
                ->orderBy('category_id')
                ->orderBy('name')
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.product.create', ['selectedCategory' => $request->query('category', null), 'categories' => Category::withoutGlobalScope('nvip')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->detail = $request->detail;
        $product->photo_path = $request->photo;
        $product->stock = $request->stock;
        $product->save();
        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', ['product' => $product, 'categories' => Category::withoutGlobalScope('nvip')->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->detail = $request->detail;
        if ($photo = $request->file('photo')) {
            $product->photo_path = $photo;
        }
        $product->stock = $request->stock;
        $product->save();
        return redirect()->route('products.index');
    }

    public function stockUpdate(Request $request)
    {
        $productIds = array_keys($request->products);
        $products = Product::whereIn('id', $productIds)->get();
        foreach ($products as $product) {
            $product->stock = $request->products[$product->id];
            $product->save();
        }
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $categoryId = $product->category_id;
        $product->delete();
        return redirect()->route('products.index');
    }
}
