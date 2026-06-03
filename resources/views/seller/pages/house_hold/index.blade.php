<div class="row">
    <div class="col-md-12 ">

        @if(isset($user_household))
        <div class="card-body p-1">
            <div class="border-bottom text-center table-responsive">

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Number Of Member</td>
                            <td> {{ $user_household->number_of_member }} </td>
                        </tr>
                        <tr>
                            <td>18 Plus Member</td>
                            <td class="text-capitalize"> {{ $user_household->person_18_and_over }} </td>
                        </tr>
                        <tr>
                            <td>Under 18 Member</td>
                            <td> {{ $user_household->person_under_18 }} </td>
                        </tr>
                        <tr>
                            <td>Primary Langeage</td>
                            <td class="text-capitalize"> {{ $user_household->primary_language }} </td>
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

            <div class="text-center mt-4">
                <a href="{{ route('seller.house_hold.update', $user_household->id ) }}"
                    class="btn btn-sm btn-warning mb-2 mr-2"><i class="fas fa-edit"></i> Edit</a>
            </div>
        </div>

        @else
        <div class="card-body py-sm-4 text-center">
            <a href="{{ route('seller.house_hold.create') }}" class="btn btn-sm btn-success mb-2 mr-2">
                <i class="fas fa-plus"></i> Add New Household
            </a>
        </div>
        @endif
    </div>
</div>