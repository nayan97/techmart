<?php

namespace App\Http\Controllers\Admin;

use App\Models\TempImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;


class TempImgController extends Controller
{
    public function create(Request $request){

        $image = $request->image;

            if (!empty($image)) {

                $ext = $image->getClientOriginalExtension();
                $newName = time().'.'.$ext;

                $tempImage = new TempImage();
                $tempImage -> name = $newName;
                $tempImage -> save();

                $image->move(public_path().'/img/temp',$newName);

                // make thumbnail image
                $sourcePath = public_path().'/img/temp/'.$newName;
                $destPath = public_path().'/img/temp/prothum/'.$newName;
                $image = Image::make($sourcePath );
                $image->fit(300,270);
                $image->save($destPath);

                return response()->json([
                    'status' => true,
                    'image_id' => $tempImage->id,
                    'ImagePath' => asset('/img/temp/prothum/'.$newName),
                    'message' => 'Image saved successfully',
                ]);

        }
    }
}
