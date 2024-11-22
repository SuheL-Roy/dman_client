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
<body onload="window.print();window.history.back()">
    <div style="text-align:center;">
        <h1>Merchant Preview</h1>
    </div>
    <br>
    <hr>
    <br>
    {{-- <div class="container">
        <div style="width:20%;">
            <b>
                <p>Business Name</p>
                <p>Business Type</p>
                <p>District</p>
                <p>Area</p>
                <p>Status</p>
            </b>
        </div>
        <div style="width:5%;">
            <p>:</p>
            <p>:</p>
            <p>:</p>
            <p>:</p>
            <p>:</p>
        </div>
        @foreach ($merchant as $data)
        <div style="width:30%;">
            <p>{{ $data->business_name }}</p>
            <p>{{ $data->b_type }}</p>
            <p>{{ $data->district }}</p>
            <p>{{ $data->area }}</p>
            <p> 
                @if ( $data->status == 1 ) Active
                @elseif ( $data->status == 0) Inactive
                @endif
            </p>
        </div>
        @endforeach
        <div style="width:10px;">
            <b>
                <p>Name</p>
                <p>Email</p>
                <p>Mobile</p>
            </b>
        </div>
        <div style="width:5%;">
            <p>:</p>
            <p>:</p>
            <p>:</p>
        </div>
        @foreach ($user as $data)
        <div style="width:30%;">
            <p>{{ $data->name }}</p>
            <p>{{ $data->email }}</p>
            <p>{{ $data->mobile }}</p>
        </div>
        @endforeach
    </div> --}}
    {{-- <table class="table table-bordered">
        <tbody>
            @foreach ($merchant as $data)
            <tr>
                <td>Business Name</td>
                <td>{{ $data->business_name }}</td>
                <td>Business Type</td>
                <td>{{ $data->b_type }}</td>
            </tr>
            <tr>
                <td>District</td>
                <td>{{ $data->district }}</td>
                <td>Area</td>
                <td>{{ $data->area }}</td>
                <td>Status</td>
                <td>
                    @if ( $data->status == 1 ) Active
                    @elseif ( $data->status == 0) Inactive
                    @endif
                </td>
            </tr>
            @endforeach
            @foreach ($user as $data)
            <tr>
                <td>Name</td>
                <td>{{ $data->name }}</td>
                <td>Email</td>
                <td>{{ $data->email }}</td>
                <td>Mobile</td>
                <td>{{ $data->mobile }}</td>
            </tr>
            @endforeach
        </tbody>
    </table> --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Business Name</th>
                <th>Business Type</th>
                <th>District</th>
                <th>Area</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($merchant as $data)
            <tr>
                <td>{{ $data->business_name }}</td>
                <td>{{ $data->b_type }}</td>
                <td>{{ $data->district }}</td>
                <td>{{ $data->area }}</td>
                <td>
                    @if ( $data->status == 1 ) Active
                    @elseif ( $data->status == 0) Inactive
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $data)
            <tr>
                <td>{{ $data->name }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->mobile }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>