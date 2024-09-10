<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $product = Product::with('product_images')->find($request->id);

        if ($product === null){
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }

        if (Cart::count() >0){
            // echo "Product already exists";
            // product found in cart

            $cartContent = Cart::content();
            $productAlreadyExists = false;

            foreach ($cartContent as $item){
            if ($item->id == $product->id){
                $productAlreadyExists = true;
    
                }
            }
            
            if ($productAlreadyExists == false) {
                Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product ->product_images->first() : '']);

                $status = true;
                $message = $product->title.' added in cart';

            }else {
                $status = false;
                $message = $product->title.' already added in cart';
            }
        } else {
          
           Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product ->product_images->first() : '']);

              $status = true;
                $message = $product->title.' added in cart';
        }
            return response()->json([
                'status' => $status,
                'message' =>$message
            ]);

    }

    public function cart(){
      
        $cartContent = Cart::Content();
        $data['cartContent'] = $cartContent;
        return view('front.cart', $data);
    }

    public function updateCart(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);

        session()->flash('success', 'Cart updated successfully');
        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully'
        ]);
    }

}
