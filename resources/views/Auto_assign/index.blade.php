@extends('Master.main')
@section('title')
Auto Assign
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4 p-0" style="padding:0px;">
                                    Auto Assign<span class="table-project-n"></span> Table
                                </h1>
                                <div class="container col-lg-4">
                                    @if (session('success'))
                                        <div class="alert alert-dismissible alert-success">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('success') }}</strong>
                                        </div>
                                    @elseif(session('message'))
                                        <div class="alert alert-dismissible alert-info">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @elseif(session('danger'))
                                        <div class="alert alert-dismissible alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('danger') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                @php 
                                    Illuminate\Support\Facades\Session::forget('message'); 
                                @endphp

                                <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;"
                                    data-toggle="modal" data-target="#PrimaryModalalert">Add Auto Assign
                                </button>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div style="width:450px"  class="modal-content">
                                    <form action="{{ route('autoassign.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title">Add Auto Assign Info</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                       <select class="form-control merchant" name="merchant_id">
                                                    <option>---Select Merchant---</option>   
                                                    @foreach($merchantdata as $value)
                                                     <option value="{{$value->id}}">{{$value->business_name}}</option>  
                                                    @endforeach                                              
                                                       </select>


                                                    </div>
                                                    <div style="padding-top:10px;" class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                     <span style="float:left;padding-left:15px;">Hub:</span><span style="float:left;padding-left:2px;" id="hub"></span>
                                                    </div>
                                                     <div style="padding-top:10px;" class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                       <select class="form-control rider" name="rider_id">
                                                    <option>---Select Rider---</option>                                                 
                                                       </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm"
                                                type="button"data-dismiss="modal">Close</button>
                                            <button class="btn btn-danger btn-sm clear" type="reset">Clear</button>
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
                                        <h4 class="modal-title">Edit Auto Assign</h4>
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i
                                                    class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                    <form id="updatE">@csrf
                                <input name="id" class="e_id" type="hidden" />
                                       <div class="modal-body">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                       <select class="form-control e_merchant" name="merchant_id">
                                                    <option>---Select Merchant---</option>   
                                                    @foreach($merchantdata as $value)
                                                     <option value="{{$value->id}}">{{$value->business_name}}</option>  
                                                    @endforeach                                              
                                                       </select>


                                                    </div>
                                                      <div style="padding-top:10px;" class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                     <span style="float:left;padding-left:15px;">Hub:</span><span style="float:left;padding-left:2px;" id="e_hub"></span>
                                                    </div>
                                                     <div style="padding-top:10px;" class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                       <select class="form-control e_rider" name="rider_id">
                                                    <option>---Select Rider---</option>    
                                                                                                 
                                                       </select>
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
                                            <th data-field="merchant" data-editable="false">Merchant</th>
                                            <th data-field="rider" data-editable="false">Rider</th>
                                             <th data-field="hub" data-editable="false">Hub</th>
                                              <th data-field="action">Action</th>
                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $value)
                                            <tr>
                                                
                                                <td>{{ $i++ }}.</td>                                              
                                                <td>{{ $value->business_name}}</td>
                                                  <td>{{ $value->user_rider->name}}</td>
                                                     <td>{{ $value->hub}}</td>
                                                <td class="datatable-ct w-25" style="width:25%;">

                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" value="{{ $value->id }}"
                                                            class="btn btn-primary ediT " data-toggle="modal"
                                                            data-target="#InformationproModalhdbgcl">
                                                            <i class="fa fa-edit"></i>
                                                            Edit
                                                        </button>  


                                                        <a class="btn btn-danger"
                                                                href="{{ route('autoassign.destroy', ['id' => $value->id]) }}"                                                               
                                                                onclick="return confirm('Are You Sure You Want To delete this Auto Assign ??')">
                                                               Delete
                                                            </a>  
                                                                                                        
                                                    </div>
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
        $(document).ready(function() {
        $('.merchant').change(function() {  

            $('.rider').empty();
            $('.rider').append($('<option>', {
                value: '',
                text: '---Select Rider---'
            }));

            var merchant_id = $('.merchant :selected').val();           

            $.ajax({
                url: "{{ route('ajaxdata.merchant_rider') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: merchant_id
                },
                cache: false,
                dataType: 'json',
                success: function(dataResult) {

                    var resultData = dataResult.data;

                    var hub = dataResult.hub;

                     $('#hub').text(hub);

                    $.each(resultData, function(index, row) {

                        $('.rider').append($('<option>', {
                            value: row.id,
                            text: row.name
                        }));

                        



                    })


                }
            });

        });







    

  $('.clear').on('click', function() {


    $('.rider').empty();
    $('.rider').append($('<option>', {
                value: '',
                text: '---Select Rider---'
            }));

    $('#hub').text('');

 });



            $('.ediT').on('click', function() {
                var id = $(this).val();             
               
                $.ajax({
                    type: "GET",
                    url: "{{ route('autoassign.edit') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.e_id').val(data[0]['id']);
                        $('.e_merchant').val(data[0]['merchant_id']);   


            $('.e_rider').empty();
            $('.e_rider').append($('<option>', {
                value: '',
                text: '---Select Rider---'
            }));

            var merchant_id = $('.e_merchant :selected').val();           

            $.ajax({
                url: "{{ route('ajaxdata.merchant_rider') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: merchant_id
                },
                cache: false,
                dataType: 'json',
                success: function(dataResult) {

                    var resultData = dataResult.data;

                 
                    var hub = dataResult.hub;

                     $('#e_hub').text(hub);



                    $.each(resultData, function(index, row) {

                        $('.e_rider').append($('<option>', {
                            value: row.id,
                            text: row.name
                        }));

                        if(data[0]['rider_id']==row.id){                               
                    $('.e_rider').val(data[0]['rider_id']);                             
                        }

                    })


                }
            });

            
                    }
                });
            });

 $('.e_merchant').change(function() {  
                            
            $('.e_rider').empty();
            $('.e_rider').append($('<option>', {
                value: '',
                text: '---Select Rider---'
            }));

            var merchant_id = $('.e_merchant :selected').val();           

            $.ajax({
                url: "{{ route('ajaxdata.merchant_rider') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: merchant_id
                },
                cache: false,
                dataType: 'json',
                success: function(dataResult) {

                    var resultData = dataResult.data;

                    var hub = dataResult.hub;  

                      $('#e_hub').text(hub);                  

                    $.each(resultData, function(index, row) {

                        $('.e_rider').append($('<option>', {
                            value: row.id,
                            text: row.name
                        }));

                    })


                }
            });

        });






            $('#updatE').on('submit', function(e) {
                e.preventDefault();

                          
                $.ajax({
                    type: "POST",
                    url: "{{ route('autoassign.update') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $(".e_id").val(),
                        'e_merchant': $(".e_merchant").val(),
                        'e_rider': $(".e_rider").val()
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
    
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({})
        })
    </script>
@endsection
