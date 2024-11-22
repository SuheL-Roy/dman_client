@extends('Master.main')
@section('title')
    Delivery Order Export
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-3" style="padding:0px;">
                                    Order Export <small>  </small>
                                </h1>
                                <div class="container col-lg-5">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; 
                                    padding-bottom:5px; margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                    <input type="text" class="form-control scaning" placeholder="searching..."
                                        utocomplete="off" autofocus>
                                </div>
                            </div>

                        </div>






                        <form class="" method="post" action="{{ route('delivery.assign.scan_remove') }}">
                            @csrf

                            <div class="col-lg-3">
                                {{-- <select name="rider" class="form-control" required>
                                    <option value="">Select Rider</option> --}}
                                    {{-- @foreach ($user as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach --}}
                                {{-- </select> --}}
                            </div>
                            <p id="text" style="display: none;">
                            <button type="submit" class="btn btn-danger col-lg-1" style="float:right;"
                                onclick="return confirm('Are You Sure ?')">Delete
                            </button>
                        </p>


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
                                                <th data-field="mercahnts" data-editable="false">Merchant Name</th>
                                                <th data-field="customer_name" data-editable="false">Customer Name</th>
                                                <th data-field="customer_phone" data-editable="false">Customer No.</th>
                                                <th data-field="customer_address" data-editable="false">Customer Address
                                                </th>
                                                <th data-field="area" data-editable="false">Destination</th>
                                                {{-- <th data-field="ee" data-editable="false">Type</th> --}}
                                                <th data-field="hh" data-editable="false">Collection</th>
                                                <th data-field="hh1" data-editable="false">Collect</th>
                                                <th data-field="status" data-editable="false">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @if (session('demo'))
                                                @foreach (Session::get('demo') as $item => $details)
                                                    <tr>
                                                      
                                                        <td><input id="trackings"type="checkbox" class="select_id"
                                                                value="{{ $details['tracking_id'] }}"
                                                                name="tracking_ids[]" /></td>

                                                        <td>{{ $i++ }}.</td>
                                                        <td>{{ $details['tracking_id'] }}</td>
                                                        <td>{{ $details['business_name'] }}</td>
                                                        <td>{{ $details['customer_name'] }}</td>
                                                        <td>{{ $details['customer_phone'] }}</td>
                                                        <td>{{ $details['customer_address'] }}</td>
                                                        <td>{{ $details['area'] }}</td>
                                                        {{-- <td>{{ $details['type'] == 'Urgent' ? 'One Hour' : 'Regular' }}
                                                        </td> --}}                                                        
                                                        <td>{{ $details['collection'] }}</td>
                                                        <td>{{ $details['collect'] }}</td>
                                                        <td>{{ $details['status'] }}</td>


                                                    </tr>
                                                @endforeach
                                            @endif
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

    <script>
        // $(document).on('keyup', '.search', function() {
        //     if (event.keyCode === 13) { // 13 is the keycode for the Enter key
        //         event.preventDefault();
        //         scan();
        //     }
        // });
        // $(document).on('keyup', '.search', function(event) {
        //     if (event.keyCode === 13) { // 13 is the keycode for the Enter key
        //         event.preventDefault();
        //         // scan();

        //     }
        // });
        $('.scaning').keydown(function(e) {
            // e.preventDefault();
            if (e.keyCode == 13) {
                e.preventDefault();
                // // alert('you pressed enter ^_^');
                // test();
                scan();
               
            }
        })
    </script>

    <script>
        function scan() {

            var query = $('.scaning').val();

            $.ajax({
                url: '{{ route('delivery.assign.export_search') }}',
                type: 'POST',
                data: {
                    'name': query,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                   console.log(data);
                   location.reload();
                   

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    location.reload();
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            var value = 0;
            $(".select_id").change(function() {
                var text = document.getElementById("text");
                if ($(this).is(":checked")) {
                    text.style.display = "block";
                    value = value + 1;
                    var values = $("input[name='tracking_ids[]']")
                        .map(function() {
                            return $(this).val();
                        })
                        .get();
                    if (value == values.length) {
                        $(".select_id").prop("checked", true);
                    }
                } else if ($(this).is(":not(:checked)")) {
                    value = value - 1;
                    if (value == 0) {
                        $(".select_id").prop("checked", false);
                        text.style.display = "none";
                    }
                }
            });

            $(".selectall").click(function() {
                var text = document.getElementById("text");
                var checked = this.checked;

                if (checked == true) {
                    $(".select_id").prop("checked", true);
                    text.style.display = "block";
                } else {
                    $(".select_id").prop("checked", false);
                    text.style.display = "none";
                }
            });
        });
    </script>
@endsection
