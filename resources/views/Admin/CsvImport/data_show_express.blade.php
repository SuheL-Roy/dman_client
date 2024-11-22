@extends('Master.main')
@section('title')
    CSV data
@endsection
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Responsive Timeline Design</title>
        <meta name="viewport" content="width=device-width,  user-scalable=no">
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=Poppins&family=Roboto:wght@400;500&display=swap');

        body {
            line-height: 1.3em;
            min-width: 1440px;
            text-align: center;
        }

        .history-tl-container {
            font-family: "Roboto", sans-serif;
            width: 50%;
            margin: auto;
            display: block;
            position: relative;
            backgroud: #f5f5f5;
        }

        .history-tl-container ul.tl {
            margin: 20px 0;
            padding: 0;
            display: inline-block;

        }

        .history-tl-container ul.tl li {
            list-style: none;
            margin: auto;
            margin-left: 200px;
            min-height: 50px;
            /*background: rgba(255,255,0,0.1);*/
            border-left: 1px dashed #86D6FF;
            padding: 0 0 50px 30px;
            position: relative;
        }

        .history-tl-container ul.tl li:last-child {
            border-left: 0;
        }

        .history-tl-container ul.tl li::before {
            position: absolute;
            left: -11px;
            top: -5px;
            content: " ";
            border: 8px solid rgba(255, 255, 255, 0.74);
            border-radius: 500%;
            background: #258CC7;
            height: 20px;
            width: 20px;
            transition: all 500ms ease-in-out;

        }

        .history-tl-container ul.tl li:hover::before {
            border-color: #258CC7;
            transition: all 1000ms ease-in-out;
        }

        ul.tl li .item-title {
            width: 220px;
            text-align: start;
            font-size: 1.3rem;
        }

        ul.tl li .item-detail {
            color: rgba(0, 0, 0, 0.5);
            font-size: .9rem;
            text-align: start;
        }

        ul.tl li .timestamp {
            color: #424242;
            position: absolute;
            width: 100px;
            left: -60%;
            text-align: right;
            font-size: 12px;
        }


        .container-1 h1 {
            text-align: center;
            color: purple;
        }

        .container-1 a img {
            margin-top: 5px;

        }

        .container-2 {
            border: 2px solid #f5ae70;
            height: 80px;

            padding: 5px;
        }

        .container-2 p {
            text-align: left;
            margin-top: 5%;
            color: black;
        }

        .container-2 .p1 {
            text-align: right;
            margin-top: 1%;
            color: #8D8D8D;
        }

        .container-3 {
            margin-top: -3%;
        }

        .left {
            float: left;
        }

        .right {
            float: right;
        }

        th,
        td {
            text-align: center;
            padding: 10px;

        }


        #csv_table_length {
            display: none;

        }

        #csv_table_filter {
            display: none;
        }
    </style>

    <body style="background-color:#f5f5f5;">

        <div class="container" style="margin:30px;">

            <div class="col-lg-12" style="font-size:10px;">

                <h4>Express CSV Data</h4>
                <input type="hidden" value="{{ $user_id }}" id="user_id">

            </div>
            <div class="row">
                <div class="col-12">

                    <table id="csv_table" class="table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Order No.</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Product Type</th>
                                <th>Collection</th>
                                <th style="width:150px;">Destination Hub</th>
                                <th style="width:180px;">Destination Area</th>
                                <th style="width:150px;">Weight</th>
                                <th>Remarks</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <?php $s = 1;
                        $j = 0;
                        ?>
                        <tbody>
                            @foreach (session('session_data') as $key => $value)
                                <tr>
                                    <td>{{ $s++ }}.</td>
                                    <td>{{ $value['invoice_no'] }}</td>
                                    <td>{{ $value['customer_name'] }}</td>
                                    <td class="num_type">{{ $value['customer_phone'] }}</td>
                                    <td>{{ $value['customer_address'] }}</td>
                                    <td>{{ $value['product_title'] }}</td>
                                    <td class="num_type">{{ $value['collection'] }}</td>
                                    <td class="edit_ignore">
                                        <select class="form-control zone" data-id="{{ $j }}"
                                            id="sel_zone{{ $j }}">
                                            @foreach ($zone_datas as $zone_data)
                                                <option value="{{ $zone_data->zone_name }}">{{ $zone_data->zone_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="edit_ignore">
                                        <select class="form-control area" id="sel_area{{ $j }}">
                                            @foreach ($area_datas as $area_data)
                                                <option value="{{ $area_data->area }}">{{ $area_data->area }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="edit_ignore">
                                        <select class="form-control " id="sel_weights_prices{{ $j }}">
                                            @foreach ($weights_prices as $weights_price)
                                                <option value="{{ $weights_price->title }}">{{ $weights_price->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="remarks">{{ $value['remarks'] }}</td>
                                    <td class="datatable-ct">

                                        <button class="btn btn-danger deletE btn-sm" data-id="{{ $j }}">

                                            <i class="fa fa-trash-o"></i>

                                        </button>

                                    </td>
                                </tr>

                                <?php
                                $j++;
                                ?>
                            @endforeach

                        </tbody>
                    </table>



                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-center" style="">
                    <a href="#" class="btn btn-success Submitdata">Submit</a>


                </div>
            </div>
            <br />
        </div>

        <div style="position:absolute;top:50%;left:50%; height:70px;width:70px " class="spinner-border">
        </div>


        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

        <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>

        <script>
            $(document).ready(function() {

                $(".spinner-border").hide();


            });



            var table = $('#csv_table').DataTable({
                paging: false,
                ordering: false,
                info: false,
            });

            $('#csv_table').on('dblclick', 'tbody td', function() {



                var data = $(this).attr("class");

                if (data != 'edit_ignore') {

                    var text = table.cell($(this)).data();

                    var inputElement = document.createElement('input');

                    if (data == 'num_type') {

                        inputElement.type = "number";

                    } else {

                        inputElement.type = "text";

                    }

                    inputElement.value = text;

                    inputElement.className = "editable";

                    this.innerHTML = '';

                    this.appendChild(inputElement);

                    $(inputElement).focus();



                }
            });



            $('#csv_table').on('change', '.editable', function() {

                var inputVal = this.value;

                var cell = table.cell($(this).parent('td'));

                var row = table.row($(this).parents('tr'));

                var oldData = cell.data();

                cell.data(inputVal);

                table.draw();

            });


            $('#csv_table').on('blur', '.editable', function() {

                $(this).parent('td').html(this.value);

                table.draw();

            });


            $('#csv_table tbody').on('click', '.deletE', function() {

                if (confirm("Do you want to delete this data?") == true) {

                    table
                        .row($(this).parents('tr'))
                        .remove()
                        .draw();


                }
            });


            $('#csv_table tbody').on('change', '.zone', function() {



                var id = $(this).data("id");

                var zone = $('#sel_zone' + id).find(':selected').val();

                $('#sel_area' + id).empty();

                $.ajax({
                    url: "{{ route('ajaxdata.area') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        zone: zone
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(dataResult) {

                        var resultData = dataResult.data;

                        $.each(resultData, function(index, row) {


                            $('#sel_area' + id).append($('<option>', {
                                value: row.area,
                                text: row.area
                            }));

                        })


                    }
                });

            });



            $('.Submitdata').on('click', function() {

                $(".container").css("opacity", 0.2);

                $(".spinner-border").show();


                var data = table.rows().data().toArray();

               

                var i = 0;

                $('#csv_table tbody tr').each(function() {

                    data[i].shift();

                    var tdObject = $(this).find('td:eq(7)');
                    var selectObject = tdObject.find("select");
                    var zone = selectObject.val();

                    var tdObject = $(this).find('td:eq(8)');
                    var selectObject = tdObject.find("select");
                    var area = selectObject.val();

                    var tdObject = $(this).find('td:eq(9)');
                    var selectObject = tdObject.find("select");
                    var weights_price = selectObject.val();

                    data[i][6] = zone;
                    data[i][7] = area;
                    data[i][8] = weights_price;
                   
                  
                    //data[i][0] = user_id;

                   // data[i].pop();
                    i++;
                });


                var user_id = document.getElementById("user_id").value;



                $.ajax({
                    url: "{{ route('file-data-submit-express') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'data': data,
                        'user_id': user_id

                    },
                    success: function() {

                        alert('CSV Data Saved');


                       window.location.href = '{{ route('csv-file-upload') }}';


                    },
                    error: function(error) {
                        console.log(error);
                        alert('Data Not Saved');
                    }
                });
            });
        </script>

    </body>

    </html>
@endsection
