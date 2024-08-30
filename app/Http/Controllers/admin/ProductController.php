<?php

namespace App\Http\Controllers\admin;

use Image;
use App\Models\Brand;
use App\Models\Product;
use App\Models\category;
use App\Models\TempImage;
use App\Models\SubCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::latest('id')->with('product_images');
        if ($request->get('keyword') != "") {
            $products = $products->where('title', 'like', '%' . $request->keyword.'%');
        }
        $products = $products->paginate();
        // dd($products);
        $data['products'] = $products;
        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [];
        $categories = category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;

        return view('admin.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
  
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No,',
            'category' => 'required|numeric',
            'brand' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No,',
        ];

        if (!empty($request->track_qty) && $request->track_qty === 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $product = new Product;
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->status = $request->status;
            $product->is_featured = $request->is_featured;
            $product->save();

            // save product image gallery

            if (!empty($request->image_array)){
                foreach ($request->image_array as $temp_image_id){

                    $tempImgInfo = TempImage::find($temp_image_id);
                    $extArray = explode('.', $tempImgInfo->name);
                    $ext = last($extArray);

                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $imageName = $product->id.'-'.$productImage->id.'-'.time().'.'.$ext;

                    $productImage->image = $imageName;
                    $productImage->save();


                       //generate thumbnail
                       
                       // Large Image
                   
                    $sourcePath = public_path().'/img/temp/'.$tempImgInfo->name;
                    $dPath = public_path().'/img/product/large/'.$imageName;
                    $image = Image::make($sourcePath);
                    $image->resize(1400, null, function ($constraint){
                        $constraint->aspectratio();
                    });
                    $image->save($dPath);

                    // Small Image
                   
                    $dPath = public_path().'/img/product/small/'.$imageName;
                    $image = Image::make($sourcePath);
                    $image->fit(300, 300);
                    $image->save($dPath);

                }
            }

            $request->session()->flash('success', 'Product Uploaded successfully');

            return response()->json([
                'status' => true,
                'message' => 'Product Uploaded successfully',
            ]);
          

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
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
        $product = Product::find($id);
        if (empty($product)) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        $subCategories = SubCategory::where('category_id', $product->category_id)->get();
        $productImages = ProductImage::where('product_id', $product->id)->get();

        $data = [];
        $categories = category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['productImages'] = $productImages;
        $data['subCategories'] = $subCategories;
        $data['brands'] = $brands;
        $data['product'] = $product;
        return view('admin.product.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$product->id.',id',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,'.$product->id.',id',
            'track_qty' => 'required|in:Yes,No,',
            'category' => 'required|numeric',
            'brand' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No,',
        ];

        if (!empty($request->track_qty) && $request->track_qty === 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
        
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->status = $request->status;
            $product->is_featured = $request->is_featured;
            $product->save();



            $request->session()->flash('success', 'Product Updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Product Updated successfully',
            ]);
          

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
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
