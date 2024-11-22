@extends('Master.main')
@section('title')
    Submit Complain Information
@endsection
@section('content')
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
                            <form action="{{ route('merchant.merchant.complain') }}" method="POST">
                                @csrf
                                <div class="row">


                                    <div class="col-lg-4 form-group">
                                        <label>Name</label>
                                        <input type="text" value="{{ $user->name }}" name="name"
                                            class="form-control name" readonly />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>E-mail</label>
                                        <input type="email" value="{{ $user->email }}" name="email"
                                            class="form-control email" readonly />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>Mobile</label>
                                        <input type="number" value="{{ $user->mobile }}" name="mobile"
                                            class="form-control mobile" readonly />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>User Role</label>
                                        @if ($user->role == 12)
                                            <input type="text" value="activeMerchant" name="role"
                                                class="form-control role" readonly />
                                        @else
                                            <input type="text" value="inactiveMerchant" name="role"
                                                class="form-control role" readonly />
                                        @endif
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>Date</label>
                                        <input type="date" name="date" class="form-control"
                                            value="{{ $date }}" required />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>Duration</label>
                                        <input type="time" name="time" class="form-control"
                                            value="{{ $time }}" required />
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
                                        <label>Problem</label>
                                        <select name="problem[]" class="chosen-select" multiple=""
                                            data-placeholder=" Choose Problem ... " required>
                                            {{--  <option value="">Select Problem</option>  --}}
                                            @foreach ($problem as $data)
                                                <option value="{{ $data->title }}"> {{ $data->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label>Comment</label>
                                        <textarea name="comment" class="form-control" style="height:50px;" required></textarea>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('merchant.complain') }}" class="btn btn-warning">Back</a>
                                    <a href="{{ route('merchant.complain.create') }}" class="btn btn-danger">Reset</a>
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
