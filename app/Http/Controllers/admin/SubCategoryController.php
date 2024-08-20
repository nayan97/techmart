<?php

namespace App\Http\Controllers\Admin;

use App\Models\category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   $cats = category::orderBy('name','ASC')->get();
        return view('admin.subcategory.create', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'      => 'required',
            'slug'      => 'required|unique:categories',
            'category'  => 'required',
            'status'    => 'required'
        ]);

        if ($validator->passes()){

            $subcategory = new SubCategory();
            $subcategory -> name = $request->name;
            $subcategory -> slug = Str::slug($request -> name);
            $subcategory -> status = $request->status;
            $subcategory -> category_id = $request->category;

            $subcategory -> save();

            $request ->session()->flash('success','Sub Category added successfully');

            return response()->json([
                'status' => true,
                'massage' => 'Sub Category added successfully'
            ]);

        }else{
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
