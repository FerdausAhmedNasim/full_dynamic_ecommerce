@php
use \App\Library\Enum;
$categories = \App\Models\Category::active()->get();
$brands = \App\Models\Brand::active()->get();
$ratings = Enum::getRattingType();
@endphp

<div class="left-box">
    <div class="shop-left-sidebar">
        <div class="back-button">
            <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
        </div>

        <div class="filter-category">
            <div class="filter-title">
                <h2>Filters</h2>
                <a href="javascript:void(0)" onclick="ClearAll()">Clear All</a>
            </div>
        </div>

        <form class="filter-form" action="javascript:void(0)">

            <div class="accordion custom-accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne">
                            <span>Categories</span>
                        </button>
                    </h2>

                    <div id="collapseOne" class="accordion-collapse collapse show">
                        <div class="accordion-body">

                            <ul class="category-list custom-padding custom-height">
                                @foreach($categories as $key => $cat)
                                <li>
                                    <div class="form-check ps-0 m-0 category-list-box">
                                        <input class="checkbox_animated" type="checkbox"
                                        @if(isset($category)) @if($category->id == $cat->id)
                                        checked @endif @endif name="category[]" onclick="filter()"
                                            value="{{$cat->id}}" id="category{{$cat->id}}">
                                        <label class="form-check-label" for="category{{$cat->id}}">
                                            <span class="name">{{ $cat->getTranslation('title') }}</span>
                                            <!-- <span class="number">(15)</span> -->
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo">
                            <span>Brands</span>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <ul class="category-list custom-padding custom-height">
                                @foreach($brands as $key => $brand_data)
                                <li>
                                    <div class="form-check ps-0 m-0 category-list-box">
                                        <input class="checkbox_animated" type="checkbox" 
                                        @if(isset($brand))@if($brand->id ==  $brand_data->id) checked @endif @endif
                                        name="brand[]" value="{{$brand_data->id}}"
                                            id="brand{{$brand_data->id}}" onclick="filter()">
                                        <label class="form-check-label" for="brand{{$brand_data->id}}">
                                            <span class="name"> {{$brand_data->getTranslation('title')}} </span>
                                            <!-- <span class="number">(08)</span> -->
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree">
                            <span>Price</span>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="range-slider">
                                <input type="text" class="js-range-slider d-none" name="price_range" value="" onchange="filter()">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseSix">
                            <span>Rating</span>
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <ul class="category-list custom-padding">
                                @foreach($ratings as $key => $rating)
                                <li>
                                    <div class="form-check ps-0 m-0 category-list-box">
                                        <input class="checkbox_animated" type="checkbox" name="rating[]" value="{{$rating}}"
                                            id="rating{{$rating}}" onclick="filter()">
                                        <label class="form-check-label" for="rating{{$rating}}">
                                            {!! \App\Library\Html::rating($rating) !!}
                                            <!-- <span class="number">(08)</span> -->
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@vite('resources/frontend_assets/js/pages/product/filter.js')
@endpush