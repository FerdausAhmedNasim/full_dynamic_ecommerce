@extends('seller.layouts.master')
@section('title', __('Attendance'))
@section('content')

<div class="content-wrapper">


    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ __('Attendance' ) }}</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <div class="text-center pb-2">
                        <div class="mb-3">
                            <table class="table table-bordered" id="attendanceDataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>In Time</th>
                                        <th>In Location</th>
                                        <th>Out Time</th>
                                        <th>Out Location</th>
                                        <th>Sign Out Type</th>
                                        <th>Expected Back Time</th>
                                        <th>In time Note</th>
                                        <th>Out time Note</th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <form id="createInForm" onsubmit="signIn(event, this)">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title title-in" id="exampleModalLabel" style="text-transform: capitalize; display: none;"> <i class="fa fa-sign-in" aria-hidden="true"></i> Sign In</h5>
                    <h5 class="modal-title title-out" id="exampleModalLabel" style="text-transform: capitalize"> <i class="fa fa-sign-out" aria-hidden="true"></i> Sign Out</h5>
                    <h5 class="modal-title title-edit" id="exampleModalLabel" style="text-transform: capitalize; display: none;"> <i class="fas fa-edit" aria-hidden="true"></i> Update Attendance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- IN -->

                <input type="hidden" name="can_sign_in" value="{{ $can_sign_in }}" id="canSignIn">

                <div class="modal-body">

                    <div id="signInBody">
                        <div class="form-group">
                            <label for="name">{{ __('Sign In Time') }}</label>
                            <input name="in_time" id="in_time" type="datetime-local" class="form-control" aria-describedby="emailHelp" placeholder="Sign In Time">
                            <span class="text-danger in_time"></span>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Sign In Note') }}</label>
                            <textarea class="form-control" rows="5" name="in_time_note" id="in_time_note" aria-describedby="emailHelp" placeholder="Sign In Note"></textarea>
                        </div>
                    </div>

                    <!-- OUT -->
                    <div id="signOutBody" style="display: none; padding-top: 0">
                        <div class="form-group">
                            <label for="name">{{ __('Sign Out Time') }}</label>
                            <input name="out_time" id="out_time" type="datetime-local" class="form-control" aria-describedby="emailHelp" placeholder="Sign Out Time">
                            <span class="text-danger out_time"></span>
                        </div>

                        <div class="form-group" id="signOutType">
                            <label for="name">{{ __('Sign Out Type') }}</label>
                            <select class="form-control" name="sign_out_type" id="sign_out_type">
                                <option value="" class="selected highlighted">Select One</option>
                                @foreach(\App\Library\Enum::getSignOutType() as $index => $value)
                                    <option class="text-capitalize" value="{{ $index }}" {{(old("sign_out_type") == $index) ? "selected" : ""}}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger sign_out_type"></span>
                        </div>

                        <div class="form-group" id="expected_back_time" style="display: none;">
                            <label for="name">{{ __('Expected Back Time') }}</label>
                            <input name="expected_back_time" type="datetime-local" id="expected_back_time2" class="form-control" placeholder="Expected Back Time">
                            <span class="text-danger expected_back_time"></span>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Sign Out Note') }}</label>
                            <textarea class="form-control" id="out_time_note" rows="5" name="out_time_note" aria-describedby="emailHelp" placeholder="Sign Out Note"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn mr-3 close bg-success p-3 text-white" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i> {{ __('Close') }}</button>
                    <button type="submit" class="btn btn2-secondary btn-in"><i class="fa fa-sign-in" aria-hidden="true"></i></i> Sign In</button>
                    <button style="display: none;" type="submit" class="btn btn-danger btn-out"><i class="fa fa-sign-out" aria-hidden="true"></i></i> Sign Out</button>
                    <button style="display: none;" type="submit" class="btn btn2-secondary btn-edit"><i class="fas fa-save"></i> {{ __('Save') }} </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection


@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
    @vite('resources/employee_assets/js/attendance/index.js')
@endpush
