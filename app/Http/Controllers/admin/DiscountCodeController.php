<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\DiscountCoupon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
        //discountcode.create 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[

            'code' => 'required|string|unique:discount_coupons,code|max:255',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'max_uses' => 'nullable|integer|min:1',
            'max_uses_user' => 'nullable|integer|min:1',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0|max:9999999999.99',
            'min_amount' => 'nullable|numeric|min:0|max:9999999999.99',
            'status' => 'integer|in:0,1',
            'starts_at' => 'nullable|date|before_or_equal:expires_at',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
        ]);
        if ($validator->passes()){
            $discountCode = new DiscountCoupon();

            $discountCode->code = $request->code;
            $discountCode->name = $request->name;
            $discountCode->description = $request->description;
            $discountCode->max_uses = $request->max_uses;
            $discountCode->max_uses_user = $request->max_uses_user;
            $discountCode->type = $request->type;
            $discountCode->discount_amount = $request->discount_amount;
            $discountCode->min_amount = $request->min_amount;
            $discountCode->status = $request->status;
            $discountCode->starts_at = $request->starts_at;
            $discountCode->expires_at = $request->expires_at;
            $discountCode->save();

            return response()->json([
                'status' => true,
                'message' => 'Discount code saved successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}