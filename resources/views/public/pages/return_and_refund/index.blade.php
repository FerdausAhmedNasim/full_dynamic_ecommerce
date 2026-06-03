@extends('public.layout.master')

@section('title', settings('app_title') ? settings('app_title') : 'Return And Refund Policy')

@section('content')
<section class="return-refund pt-0">
    <div class="container-md">
        <div class="mt-5">
            <div class="mb-md-4 d-flex justify-content-md-center">
                <ul class="nav nav-tabs tab-style-color-2 tab-style-color" id="myTab">
                    <li class="nav-item">
                        <button class="nav-link btn active" id="returnProduct-tab" data-bs-toggle="tab"
                            data-bs-target="#ReturnProduct" type="button">How to Return a Product</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link btn" id="returnPolicy-tab" data-bs-toggle="tab"
                            data-bs-target="#ReturnPolicy" type="button">Return Policy</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link btn" id="Refund-tab" data-bs-toggle="tab" data-bs-target="#Refund"
                            type="button">Refund Policy</button>
                    </li>
                </ul>
            </div>
            <div>
                <div id="ReturnProduct" class="tab-pane fade show active ">
                    <h2>Return Product</h2>
                    <p class="mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa deleniti, accusamus
                        velit sed, in asperiores, eveniet quaerat odio non eligendi placeat tenetur suscipit mollitia
                        corrupti cumque ducimus. Nemo ipsum ab, reprehenderit autem unde delectus quis possimus velit
                        porro voluptas culpa praesentium molestias repudiandae est deserunt commodi dolore dolores
                        voluptates repellendus!</p>
                </div>
                <div id="ReturnPolicy" class="tab-pane fade ">
                    <h2>Return Policy</h2>
                    <p class="mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa deleniti, accusamus
                        velit sed, in asperiores, eveniet quaerat odio non eligendi placeat tenetur suscipit mollitia
                        corrupti cumque ducimus. Nemo ipsum ab, reprehenderit autem unde delectus quis possimus velit
                        porro voluptas culpa praesentium molestias repudiandae est deserunt commodi dolore dolores
                        voluptates repellendus!</p>
                </div>
                <div id="Refund" class="tab-pane fade ">
                    <h1 class="fs-4">{{$page->getTranslation('title')}}</h1>
                    <div class="mt-3 ">
                        <div>{!! $page->getTranslation('content') !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
