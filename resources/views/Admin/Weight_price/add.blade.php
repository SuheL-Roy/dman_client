@extends('Master.main')
@section('title')
    Add Weight Price
@endsection
<style>
    .header {
        margin-top: 20px;
        margin-left: 50px;
        text-align: center;
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
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <div class="container-fluid p-4" style="margin-left: 10px;">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-8">
                <h4 class="header">Add Weight Price</h4>
            </div>
            <div class="col-xs-6 col-md-4">
                @if (session('message'))
                    <div class="alert alert-dismissible alert-info text-c"
                        style="padding-top:5px; padding-bottom:5px; margin-top:0px; margin-bottom:0px;">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('message') }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <hr>

        <form method="post" style="" action="{{ route('weight_price.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Title*</label>
                            <input placeholder=" weight title " type="text" class="form-control" name="title"
                                value="" required />
                        </div>
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside-Dhaka(Regular)</label>
                            <input placeholder=" inside-dhaka regular charge" type="text" class="form-control"
                                name="ind_Re" value="" required />
                        </div>
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside-City(Regular)</label>
                            <input placeholder=" inside-city regular charge" type="text" class="form-control"
                                name="ind_city_Re" value="" required />
                        </div>
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside-Dhaka(Regular)</label>
                            <input placeholder=" outside-dhaka regular charge" type="text" class="form-control"
                                name="out_Re" value="" required />
                        </div>
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside-City(Regular)</label>
                            <input placeholder=" outside-city regular charge" type="text" class="form-control"
                                name="out_city_Re" value="" required />
                        </div>
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub-Dhaka(Regular)</label>
                            <input placeholder=" sub-dhaka regular charge" type="text" class="form-control"
                                name="sub_Re" value="" required />
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub-City(Regular)</label>
                            <input placeholder=" sub-city regular charge" type="text" class="form-control"
                                name="sub_city_Re" value="" required />
                        </div>


                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside-Dhaka(Express)</label>
                            <input placeholder=" inside-dhaka one-hour charge" type="text" class="form-control"
                                name="ind_Ur" value="" required />
                        </div>
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside-City(Express)</label>
                            <input placeholder=" inside-city one-hour charge" type="text" class="form-control"
                                name="ind_city_Ur" value="" required />
                        </div>
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside-Dhaka(Express)</label>
                            <input placeholder=" outside-dhaka one-hour charge" type="text" class="form-control"
                                name="out_Ur" value="" required />
                        </div>
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside-City(Express)</label>
                            <input placeholder=" outside-dhaka one-hour charge" type="text" class="form-control"
                                name="out_City_Ur" value="" required />
                        </div>
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub-Dhaka(Express)</label>
                            <input placeholder=" sub-dhaka one-hour charge" type="text" class="form-control"
                                name="sub_Ur" value="" required />
                        </div>

                    </div>
                    <div class="row mt-2">

                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub-City(Express)</label>
                            <input placeholder=" sub-city one-hour charge" type="text" class="form-control"
                                name="sub_city_Ur" value="" required />
                        </div>
                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside-Dhaka(Return)</label>
                            <input placeholder=" inside-dhaka return charge" type="text" class="form-control"
                                name="ind_ReC" value="" required />
                        </div>

                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside-Dhaka(Return)</label>
                            <input placeholder=" outside-dhaka return charge" type="text" class="form-control"
                                name="out_ReC" value="" required />
                        </div>




                    </div>
                    <div class="row mt-2">


                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub-Dhaka(Return)</label>
                            <input placeholder=" sub-dhaka return charge" type="text" class="form-control"
                                name="sub_ReC" value="" required />
                        </div>


                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside Dhaka (COD %)</label>
                            <input placeholder="Inside Dhaka (COD %)" type="text" class="form-control" name="cod"
                                value="" required />
                        </div>

                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside Dhaka (COD %)</label>
                            <input placeholder="Outside Dhaka (COD %)" type="text" class="form-control"
                                name="outside_dhaka_cod" value="" required />
                        </div>

                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub Dhaka (COD %)</label>
                            <input placeholder="Sub Dhaka (COD %)" type="text" class="form-control"
                                name="sub_dhaka_cod" value="" required />
                        </div>



                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside City (COD %)</label>
                            <input placeholder="Inside City (COD %)" type="text" class="form-control" name="inside_city_cod"
                                value="" required />
                        </div>

                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside City (COD %)</label>
                            <input placeholder="Outside City (COD %)" type="text" class="form-control"
                                name="outside_city_cod" value="" required />
                        </div>

                    </div>
                    <div class="row mt-2">

                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub City (COD %)</label>
                            <input placeholder="Sub City (COD %)" type="text" class="form-control"
                                name="sub_city_cod" value="" required />
                        </div>

                        <div class="col-4 col-xs-12 col-sm-10 col-md-12  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Risk Fee(%)</label>
                            <input placeholder=" insurance %" type="text" class="form-control" name="insurance"
                                value="" required />
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                <div class="mb-3">

                </div>
            </div>

            <div style="text-align: center; margin-top:10px;" class="mt-4">
                <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12"></div>
                <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12">
                    <button type="reset" class="button0 btn btn-warning mr-4">Clear</button>
                    <button type="submit" class="button0 btn btn-success">Submit</button>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4  col-lg-4 mg-tb-12"></div>

            </div>
        </form>
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
