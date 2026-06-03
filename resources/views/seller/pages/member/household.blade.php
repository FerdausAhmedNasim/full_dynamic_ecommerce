@extends('seller.pages.member.layout.master')

@section('title', 'Client Household')

@section('clientContent')

<div class="row">
    <div class="col-md-12 mb-4">

        @if(isset($user_household))
        <div class="card-body py-sm-4">
            <div class="border-bottom text-center pb-2 table-responsive">

                <table class="table org-data-table table-bordered">
                    <tbody>
                        <tr>
                            <td>Number Of Member</td>
                            <td> {{ $user_household->number_of_member }} </td>
                        </tr>
                        <tr>
                            <td>18 Plus Member</td>
                            <td> {{ ucwords($user_household->person_18_and_over) }} </td>
                        </tr>
                        <tr>
                            <td>Under 18 Member</td>
                            <td> {{ $user_household->person_under_18 }} </td>
                        </tr>
                        <tr>
                            <td>Primary Langeage</td>
                            <td> {{ ucwords($user_household->primary_language) }} </td>
                        </tr>
                        <tr>
                            <td>Secondary Langeage</td>
                            <td> {{ $user_household->secondary_language }} </td>
                        </tr>
                        <tr>
                            <td>Third Langeage</td>
                            <td> {{ $user_household->third_language }} </td>
                        </tr>
                        <tr>
                            <td>Helthy Home Initiative</td>
                            <td>
                                <span
                                    class="badge {{($user_household->healthy_home_initiative) ? "btn2-secondary" : "btn-secondary"}}">
                                    {{ ($user_household->healthy_home_initiative == 1) ? "Yes" : "No" }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td> Smoker Status </td>
                            <td>
                                <span
                                    class="badge {{($user_household->smoker_status) ? "btn2-secondary" : "btn-secondary"}}">
                                    {{ ($user_household->smoker_status == 1) ? "Yes" : "No" }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td>Pet In House </td>
                            <td>
                                <span
                                    class="badge {{($user_household->pet_in_house) ? "btn2-secondary" : "btn-secondary"}}">
                                    {{ ($user_household->pet_in_house == 1) ? "Yes" : "No" }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td> Number Of Pet In House</td>
                            <td> {{ $user_household->number_of_pets }} </td>
                        </tr>
                        <tr>
                            <td>Type Of Pet</td>
                            <td> {{ $user_household->type_of_pet }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if ($user_household->user_id == auth()->id())
            <div class="text-center mt-3 border-top">
                <a href="{{ route('seller.house_hold.update', $user_household->id ) }}"
                    class="btn btn-sm btn-warning mb-2 mr-2 mt-4"><i class="fas fa-edit"></i> Edit</a>
            </div>
            @endif
        </div>

        @else
        <div class="card-body py-sm-4 text-center">
             No Data Available
        </div>
        @endif
    </div>
</div>
@endsection