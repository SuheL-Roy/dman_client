@extends('Master.main')
@section('title')
    Branch Edit
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
            <h4 class="header">Branch Edit</h4>
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
    </div>
    <hr>

    <div class="container-fluid">
        <div class="container-fluid">
            <form method="post" action="{{ route('agent.update', ['id' => $data->ID]) }}" enctype="multipart/form-data">
                @csrf
                <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                    <div class="mb-3">
                        <label for="validationTooltip01" class="form-label">Name*</label>
                        <input class="form-control" name="name" value="{{ $data->name }}" readonly />
                        <input type="hidden" class="form-control" name="area" value="{{ $data->area }}" readonly />
                        <input type="hidden" class="form-control" name="district_id" value="{{ $data->district_id }}"
                            readonly />
                    </div>
                </div>
                <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                    <div class="mb-3">
                        <label for="validationTooltip01" class="form-label">Mobile</label>
                        <input class="form-control" name="mobile" value="{{ $data->mobile }}" required />
                    </div>
                </div>
                <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                    <div class="mb-3">
                        <label for="validationTooltip01" class="form-label">Delivery Charge (TK)*</label>
                        <input class="form-control" name="a_delivery_charge" value="{{ $data->a_delivery_charge }}"
                            required />
                    </div>
                </div>
                <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                    <div class="mb-3">
                        <label for="validationTooltip01" class="form-label">Pickup Charge (TK)*</label>
                        <input class="form-control" name="a_pickup_charge" value="{{ $data->a_pickup_charge }}" required />
                    </div>
                </div>
                <div class="col-xs-16 col-sm-10 col-md-12  col-lg-12">
                    <div class="mb-3">
                        <label for="validationTooltip01" class="form-label">Return Charge (TK)*</label>
                        <input class="form-control" name="a_return_charge" value="{{ $data->a_return_charge }}" required />
                    </div>
                </div>


        </div><br>
        <hr>
        <div class="mt-2" style="text-align: center;">
            <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12"></div>
            <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12">
                <button type="reset" class="button0  btn btn-warning mr-4 ">Clear</button>
                <button type="submit" class="button0 btn btn-success">Update</button>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12"></div>
        </div>
        </form>
    </div>
    </div>


    </div>



    <script>
        $('#edit_district').change(function() {

            $('#edit_zone').empty();
            $('#edit_zone').append($('<option>', {
                value: '',
                text: 'Select Zone'
            }));

            var district = $('#edit_district :selected').val();

            $.ajax({
                url: "{{ route('ajaxdata.zone') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    district: district
                },
                cache: false,
                dataType: 'json',
                success: function(dataResult) {

                    var resultData = dataResult.data;

                    $.each(resultData, function(index, row) {

                        $('#edit_zone').append($('<option>', {
                            value: row.name,
                            text: row.name
                        }));

                    })


                }
            });

        });
    </script>
@endsection
