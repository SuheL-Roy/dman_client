<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/bootstrap.min.css">
    <style type="text/css">
        @media print {
            @page {
                size: auto;
            }
        }
    </style>
    
</head>

<body onload="window.print();window.history.back()">
    <div>
        <div style="text-align:center;">
            @foreach ($company as $data)
                <h2>{{ $data->name }}</h2>
                <h4>Address : {{ $data->address }} &nbsp; Mobile : {{ $data->mobile }}</h4>
            @endforeach
            <h4><u>Date Wise Ticket Report</u></h4>
            <h5>From Date : {{ $fromdate }} &nbsp;&nbsp; To Date : {{ $todate }}</h5>
        </div>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL.</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Name</th>
                    <th>User Role</th>
                    <th>Mobile</th>
                    <th>Call Duration</th>
                    <th>Problem</th>
                    <th>Comment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;?>
                @foreach ($complain as $data)
                <tr>
                    <td>{{ $i++ }}.</td>
                    <td>{{ $data->date }}</td>
                    <td>{{ $data->time }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->role=='activeMerchant'?'Mercahnt':'Call Center' }}</td>
                    <td>{{ $data->mobile }}</td>
                    <td>{{ $data->call_duration }}</td>
                    <td>{{ $data->problem }}</td>
                    <td>{{ $data->commnet }}</td>
                    <td>{{ $data->status }}</td>
                </tr>
                @endforeach
            </tbody>
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
    </div>
</body>
</html>