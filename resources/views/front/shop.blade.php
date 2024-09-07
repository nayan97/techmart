

@extends('front.layouts.app')

    @section('content')

        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                        <li class="breadcrumb-item active">Shop</li>
                    </ol>
                </div>
            </div>
        </section>
    
        <section class="section-6 pt-5">
            <div class="container">
                <div class="row">            
                    <div class="col-md-3 sidebar">
                        <div class="sub-title">
                            <h2>Categories</h3>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-flush" id="accordionExample">
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $key => $category)
                                        <div class="accordion-item">
                                            @if($category->sub_category->isNotEmpty())
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{$key}}" aria-expanded="false" aria-controls="collapseOne">
                                                   {{ $category->name}}
                                                </button>
                                            </h2>
                                            @else
                                              <a href="{{ route("shop.index",$category->slug)}}" class="nav-item nav-link {{ ($categorySelected == $category->id) ? 'text-primary' : ''}}" {{$subcategory->name}}>{{$category->name}}</a>
                                            @endif
                                            @if($category->sub_category->isNotEmpty())
                                            <div id="collapseOne-{{$key}}" class="accordion-collapse collapse {{($categorySelected == $category->id ) ? 'show' : ''}}" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                <div class="accordion-body">
                                                    <div class="navbar-nav">
                                                     
                                                        @foreach ($category->sub_category as $subcategory)
                                                          <a href="{{ route("shop.index",[$category->slug, $subcategory->slug])}}" class="nav-item nav-link {{ ($subCategorySelected == $subcategory->id) ? 'text-primary' : ''}}">{{$subcategory->name}}</a>
                                                        @endforeach
                                                                                                
                                                    </div>
                                                </div>
                                            </div>
                                            @endif  
                                        </div>  
                                        @endforeach
                                    @endif
                                                                        
                                </div>
                            </div>
                        </div>
    
                        <div class="sub-title mt-5">
                            <h2>Brand</h3>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                @if ($brands->isNotEmpty())
                                @foreach ($brands as $brand)
                                <div class="form-check mb-2">
                                    <input {{ (in_array($brand->id, $brandsArray)) ? 'checked' : ''}} name="brand[]" value="{{ $brand->id }}" class="form-check-input brand-label" type="checkbox" id="brand-{{ $brand->id }}">
                                    <label class="form-check-label" for="brand-{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </label>
                                </div>
                                            
                                @endforeach
                                  
                                @endif              
                            </div>
                        </div>
    
                        <div class="sub-title mt-5">
                            <h2>Price</h3>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <input type="text" class="js-range-slider" name="my_range" value="" />               
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row pb-3">
                            <div class="col-12 pb-1">
                                <div class="d-flex align-items-center justify-content-end mb-4">
                                    <div class="ml-2">
                                        <select name="sort" id="sort" class="form-control">
                                            <option value="latest" {{ ($sort == 'latest') ? 'selected' : ''}}>Latest</option>
                                            <option value="price_desc" {{ ($sort == 'price_desc') ? 'selected' : ''}}>Price High</option>
                                            <option value="price_asc" {{ ($sort == 'price_asc') ? 'selected' : ''}}>Price Low</option>

                                        </select>
                        
                                    </div>
                                </div>
                            </div>
                            
                            @if ($products->isNotEmpty())
                            @foreach ($products as $product )
            
                            @php
                                 $productImage = $product->product_images->first();
                            @endphp
                            <div class="col-md-4">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{ route('product.index', $product->slug)}}" class="product-img">
                                            @if (!empty($productImage->image))
                                            <img src="{{ asset('img/product/small/'.$productImage->image)}}" class="card-img-top" alt="">
                                            @else
                                                 <img src="{{ asset('assets/admin/img/default-150x150.png')}}" class="card-img-top">
                                            @endif
                                        </a>
                                        <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            
    
                                        <div class="product-action">
                                            <a class="btn btn-dark" href="#">
                                                <i class="fa fa-shopping-cart"></i> Add To Cart
                                            </a>                            
                                        </div>
                                    </div>                        
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link" href="{{ route('product.index', $product->slug)}}">{{ $product->title}}</a>
                                        <div class="price mt-2">
                                            <span class="h5"><strong>${{$product->price}}</strong></span>
                                            @if ($product->compare_price > 0)
                                            <span class="h6 text-underline"><del>${{$product->compare_price}}</del></span>
                                                
                                            @endif
                                        </div>
                                    </div>                        
                                </div>                                               
                            </div>  
                            @endforeach
                            @endif                                            
        
                            <div class="col-md-12 pt-5">
           
                                {{ $products->withQueryString()->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    @endsection
    @section('customJs')
    <script>
        rangeSlider = $(".js-range-slider").ionRangeSlider({
            type: "double",
            min: 0,
            max: 1000,
            from: 0,
            step: {{($priceMin)}},
            to: {{($priceMax)}},
            skin: "round",
            max_postfix: "+",
            prefix: "$",
            onFinish: function() {
                apply_filters();
            }

        });

        //

        var slider = $(".js-range-slider").data("ionRangeSlider");

        $(".brand-label").change(function(){
            apply_filters();
        });

        $("#sort").change(function(){
            apply_filters();
        });

        function apply_filters() {
            var brands = [];
            $(".brand-label").each(function(){
                    if ($(this).is(":checked") == true){
                            brands.push($(this).val());
                    }
            });
          
            var url = '{{ url()->current() }}?';
            // brand filter 
            if (brands.length > 0){
                url += '&brand='+brands.toString()
            }

            // price range filter
            url += 'price_min='+slider.result.from+'&price_max='+slider.result.to;

        
            // shorting filter

            url += '&sort='+$("#sort").val();


            window.location.href = url;
        }

    </script>
    @endsection
