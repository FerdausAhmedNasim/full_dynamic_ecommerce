
<div class="row">
    <div class="col-md-6 stretch-card">
        <div class="card box-shadow1 card-design mt-2 mb-2">
            <div class="client-card-title">
                <span>Client Details</span>
            </div><hr>
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
    <div class="col-md-6 stretch-card">
        <div class="card box-shadow3 card-design mt-2 mb-2">
            <div class="client-card-title">
                <span class="text-left">Alerts</span>

                <div class="text-right btn-right">
                    <a href="#alert-2" onclick="showMore( {{ $member->id }} )" class="text-decoration-none alert-see-more-btn"> See More</a>
                </div>
            </div>
            <hr>
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
    <div class="col-md-6 stretch-card">
        <div class="card box-shadow1 card-design mt-2 mb-2">
            <div class="client-card-title">
                <span>Enrolled Service List</span>
            </div>
            <div class="card-body client-card-body py-2">
                {{-- <div class="row">
                    <div class="col-md-6">
                        <div class="boxDesign text-center">
                            <h5>Service Name</h5>
                            <p>Doctor Name</p>
                        </div>
                    </div>
                </div> --}}

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

    <div class="col-md-6 stretch-card">
        <div class="card box-shadow2 card-design mt-2 mb-2">
            <div class="card-body client-card-body py-2 d-flex align-items-center justify-content-center" >
                <h2 class="">Coming Soon...</h2>
            </div>
        </div>
    </div>

</div>
