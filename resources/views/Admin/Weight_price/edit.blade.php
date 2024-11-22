@extends('Master.main')
@section('title')
    Edit Weight Price
@endsection
<style>
    .header {
        margin-top: 20px;
        margin-left: 50px;
        text-align: center !important;
        font-size: 30px;
    }

    .form-control {
        width: 100% !important;
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
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid" style="margin-left: 10px;">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-8">
                    <h1 class="header">Edit Weight Price</h1>
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
            <form method="post" style="" action="{{ route('weight_price.update') }}" enctype="multipart/form-data">
                @csrf

                <br><br>
                <div class="modal-body" style="padding-top: 10px; padding-bottom:0px;">
                    <input type="hidden" class="id" name="id" value="{{ $weightprice->id }}" />

                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Title*</label>
                                <input type="text" class="form-control" name="title" value="{{ $weightprice->title }}"
                                    required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Inside-Dhaka(Regular)</label>
                                <input type="text" class="form-control" name="ind_Re" value="{{ $weightprice->ind_Re }}"
                                    required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Inside-City(Regular)</label>
                                <input type="text" class="form-control" name="ind_city_Re" value="{{ $weightprice->ind_city_Re }}"
                                    required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Outside-Dhaka(Regular)</label>
                                <input type="text" class="form-control" name="out_Re" value="{{ $weightprice->out_Re }}"
                                    required />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Outside-City(Regular)</label>
                                <input type="text" class="form-control" name="out_city_Re" value="{{ $weightprice->out_city_Re }}"
                                    required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Sub-Dhaka(Regular)</label>
                                <input type="text" class="form-control" name="sub_Re" value="{{ $weightprice->sub_Re }}"
                                    required />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Sub-City(Regular)</label>
                                <input type="text" class="form-control" name="sub_city_Re" value="{{ $weightprice->sub_city_Re }}"
                                    required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Inside-Dhaka(Express)</label>
                                <input type="text" class="form-control" name="ind_Ur" value="{{ $weightprice->ind_Ur }}"
                                    required />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Inside-City(Express)</label>
                                <input type="text" class="form-control" name="ind_city_Ur" value="{{ $weightprice->ind_city_Ur }}"
                                    required />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Outside-Dhaka(Express)</label>
                                <input type="text" class="form-control" name="out_Ur" value="{{ $weightprice->out_Ur }}"
                                    required />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Outside-City(Express)</label>
                                <input type="text" class="form-control" name="out_City_Ur" value="{{ $weightprice->out_City_Ur }}"
                                    required />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Sub-Dhaka(Express)</label>
                                <input type="text" class="form-control" name="sub_Ur" value="{{ $weightprice->sub_Ur }}"
                                    required />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Sub-City(Express)</label>
                                <input type="text" class="form-control" name="sub_city_Ur" value="{{ $weightprice->sub_city_Ur }}"
                                    required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Inside-Dhaka(Return)</label>
                                <input type="text" class="form-control" name="ind_ReC"
                                    value="{{ $weightprice->ind_ReC }}" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Outside-Dhaka(Return)</label>
                                <input type="text" class="form-control" name="out_ReC"
                                    value="{{ $weightprice->out_ReC }}" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Sub-Dhaka(Return)</label>
                                <input type="text" class="form-control" name="sub_ReC"
                                    value="{{ $weightprice->sub_ReC }}" required />
                            </div>
                        </div>







                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Inside Dhaka (COD %)</label>
                                <input type="text" class="form-control" name="cod"
                                    value="{{ $weightprice->cod }}" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Outside Dhaka (COD %)</label>
                                <input type="text" class="form-control" name="outside_dhaka_cod"
                                    value="{{ $weightprice->outside_dhaka_cod }}" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Sub Dhaka (COD %)</label>
                                <input type="text" class="form-control" name="sub_dhaka_cod"
                                    value="{{ $weightprice->sub_dhaka_cod }}" required />
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Inside City (COD %)</label>
                                <input type="text" class="form-control" name="inside_city_cod"
                                    value="{{ $weightprice->inside_city_cod }}" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Outside City (COD %)</label>
                                <input type="text" class="form-control" name="outside_city_cod"
                                    value="{{ $weightprice->outside_city_cod }}" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Sub City (COD %)</label>
                                <input type="text" class="form-control" name="sub_city_cod"
                                    value="{{ $weightprice->sub_city_cod }}" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-5  col-lg-4">
                            <div class="mb-3">
                                <label for="validationTooltip01" class="form-label">Risk Fee(%)</label>
                                <input type="text" class="form-control" name="insurance"
                                    value="{{ $weightprice->insurance }}" required />
                            </div>
                        </div>

                    </div>

                  



                </div>
                <div style="text-align: center; margin-top:10px;">
                    <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12"></div>
                    <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12">
                        <button type="reset" class="button0 btn btn-warning mr-4">Clear</button>
                        <button type="submit" class="button0 btn btn-success">Update</button>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12"></div>
                </div>

            </form>

        </div>
    </div>
    </div>
    </div>
    </div>





    <script>
        //area data
        $('#district').change(function() {

            $('#area').empty();

            var district = $('#district :selected').val();

            $.ajax({
                url: "",
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

                        $('#area').append($('<option>', {
                            value: row.area,
                            text: row.area
                        }));


                    })


                }
            });

        });
    </script>
@endsection
