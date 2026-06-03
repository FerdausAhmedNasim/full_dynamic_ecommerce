@php
    use App\Library\Helper;
@endphp

@if (Helper::hasAuthRolePermission('product_index'))
    <a class="btn btn-sm btn-outline-primary mr-2 @yield('product', '')"
        href="{{ route('admin.product.index') }}">Products</a>
@endif

@if (Helper::hasAuthRolePermission('category_index'))
    <a class="btn btn-sm btn-outline-primary mr-2 @yield('category', '')" href="/category">Categories</a>
@endif

@if (Helper::hasAuthRolePermission('brand_index'))
    <a class="btn btn-sm btn-outline-primary mr-2 @yield('brand', '')" href="{{ route('admin.brand.index') }}">Brands</a>
@endif

@if (Helper::hasAuthRolePermission('color_index'))
    <a class="btn btn-sm btn-outline-primary mr-2 @yield('color', '')" href="{{ route('admin.color.index') }}">Colors</a>
@endif

@if (Helper::hasAuthRolePermission('attribute_index'))
    <a class="btn btn-sm btn-outline-primary mr-2 @yield('attribute', '')"
        href="{{ route('admin.attribute.index') }}">Attributes</a>
@endif

@if (Helper::hasAuthRolePermission('attribute_value_index'))
    <a class="btn btn-sm btn-outline-primary mr-2 @yield('attribute_value', '')"
        href="{{ route('admin.attributeValue.index') }}">Attribute Values</a>
@endif

@if (Helper::hasAuthRolePermission('purchase_index') && false)
    <a class="btn btn-sm btn-outline-primary  @yield('purchase', '')" href="/purchase">Purchases</a>
@endif
