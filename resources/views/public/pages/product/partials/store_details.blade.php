<div class="table-responsive">
    <table class="table info-table">
        <tbody>
            <tr>
                <td>Store Name</td>
                <td>{{$product?->seller?->store?->getTranslation('store_name')}}</td>
            </tr>
            <tr>
                <td>Store Logo</td>
                <td><img alt="user" class="img-thumbnail" width="120" height="120"
                        src="{{ $product?->seller?->store?->getThumbnailImage() }}"></td>
            </tr>
            <tr>
                <td>Store Tagline</td>
                <td> {{ $product?->seller?->store?->getTranslation('store_tagline') }} </td>
            </tr>

            <tr>
                <td>License No.</td>
                <td> {{ $product?->seller?->store?->license_no ?? 'N/A' }} </td>
            </tr>

            <tr>
                <td>Slug</td>
                <td> {{ $product?->seller?->store?->slug ?? 'N/A' }} </td>
            </tr>

            <tr>
                <td>Google</td>
                <td>
                    @if(isset($product?->seller?->store?->google))
                    <a href="{{ $product?->seller?->store?->google}}" target="_blank">Show</a>
                    @else
                    N/A
                    @endif
                </td>
            </tr>

            <tr>
                <td>Twitter</td>
                <td>
                    @if(isset($product?->seller?->store?->twitter))
                    <a href="{{ $product?->seller?->store?->twitter}}" target="_blank">Show</a>
                    @else
                    N/A
                    @endif
                </td>
            </tr>

            <tr>
                <td>Instagram</td>
                <td>
                    @if(isset($product?->seller?->store?->instagram))
                    <a href="{{ $product?->seller?->store?->instagram}}" target="_blank">Show</a>
                    @else
                    N/A
                    @endif
                </td>
            </tr>

            <tr>
                <td>Youtube</td>
                <td>
                    @if(isset($product?->seller?->store?->youtube))
                    <a href="{{ $product?->seller?->store?->youtube}}" target="_blank">Show</a>
                    @else
                    N/A
                    @endif
                </td>
            </tr>

            <tr>
                <td>Facebook</td>
                <td>
                    @if(isset($product?->seller?->store?->facebook))
                    <a href="{{ $product?->seller?->store?->facebook}}" target="_blank">Show</a>
                    @else
                    N/A
                    @endif
                </td>
            </tr>

            <tr>
                <td>Ratting</td>
                <td>
                    {{ $product?->seller?->store?->rating_count}}

                </td>
            </tr>

            <tr>
                <td>Review</td>
                <td>
                    {{ $product?->seller?->store?->reviews_count }}
                </td>
            </tr>
        </tbody>
    </table>
</div>