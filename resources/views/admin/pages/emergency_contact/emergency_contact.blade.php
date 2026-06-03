@php
    use App\Library\Helper;
@endphp

<div class="row">
    <div class="col-xxl-5 col-xl-5 col-lg-12 col-md-12 mb-4">
        <div class="card">

            @if(isset($emergency_contact))
            <div class="card-body py-sm-4">
                <div class="border-bottom text-center pb-2">
                    <div class="mb-3 border-bottom">
                        <img src="{{ $emergency_contact->getImage() }}" alt="profile" class="img-lg rounded-circle mb-3">
                    </div>
                    <div class="mb-3">
                        <h3>{{$emergency_contact->name}}</h3>
                    </div>
                </div>
                
                <div class="text-center mt-4">

                    @if(Helper::hasAuthRolePermission('emergency_contact_update'))
                    <a href="{{ route('admin.user.emergency.update', $emergency_contact->id) }}"
                        class="btn btn-sm btn-warning mb-2 mr-2"><i class="fas fa-edit"></i> Edit</a>
                    @endif

                    @if(Helper::hasAuthRolePermission('emergency_contact_delete'))
                    {{-- <button class="btn btn-sm btn-danger mb-2"
                        onclick="confirmFormModal('{{ route('admin.user.emergency.delete.api', $emergency_contact->id) }}', 'Confirmation', 'Are you sure to delete operation?')"><i
                            class="fas fa-trash-alt"></i> Delete </button> --}}
                    @endif

                </div>

            </div>
            @else
            <div class="card-body py-sm-4 text-center">
                <a href="{{ route('admin.user.emergency.create', $user_id) }}"
                    class="btn btn-sm btn-success mb-2 mr-2">
                    <i class="fas fa-plus"></i> Add New Emergency Contact
                </a>
            </div>
            @endif
        </div>
    </div>
    <div class="col-xxl-7 col-xl-7 col-lg-12 col-md-12 mb-4">
        <div class="card shadow-sm">
            @if(isset($emergency_contact))
            <div class="card-body table-responsive">
                <table class="table org-data-table table-bordered">
                    <tbody>
                        <tr>
                            <td>Mobile</td>
                            <td>{{ $emergency_contact->mobile_number }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td> {{ $emergency_contact->email ?? 'N/A' }} </td>
                        </tr>
                        <tr>
                            <td>Relationship</td>
                            <td> {{ $emergency_contact->relationship }} </td>
                        </tr>
                        <tr>
                            <td>Note</td>
                            <td> {{ $emergency_contact->note ?? 'N/A' }} </td>
                        </tr>
                        <tr>
                            <td style="width:30%;">Address</td>
                            <td style="white-space: unset;"> {{ $emergency_contact->address ?? 'N/A' }} </td>
                        </tr>
                        <tr>
                            <td>Create At</td>
                            <td> {{ getFormattedDateTime($emergency_contact->created_at) }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
            <div class="card-body">
                No Emergency Contact Added.
            </div>
            @endif
        </div>
    </div>
</div>
