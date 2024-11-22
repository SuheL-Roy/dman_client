<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/bootstrap.min.css">
    <style type="text/css">
        @media print {
            @page {
                size: auto;
            }
        }
    </style>
    
</head>
<body onload="window.print();">
    <div style="text-align:center;">
        @foreach ($company as $data)
            <h2>{{ $data->name }}</h2>
            <h4>Address : {{ $data->address }} &nbsp; Mobile : {{ $data->mobile }}</h4>
        @endforeach
        <h4><u>Rider Payment History Report</u></h4>
        <h5>From Date : {{ $fromdate }} &nbsp;&nbsp; To Date : {{ $todate }}</h5>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th data-field="sl">SL.</th>
                <th data-field="create_date" data-editable="false">Create Date</th>
                <th data-field="invoice" data-editable="false">Invoice No</th>
                <th data-field="rider_name" data-editable="false">Rider Name</th>
                <th data-field="create_by" data-editable="false">Create By</th>
                <th data-field="update_by" data-editable="false">Update By</th>
                <th data-field="t_collect" data-editable="false">Total Collect </th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            $total = 0;
            ?>
            @foreach ($payments as $data)
            <tr>
                <td>{{ $i++ }}.</td>
                <td>{{ $data->created_at }}</td>
                <td>{{ $data->invoice_id }}</td>
                <td>{{ $data->rider->name??'' }}</td>
                <td>{{ $data->create->name??'' }}</td>
                <td>{{ $data->updateUser->name??'' }}</td>                
                <td>{{ $data->t_collect }}</td> 
                <td style="display:none;">{{$total = $total + $data->t_collect}}</td>
                
            </tr>
           
            @endforeach
        </tbody> 
        <tfoot>
            <tr>            
                            
                <td colspan="6" style="text-align:right;">Total:</td>
                <td>{{ $total }}</td>
            </tr>
        </tfoot>     
    </table>
    <div class="navbar-fixed-bottom">
        <div style="float:left;">
            @foreach ($company as $data)
                Printed By : {{ $data->name }}
            @endforeach
        </div>
        <div style="float:right;">
            <?php echo "Date & Time : " . date("D, d M Y h:i:s a"); ?>
        </div>
    </div>
</body>
</html>