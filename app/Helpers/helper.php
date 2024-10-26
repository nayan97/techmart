<?php

use App\Models\Order;
use App\Mail\OrderEmail;
use App\Models\category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Mail;

     function getCategories(){
        return category::orderBy('name', 'ASC')
        ->with('sub_category')
        ->where('status', 1)
        ->where('showcat', 'Yes')
        ->get();
     }

     function productImage($productId){
      return ProductImage::where('product_id',$productId)->first();
     }


     // send email after complete order

     function orderEmail($orderId){
      $order = Order::where('id',$orderId)->with('items')->first();

      $mailData = [
         'subject' => 'Thanks for your order',
         'order' => $order
      ];

      Mail::to($order->email)->send(new OrderEmail($mailData));
      // dd($order); 
     }

      

?>