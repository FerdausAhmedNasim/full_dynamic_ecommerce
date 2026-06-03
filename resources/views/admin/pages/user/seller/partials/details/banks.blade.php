@extends('admin.pages.user.seller.layout.master')

@section('title', 'Seller Details')
@section('details', 'active')

@section('clientContent')

<div class="row">
    @if ($banks->count() > 0)
    @foreach ($banks as $bank)
    <div class="col-md-6 stretch-card">
        <div class="card box-shadow1 card-design mt-2 mb-2">
            <div class="client-card-title">
                <span>Bank Details</span>
            </div>
            <div class="card-body client-card-body py-2">

                <table class="table table-bordered" id="dataTable">
                    <tbody>
                        <tr>
                            {{-- <td><strong>#Id</strong></td>
                            <td>{{ $bank->id }}</td> --}}
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
    @endforeach
    @else
    <div class="w-100">
        <h4 class="text-center">Banks are not available...</h4>
    </div>
    @endif
</div>

@endsection
