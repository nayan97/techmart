<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request -> all(),[
            'name' => 'required',
            'slug' => 'required|unique:brands',

        ]);

        if ($validator->passes()) {

            $brand = new Brand();

            $brand-> name = $request->name;
            $brand -> slug = Str::slug($request->name);
            $brand -> status = $request->status;
            $brand -> save();

            return response()->json([
                'status' => true,
                'message' => 'brand Added successfully'
        ]);
        
        }else {
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
