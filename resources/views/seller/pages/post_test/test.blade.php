@extends('seller.layouts.master')

@section('title', __('Post Test'))

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('seller.post.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__(' Post Test')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 mb-2">
        <div class="card shadow-sm">
                <div class="card-body py-sm-4">

                    <div class="border-bottom text-center pb-2">
                        <h3>{{ $post?->title }}</h3>
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
                                    <a href="{{ asset($post->attachment) }}" target="_blank"><i
                                            class="fa-solid fa-eye"></i> View </a>
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
            <div class="card shadow-sm mt-2">
                <div class="card-body py-sm-4">
                    <div class="border-bottom text-center mb-3">
                        <h3>Description</h3>
                    </div>
                    {!! $post->description !!}
                </div>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
            <div class="card shadow-sm">
                <div class="card-body m-3">
                    <div class="border-bottom text-center mb-2">
                        <h4>Test Questions</h4>
                    </div>
                    <form method="post" id="frmInfo"
                        action="{{ route('seller.post.answer', $post->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="wizard">

                            @foreach($questions as $key => $qus)
                            @if($qus->is_mcq == 1)
                            <h4>Question</h4>
                            <section>
                                <div class="col-md-12">
                                    <div class="my-2 p-4 card">

                                        <input type="hidden" class="form-control" name="is_mcq[]" value="1">
                                        <input type="hidden" class="form-control" name="qus_id[]"
                                            id="qus_id{{$qus->id}}" value="{{$qus->id}}">
                                        <input type="hidden" class="form-control qus_id" value="{{ $qus->id }}">

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="media">
                                                    <strong>Q{{++$key}} : &nbsp;</strong>
                                                    <div class="media-body">
                                                        <strong> {{$qus->question}}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row ml-3">
                                            <div class="col-md-6 mt-2">
                                                <div class="media">
                                                    <strong>A : &nbsp;</strong>
                                                    <div class="media-body">
                                                        <span> {{$qus->option1}}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-2">
                                                <div class="media">
                                                    <strong>B : &nbsp;</strong>
                                                    <div class="media-body">
                                                        <span> {{$qus->option2}}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-2">
                                                <div class="media">
                                                    <strong>C : &nbsp;</strong>
                                                    <div class="media-body">
                                                        <span> {{$qus->option3}}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-2">
                                                <div class="media">
                                                    <strong>D : &nbsp;</strong>
                                                    <div class="media-body">
                                                        <span> {{$qus->option4}}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mt-3 col-md-12">
                                                <hr>
                                                <h5>Answer <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="submitted_answer[]" id="submitted_answer{{$qus->id}}"
                                                        required="" class="form-control">
                                                        <option value="" selected>Select Answer</option>
                                                        <option value="A"> Option A</option>
                                                        <option value="B"> Option B</option>
                                                        <option value="C"> Option C</option>
                                                        <option value="D"> Option D</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            @else
                            <h4>Question</h4>
                            <section>
                                <div class="col-md-12">
                                    <div class="my-2 p-4">
                                        <input type="hidden" class="form-control" name="is_mcq[]" value="0">
                                        <input type="hidden" class="form-control" name="qus_id[]" value="{{$qus->id}}">

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <strong> Q{{++$key}} : {{$qus->question}} </strong>
                                            </div>
                                        </div>

                                        <div class="row ml-3">
                                            <div class="col-md-12 mt-2">
                                                <span>A : Yes</span>
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <span>B : No</span>
                                            </div>

                                            <div class="form-group mt-3 col-md-12">
                                                <hr>
                                                <h5>Answer <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="submitted_answer[]" id="submitted_answer" required=""
                                                        class="form-control">
                                                        <option value="" selected="">Select Answer
                                                        </option>
                                                        <option value="A"> Option A</option>
                                                        <option value="B"> Option B</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            @endif
                            @endforeach
                        </div>
                        <button type="submit" class="d-none" id="textQuestionSubmitBtn"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    $(function () {
        var frmInfo = $('#frmInfo');
        var frmInfoValidator = frmInfo.validate();
        $("#wizard").steps({
            headerTag: "h4",
            bodyTag: "section",
            transitionEffect: "fade",
            enableAllSteps: true,
            transitionEffectSpeed: 500,
            onStepChanging: function (event, currentIndex, newIndex, direction) {
                if (currentIndex === 0) {
                    return frmInfo.valid();
                } else if (currentIndex === 1) {
                    return frmInfo.valid();
                }
                return true;
            },
            onFinishing: function (event, currentIndex) {
                if (currentIndex === 2) {
                    return frmInfo.valid();
                }
            },
            onFinished: function (event, currentIndex, newIndex) {
                $("#textQuestionSubmitBtn").click();
            },
            labels: {
                finish: "Finish",
                next: "Next",
                previous: "Previous"
            }
        });
    })
</script>
@endpush
