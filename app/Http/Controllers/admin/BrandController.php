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
    public function index(Request $request)
    {
        $brand = Brand::latest();
        if (!empty($request->get('keyword'))) {
            $brand = $brand->where('name', 'like', '%'.$request->get('keyword').'%');
        }
        $brand =  $brand->paginate(10);
        return view('admin.brand.index', compact('brand'));
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
        $brand = new Brand();

        $validator = Validator::make($request -> all(),[
            'name' => 'required',
            'slug' => 'required|unique:brands',

        ]);

        if ($validator->passes()) {

            $brand-> name = $request->name;
            $brand -> slug = Str::slug($request->name);
            $brand -> status = $request->status;
            $brand -> save();

            return response()->json([
                'status' => true,
                'message' => 'brand updated successfully'
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
    public function edit(Request $request, string $id)
    {
        $brand = Brand::find($id);

        if (empty($brand)) {
            $request->session->flash('error', 'resource not found');
            return redirect()->route('brand.index');

        }
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);

        if (empty($brand)) {
            $request->session->flash('error', 'resource not found');
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);

        }
        $validator = Validator::make($request -> all(),[
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$brand->id.',id',


        ]);

        if ($validator->passes()) {

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
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request, string $id)
    {
        $brand = Brand::find($id);

        if (empty($brand)){
            $request->session->flash('error', 'resource not found');
            return redirect ()->route('brand.index');
        }

        $brand->delete();

        $request ->session()->flash('success','brand successfully');

        return response()->json([
            'status' => true,
            'massage' => 'Brand deleted successfully'
        ]);

    }
}
