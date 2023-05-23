<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use App\Models\StarRating;
use Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();
        if ($product == null) {
          return response()->json([
                  'message'  => "No products available!",
            ], 422);
       } else{
          return response()->json($product, 201);
      }
    }

 
    public function store(Request $request)
    {
        $validator = Validator::make($request->only('name','price','colors','sizes','cathegory'), [
            "name"=> "required",
            "price"=> "required",
            "colors"=> "required",
            "sizes"=> "required",
            "cathegory"=> "required" 
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $formFields = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'colors' => $request->input('colors'),
            'sizes' => $request->input('sizes'),
            'cathegory' => $request->input('cathegory')
        ];

        $product= Product::create($formFields);
        
        $colors= explode(",",$formFields["colors"]);
        $sizes= explode(",",$formFields["sizes"]);
        foreach ($sizes as $size) {
            foreach ($colors as $color){
                $variation= [
                    'product' => $product->id,
                    'color' => $color,
                    'size' => $size,
                    'stock' => $request->input('stock')
                ];
                ProductVariation::create($variation);
            }
        }
        return response()->json([
            'msg' =>'product created successfully!',
            'produit'  => $request->all(),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);
        $reviews = Review::where('product', "$id")->get();
        $stars = StarRating::where('product', "$id")
        ->avg('star_rating');

        if ($product == null) {
            return response()->json([
                    'message'  => "Product not fount!",
              ], 422);
        } else{
            return response()->json([
                'products'  => $product,
                'reviews'  => $reviews,
                'stars'  => $stars
            ], 200);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return response()->json([
                    'message'  => "Product not found!"
              ], 422);
         } else{
            $product->update($request->all());
            return response()->json([
                'msg' =>'Product updated successfully',
                'produit'  => $product,
            ], 200);
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return response()->json([
                    'message'  => "Product not found!",
              ], 422);
         } else{
             Product::destroy($id);
             return response()->json([
                'msg' =>'Product deleted successfully',
            ], 200);
    
        }
    }
}
