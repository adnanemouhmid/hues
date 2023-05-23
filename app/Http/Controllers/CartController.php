<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Auth;
use Validator;

class CartController extends Controller
{
    
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->only('quantite', 'color', 'size'), [
            'quantite' => 'required|numeric',
            'color' => 'required',
            'size' => 'required',
        ]);

        if ($validator->fails()) 
            return response()->json(['error' => $validator->errors()], 401);

        $formFields= [];
        $data= $request->all();
        $color= $request->input("color");
        $size= $request->input("size");
        $product = ProductVariation::where('product', $id)
                ->where('color', $data["color"])
                ->where('size', $data["size"])
                ->first();

        if ($product == null)
            return response()->json([
                'msg' => 'Product not found!',
            ], 401);

        if($product["stock"] == 0)
            return response()->json([
                'msg' => 'This product is out of stock',
            ],200);

    
        $user_id = Auth::id();
        $cartItem = Cart::where('user', $user_id)
            ->where('product', $id)
            ->where('color', $color)
            ->where('size', $size)
            ->first();

        if ($cartItem === null) {
            $formFields = [
                'user' => $user_id,
                'product' => $id,
                'quantite' => $data["quantite"],
                'color' => $data["color"],
                'size' => $data["size"]
            ];
            // dd($formFields);

            Cart::create($formFields);

            return response()->json([
                'msg' => 'Cart item added successfully!',
                'cart Item'  => $formFields,
            ], 200);
        } 
        else {
            $cartItem->quantite += $data["quantite"];
            $cartItem->save();
            // $cartItem->update($formFields);

            return response()->json([
                'msg' => 'Cart item updated successfully',
                'cart item'  => $cartItem,
            ], 200);
        }
    }


    public function destroy($id)
    {
        $cartItem = Cart::find($id);
        if ($cartItem == null) {
            return response()->json([
                'message'  => "Cart item not found!",
            ], 403);
        } else if ($cartItem["user"]  != Auth::id()) {
            return response()->json([
                'message'  => "You can't delete this Cart Item!",
            ], 200);
        } else {
            Cart::destroy($id);
            return response()->json([
                'msg' => 'Cart item deleted successfully',
            ], 200);
        }
    }

    public function index(){
        $user_id= Auth::id();
        // $cartItems = Cart::where('user', "$user_id")->select('id', 'name', 'price')->get();
        $cartItems = Cart::where('user', "$user_id")->get();
        $items= [];

        $cart= Cart::join('products', 'carts.product', '=', 'products.id')
        ->select('cart.*', 'products.name', 'products.price', 'products.cathegory')
        ->get();

        // foreach ($cartItems as $i => $item) {
        //     $items[$i]= Product::where("id", $item["product"])->select("name","price","cathegory")->get();
        //     $items[$i]["quantite"]= $item["quantite"];
        // }
        if ($cart == null) {
            return response()->json([
                    'message'  => "your cart is empty",
              ], 200);
        } else{
            return response()->json([
                'cart'  => $cart,
            ], 200);
        }
}

   

}