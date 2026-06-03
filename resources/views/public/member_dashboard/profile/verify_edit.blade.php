@extends('public.member_dashboard.dashboard_master')
@section('profile', 'active')

@section('member_content')
<div class="row">
    <div class="col-md-12 content-area">
        <h2>Edit Verify</h2>
        <hr>
        <div class="row d-flex flex-column align-items-center justify-content-center p-4 rounded-4">
            <form method="post" action="{{ route('member.dashboard.profile.verify.edit', $type) }}"
                class="client-signup-form" enctype="multipart/form-data">
                @csrf

                <div class="row gy-4 default-show">
                    <div class="col-12">
                        <div class="row gy-4 gx-5">
                            @if($type == 1)
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label required required" for="name">
                                        {{__('First Nominated By') }} </label>
                                    <div class="col-sm-9 ">
                                        <select class="select form-control @error('nominated_by') error @enderror"
                                            name="nominated_by" id="nominated" style="width: 100%;" required>
                                            <option value="" selected disabled>Select One</option>
                                            @foreach($nominated as $nomitatedBy)
                                                @if( $nomitatedBy->id != authMember()->seconded_by)
                                                    <option value="{{ $nomitatedBy->id }}" {{ old('nominated_by', authMember()->nominated_by)==$nomitatedBy->id
                                                            ? "selected" : "" }} data-params="{{ $nomitatedBy->id }}">
                                                {{ $nomitatedBy->full_name }}-ID:{{$nomitatedBy->id}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('nominated_by')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($type == 2)
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label required required" for="name">{{
                                                __('Seconded Nominated By') }}</label>
                                    <div class="col-sm-9">
                                       
                                        <select class="select form-control @error('seconded_by') error @enderror"
                                            name="seconded_by" id="seconded" style="width: 100%;" required>
                                            <option value="" selected disabled>Select One</option>
                                            @foreach($seconded as $secondedBy)
                                            @if( $secondedBy->id != authMember()->nominated_by)
                                            <option value="{{ $secondedBy->id }}" {{ old('seconded_by', authMember()->seconded_by)==$secondedBy->id
                                                        ? "selected" : "" }} data-params="{{ $secondedBy->id }}">
                                                {{ $secondedBy->full_name }}-ID:{{$secondedBy->id}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('seconded_by')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button class="btn register-btn" type="submit"> Edit </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
    function hideThis() {
        $(".default-show").addClass('d-none');
        $(".default-hide").removeClass('d-none');
    }
</script>