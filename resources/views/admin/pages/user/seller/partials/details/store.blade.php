@extends('admin.pages.user.seller.layout.master')
@section('title', 'Store Details')

@section('details', 'active')
@section('shop', 'active')

@section('clientContent')

<div class="text-center">
    <table class="table org-data-table table-bordered">
        <tbody>
            <tr>
                <td>Store Name</td>
                <td>
                    {{ $user?->store(true)?->getTranslation('store_name') }}
                </td>
            </tr>

            <tr>
                <td>Store Status</td>
                <td>
                    <div class="badge {{ $user?->store->active ? 'badge-success' : 'badge-danger' }}">
                        {{ $user?->store->active ? 'Active' : 'Inactive' }}
                    </div>
                </td>
            </tr>

            <tr>
                <td>Store Tagline</td>
                <td> {{ $user?->store(true)?->getTranslation('store_tagline') }} </td>
            </tr>

            <tr>
                <td>License No.</td>
                <td> {{ $user?->store?->license_no ?? 'N/A' }} </td>
            </tr>

            <tr>
                <td>Slug</td>
                <td> {{ $user?->store?->slug ?? 'N/A' }} </td>
            </tr>

            <tr>
                <td>Google</td>
                <td>
                    @if(isset($user?->store?->google))
                    <a href="{{ $user?->store?->google}}" target="_blank">Show</a>
                    @else
                    N/A
                    @endif
                </td>
            </tr>

            <tr>
                <td>Twitter</td>
                <td>
                    @if(isset($user?->store?->twitter))
                    <a href="{{ $user?->store?->twitter}}" target="_blank">Show</a>
                    @else
                    N/A
                    @endif
                </td>
            </tr>

            <tr>
                <td>Instagram</td>
                <td>
                    @if(isset($user?->store?->instagram))
                    <a href="{{ $user?->store?->instagram}}" target="_blank">Show</a>
                    @else
                    N/A
                    @endif
                </td>
            </tr>

            <tr>
                <td>Youtube</td>
                <td>
                    @if(isset($user?->store?->youtube))
                    <a href="{{ $user?->store?->youtube}}" target="_blank">Show</a>
                    @else
                    N/A
                    @endif
                </td>
            </tr>

            <tr>
                <td>Facebook</td>
                <td>
                    @if(isset($user?->store?->facebook))
                    <a href="{{ $user?->store?->facebook}}" target="_blank">Show</a>
                    @else
                    N/A
                    @endif
                </td>
            </tr>

            <tr>
                <td>Ratting</td>
                <td>
                   {{ $user?->store?->rating_count}}

                </td>
            </tr>

            <tr>
                <td>Review</td>
                <td>
                    {{ $user?->store?->reviews_count }}
                </td>
            </tr>

            <tr>
                <td>Meta Title</td>
                <td>
                    {{ $user?->store(true)?->getTranslation('meta_title') ?? 'N/A'}}
                </td>
            </tr>

            <tr>
                <td>Meta Description</td>
                <td>
                    {{ $user?->store(true)?->getTranslation('meta_description') ?? 'N/A'}}
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
