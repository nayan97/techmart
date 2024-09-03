<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null){
        $categorySelected = '';
        $subCategorySelected = '';
        $brandsArray = [];
        if (!empty($request->get('brand'))){
            $brandsArray = explode(',', $request->get('brand'));
        }

        $categories = category::orderBy('name', 'ASC')->with('sub_category')->where('status', 1)->get();
        $brands = Brand::orderBy('name', 'ASC')->where('status', 1)->get();
        $products = Product::where('status', 1);

        // apply filter here
        if (!empty($categorySlug)){
            $category = category::where('slug',$categorySlug)->first();
            $products =  $products->where('category_id', $category->id);
            $categorySelected =$category->id;
        }

        if (!empty($subCategorySlug)){
            $subCategory = SubCategory::where('slug',$subCategorySlug)->first();
            $products =  $products->where('sub_category_id', $subCategory->id);
            $subCategorySelected = $subCategory->id;
        }

        $products =  $products->orderBy('id', 'DESC');
        $products =  $products->get();

        $data['products'] = $products;
        $data['brands'] = $brands;
        $data['categories'] = $categories;
        $data['categorySelected'] = $categorySelected;
        $data['subCategorySelected'] = $subCategorySelected;
        $data['brandsArray'] = $brandsArray;

        return view('front.shop', $data);
    }
}
