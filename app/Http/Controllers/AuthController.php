<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(){
        return view('front.account.login');
    }

    public function register(){
        return view('front.account.register');
        
    }

    public function customerRegister(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|confirmed',
        ]);
        if ($validator->passes()){

            $user = new User();
            $user -> name = $request->name;
            $user -> email = $request->email;
            $user -> phone = $request->phone;
            $user -> password = Hash::make($request->password);
            $user -> save();

            session()->flash('success', 'User created successfully');
            return response()->json([
                'status' => true,
                
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }


    // attem to login

    public function authenticate(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()){

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))){
                if (session()->has('url.intended')){
                    return redirect(session()->get('url.intended'));
                }
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('account.login')
                ->withInput($request->only('email'))
                ->with('error', 'Wrong email or password');
            }

        } else {
            return redirect()->route('account.login')
            ->withErrors($validator)->withInput($request->only('email'));
        }
    }

    // after login

    public function profile(){
        return view('front.account.profile');
    }

    public function logout(){
        Auth::logout();
        
        // $admin = Auth::guard('admin')->logout();
        return redirect()->route('account.login')->with('success', 'Logout Successfully');
    }

    public function myOrders(){

        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        
        $data ['orders'] = $orders;
        return view('front.account.order', $data);
    }

    public function orderDetail($id){
        $data = [];
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('id', $id)->first();
        $data ['order'] = $order;

        $orderItems = OrderItems::where('order_id', $id)->get();

        $data ['orderItems'] = $orderItems;


        return view('front.account.order-detail', $data);
    }
}

