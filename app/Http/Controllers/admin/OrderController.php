<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request){

        $orders = Order::latest('orders.created_at')
        ->select('orders.*', 'users.name', 'users.email')
        ->leftJoin('users', 'users.id', '=', 'orders.user_id');

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');
            
            // Grouping the 'orWhere' conditions within a closure
            $orders = $orders->where(function ($query) use ($keyword) {
                $query->where('users.name', 'like', '%'.$keyword.'%')
                      ->orWhere('users.email', 'like', '%'.$keyword.'%')
                      ->orWhere('orders.id', 'like', '%'.$keyword.'%');
            });
        }

        $orders = $orders->paginate(10);

        // $data['orders'] = $orders;

        return view('admin.order.index', [
            'orders' => $orders
        ]);

    }


    public function detail($id){
        return view('admin.order.order-detail');
    }
}
