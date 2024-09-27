<?php

namespace App\Http\Controllers\Admin;

use App\Models\category;
use App\Models\TempImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Image;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {  
         $categories = category::latest();
        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name', 'like', '%'.$request->get('keyword').'%');
        }
        $categories =  $categories->paginate(10);

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);

        if ($validator->passes()){

            $category = new Category();
            $category -> name = $request->name;
            $category -> slug = Str::slug($request -> name);
            $category -> status = $request->status;
            $category -> showcat = $request->showcat;
            $category -> save();

            // Saveimage code

            if (!empty($request->image_id)) {
                $tempImg = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImg->name);
                $ext = last($extArray);

                $newImageName = $category->id.'.'.$ext; 
                $sPath = public_path().'/img/temp/'.$tempImg->name;
                $dPath = public_path().'/img/category/'.$newImageName;
                File::copy($sPath,$dPath);

                //generate thumbnail
                $dPath = public_path().'/img/category/thumb/'.$newImageName;

                $img = Image::make($sPath);
                $img->resize(450, 600);
                $img->save($dPath);

                $category -> img = $newImageName;
                $category -> save();



            }
            $request ->session()->flash('success','Category added successfully');

            return response()->json([
                'status' => true,
                'massage' => 'Category added successfully'
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
        $category = category::find($id);
         return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = category::find($id);

        if (empty($category)){
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'No category found',

            ]);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id.',id',
        ]);

        if ($validator->passes()){

      
            $category -> name = $request->name;
            $category -> slug = Str::slug($request -> name);
            $category -> status = $request->status;
            $category -> showcat = $request->showcat;
            $category -> save();

            //unlink old Image

            $oldImage = $category->img;

            // Saveimage code

            if (!empty($request->image_id)) {
                $tempImg = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImg->name);
                $ext = last($extArray);

                $newImageName = $category->id.'-'.time().'.'.$ext; 
                $sPath = public_path().'/img/temp/'.$tempImg->name;
                $dPath = public_path().'/img/category/'.$newImageName;
                File::copy($sPath,$dPath);

                //generate thumbnail
                $dPath = public_path().'/img/category/thumb/'.$newImageName;

                $img = Image::make($sPath);
                $img->resize(450, 600);
                $img->save($dPath);

                $category -> img = $newImageName;
                $category -> save();

                // delete old image
                File::delete(public_path().'/img/category/thumb/'.$oldImage);
                File::delete(public_path().'/img/category/'.$oldImage);



            }
            $request ->session()->flash('success','Category updated successfully');

            return response()->json([
                'status' => true,
                'massage' => 'Category updated successfully'
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
    public function destroy(Request $request, string $id)
    {
        $category = category::find($id);

        $oldImage = $category->img;

        // if (empty($category)){
        //     return redirect ()->route('category.index');
        // }

        File::delete(public_path().'/img/category/thumb/'.$oldImage);
        File::delete(public_path().'/img/category/'.$oldImage);

        $category->delete();

        $request ->session()->flash('success','Category category successfully');

        return response()->json([
            'status' => true,
            'massage' => 'Category deleted successfully'
        ]);



    }
}
