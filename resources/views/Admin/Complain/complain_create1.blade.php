@extends('Master.main')
@section('title')
Ticket Create
@endsection
@section('content')

<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="main-sparkline13-hd">
                        <h1 class="col-lg-6">Add Ticket Information</h1>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="container-fluid">
                        <form action="{{ route('complain.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 form-group">
                                    <label>User Type</label>
                                    <select name="type" class="form-control" id="utype" required>
                                        <option value="null">Select User Type</option>
                                        <option value="null">Customer</option>
                                        <option value="7">Merchant</option>
                                        <option value="5">Agent</option>
                                        <option value="6">Rider</option>
                                        <option value="null">Others</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>Mobile Number</label>
                                    <select name="mnumber" id="mnumber" required
                                        class="form-control chosen -select">
                                        <option value="">Select User Mobile Number</option>
                                    </select>
                                </div>
                                {{--  <div class="col-lg-4 form-group">
                                    <button class="btn btn-success btn-sm" type="submit"
                                        style="float:left; margin-top:26px;">Search
                                    </button>
                                </div>  --}}
                                {{--  <div class="clearfix"></div>  --}}
                                <div class="col-lg-4 form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        {{--  <option value="">Select Status</option>  --}}
                                        <option value="Received">Received</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Solved">Solved</option>
                                        <option value="Cancel">Cancel</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control name" required/>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>Mobile</label>
                                    <input type="number" name="mobile" class="form-control mobile" required/>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>E-mail</label>
                                    <input type="email" name="email" class="form-control email" required/>
                                </div>
                                {{--  <div class="col-lg-4 form-group">
                                    <label>District</label>
                                    <input type="text" name="district" class="form-control" required/>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>Area</label>
                                    <input type="text" name="area" class="form-control" required/>
                                </div>  --}}
                                <div class="col-lg-4 form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control" 
                                        value="{{ $date }}" required/>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>Time</label>
                                    <input type="time" name="time" class="form-control" 
                                        value="{{ $time }}" required/>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>Call Duration</label>
                                    <input type="text" name="duration" class="form-control" required/>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label>Problem</label>
                                    <textarea type="text" name="problem" style="height:103px;"
                                        class="form-control" required></textarea>
                                </div>
                                
                            </div>
                            <div class="text-center">
                                <a href="{{ route('.index') }}" 
                                    class=" btn btn-info btn- sm">Back
                                </a>
                                <a href="{{ route('complain.create') }}" 
                                    class=" btn btn-danger btn- sm">Reset
                                </a>
                                <button class=" btn btn-warning btn- sm" type="reset">Clear</button>
                                <button class=" btn btn-success btn- sm" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        $('#utype').on('change', function () {
            var id = $(this).val();
            if (id) {
                $.ajax({
                    url: '{{ route('complain.find.user') }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {id: id},
                    success: function (data) {
                        $('select[name="mnumber"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="mnumber"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="mnumber"]').val("Search User Mobile Number");
            }
        });
        $('#mnumber').on('change', function () {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('complain.find.details') }}",
                data: {id: id},
                success: function (data) {
                    $('.id').val(data[0]['id']);
                    $('.name').val(data[0]['name']);
                    $('.mobile').val(data[0]['mobile']);
                    $('.email').val(data[0]['email']);
                }
            });
        });
    </script>

@endsection