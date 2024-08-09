<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        return view('admin/home');
        // echo "welcome";
        
    }

    
    // logout method

    public function logout(){

        $admin = Auth::guard('admin')->logout();
        return redirect()->route('admin.login');


    }

}
