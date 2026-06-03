@extends('public.layout.master')

@section('title', settings('app_title') ? settings('app_title') : 'Privacy Policy')

@section('content')
<section class="pt-0">
    <div class="container-md">
        <h1 class="fs-4">{{$page->getTranslation('title')}}</h1>
        <div class="mt-3">
            <div>{!! $page->getTranslation('content') !!}</div>
        </div>
    </div>
</section>
@endsection
