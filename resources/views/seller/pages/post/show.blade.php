@extends('seller.layouts.master')

@section('title', 'Post Details')

@section('content')


<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('seller.post.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Post Details')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-5 col-xl-5 col-lg-12 col-md-12">
        <div class="card shadow-sm">
                <div class="card-body py-sm-4">

                    <div class="border-bottom text-center pb-2">
                        <h3>{{ $post?->title }}</h3>
                    </div>

                    <div class="text-center mt-3 nav-tab border-bottom">
                        <a href="{{ route('seller.post.test', $post->id) }}" class="btn btn-sm btn-warning mb-2 mr-2">
                            Take the Quiz
                        </a>
                    </div>

                    <table class="table org-data-table table-bordered mt-2">
                        <tbody>

                            <tr>
                                <td class="text-center"> Type</td>
                                <td>
                                    {{ ucwords($post->type) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">Sending Date</td>
                                <td>
                                    {{ getFormattedDate($post->sending_date) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">Attachment</td>
                                <td>
                                    @if($post->attachment)
                                        <a href="{{ asset($post->attachment) }}" target="_blank"><i
                                                class="fa-solid fa-eye"></i> View </a>
                                    @else N/A @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">Created Date</td>
                                <td>
                                    {{ getFormattedDateTime($post->created_at) }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xxl-7 col-xl-7 col-lg-12 col-md-12">
        <div class="card shadow-sm mt-2">
                <div class="card-body py-sm-4">
                    <div class="border-bottom text-center mb-3">
                        <h3>Description</h3>
                    </div>
                    {!! $post->description !!}
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('scripts')
@endpush
