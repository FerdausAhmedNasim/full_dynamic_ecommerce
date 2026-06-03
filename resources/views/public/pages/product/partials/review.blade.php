<div class="review-box">
    <div class="row">
        <div class="col-xl-5">
            <div class="product-rating-box">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="product-main-rating">
                            <h2>{{ $overallRetting }}
                                <i data-feather="star"></i>
                            </h2>

                            <h5>{{ $product->productReview(true)->count() }} Overall Rating</h5>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <ul class="product-rating-list">
                            @foreach($ratingWiseTotalRetting as $key => $rating)
                            <li>
                                <div class="rating-product">
                                    <h5>{{ $key }}<i data-feather="star"></i></h5>
                                    <div class="progress">
                                        <div class="progress-bar"
                                            style="width: {{ getPercentageRatting(count($product->productReview), $rating) }}%;">
                                        </div>
                                    </div>
                                    <h5 class="total">{{ $rating }}</h5>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @if($product->isBuyThisProduct())
                    <div class="col-md-12 mb-2">
                        <div class="wrapper">
                            <h3>Write A Review</h3>
                            <form class="review-form pb-3" action="javascript:void(0)">
                                @csrf
                                <input type="number" name="product_id" id="product_id" value="{{$product->id}}"
                                    class="hidden_input" required>

                                <div class="form-group  @error('rating') error @enderror">
                                    <div class="rating mb-4">
                                        <input type="number" name="rating" class="hidden_input" required>
                                        <i class='bx bx-star star' style="--i: 0;"></i>
                                        <i class='bx bx-star star' style="--i: 1;"></i>
                                        <i class='bx bx-star star' style="--i: 2;"></i>
                                        <i class='bx bx-star star' style="--i: 3;"></i>
                                        <i class='bx bx-star star' style="--i: 4;"></i>
                                    </div>
                                    @error('rating')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group  @error('comment') error @enderror">
                                    <textarea name="comment" cols="30" rows="5" placeholder="Your opinion..."
                                        required></textarea>
                                    @error('comment')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="form-group  @error('images') error @enderror">
                                    <div class="dropMeInputImage"></div>

                                    @error('images')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div id="error-msg">

                                </div>
                                <div class="btn-group mt-3">
                                    <button type="reset" class="btn cancel">Cancel</button>
                                    <button type="submit" class="btn submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="review-people">
                <ul class="review-list list-wrapper">

                    @foreach($reviews as $review)
                    <li class="list-item">
                        <div class="people-box">
                            <div>
                                <div class="people-image people-text">
                                    <img alt="user" class="img-fluid " src="{{ $review->customer->getAvatar() }}">
                                </div>
                            </div>

                            <div class="people-comment">
                                <div class="people-name"><a href="javascript:void(0)"
                                        class="name">{{ $review->customer->full_name }}</a>
                                    <div class="date-time">
                                        <h6 class="text-content"> {{ $review->created_at->format("m-d-Y g:i A") }}
                                        </h6>
                                        <div class="product-rating">
                                            {!! \App\Library\Html::rating($review->rating) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="reply">
                                    <p>{{ $review->comment }}</p>
                                </div>

                                <div class="row mt-3">
                                    @foreach($review->attachments as $key => $attachment)
                                    <div class="col-md-2">
                                        <img src="{{ $attachment->getAttachment() }}" id="img-1"
                                            class="img-thumbnail w-100 h-100 blur-up lazyload preview-image" alt=""
                                            data-toggle="modal" data-target="#imageModal" data-src="{{ $attachment->getAttachment() }}"
                                        >
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @if(count($reviews) > 3 )
            <div id="pagination-container" class="float-end"></div>
            @endif
        </div>
    </div>
</div>
@include('public.components.review')
@include('seller.assets.dropMeImageUploader')


@push('styles')
<style>
    .dropMeUploader .preview .previewImage {
        text-align: left !important;
    }
</style>
@endpush
