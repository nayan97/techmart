<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
}

