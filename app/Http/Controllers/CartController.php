<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

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
                $message = $product->title.' added in your cart successfully';
                session()->flash('success', $message);

            }else {
                $status = false;
                $message = $product->title.' already added in cart';
            }
        } else {
          
           Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product ->product_images->first() : '']);

              $status = true;
                $message = $product->title.' added in your cart successfully';
                session()->flash('success', $message);
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

        // find product qty
        $itemInfo = Cart::get($rowId);
        $product = Product::find($itemInfo->id);

        if ($product->track_qty === 'yes'){
            if ($qty <= $product->qty){
                Cart::update($rowId, $qty);
                $status = true;
                $message = 'Cart updated successfully';
                
                 session()->flash('success', $message);
            } else { 
                $status = false;
                $message = 'Requested quantity ('.$qty.') not not avilable in stock';
                
                session()->flash('error', $message);
            }
        }else {
            Cart::update($rowId, $qty);
            $status = true;
            $message = 'Cart updated successfully';
            
            session()->flash('success', $message);

        }
        
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function deleteCartItem(Request $request){
        Cart::remove($request->rowId);

        session()->flash('success', 'Cart item deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Cart cart item successfully'
        ]);  
    }


    public function checkout(){
        // when cart is empty
        if (Cart::count() == 0){
            return redirect()->route('front.cart');
        }

        // when user is not logged in

        if (Auth::check() == false){
            if (!session()->has('url.intended')){

                session(['url.intended' =>url()->current()]);
            }
            return redirect()->route('account.login');
        }
        session()->forget('url.intended');

        $countries = Country::orderBy('name', 'ASC')->get();
        return view('front.checkout',[
            'countries' => $countries
        ]);
    }


    public function processCheckout(Request $request){

        // form validation
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:15', // Consider a proper regex if you want mobile number format validation
            'country' => 'required',
            'address' => 'required|string|max:1000',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10', // You can customize this based on country format
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'something went wrong',
                'errors' => $validator->errors()
            ]);
        }
    }


}
