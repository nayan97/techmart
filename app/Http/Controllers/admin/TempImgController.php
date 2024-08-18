<?php

namespace App\Http\Controllers\Admin;

use App\Models\TempImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

                return response()->json([
                    'status' => true,
                    'image_id' => $tempImage->id,
                    'message' => 'Image saved successfully',
                ]);

        }
    }
}
