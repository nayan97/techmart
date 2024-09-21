<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Country;
use App\Models\Product;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
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
        $customerAddress = CustomerAddress::where('user_id', Auth::user()->id)->first();

        session()->forget('url.intended');

        $countries = Country::orderBy('name', 'ASC')->get();
        return view('front.checkout',[
            'countries' => $countries,
            'customerAddress' => $customerAddress
        ]);
    }
            
    // process checkout 

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

        // save user addresses

        $user = Auth::user();

        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],

            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->appartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip

                ]
            );

            // store data in order table

            if ($request->pay_method == 'cod'){
                $shipping = 0;
                $discount = 0;
                $subTotal = Cart::subtotal(2,'.','');
                $grandTotal = $subTotal+$shipping;

                $order = new Order;
                $order->subtotal = $subTotal;  
                $order->shipping = $shipping;  
                $order->grand_total = $grandTotal; 
                $order->user_id = $user->id;
            
                $order->first_name = $request->first_name;
                $order->last_name = $request->last_name;
                $order->email = $request->email;
                $order->mobile = $request->mobile;
                $order->country_id = $request->country;
                $order->address = $request->address;
                $order->apartment = $request->appartment;
                $order->city = $request->city;
                $order->state = $request->state;
                $order->zip = $request->zip;
                $order->notes = $request->notes;
                $order->save();

                //  store order item in order items table
                foreach (Cart::content() as $item){
                    $orderItem = new OrderItems;
                    $orderItem->product_id = $item->id;
                    $orderItem->order_id = $order->id;
                    $orderItem->name = $item->name;
                    $orderItem->qty = $item->qty;
                    $orderItem->price = $item->price;
                    $orderItem->total = $item->price*$item->qty;
                    $orderItem->save();
                }

                session()->flash('success', 'Order Added Successfully');

                Cart::destroy();

                return response()->json([
                    'status' => true,
                    'orderId' => $order->id,
                    'message' => 'successfully created',
                   
                ]);
             
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong',
               
                ]);

            }
    }


    public function thankYou(){
        return view('front.thankyou');
    }

}
