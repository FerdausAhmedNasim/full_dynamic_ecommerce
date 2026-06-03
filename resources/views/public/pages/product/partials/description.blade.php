<style>
    .product-description li {
        display: list-item !important;
    }
</style>

<div class="product-description">
    @if($product->getTranslation('short_description') != '')
    <div class="nav-desh">
        <div class="desh-title">
            <h5>Short Description:</h5>
        </div>
        <p>{{ $product->getTranslation('short_description') }}</p>
    </div>
    @endif
    @if($product->getTranslation('description') != '')
    <div class="nav-desh">
        <div class="desh-title">
            <h5>Description:</h5>
        </div>
        <p class="description">{!! $product->getTranslation('description') !!}</p>
    </div>
    @endif

    @if($product->attachments->where('for', 'description')->first())
    <div class="nav-desh">
        <img style="max-width: 100%" src="{{ $product->attachments->where('for', 'description')->first()->getAttachment() }}" />
    </div>
    @endif

</div>
