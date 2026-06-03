<div class="row">
    <div class="col-md-12 table-responsive">
        @if(isset($health))
            <table class="table org-data-table table-bordered">
                <tbody>
                    <tr>
                        <td>Vaccination Status</td>
                        <td> {{ $health->vaccination_status ? : 'N/A' }} </td>
                    </tr>
                    <tr>
                        <td>Disability Status</td>
                        <td> {{ $health->disablity_status ? 'Yes' : 'No' }} </td>
                    </tr>
                    <tr>
                        <td>Blood Group</td>
                        <td> {{ $health->blood_group ? : 'N/A' }} </td>
                    </tr>
                    <tr>
                        <td>Medical Practice</td>
                        <td> {{ $health->medical_practice ? : 'N/A' }} </td>
                    </tr>
                    <tr>
                        <td style="width:30%;">GP Name</td>
                        <td style="white-space: unset;"> {{ $health->gp_name ? : 'N/A' }} </td>
                    </tr>
                    <tr>
                        <td>Create At</td>
                        <td> {{ getFormattedDateTime($health->created_at) }} </td>
                    </tr>
                </tbody>
            </table>

                <div class="pt-4 text-center">
                    <a href="{{ route('seller.health.update', $health->id ) }}"
                        class="btn btn-sm btn-warning mb-2 mr-2">
                        <i class="fas fa-edit"></i> Update
                    </a>
                </div>
        @else
                <div class="card-body py-sm-4 text-center">
                    <a href="{{ route('seller.health.create') }}"
                        class="btn btn-sm btn-success mb-2 mr-2">
                        <i class="fas fa-plus"></i> Add New Health
                    </a>
                </div>

        @endif

    </div>
</div>
