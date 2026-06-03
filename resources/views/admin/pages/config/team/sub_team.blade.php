<div class="card shadow-sm">
    <div class="pl-3 pt-4">
        <h4> Sub Team</h4>
        <hr>
    </div>
    <div class="card-body">

        <table id="subTeamDataTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Team Leader / Manager</th>
                    <th>Status</th>
                    <th>Operator</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sub_team as $key => $data)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data?->teamLeader?->full_name }}</td>

                        @php
                            $is_check = $data->is_active ? "checked" : "";
                            $route = "'" . route('admin.team.status_change', $data->id) . "'";
                        @endphp

                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                    onchange="changeStatus(event, {{ $route }})"
                                    class="custom-control-input"
                                    id="primarySwitch_{{ $data->id }}" {{ $is_check }} >
                                <label class="custom-control-label" for="primarySwitch_{{ $data->id }}"></label>
                            </div>
                        </td>

                        <td>{{ $data->operator->full_name }}</td>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
