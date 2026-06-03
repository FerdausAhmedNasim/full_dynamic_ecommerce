@extends('seller.pages.member.layout.master')

@section('title', 'Client Details')

@section('clientContent')

@php $user = $member->user; @endphp

<div class="text-center table-responsive">
    <table class="table org-data-table table-bordered">
        <tbody>
            <tr>
                <td>Status</td>
                <td>
                    @php
                        use App\Library\Enum;
                        if ($member?->user?->status == Enum::USER_STATUS_PENDING)
                            $class = 'badge-secondary';
                        else if ($member?->user?->status == Enum::USER_STATUS_ACTIVE)
                            $class = 'badge-success';
                        else if ($member?->user?->status == Enum::USER_STATUS_HOLD)
                            $class = 'badge-warning';
                        else if ($member?->user?->status == Enum::USER_STATUS_INACTIVE)
                            $class = 'badge-danger';
                    @endphp

                    <div class="badge {{ $class }}">
                        {{ Enum::getUserStatus($member?->user?->status) }}
                    </div>
                </td>
            </tr>
            <tr>
                <td>Date Of Birth</td>
                <td> {{ $member?->user?->dob ? getFormattedDate($member->user->dob) : 'N/A' }} </td>
            </tr>
            <tr>
                <td>User Type</td>
                <td> {{ ucwords($member?->user?->user_type) }} </td>
            </tr>
            <tr>
                <td>Phone</td>
                <td> {{ $member?->user?->phone }} </td>
            </tr>
            <tr>
                <td>Preferred Contact</td>
                <td> {{ ucwords($member->preferred_contact_type) }} </td>
            </tr>
            <tr>
                <td>Email</td>
                <td> {{ $user->email }} </td>
            </tr>
            <tr>
                <td>Gender</td>
                <td> {{ $member?->user?->gender }} </td>
            </tr>
            <tr>
                <td>Pronoun</td>
                <td> {{ $member?->user?->pro_noun }} </td>
            </tr>
            <tr>
                <td>NHI</td>
                <td> {{ $member?->user?->nhi ?? 'N/A'}} </td>
            </tr>

            <tr>
                <td>Ethnicity</td>
                <td> {{ $member->ethnicity }} </td>
            </tr>
            <tr>
                <td>IWI</td>
                <td> {{ $member->iwi }} </td>
            </tr>
            <tr>
                <td>Hapu</td>
                <td> {{ $member->hapu ?? 'N/A'}} </td>
            </tr>
            <tr>
                <td>Marae</td>
                <td> {{ $member->marae ?? 'N/A' }} </td>
            </tr>
            <tr>
                <td>Job Title</td>
                <td> {{ $member->job_title }} </td>
            </tr>
            <tr>
                <td>Employment Type</td>
                <td> {{ $member->employment_type }} </td>
            </tr>
            <tr>
                <td>Client Is</td>
                <td> {{ $member->client_is }} </td>
            </tr>
            <tr>
                <td>Employment Status</td>
                <td> {{ ucwords($member->employment_status) }} </td>
            </tr>
            <tr>
                <td>Joined At</td>
                <td> {{ getFormattedDateTime($member->created_at) }} </td>
            </tr>

            <tr>
                <td>{{ __('Photo ID') }}</td>
                <td> <img src="{{ $member?->user?->getPhotoId() }}" alt="photo_id" class="img-nid"> </td>
            </tr>

        </tbody>
    </table>
</div>

@endsection
