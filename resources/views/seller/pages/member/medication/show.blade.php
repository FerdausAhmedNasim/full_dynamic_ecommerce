@extends('seller.layouts.master')

@section('title', 'Medication Details')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.member.show.medication', $medication->client_id)) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Medication Details')) }}</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-md-5 pb-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3">
                            <h3>{{ $medication->name }}</h3>
                        </div>
                    </div>

                    <table class="table org-data-table table-bordered">
                          <tbody>

                            <tr><td>ID</td><td>{{ $medication->id }}</td></tr>

                            <tr>
                                <td>Follow Up Date</td>
                                <td> {{ getFormattedDateTime($medication->follow_up_date) }} </td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="text-center mt-4">

                        <a href="{{ route('seller.member.medication.edit', $medication->id) }}" class="btn btn-sm btn-warning mb-2 mr-2"><i class="fas fa-edit"></i> Edit</a>

                        <button class="btn btn-sm mb-2 mr-2 btn-danger"
                                    onclick="confirmFormModal('{{ route('seller.member.medication.delete', $medication->id) }}', 'Confirmation', 'Are you sure to delete operation?')"><i class="fas fa-trash-alt"></i> Delete </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body py-4">
                    {!! $medication->note !!}
                </div>
            </div>
        </div>
    </div>


</div>

@stop

