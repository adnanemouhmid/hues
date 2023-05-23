<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Review;
use App\Models\Product;
use App\Models\StarRating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function storeReview(Request $request, $id)
    {
        if (Product::find($id) == null)
            return response()->json([
                'message'  => "Product not found!",
            ], 403);

        $validator = Validator::make($request->only('review'), [
            'review' => 'required|max:515',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $formFields["review"] = $request->input("review");
        $formFields["product"] = $id;
        $formFields["user"] = Auth::id();

        Review::create($formFields);
        return response()->json([
            'msg' => 'Comment created successfully!',
            'review'  => $request->all(),
        ], 200);
    }


    public function destroyReview($id)
    {
        $review = Review::find($id);
        if ($review == null) {
            return response()->json([
                'message'  => "Comment not found!",
            ], 403);
        } else if ($review["user"]  != Auth::id()) {
            return response()->json([
                'message'  => "You can't delete this review!",
            ], 200);
        } else {
            Review::destroy($id);
            return response()->json([
                'msg' => 'Review deleted successfully',
            ], 200);
        }
    }



    public function storeRating(Request $request, $id)
    {
        
        if(Product::find($id) == null)
            return response()->json([
                'msg' => 'Product not found!',
            ], 401);
    

            $user_id = Auth::id();
            $rating = StarRating::where('user', $user_id)
                ->where('product', $id)
                ->first();
    
            if ($rating === null) {
                $formFields = [
                    'product' => $id,
                    'user' => $user_id,
                    'star_rating' => $request->input("star_rating"),
                ];
    
                StarRating::create($formFields);
    
                return response()->json([
                    'msg' => 'Rating created successfully!',
                    'star_rating'  => $request->all(),
                ], 200);
            } else {
                $rating->update($request->all());
    
                return response()->json([
                    'msg' => 'Rating updated successfully',
                    'star_rating'  => $rating,
                ], 200);
            
        }
    }
}