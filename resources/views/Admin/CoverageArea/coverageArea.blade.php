@extends('Master.main')
@section('title')
    Coverage Area
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">

                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">Coverage Area
                                    <span class="table-project-n"></span> Table

                                </h1>
                                <div class="container col-lg-4">
                                    @if (Session::has('success'))
                                        <div class="alert alert-dismissible alert-success">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('success') }}</strong>
                                        </div>
                                    @elseif (Session::has('message'))
                                        <div class="alert alert-dismissible alert-info">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @elseif(Session::has('danger'))
                                        <div class="alert alert-dismissible alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('danger') }}</strong>
                                        </div>
                                    @endif

                                    @php
                                        Illuminate\Support\Facades\Session::forget('success');
                                        Illuminate\Support\Facades\Session::forget('message');
                                        Illuminate\Support\Facades\Session::forget('danger');
                                    @endphp

                                </div>
                                <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;"
                                    data-toggle="modal" data-target="#PrimaryModalalert">Add Coverage Area
                                </button>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('coverage.area.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title">Add Coverage Area</h4>
                                        </div>
                                        <div class="modal-body" style="padding-top: 10px; padding-bottom:0px;">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Location <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 text-left"
                                                        style="padding-top: 8px;">
                                                        <input type="checkbox" class="location-checkbox" name="inside"
                                                            value="1" onclick="checkOne(this)" />
                                                        Inside Dhaka &nbsp; &nbsp;
                                                        <input type="checkbox" class="location-checkbox" name="inside"
                                                            value="2" onclick="checkOne(this)" />
                                                        Sub Dhaka &nbsp; &nbsp;
                                                        <input type="checkbox" class="location-checkbox" name="inside"
                                                            value="0" onclick="checkOne(this)" />
                                                        Outside Dhaka
                                                        {{-- </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 text-left"
                                                        style="padding-top: 8px;"> --}}
                                                        <input type="checkbox" class="location-checkbox" name="city_track"
                                                            value="3" onclick="checkOne(this)" />
                                                        Inside City &nbsp; &nbsp;
                                                        <input type="checkbox" class="location-checkbox" name="city_track"
                                                            value="4" onclick="checkOne(this)" />
                                                        Sub City &nbsp; &nbsp;
                                                        <input type="checkbox"class="location-checkbox" name="city_track"
                                                            value="5" onclick="checkOne(this)" />
                                                        Outside City
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">
                                                                Hub <span class="table-project-n">*</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                                            {{-- <select id="zone" name="zone" class="form-control zone" id="edit_zone"
                                                            required>
                                                            <option value="">-------- Select Hub --------</option>
                                                            @foreach ($zones as $zone)
                                                                <option value="{{ $zone->name }}">{{ $zone->name }}
                                                                </option>
                                                            @endforeach
                                                        </select> --}}
                                                            <select name="zone" id="edit_zone"
                                                                class="form-control edit_zone" required>
                                                                <option value="">-------- Select Hub --------</option>

                                                                @foreach ($zones as $zone)
                                                                    <option value="{{ $zone->id }}">{{ $zone->name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">
                                                                District <span class="table-project-n">*</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                                            {{-- <select id="edit_district" name="district" class="form-control"
                                                            required>
                                                            <option value="">-------- Select District --------
                                                            </option>
                                                             @foreach ($districts as $district)
                                                                <option value="{{ $district->id }}">{{ $district->name }}
                                                                </option>
                                                            @endforeach 
                                                        </select> --}}
                                                            <select name="district" id="edit_district"
                                                                class="form-control edit_district" required>
                                                                <option value="">-------- Select District --------
                                                                </option>
                                                                {{-- @foreach ($districts as $district)
                                                                <option value="{{ $district->id }}">{{ $district->name }}
                                                                </option>
                                                            @endforeach --}}
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">
                                                                Area <span class="table-project-n">*</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                                            <input name="area" class="form-control" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-warning btn-sm"
                                                    type="button"data-dismiss="modal">Close</button>
                                                <button class="btn btn-danger btn-sm" type="reset">Clear</button>
                                                <button class="btn btn-success btn-sm" type="submit">Submit</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="InformationproModalhdbgcl"
                            class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header header-color-modal bg-color-1">
                                        <h4 class="modal-title">Edit Coverage Area Info</h4>
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i
                                                    class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                    <form id="updatE">@csrf
                                        <input name="id" class="edit_id" type="hidden" />
                                        <div class="modal-body" style="padding-top: 10px; padding-bottom:0px;">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Location <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 text-left"
                                                        style="padding-top: 8px;">
                                                        <input type="checkbox" class="location-checkbox" name="edit_inside" id="edit_inside"
                                                            class="inside" value="1" onclick="checkOne(this)" />
                                                        Inside Dhaka &nbsp; &nbsp;
                                                        <input type="checkbox" class="location-checkbox" name="edit_inside" id="edit_sub"
                                                            class="inside" value="2" onclick="checkOne(this)" />
                                                        Sub Dhaka &nbsp; &nbsp;
                                                        <input type="checkbox" class="location-checkbox" name="edit_inside" id="edit_outside"
                                                            class="inside" value="0" onclick="checkOne(this)" />
                                                        Outside Dhaka
                                                        <input type="checkbox" class="location-checkbox" name="edit_insides" id="edit_inside3"
                                                            class="insides" value="3" onclick="checkOne(this)"/>
                                                        Inside City &nbsp; &nbsp;
                                                        <input type="checkbox" class="location-checkbox" name="edit_insides" id="edit_sub4"
                                                            class="insides" value="4" onclick="checkOne(this)"/>
                                                        Sub City &nbsp; &nbsp;
                                                        <input type="checkbox" class="location-checkbox" name="edit_insides" id="edit_outside5"
                                                            class="insides" value="5" onclick="checkOne(this)"/>
                                                        Outside City
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Hub <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="zone" id="edit_zone_id"
                                                            class="form-control edit_zone_class" required>
                                                            <option value="">-------- Select Hub --------</option>

                                                            @foreach ($zones as $zone)
                                                                <option value="{{ $zone->id }}">{{ $zone->name }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            District <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="district" id="edit_district_id"
                                                            class="form-control edit_district_class" required>
                                                            <option value="">-------- Select District --------
                                                            </option>
                                                            {{-- @foreach ($districts as $district)
                                                                <option value="{{ $district->id }}">{{ $district->name }}
                                                                </option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Area <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                                        <input name="area" class="form-control edit_area" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm" data-dismiss="modal">Close</button>
                                            <button class="btn btn-success btn-sm" type="submit">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

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
                                            <th data-field="sl">SL.</th>
                                            <th data-field="location" data-editable="false">Location</th>
                                            <th data-field="district" data-editable="false">District</th>
                                            <th data-field="zone" data-editable="false">Hub Name</th>
                                            <th data-field="area" data-editable="false">Area</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $data)
                                            <tr class=" ">
                                                <td>{{ $i++ }}.</td>
                                                <td>
                                                    @if ($data->inside == '1')
                                                        Inside Dhaka
                                                    @elseif($data->inside == '0')
                                                        Outside Dhaka
                                                    @elseif($data->inside == '2')
                                                        Sub Dhaka
                                                    @elseif($data->city_track == '3')
                                                        Inside City
                                                    @elseif($data->city_track == '4')
                                                        Sub City
                                                    @elseif($data->city_track == '5')
                                                        OutSide City
                                                    @endif

                                                </td>
                                                <td>{{ $data->district }}</td>
                                                <td>{{ $data->zone_name }}</td>
                                                <td>{{ $data->area }}</td>
                                                <td>{{ $data->status == '0' ? 'ACTIVE' : 'INACTIVE' }}</td>
                                                <td class="datatable-ct">
                                                    <button type="button" value="{{ $data->id }}"
                                                        class="btn btn-primary ediT " data-toggle="modal"
                                                        data-target="#InformationproModalhdbgcl">
                                                        <i class="fa fa-edit"></i>
                                                        Edit
                                                    </button>
                                                    {{--  <button class="btn btn-danger deletE btn-xs" value="{{ $data->id }}"
                                                onclick="myFunction()">
                                                <i class="fa fa-trash-o"></i>
                                            </button> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function myFunction() {
            let text = "Press a button!\nEither OK or Cancel.";
            if (confirm(text) == true) {
                text = "You pressed OK!";
            } else {
                text = "You canceled!";
            }
            document.getElementById("demo").innerHTML = text;
        }
    </script>
    <script>
        $(document).ready(function() {



            $('#edit_zone').change(function() {

                $('#edit_district').empty();
                $('#edit_district').append($('<option>', {
                    value: '',
                    text: '-----Select District ----'
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
            $('#edit_zone_id').change(function() {

                $('#edit_district_id').empty();
                $('#edit_district_id').append($('<option>', {
                    value: '',
                    text: '-----Select District ----'
                }));

                var zone_id = $('#edit_zone_id :selected').val();


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

                            $('#edit_district_id').append($('<option>', {
                                value: row.d_id,
                                text: row.d_name
                            }));

                        })


                    }
                });

            });





            $('#district').change(function() {

                $('#zone').empty();
                $('#zone').append($('<option>', {
                    value: '',
                    text: 'Select Zone'
                }));

                var district = $('#district :selected').val();


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

                            $('#zone').append($('<option>', {
                                value: row.name,
                                text: row.name
                            }));

                        })


                    }
                });

            });


            //$('.ediT').on('click',function () {
            $('#table').on('click', '.ediT', function() {
                var id = $(this).val();
                //alert(id);

                $.ajax({
                    type: "POST",
                    url: "{{ route('coverage.area.edit') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(data) {

                        $('#edit_zone_id').empty();
                        $('#edit_zone_id').append($('<option>', {
                            value: '',
                            text: '-------- Select Zone --------'
                        }));

                        $('#edit_district_id').empty();
                        $('#edit_district_id').append($('<option>', {
                            value: '',
                            text: '-------- Select District --------'
                        }));

                        $('.edit_id').val(data[0]['id']);

                        // if (data[0]['inside'] == 1) {
                        //     $("#edit_inside").prop("checked", true);
                        // } else if (data[0]['inside'] == 0) {
                        //     $("#edit_outside").prop("checked", true);
                        // } else if (data[0]['inside'] == 2) {
                        //     $("#edit_sub").prop("checked", true);
                        // } else if (data[0]['city_track'] == 3) {
                        //     $("#edit_inside3").prop("checked", true);
                        // } else if (data[0]['city_track'] == 4) {
                        //     $("#edit_outside4").prop("checked", true);
                        // } else if (data[0]['city_track'] == 5) {
                        //     $("#edit_sub5").prop("checked", true);
                        // }
                        $('input[name="edit_inside"]').prop('checked',
                            false); // Uncheck all first
                        $('input[name="edit_insides"]').prop('checked', false);

                        if (data[0]['inside'] == 1) {
                            $("#edit_inside").prop("checked", true);
                        } else if (data[0]['inside'] == 2) {
                            $("#edit_sub").prop("checked", true);
                        } else if (data[0]['inside'] == 0) {
                            $("#edit_outside").prop("checked", true);
                        }

                        if (data[0]['city_track'] == 3) {
                            $("#edit_inside3").prop("checked", true);
                        } else if (data[0]['city_track'] == 4) {
                            $("#edit_sub4").prop("checked", true);
                        } else if (data[0]['city_track'] == 5) {
                            $("#edit_outside5").prop("checked", true);
                        }





                        for (var i = 0; i < data[4]; i++) {

                            $('#edit_district_id').append($('<option>', {
                                value: data[3][i]['d_id'],
                                text: data[3][i]['d_name']
                            }));
                        }
                        $('#edit_district_id').val(data[5]);

                        for (var i = 0; i < data[2]; i++) {

                            $('#edit_zone_id').append($('<option>', {
                                value: data[1][i]['id'],
                                text: data[1][i]['name']
                            }));
                        }


                        $('#edit_zone_id').val(data[0]['zone_id']);





                        $('.edit_area').val(data[0]['area']);
                    }
                });
            });

            $('#updatE').on('submit', function(e) {


                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('coverage.area.update') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $(".edit_id").val(),
                        'inside': $("input[name='edit_inside']:checked").val(),
                        'insides': $("input[name='edit_insides']:checked").val(),
                        'district': $("#edit_district_id").val(),
                        'zone': $("#edit_zone_id").val(),
                        'area': $(".edit_area").val(),
                    },
                    success: function() {
                        $('#InformationproModalhdbgcl').modal('hide');
                        location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                        alert('Data Not Saved');
                    }
                });
            });
        });
        /*  $(document).ready(function () {
             $('.deletE').on('click', function () {
                 
                 var id = $(this).val();
               
                 $.ajax({
                     type: "GET",
                     url: "{{ route('coverage.area.destroy') }}",
                     data: { id: id },
                     success: function (){
                         //console.log("Data Deleted Successfully");
                         alert('test');
                         location.reload();
                     }
                 });
             });
         }); */
    </script>
    <script>
        function checkOne(checkbox) {
            const checkboxes = document.querySelectorAll('.location-checkbox');

            checkboxes.forEach(cb => {
                // Uncheck all checkboxes except the one that was clicked
                if (cb !== checkbox) {
                    cb.checked = false;
                }
            });
        }
    </script>
@endsection
