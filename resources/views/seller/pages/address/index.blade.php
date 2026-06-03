<div class="row" id="addressTableShow">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2">
                        <h4 class="text-center">Address</h4>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="20%">Street Name & Number :</td>
                    <td width="40%">
                        {{ $address?->street_address }}
                    </td>
                </tr>

                <tr>
                    <td>Area :</td>
                    <td>{{ $address->area->en_name }}</td>
                </tr>

                <tr>
                    <td>Thana :</td>
                    <td>{{ $address->area->thana->en_name }}</td>
                </tr>

                <tr>
                    <td>District :</td>
                    <td>{{ $address->area->district->en_name }}</td>
                </tr>

                <tr>
                    <td>Division :</td>
                    <td>{{ $address->area->division->en_name }}</td>
                </tr>

                <tr>
                    <td>Latitude :</td>
                    <td>{{$address->latitude??'N/A'}}</td>
                </tr>
                <tr>
                    <td>Longitude :</td>
                    <td>{{$address->longitude??'N/A'}}</td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <hr>
        <div class="text-center mt-4">
            <a href="javascript:void(0)" id="addressEdit" class="btn btn-sm btn-warning mb-2 mr-2"><i
                    class="fas fa-edit"></i> Edit </a>
        </div>
    </div>
</div>