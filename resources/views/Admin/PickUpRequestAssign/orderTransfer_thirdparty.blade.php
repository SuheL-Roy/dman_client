@extends('Master.main')
@section('title')
    Transfer Redx
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h4 class="col-lg-4" style="padding:0px;">
                                    Transfer to Redx <small> (Assign Confoirmation) </small>
                                </h4>


                                <div class="container col-lg-1">

                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; padding-bottom:5px; 
                                        margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif

                                </div>

                                <form class="" method="get" action="{{ route('order.transfer_to_third_party') }}">
                                    @csrf

                                    <div class="col-lg-2">

                                        <select name="area" class="form-control area" required>
                                            <option value="">Select Destination Hub</option>
                                            @foreach ($area_list as $value)
                                                <option value="{{ $value->zone_name }}"
                                                    {{ $area == $value->zone_name ? 'selected' : '' }}>
                                                    {{ $value->zone_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <button type="submit" class="col-lg-1 btn btn-info btn-sm">
                                        Load
                                    </button>

                                </form>




                            </div>
                        </div>



                        <form class="" method="post" action="{{ route('order.transfer.redx.store') }}">
                            @csrf

                            <input type="hidden" name="area" value="{{ $area ?? '' }}" />

                            <div class="col-lg-1">
                                {{-- <select name="rider" class="form-control" required>
                                    <option value="">Select Rider</option>
                                    @foreach ($user as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select> --}}
                            </div>
                            <button type="submit" class="btn btn-success col-lg-2" style="float:right;"
                                onclick="return confirm('Are You Sure ?')">Transfer To Redx
                            </button>

                            <div class="clearfix"></div>
                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">
                                    <div id="toolbar">
                                        <select class="form-control">
                                            <option value="">Export Basic</option>
                                            <option value="all">Export All</option>
                                            <option value="selected">Export Selected</option>
                                        </select>
                                    </div>
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                        data-key-events="true" data-show-toggle="true" data-resizable="true"
                                        data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
                                        data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th> <input type="checkbox" class="selectall"></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                {{--                <th data-field="order_id" data-editable="false">Order ID</th> --}}
                                                {{-- <th data-field="merchant" data-editable="false">Merchant Name</th>
                                                <th data-field="mobile_no" data-editable="false">Merchant Phone</th>
                                                <th data-field="business_name" data-editable="false">Merchant Address</th> --}}
                                                <th data-field="customer_name" data-editable="false">Customer</th>
                                                <th data-field="customer_mobile_no" data-editable="false">Customer Mobile
                                                    No.</th>
                                                <th data-field="customer_address" data-editable="false">Customer Address
                                                </th>
                                                {{-- <th data-field="type" data-editable="false">Type</th> --}}
                                                <th data-field="destination1" data-editable="false">District</th>

                                                <th data-field="destination2" data-editable="false">Area</th>
                                                <th data-field="destination3" data-editable="false">Weight</th>
                                                {{-- <th data-field="pickup_date" data-editable="false">Status</th> --}}

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            $s = 1;
                                            $j = 0;
                                            ?>

                                            @foreach ($order as $data)
                                                <tr>
                                                    <td><input type="checkbox" class="select_id"
                                                            value="{{ $data->tracking_id }}" name="tracking_ids[]" /></td>
                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $data->tracking_id }}</td>
                                                    {{--    <td>{{ $data->order_id }}</td> --}}
                                                    {{-- <td>{{ $data->merchant_info->business_name }}</td>
                                                    <td>{{ $data->user_info->mobile }}</td>
                                                    <td>{{ $data->user_info->address }}</td> --}}
                                                    <td><input type="hidden" class="select_id" name="customer_name[]"
                                                            value="{{ $data->customer_name }}">{{ $data->customer_name }}
                                                    </td>
                                                    <td><input type="hidden" class="select_id" name="customer_phone[]"
                                                            value="{{ $data->customer_phone }}">{{ $data->customer_phone }}
                                                    </td>
                                                    <td><input type="hidden"class="select_id" name="customer_address[]"
                                                            value="{{ $data->customer_address }}">{{ $data->customer_address }}
                                                    </td>
                                                    <td>
                                                        <select name="district[]" class="form-control district"
                                                            data-id="{{ $j }}"
                                                            id="sel_districts{{ $j }}">
                                                            <option value="">Select District</option>
                                                            @foreach ($district as $item)
                                                                <option value="{{ $item->name }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </td>
                                                    <td><select name="areas[]" class="form-control area"
                                                            id="sel_area{{ $j }}"> >
                                                            <option value="">Select Area</option>
                                                            @foreach ($data_area_list2 as $item)
                                                                <option value="{{ $item['id'] }}">{{ $item['name'] }}
                                                                </option>
                                                            @endforeach

                                                        </select>



                                                    </td>


                                                    <td> <input type="text" class="form-control" placeholder="please Enter weight" name="weight[]"></td>
                                                    {{-- <td>
                                                        @if ($data->type == 'Urgent')
                                                            One Hour
                                                        @elseif ($data->type == 'Regular')
                                                            Regular
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->area }}</td>
                                                    <td>{{ $data->status }}</td> --}}

                                                    <?php
                                                    $j++;
                                                    ?>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        
        $(document).on('change', '.district', function() {
      
        var id = $(this).data("id");
        var zone = $('#sel_districts' + id).find(':selected').val();


        $('#sel_area' + id).empty();

        $("#sel_area" + id).html(
            '<option value="" disabled selected>' +
            '<div class="spinner-border spinner-border-sm" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            "</div></option>"
        );

        $.ajax({
            type: 'GET',
            url: '{{ route('get_area') }}',
            data: {
                district_name: zone
            },
            success: function(response) {

                if (response.length != 0) {
                    $("#sel_area" + id).empty();
                }
                $.each(response.areas, function(index, option) {

                    $('.area').append('<option value="' + option
                        .id + '">' +
                        option.name + '</option>');

                });


            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
        });
        // });
        // });
    </script>
    <script></script>
    <script>
        $(document).ready(function() {
            $(".selectall").click(function() {
                var checked = this.checked;
                if (checked == true) {
                    $('.select_id').prop('checked', true);
                } else {
                    $('.select_id').prop('checked', false);
                }
            });
        });
    </script>
@endsection
