
<div class="row">
    <div class="col-md-6 stretch-card">
        <div class="card box-shadow1 card-design mt-2 mb-2">
            <div class="client-card-title">
                <span>Customer Details</span>
            </div>
            <div class="card-body client-card-body py-2" >

                <table class="table client-profile-table">
                    <tbody>
                        <tr>
                            <td>User Name</td>
                            <td>{{ $user?->user_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $user?->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $user?->phone }}</td>
                        </tr>
                        <tr>
                            <td>DOB</td>
                            <td>{{ $user?->dob ? getFormattedDate($user->dob) : 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <div class="col-md-6 stretch-card">
        <div class="card box-shadow2 card-design mt-2 mb-2">
            <div class="card-body client-card-body py-2 d-flex align-items-center justify-content-center" >
                <h2 class="">Coming Soon...</h2>
            </div>
        </div>
    </div>

</div>
