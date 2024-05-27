<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class GetProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Search Function
        $products = Product::with('category')->when($request->status, function ($query) use ($request) {
            $query->where('status', 'like', "%{$request->status}%");
        })->orderBy('favorite', 'desc')->get();

        return response()->json([
            "status" => "Get Data Product Success",
            "data" => $products,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'criteria' => 'required',
            'favorite' => 'required',
            'status' => 'required',
            'stock' => 'required',
        ]);

        //Save all data to new variable
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->criteria = $request->criteria;
        $product->favorite = $request->favorite;
        $product->status = $request->status;
        $product->stock = $request->stock;
        $product->save();

        //Check if image not empty
        if($request->file('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.png');
            $product->image = $product->id . '.png';
            $product->save();
        }

        return response()->json([
            "status" => "Success",
            "data" => $product,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                "status" => "error",
                "data" => "Product Not Found",
            ], 404);
        }
        return response()->json([
            "status" => "Success",
            "data" => $product,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                "status" => "error",
                "data" => "Product Not Found",
            ], 404);
        }

        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->criteria = $request->criteria;
        $product->favorite = $request->favorite;
        $product->status = $request->status;
        $product->stock = $request->stock;
        $product->save();

        //Check if image not empty
        if($request->file('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.png');
            $product->image = $product->id . '.png';
            $product->save();
        }

        return response()->json([
            "status" => "Success",
            "data" => $product,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                "status" => "error",
                "data" => "Product Not Found",
            ], 404);
        }

        $product->delete();
        return response()->json([
            "status" => "success",
            "data" => "Success Delete Product",
        ], 200);
    }
}
