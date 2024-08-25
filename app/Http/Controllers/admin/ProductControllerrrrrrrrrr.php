<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use App\Models\category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){

    }

    public function create(){
        $data = [];
        $categories = category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;

        return view('admin.product.create', $data);

    }


    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required',
            'track_qty' => 'required|in:Yes,No,',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No,',
        ];

        if (!empty($request->track_qty) && $request->track_qty === 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }



    }


    public function edit(){

    }


    public function update(){

    }


    public function delete(){

    }




    
}

    // $("#productForm").submit(function(event){
    //     event.preventDefault();
    //     var formArray = $(this).serializeArray();
    //     $.ajax({
    //         url: '{{ route("products.store")}}',
    //         type: 'post',
    //         data: formArray,
    //         dataType: 'json',
    //         success: function(response){
    //             if (response["status"] == true){
    //                 window.location.href="{{ route('category.index')}}";
    //                 $("#name").removeClass('is-invalid')
    //                     .siblings('p')
    //                     .removeClass('invalid-feedback')
    //                     .html("");

    //                     $("#slug").removeClass('is-invalid')
    //                     .siblings('p')
    //                     .removeClass('invalid-feedback')
    //                     .html("");

    //             }else{
    //                     var errors = response['errors'];
    //                 if (errors['name']){
    //                     $("#title").addClass('is-invalid')
    //                     .siblings('p')
    //                     .addClass('invalid-feedback')
    //                     .html(errors['name']);

    //                 }else{
    //                     $("#title").removeClass('is-invalid')
    //                     .siblings('p')
    //                     .removeClass('invalid-feedback')
    //                     .html("");
    //                 }

    //                 if (errors['slug']){
    //                     $("#slug").addClass('is-invalid')
    //                     .siblings('p')
    //                     .addClass('invalid-feedback')
    //                     .html(errors['slug']);
    //                 }else{
    //                     $("#slug").removeClass('is-invalid')
    //                     .siblings('p')
    //                     .removeClass('invalid-feedback')
    //                     .html("");

    //                  }
    //             }

    //         },
    //         error: function(){
    //             .console.log("something went wrong");
                
    //         }

    //     });
    // });

