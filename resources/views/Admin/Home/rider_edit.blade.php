@extends('Master.main')
@section('title')
    Rider
@endsection
<style>
    .header {
        margin-top: 20px;
        margin-left: 50px;
        text-align: center;
        font-size: 30px;
    }

    .form-control {

        height: 2.5rem !important;
        border-radius: 10px !important;
        margin-bottom: 25px;
    }

    .button0 {
        width: 40% !important;
        margin-bottom: 5px !important;
    }
</style>
@section('content')
    <div class="container-fluid" style="margin-left: 10px;">
        <div class="col-xs-12 col-sm-6 col-md-8">
            <h4 h4 class="header">Rider Edit</h4>
        </div>
        <div class="col-xs-6 col-md-4">
            @if (session('message'))
                <div class="alert alert-dismissible alert-info text-center"
                    style="padding-top:5px; padding-bottom:5px; margin-top:0px; margin-bottom:0px;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('message') }}</strong>
                </div>
            @endif
        </div>
        <hr>

        <div class="container-fluid">
            <div class="container-fluid">
                <form method="post" action="{{ route('rider.update', ['id' => $data->ID]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Name*</label>
                            <input class="form-control" name="name" value="{{ $data->name }}" required />
                        </div>
                    </div>
                    <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Mobile*</label>
                            <input class="form-control" name="mobile" value="{{ $data->mobile }}" required />
                        </div>
                    </div>
                    <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Delivery Charge(TK)*</label>
                            <input class="form-control" name="r_delivery_charge" value="{{ $data->r_delivery_charge }}" required />
                        </div>
                    </div>
                    <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Pickup Charge(TK)*</label>
                            <input class="form-control" name="r_pickup_charge" value="{{ $data->r_pickup_charge }}" required />
                        </div>
                    </div>

                    <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Return Charge(TK)*</label>
                            <input class="form-control" name="r_return_charge" value="{{ $data->r_return_charge }}" required />
                        </div>
                    </div>
                    
                    <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Branch*</label>
                            <select id="edit_zone" class="form-control" name="area" required>
                                @foreach ($areas as $value)
                                    <option {{ $data->zone_id == $value->id ? 'selected' : '' }}
                                        value="{{ $value->id }}">
                                        {{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">District*</label>
                            <select id="edit_district" name="district" class="form-control">
                                @foreach ($districts as $value)
                                    <option {{ $data->district_id == $value->d_id ? 'selected' : '' }}
                                        value="{{ $value->d_name }}">{{ $value->d_name }}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>
                    <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Profile Picture*</label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Rider NID*</label>
                            <input type="file" name="user_voter_id_photo" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Guardian NID*</label>
                            <input type="file" name="user_fathers_voter_id_photo" class="form-control">
                        </div>
                    </div>




            </div><br>
            <hr>
            <div class="mt-2" style="text-align: center;">
                <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12"></div>
                <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12">
                    <button type="reset" class="button0 btn btn-warning mr-4 ">Clear</button>
                    <button type="submit" class="button0 btn btn-success">Update</button>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12"></div>
            </div>

        </div>


    </div>





    <script>
        $('#edit_zone').change(function() {

            $('#edit_district').empty();
            $('#edit_district').append($('<option>', {
                value: '',
                text: '------------Select District-------'
            }));

            var zone_id = $('#edit_zone :selected').val();

            $.ajax({
                url: "{{ route('ajaxdata.dist') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    zone_id: zone_id
                },
                cache: false,
                dataType: 'json',
                success: function(dataResult) {

                    var resultData = dataResult.data;

                    $.each(resultData, function(index, row) {

                        $('#edit_district').append($('<option>', {
                            value: row.d_id,
                            text: row.d_name
                        }));

                    })


                }
            });

        });
    </script>
@endsection
