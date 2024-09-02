<?php

use App\Models\category;

     function getCategories(){
        return category::orderBy('name', 'ASC')
        ->with('sub_category')
        ->where('status', 1)
        ->where('showcat', 'Yes')
        ->get();
     }

?>