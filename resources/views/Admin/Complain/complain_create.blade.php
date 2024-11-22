@extends('Master.main')
@section('title')
    Submit Ti Information
@endsection
@section('content')
    <style>
        .btn-success {
            color: #fff;
            background-color: var(--primary);
            border-color: var(--primary);
        }

        button:hover {
            color: #111110 !important;
            background: var(--scolor) !important;
            text-decoration: none;
        }

        a:hover {
            color: #111110 !important;
            background: var(--scolor) !important;
            text-decoration: none;
        }
    </style>

    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="main-sparkline13-hd">
                            <h1 class="col-lg-6">Submit Ticket Information</h1>
                            <div class="container col-lg-4">
                                @if (session('message'))
                                    <div class="alert alert-dismissible alert-success"
                                        style="padding-top:5px; padding-bottom:5px; 
                                    margin-top:0px; margin-bottom:0px;">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ session('message') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="container-fluid">
                            <form action="{{ route('complain.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        <label>Mobile Number</label>
                                        <select name="" class="chosen-select" id="mnumber"
                                            data-placeholder="Search User Mobile Number">
                                            <option value="">Search User Mobile Number</option>
                                            @foreach ($user as $data)
                                                <option value="{{ $data->id }}">{{ $data->mobile }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>

                                    <div class="col-lg-4 form-group">
                                        <label>Name*</label>
                                        <input type="text" name="name" class="form-control name" required />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>E-mail(optional) </label>
                                        <input type="email" name="email" class="form-control email" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>Mobile*</label>
                                        <input type="number" name="mobile" class="form-control mobile" required />
                                    </div>
                                    {{--  <div class="col-lg-4 form-group">
                                    <label>User Role</label>
                                    <input type="text" name="role" class="form-control role" required/>
                                </div> --}}
                                    <div class="col-lg-4 form-group">
                                        <label>Date*</label>
                                        <input type="date" name="date" class="form-control"
                                            value="{{ $date }}" required />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>Time</label>
                                        <input type="time" name="time" class="form-control"
                                            value="{{ $time }}" required />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>Call Duration</label>
                                        <input type="text" name="call_duration" class="form-control"  />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>Ticket Type</label>
                                        <select name="priority" class="form-control" required>
                                            {{--  <option value="">Select Status</option>  --}}
                                            <option value="Complain">Complain</option>
                                            <option value="Payment Request">Payment Request</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>Ticket Type</label>
                                        <select name="problem[]" class="chosen-select" multiple=""
                                            data-placeholder=" Choose Problem ... " required>
                                            {{--  <option value="">Select Problem</option>  --}}
                                            @foreach ($problem as $data)
                                                <option value="{{ $data->title }}"> {{ $data->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>Comment</label>
                                        <textarea name="comment" class="form-control" style="height:103px;" required></textarea>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('complain.index') }}" class="btn btn-warning">Back</a>
                                    <a href="{{ route('complain.create') }}" class="btn btn-danger">Reset</a>
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#mnumber').on('change', function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('complain.find.details') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    $('.id').val(data[0]['id']);
                    $('.name').val(data[0]['name']);
                    $('.mobile').val(data[0]['mobile']);
                    $('.email').val(data[0]['email']);
                    if (data[0]['role'] === 1) {
                        $('.role').val('Super Admin')
                    }
                    if (data[0]['role'] === 2) {
                        $('.role').val('Active Admin')
                    }
                    if (data[0]['role'] === 3) {
                        $('.role').val('Inactive Admin')
                    }
                    if (data[0]['role'] === 4) {
                        $('.role').val('Active Manager')
                    }
                    if (data[0]['role'] === 5) {
                        $('.role').val('Inactive Manager')
                    }
                    if (data[0]['role'] === 6) {
                        $('.role').val('Active Accounts')
                    }
                    if (data[0]['role'] === 7) {
                        $('.role').val('Inactive Accounts')
                    }
                    if (data[0]['role'] === 8) {
                        $('.role').val('Active Agent')
                    }
                    if (data[0]['role'] === 9) {
                        $('.role').val('Inactive Agent')
                    }
                    if (data[0]['role'] === 10) {
                        $('.role').val('Active Rider')
                    }
                    if (data[0]['role'] === 11) {
                        $('.role').val('Inactive Rider')
                    }
                    if (data[0]['role'] === 12) {
                        $('.role').val('Active Merchant')
                    }
                    if (data[0]['role'] === 13) {
                        $('.role').val('Inactive Merchant')
                    }
                    if (data[0]['role'] === 14) {
                        $('.role').val('Active Employee')
                    }
                    if (data[0]['role'] === 15) {
                        $('.role').val('Inactive Employee')
                    }
                    if (data[0]['role'] === 16) {
                        $('.role').val('Active Call Center')
                    }
                    if (data[0]['role'] === 17) {
                        $('.role').val('Inactive Call Center')
                    }
                }
            });
        });
    </script>
@endsection
