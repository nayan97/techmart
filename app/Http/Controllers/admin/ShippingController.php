<?php

namespace App\Http\Controllers\admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
    public function create(){
        $countries = Country::get();

        return view('admin.shipping.create');
    }
}
