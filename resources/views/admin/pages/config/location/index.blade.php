@extends('admin.layouts.master')

@section('title', 'Location')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.more_settings.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Location' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Location IP</th>
                        <th>Details</th>
                        <th>Operator Name</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="showLocationDetails" tabindex="-1" role="dialog" aria-labelledby="alertDetailsModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-default" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"> <span id="show_subject"> </span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 ">
                        <span id="details" ></span><br><br>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                {!! \App\Library\Html::btnClose() !!}
            </div>
        </div>
        </form>

    </div>
</div>

@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/config/location/index.js')
@endpush
