<?php

namespace App\Http\Controllers\admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\ShippingCharge;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function create(){
        $countries = Country::get();
        $data['countries'] =  $countries;

        $shippingCharges = ShippingCharge::select('shipping_charges.*','countries.name')->leftJoin('countries', 'countries.id', 'shipping_charges.country_id'  )->get();
        $data['shippingCharges'] =  $shippingCharges;

        return view('admin.shipping.create', $data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'country' => 'required',
            'amount' => 'required|numeric'
        ]);

        if ($validator->passes()){
            $shipping = new ShippingCharge;
            $shipping->country_id = $request->country;
            $shipping->amount = $request->amount;
            $shipping->save();

            session()->flash('success', 'Shipping charges list added successfully');
            
            return response()->json([
                'status' => true,
                'mesage' => 'Shipping'
            ]);
         
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
