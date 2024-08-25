<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use App\Models\category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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


    public function store(){

    }


    public function edit(){

    }


    public function update(){

    }


    public function delete(){

    }




    
}
