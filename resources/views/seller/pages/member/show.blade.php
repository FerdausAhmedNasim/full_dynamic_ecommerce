@extends('seller.pages.member.layout.master')

@section('title', 'Client Details')

@section('clientContent')

<div class="row">
    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 stretch-card">
        <div class="card box-shadow card-design mt-2 mb-2">
            <div class="client-card-title">
                <span>Client Details</span>
            </div>
            <div class="card-body client-card-body py-2" >

                <table class="table client-profile-table">
                    <tbody>
                        <tr>
                            <td>NHI</td>
                            <td>{{ $member->user->nhi ? $member?->user?->nhi : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $member?->user?->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $member?->user?->phone }}</td>
                        </tr>
                        <tr>
                            <td>Ethnicity</td>
                            <td>{{ $member->ethnicity }}</td>
                        </tr>
                        <tr>
                            <td>DOB</td>
                            <td>{{ $member?->user?->dob ? getFormattedDate($member->user->dob) : 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    @if(isset($clientAlerts) && count($clientAlerts) > 0)
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 stretch-card">
        <div class="card box-shadow card-design mt-2 mb-2">
            <div class="client-card-title">
                <span class="text-left">Alerts</span>

                <div class="text-right btn-right">
                    <button onclick="showMore( {{ $member->id }} )" class="alert-see-more-btn"> See More</button>
                </div>
            </div>
            <div class="card-body client-card-body py-2" >
                <ul class="list-unstyled">
                    @foreach($clientAlerts as $index => $clientAlert)
                        <li> {{ ++$index }}. {{ $clientAlert->alert->name }} ({{ $clientAlert->alert->details }})</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    @if(isset($clientReferral) && count($clientReferral) > 0)
    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 stretch-card">
        <div class="card box-shadow card-design mt-2 mb-2">
            <div class="client-card-title">
                <span>Enrolled Service List</span>
            </div>
            <div class="card-body client-card-body py-2 table-responsive">
                <table class="table client-profile-table">
                    <tbody>
                        @foreach($clientReferral as $key => $referral)
                        <tr>
                            <td> {{ $referral->service->name }} </td>
                            <td> {{ $referral->referTo->user->full_name }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>

@endsection
