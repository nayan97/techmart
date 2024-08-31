<?php

namespace App\Http\Controllers\admin;

use Image;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductImageController extends Controller
{
    public function update(Request $request){
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $sourcePath  = $image->getPathName();

        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();

        $imageName = $request->product_id.'-'.$productImage->id.'-'.time().'.'.$ext;

        $productImage->image = $imageName;
        $productImage->save();          
                       
        // Large Image
    
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

        return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'ImagePath' => asset('img/product/small/'.$productImage->image),
            'message' => 'Image saved successfully'
        ]);
}
}
