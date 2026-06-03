@extends('seller.layouts.master')

@section('title', 'Bank Account Details')

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('seller.bankAccount.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Bank Account Details')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3">
                            <p class="text-success">Bank Account Name</p>
                            <h3>{{ $bank->account_name }} </h3>
                        </div>
                    </div>
                    <div class="text-center my-4">
                        <a href="{{ route('seller.bankAccount.edit', $bank->id) }}" class="btn btn-sm btn-warning mr-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <button class="btn btn-sm btn-danger mr-1"
                            onclick="confirmFormModal('{{ route('seller.bankAccount.delete', $bank->id) }}', 'Confirmation', 'Are you sure to delete operation?')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-light-secondary">
                    <span>Details</span>
                </div>

                <div class="card-body py-4">
                    <table class="table table-bordered" id="dataTable">
                        <tbody>
                            <tr>
                                <td><strong>#Id</strong></td>
                                <td>{{ $bank->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Bank Name</strong></td>
                                <td>{{ $bank->bank_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Branch Name</strong></td>
                                <td>{{ $bank->branch_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Account Name</strong></td>
                                <td>{{ $bank->account_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Account Number</strong></td>
                                <td>{{ $bank->account_number }}</td>
                            </tr>
                            {{-- <tr>
                                <td><strong>Routing Number</strong></td>
                                <td>{{ $bank->routing_number }}</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@stop
