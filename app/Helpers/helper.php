<?php

use App\Models\category;

     function getCategories(){
        return category::orderBy('name', 'ASC')
        ->with('sub_category')
        ->where('showcat', 'Yes')->get();
     }

?>