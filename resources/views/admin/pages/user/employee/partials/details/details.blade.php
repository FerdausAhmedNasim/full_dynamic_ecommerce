<table class="table org-data-table table-bordered">
    <tbody>
        <tr>
            <td>Status</td>
            <td>
                @php
                    use App\Library\Enum;
                    if ($employee?->user?->status == Enum::USER_STATUS_PENDING) {
                        $class = 'badge-secondary';
                    } elseif ($employee?->user?->status == Enum::USER_STATUS_ACTIVE) {
                        $class = 'badge-success';
                    } elseif ($employee?->user?->status == Enum::USER_STATUS_SUSPENDED) {
                        $class = 'badge-danger';
                    }
                @endphp

                <div class="badge {{ $class }}">
                    {{ Enum::getUserStatus($employee?->user?->status) }}
                </div>
            </td>
        </tr>

        <tr>
            <td>Location</td>
            <td> {{ $employee?->user?->location ?? 'N/A' }} </td>
        </tr>

        <tr>
            <td>Date Of Birth</td>
            <td> {{ getFormattedDate($employee?->user?->dob) }} </td>
        </tr>
        <tr>
            <td>User Type</td>
            <td class="text-capitalize"> {{ $employee?->user?->user_type == \APP\Library\Enum::USER_TYPE_SUPER_ADMIN ? 'Database User' : $employee?->user?->user_type }} </td>
        </tr>

        <tr>
            <td>Phone</td>
            <td> {{ $employee?->user?->phone }} </td>
        </tr>
        <tr>
            <td>Email</td>
            <td> {{ $employee?->user?->email }} </td>
        </tr>
        <tr>
            <td>Gender</td>
            <td> {{ $employee?->user?->gender }} </td>
        </tr>
        <tr>
            <td>Job Title</td>
            <td> {{ $employee->job_title ?? 'N/A' }} </td>
        </tr>
        <tr>
            <td>Employment Type</td>
            <td> {{ $employee->employment_type ?? 'N/A' }} </td>
        </tr>
        <tr>
            <td>Entitlement to Work</td>
            <td> {{ $employee->entitlement_to_work ?? 'N/A' }} </td>
        </tr>

        <tr>
            <td>Joined At</td>
            <td> {{ getFormattedDateTime($employee->created_at) }} </td>
        </tr>
        {{-- <tr>
            <td>Verified</td>
            <td>
                @if($employee?->user?->email_verified_at)
                    <i class="fa-solid fa-circle-check"></i>
                @else
                    <i class="fa-solid fa-circle-xmark"></i>
                @endif
            </td>
        </tr> --}}
        <tr>
            <td>Roles</td>
            <td>
                @foreach ($employee?->user?->getRole() as $key => $value)
                    <span class="badge btn2-secondary mr-2">{{ $value->name }}</span>
                @endforeach
            </td>
        </tr>

    </tbody>
</table>
