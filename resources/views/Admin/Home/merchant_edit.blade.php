@extends('Master.main')
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
        width: 10% !important;
        margin-bottom: 5px !important;
    }
</style>
@section('title')
    Category
@endsection
@section('content')
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mb-5">
                <h4 class="header text-center"><u>Edit Marchent Information</u></h4>
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
        <div class="container-fluid p-4">
            <div class="container-fluid">
                <form method="post" style="margin-right: 350px;"
                    action="{{ route('shop.merchant.update', ['id' => $merchant->id]) }}" enctype="multipart/form-data">
                    @csrf
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Business Name*</label>
                            <input class="form-control mr-5" name="business_name" value="{{ $merchant->business_name }}"
                                required />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Name*</label>
                            <input class="form-control" name="name" value="{{ $user->name }}" required />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Mobile*</label>
                            <input class="form-control" name="mobile" value="{{ $user->mobile }}" required />
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Email</label>
                            <input class="form-control" name="email" value="{{ $user->email }}" />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Address*</label>
                            <textarea name="address" class="form-control" rows="1">{{ $user->address }}</textarea>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Business Type*</label>
                            <select id="businesstype" name="b_type" class="form-control" required>
                                @foreach ($businesstype as $value)
                                    <option {{ $merchant->b_type == $value->b_type ? 'selected' : '' }}
                                        value="{{ $value->b_type }}">
                                        {{ $value->b_type }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                    <div class="row mt-2">


                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Hub</label>
                            <select id="edit_zone" class="form-control" name="area">
                                <option value="">-- Select Hub --</option>
                                @foreach ($area as $value)
                                    <option {{ $merchant->area == $value->name ? 'selected' : '' }}
                                        value="{{ $value->id }}">
                                        {{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">District*</label>
                            <select id="edit_district" name="district" class="form-control">
                                @foreach ($districts as $value)
                                    <option {{ $merchant->district_id == $value->d_id ? 'selected' : '' }}
                                        value="{{ $value->d_id }}">
                                        {{ $value->d_name }}</option>
                                @endforeach


                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Risk Fee (%)*</label>
                            <input type="number" class="form-control" name="m_insurance"
                                value="{{ $merchant->m_insurance }}" required />
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside Dhaka Regular(TK)*</label>
                            <input class="form-control" name="m_discount" value="{{ $merchant->m_discount }}" required />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside Dhaka Regular(TK)</label>
                            <input type="number" class="form-control" name="outside_dhaka_regular"
                                value="{{ $merchant->outside_dhaka_regular }}" />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub Dhaka Regular(TK)</label>
                            <input type="number" class="form-control" name="sub_dhaka_regular"
                                value="{{ $merchant->sub_dhaka_regular }}" />
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside City Regular(TK)*</label>
                            <input class="form-control" name="m_ind_city_Re" value="{{ $merchant->m_ind_city_Re }}" required />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside City Regular(TK)</label>
                            <input type="number" class="form-control" name="m_out_city_Re"
                                value="{{ $merchant->m_out_city_Re }}" />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub City Regular(TK)</label>
                            <input type="number" class="form-control" name="m_sub_city_Re"
                                value="{{ $merchant->m_sub_city_Re }}" />
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside Dhaka Express (TK)*</label>
                            <input class="form-control" name="ur_discount" value="{{ $merchant->ur_discount }}"
                                required />
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside Dhaka Express(TK)</label>
                            <input type="number" class="form-control" name="outside_dhaka_express"
                                value="{{ $merchant->outside_dhaka_express }}">
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub Dhaka Express(TK)</label>
                            <input type="number" class="form-control" name="sub_dhaka_express"
                                value="{{ $merchant->sub_dhaka_express }}" />
                        </div>

                        

                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside City Express (TK)*</label>
                            <input class="form-control" name="m_ind_city_Ur" value="{{ $merchant->m_ind_city_Ur }}"
                                required />
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside City Express(TK)</label>
                            <input type="number" class="form-control" name="m_out_City_Ur"
                                value="{{ $merchant->m_out_City_Ur }}">
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub City Express(TK)</label>
                            <input type="number" class="form-control" name="m_sub_city_Ur"
                                value="{{ $merchant->m_sub_city_Ur }}" />
                        </div>




                    </div>
                    <div class="row mt-2">

                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside Dhaka COD Discount(%)*</label>
                            <input class="form-control" name="m_cod" value="{{ $merchant->m_cod }}" required />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside Dhaka COD Discount(%)*</label>
                            <input class="form-control" name="m_outside_dhaka_cod"
                                value="{{ $merchant->m_outside_dhaka_cod }}" />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub Dhaka COD Discount(%)*</label>
                            <input class="form-control" name="m_sub_dhaka_cod"
                                value="{{ $merchant->m_sub_dhaka_cod }}" />
                        </div>


                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Inside City COD Discount(%)*</label>
                            <input class="form-control" name="m_inside_city_cod" value="{{ $merchant->m_inside_city_cod }}"/>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Outside City COD Discount(%)*</label>
                            <input class="form-control" name="m_outside_city_cod"
                                value="{{ $merchant->m_outside_city_cod }}" />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Sub City COD Discount(%)*</label>
                            <input class="form-control" name="m_sub_city_cod"
                                value="{{ $merchant->m_sub_city_cod }}" />
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Return Inside Dhaka Discount (Tk)*</label>
                            <input type="number" class="form-control" name="return_inside_dhaka_discount"
                                value="{{ $merchant->return_inside_dhaka_discount }}" required />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Return OutSide Dhaka Discount (TK)*</label>
                            <input type="number" class="form-control" name="return_outside_dhaka_discount"
                                value="{{ $merchant->return_outside_dhaka_discount }}" required />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">Return Sub Dhaka Discount (Tk)*</label>
                            <input type="number" class="form-control" name="return_sub_dhaka_discount"
                                value="{{ $merchant->return_sub_dhaka_discount }}" required />
                        </div>



                    </div>
                    <div class="row mt-2">

                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">NID Front*</label>
                            <input type="file" name="nid_front" class="form-control" />
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-4  col-lg-4">
                            <label for="validationTooltip01" class="form-label">NID Back*</label>
                            <input type="file" name="nid_back" class="form-control" />
                        </div>

                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 80px">
                <button type="reset" class=" btn btn-warning mr-4 button0">Clear</button>
                <button type="submit" class="button0 btn btn-success">Update</button>
            </div>

        </div>

        </form>
    </div>


    </div>



    </div>


    </div>






    <script>
        $('#edit_zone').change(function() {

            $('#edit_district').empty();
            $('#edit_district').append($('<option>', {
                value: '',
                text: '--------Select District--------'
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
@endsection
