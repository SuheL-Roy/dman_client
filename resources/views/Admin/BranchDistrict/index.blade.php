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
                                <h1 class="col-lg-2" style="padding:0px;">
                                    Hub Manage
                                </h1>
                                <form class="" method="post" action="{{ route('branch_district.index') }}">
                                    @csrf

                                    <div class="col-lg-5">

                                        <select name="zone" class="form-control area" required>
                                            <option value="">Select Zone</option>
                                            @foreach ($zones as $value)
                                                <option value="{{ $value->id }}"
                                                    {{ $selectedZone == $value->id ? 'selected' : '' }}>
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <button type="submit" class="col-lg-2 btn btn-info btn-sm">
                                        Load
                                    </button>

                                </form>

                                <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;"
                                    data-toggle="modal" data-target="#PrimaryModalalert">Add 
                                </button>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('branch_district.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title">Add District in Hub</h4>
                                        </div>
                                        <div class="modal-body" style="padding-top: 10px; padding-bottom:0px;">
                                           
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Hub <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                                        <select id="kk" name="zone" class="form-control zone"
                                                            required>
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
                                                        <select id="k" name="dist" class="form-control"
                                                            required>
                                                            <option value="">-------- Select District --------
                                                            </option>
                                                            @foreach ($districts as $district)
                                                                <option value="{{ $district->id }}">{{ $district->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm"
                                                type="button"data-dismiss="modal">Close</button>
                                            <button class="btn btn-danger btn-sm" type="reset">Clear</button>
                                            <button class="btn btn-success btn-sm" type="submit">Add</button>
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
                                        <h4 class="modal-title">Edit Hub wise District Info</h4>
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
                                                            Hub <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="zone" id="edit_zone" class="form-control edit_zone"
                                                            required>
                                                            <option value="">-------- Select Hub --------</option>

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
                                                        <select name="district" id="edit_district"
                                                            class="form-control edit_district" required>
                                                            <option value="">-------- Select District --------
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <input type="hidden" id="id_dist">
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
                                    data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="sl">SL.</th>
                                            
                                            <th data-field="district" data-editable="false">District Name</th>
                                            <th data-field="zone" data-editable="false">Hub Name</th>
                                           
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($district_branchs as $data)
                                            <tr class=" ">
                                                <td>{{ $i++ }}.</td>
                                                {{-- <td>
                                                    @if ($data->inside == '1')
                                                        Inside Dhaka
                                                    @elseif($data->inside == '0')
                                                        Outside Dhaka
                                                    @elseif($data->inside == '2')
                                                        Sub Dhaka
                                                    @endif

                                                </td> --}}
                                                <td>{{ $data->d_name }}</td>
                                                <td>{{ $data->z_name }}</td>
                                                {{-- <td>{{ $data->area }}</td> --}}
                                                <td class="datatable-ct">
                                                    <button type="button" value="{{ $data->id }}"
                                                        class="btn btn-primary ediT " id="ediT" data-toggle="modal"
                                                        data-target="#InformationproModalhdbgcl">
                                                        <i class="fa fa-edit"></i>
                                                        Edit
                                                    </button>
                                                     <button class="btn btn-danger deletE " value="{{ $data->id }}"
                                                >
                                                <i class="fa fa-trash-o"> Delete</i>
                                            </button>
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
        


        //$('.ediT').on('click',function () {
        $('#table').on('click', '.ediT', function() {
            var id = $(this).val();
            // alert(id);

            $.ajax({
                type: "POST",
                url: "{{ route('branch_district.edit') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(data) {

                    $('#edit_zone').empty();
                    $('#edit_zone').append($('<option>', {
                        value: '',
                        text: '-------- Select Hub --------'
                    }));

                    $('#edit_district').empty();
                    $('#edit_district').append($('<option>', {
                        value: '',
                        text: '-------- Select District --------'
                    }));

                    for (var i = 0; i < data[3]; i++) {
                        // alert(id);
                        $('#edit_zone').append($('<option>', {
                            value: data[0][i]['id'],
                            text: data[0][i]['name']
                        }));
                    }

                    for (var i = 0; i < data[4]; i++) {

                        $('#edit_district').append($('<option>', {
                            value: data[1][i]['id'],
                            text: data[1][i]['name']
                        }));
                    }




                    $('.edit_zone').val(data[2]['z_id']);


                    $('.edit_district').val(data[2]['d_id']);
                    $('#id_dist').val(data[2]['id']);
                }
            });
        });

        $('#updatE').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('branch_district.update') }}",
                data: {
                    '_token': $('input[name=_token]').val(),

                    'dist': $(".edit_district").val(),
                    'zone': $(".edit_zone").val(),
                    'id': $("#id_dist").val()

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

          $(document).ready(function () {
             $('.deletE').on('click', function () {
                 
                 var id = $(this).val();
               
                 $.ajax({
                     type: "GET",
                     url: "{{ route('branch_district.destroy') }}",
                     data: { id: id },
                     success: function (data){
                         //console.log(data);
                        
                         location.reload();
                     }
                 });
             });
         }); 
    </script>
@endsection
