<?php

use App\Models\category;
use App\Models\ProductImage;

     function getCategories(){
        return category::orderBy('name', 'ASC')
        ->with('sub_category')
        ->where('status', 1)
        ->where('showcat', 'Yes')
        ->get();
     }

     function productImage($productId){
      return ProductImage::where('product_id',$productId)->first();
     }

?>