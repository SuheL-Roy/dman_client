@extends('Master.main')
@section('title')
    Income Report Date Wise
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">


                            <div class="main-sparkline13-hd">
                                <h5 class="col-lg-2 form-group" style="padding:0px;">
                                    Income And Expense Report
                                </h5>
                                <form action="{{ route('Income.report.print') }}" method="get" class="col-lg-1"
                                    style="float:right;" target="_blank">
                                    @csrf

                                    {{-- <input type="hidden" name="income_type" value="{{ $income_type }}" />
                                    <input type="hidden" name="income_fors" value="{{ $income_for }}" />
                                    <input type="hidden" name="fromdate" value="{{ $fromdate }}" />
                                    <input type="hidden" name="todate" value="{{ $todate }}" /> --}}
                                    {{-- <button type="submit" class="btn btn-primary" style="float:right;">
                                        <i class="fa fa-print"></i>
                                    </button> --}}
                                </form>
                                <form action="{{ route('Summary.view') }}" method="get">
                                    @csrf

                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">From:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" name="fromdate" value="{{ $fromdate }}"
                                                    class="form-control" style="padding-left: 7px;" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label style="float:right;">To:</label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input type="date" value="{{ $todate }}" class="form-control"
                                                    name="todate" />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="col-lg-1 btn btn-success btn-sm" style="">Load
                                    </button>
                                </form>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>




                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright row">
                                <div class="col-lg-6" style="overflow: scroll; height: 350px;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <?php $i = 1; ?>
                                            <tr>
                                                <th>SL.</th>
                                                <th>Date</th>
                                                <th>Voucher No</th>
                                                <th>Income Type</th>
                                                <th>Income For</th>
                                                <th>Amount</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($income as $data)
                                                <tr>
                                                    
                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $data->date }}</td>
                                                    <td>{{ $data->voucher_no }}</td>
                                                    <td>{{ $data->income_type }}</td>
                                                    <td>{{ $data->income_for }}</td>
                                                    <td>{{ $data->amount }}</td>
                                                    <td>{{ $data->details }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-lg-6" style="overflow: scroll; height: 350px;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>SL.</th>
                                                <th>Date</th>
                                                <th>Voucher No</th>
                                                <th>ExpenseType</th>
                                                <th>Expense For</th>
                                                <th>Amount</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($expense as $data)
                                            <tr>
                                                
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->date }}</td>
                                                <td>{{ $data->voucher_no }}</td>
                                                <td>{{ $data->expense_type }}</td>
                                                <td>{{ $data->expense_for }}</td>
                                                <td>{{ $data->amount }}</td>
                                                <td>{{ $data->details }}</td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>

                                <div class="clearfix"></div>


                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
