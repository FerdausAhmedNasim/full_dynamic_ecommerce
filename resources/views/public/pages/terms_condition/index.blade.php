@extends('public.layout.master')

@section('title', settings('app_title') ? settings('app_title') : 'Terms Condition')

@section('content')
<section class="terms-condition pt-0">
    <div class="container-lg">
        <h1 class="fs-3">{{$page->getTranslation('title')}}</h1>
        <div class="mt-4">
            <p>{!! $page->getTranslation('content') !!}</p>
        </div>
    </div>
</section>
@endsection