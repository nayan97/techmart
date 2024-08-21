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
    public function index(Request $request)
    {   
        $subcategory = SubCategory::select('sub_categories.*', 'categories.name as categoryName')
                                ->latest('sub_categories.id')
                                ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');

        if (!empty($request->get('keyword'))) {
            $subcategory = $subcategory->where('sub_categories.name', 'like', '%'.$request->get('keyword').'%');
            $subcategory = $subcategory->orWhere('categories.name', 'like', '%'.$request->get('keyword').'%');
        }

        $subcategory = $subcategory->paginate(5);

        return view('admin.subcategory.index', compact('subcategory'));
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
    public function edit(Request $request, string $id)
    {
        $subcategory = SubCategory::find($id);
        if (empty($subcategory)){
            $request->session()->flash('error', 'record not found');
            return redirect()->route('subcategory.index');
        }
        $categories = category::orderBy('name', 'ASC')->get();

        $data['categories'] = $categories;
        $data['subcategory'] = $subcategory;
        return view('admin.subcategory.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subcategory = SubCategory::find($id);
        if (empty($subcategory)){
            $request->session()->flash('error', 'record not found');
            return response([
                'status' => false,
                'notFound' => true
            ]);
            // return redirect()->route('subcategory.index');
        }
        
        $validator = Validator::make($request->all(),[
            'name'      => 'required',
            'slug' => 'required|unique:sub_categories,slug,'.$subcategory->id.',id',
            'category'  => 'required',
            'status'    => 'required'
        ]);

        if ($validator->passes()){

            $subcategory -> name = $request->name;
            $subcategory -> slug = Str::slug($request -> name);
            $subcategory -> status = $request->status;
            $subcategory -> category_id = $request->category;

            $subcategory -> save();

            $request ->session()->flash('success','Sub Category updated successfully');

            return response()->json([
                'status' => true,
                'massage' => 'Sub Category updated successfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
