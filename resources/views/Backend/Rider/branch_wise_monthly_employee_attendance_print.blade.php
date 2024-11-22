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
    <div style="text-align:center;">
        @foreach ($company as $data)
            <h2>{{ $data->name }}</h2>
            <h4>Address : {{ $data->address }} &nbsp; Mobile : {{ $data->mobile }}</h4>
        @endforeach
        <h4><u>Branch Wise Monthly Attendance Report</u></h4>
        <h5>Branch : {{ $branch }}</h5>
        <h5> Date : {{ Carbon\Carbon::parse($todate)->format('d-m-Y') }}</h5>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>

                <th data-field="sl">SL.</th>
                <th data-field="sl">Name</th>

                @php

                    /// if ($todate) {
                    //  $today = \Carbon\Carbon::parse($todate)->format('Y-m-d');
                    // } else {
                    //     $today = today();
                    // }
                    if ($todate) {
                        $today1 = $todate;
                        $today = \Carbon\Carbon::parse($today1);
                    } else {
                        $today = today();
                    }
                    //$today = today();

                    $dates = [];

                    for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                        $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                    }

                @endphp
                @foreach ($dates as $key => $date)
                    <th style="">


                        {{ $key + 1 }}

                    </th>
                @endforeach
                <th>Total Present</th>
                <th>Total Absent</th>
                <th>Total Leave</th>
                <th>Total Late</th>

            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
                $j = 0;
            @endphp

            @if (isset($branch_wise_monthly_attendance))
                @foreach ($branch_wise_monthly_attendance as $key => $item)
                    <tr>

                        <td>{{ ++$j }}</td>
                        <td class="rider-name">{{ $item->name }}</td>


                        @for ($i = 1; $i < $today->daysInMonth + 1; ++$i)
                            @php

                                $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');

                                $check_attd = \App\Attendance::query()
                                    ->where('name', $item->name)
                                    //->whereMonth('created_at', '=', \Carbon\Carbon::parse($todate)->format('m'))
                                    ->whereDate('created_at', $date_picker)
                                    ->first();
                                $total_leave = \App\Attendance::query()
                                    ->where('name', $item->name)
                                    ->whereMonth('created_at', '=', \Carbon\Carbon::parse($todate)->format('m'))
                                    ->where('status', 'Leave')
                                    ->count();
                                $total_present = \App\Attendance::query()
                                    ->where('name', $item->name)
                                    ->whereMonth('created_at', '=', \Carbon\Carbon::parse($todate)->format('m'))
                                    ->where('status', 'Present')
                                    ->count();

                                $total_absent = \App\Attendance::query()
                                    ->where('name', $item->name)
                                    ->whereMonth('created_at', '=', \Carbon\Carbon::parse($todate)->format('m'))
                                    ->where('status', 'Absent')
                                    ->count();

                                $total_late = \App\Attendance::query()
                                    ->where('name', $item->name)
                                    ->whereMonth('created_at', '=', \Carbon\Carbon::parse($todate)->format('m'))
                                    ->where('status', 'Late')
                                    ->count();
                            @endphp


                            <td>

                                <div style="text-align: center; font-weight: bold;"
                                    class="form-check form-check-inline ">

                                    @if (isset($check_attd))
                                        @if ($check_attd->status == 'Present')
                                            <i class="text-success">p</i>
                                        @elseif($check_attd->status == 'Absent')
                                            <i class="text-danger">A</i>
                                        @elseif($check_attd->status == 'Leave')
                                            <i class="text-danger">L</i>
                                        @elseif($check_attd->status == 'Late')
                                            <i class="text-warning">LA</i>
                                        @endif
                                    @else
                                        <i class=""></i>
                                    @endif
                                </div>
                            </td>
                        @endfor
                        <td>{{ $total_present }}</td>
                        <td>{{ $total_absent }}</td>
                        <td>{{ $total_leave }}</td>
                        <td>{{ $total_late }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>

    </table>
    <div class="navbar-fixed-bottom">
        <div style="float:left;">
            @foreach ($company as $data)
                Printed By : {{ $data->name }}
            @endforeach
        </div>
        <div style="float:right;">
            <?php echo 'Date & Time : ' . date('D, d M Y h:i:s a'); ?>
        </div>
    </div>
</body>

</html>
