@extends('seller.layouts.master')
@section('title', __('Seller || Shop'))
@section('content')

@php
use App\Library\Helper;
$user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ __('My Shop') }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3 border-bottom">
                            <img src="{{ $user->getAvatar() }}" alt="profile" class="img-lg rounded-circle mb-3">
                        </div>
                        <div class="mb-3">
                            <h3>{{ $user?->store?->getTranslation('store_name') }}</h3>
                        </div>
                        <p class="mx-auto mb-2">
                            {{ $user?->store?->getTranslation('store_tagline') ??'N/A' }}
                        </p>

                    </div>

                    <div class="text-center mt-4">

                        <a href="{{ route('seller.profile.shop.update') }}" class="btn btn-sm btn-warning mb-2 mr-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                    </div>
                </div>
            </div>
            </div>
            <div class="col-md-8">
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <table class="table org-data-table table-bordered">
                        <tbody>
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
                                <td> {{ $user?->store?->getTranslation('store_tagline') }} </td>
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
                                    {{ $user?->store?->getTranslation('meta_title') ?? 'N/A'}}
                                </td>
                            </tr>

                            <tr>
                                <td>Meta Description</td>
                                <td>
                                    {{ $user?->store?->getTranslation('meta_description') ?? 'N/A'}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@stop
@push('scripts')
<script type="text/javascript">
</script>
@endpush