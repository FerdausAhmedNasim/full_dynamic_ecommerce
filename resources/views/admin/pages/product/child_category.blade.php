<option>{{ $child_category->name }}</option>
@if ($child_category->categories)
    <option>
        @foreach ($child_category->categories as $childCategory)
            @include('admin.pages.ams.product.child_category', ['child_category' => $childCategory])
        @endforeach
    </option>
@endif