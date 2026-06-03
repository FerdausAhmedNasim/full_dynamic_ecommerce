<div class="row">
    <div class="col-md-12 mb-4">
        @php
        use App\Library\Helper;
        $user_role = App\Models\User::getAuthUser()->roles()->first();
        $hasPermission = Helper::hasAuthRolePermission('ticket_create');
        @endphp

        <div class="card shadow-sm">
            <div class="card-body">

                <table id="DataTable" class="table table-bordered ticket-data-table">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
