@extends('public.member_dashboard.dashboard_master')
@section('profile', 'active')

@section('member_content')
<div class="row">
    <div class="col-md-12 content-area">
        <h2>Verify Profile</h2>
        <hr>
        <div class="row d-flex flex-column align-items-center justify-content-center p-4 rounded-4">
            <form method="post" action="{{ route('member.dashboard.profile.verify') }}" class="client-signup-form"
                enctype="multipart/form-data">
                @csrf

                <div class="row gy-4 default-show">
                    <div class="col-12">
                        <div class="row gy-4 gx-5">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label required required" for="name">
                                        {{__('First Nominated By') }} </label>
                                    <div class="col-sm-9 ">
                                        @if(!authMember()->nominated_by && !authMember()->is_nominated)
                                        <select class="select form-control @error('nominated_by') error @enderror"
                                            name="nominated_by" id="nominated" style="width: 100%;" required>
                                            <option value="" selected disabled>Select One</option>
                                            @foreach($nominated as $nomitatedBy)
                                            <option value="{{ $nomitatedBy->id }}" {{ old('nominated_by')==$nomitatedBy->id
                                                            ? "selected" : "" }} data-params="{{ $nomitatedBy->id }}">
                                                {{ $nomitatedBy->full_name }}-ID:{{$nomitatedBy->id}}</option>
                                            @endforeach
                                        </select>
                                        @error('nominated_by')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        @elseif(authMember()->nominated_by && !authMember()->is_nominated)
                                        <div>Request Sent to : {{authMember()->nominated->full_name}}-ID:{{authMember()->nominated->id}}, Verify Status: 
                                            <span class="badge bg-warning">Pending</span> 
                                            <a class="icon-btn ms-3"
                                                href="{{ route('member.dashboard.profile.verify.resend', 1) }}">
                                                <i class="fa-solid fa-repeat"></i> Resend
                                            </a>
                                            <a class="icon-btn ms-3"
                                                href="{{ route('member.dashboard.profile.verify.edit', 1) }}">
                                                <i class="fa-solid fa-edit"></i> Edit
                                            </a>
                                        </div>

                                        @else
                                        <h6>Verify Request Sent to : {{authMember()->nominated->full_name}}-ID:{{authMember()->nominated->id}}, Verify Status: <span
                                                class="badge bg-success">Verified</span></h6>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label required required" for="name">{{
                                                __('Seconded Nominated By') }}</label>
                                    <div class="col-sm-9">
                                        @if(!authMember()->seconded_by && !authMember()->is_seconded)
                                        <select class="select form-control @error('seconded_by') error @enderror"
                                            name="seconded_by" id="seconded" style="width: 100%;" required>
                                            <option value="" selected disabled>Select One</option>
                                            @foreach($seconded as $secondedBy)
                                            <option value="{{ $secondedBy->id }}" {{ old('seconded_by')==$secondedBy->id
                                                        ? "selected" : "" }} data-params="{{ $secondedBy->id }}">
                                                {{ $secondedBy->full_name }}-ID:{{$secondedBy->id}}</option>
                                            @endforeach
                                        </select>
                                        @error('seconded_by')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror

                                        @elseif(authMember()->seconded_by && !authMember()->is_seconded)
                                        <div>Request Sent to : {{ authMember()->seconded->full_name }}-ID:{{authMember()->nominated->id}}, Verify Status: 
                                            <span class="badge bg-warning">Pending</span> 
                                            <a class="icon-btn ms-3"
                                                href="{{ route('member.dashboard.profile.verify.resend', 2) }}">
                                                <i class="fa-solid fa-repeat"></i> Resend
                                            </a>
                                            <a class="icon-btn ms-3"
                                                href="{{ route('member.dashboard.profile.verify.edit', 2) }}">
                                                <i class="fa-solid fa-edit"></i> Edit
                                            </a>
                                        </div>
                                        @else
                                        <h6>Verify Request to : {{ authMember()->seconded->full_name }}-ID:{{authMember()->nominated->id}}, Verify Status: <span
                                                class="badge bg-success">Verified</span></h6>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!authMember()->nominated_by && !authMember()->seconded_by)
                    <div class="text-center mt-3">
                        <button class="btn register-btn" type="submit"> Verify </button>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
     function hideThis(){
        $(".default-show").addClass('d-none');
        $(".default-hide").removeClass('d-none');
     }
</script>