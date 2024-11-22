@extends('FrontEnd.loginMaster')
@section('title')
    Inactive Merchant
@endsection
@section('content')
    <section class="container">


        {{-- @if ($merchant)
            <div class="col-lg-3"></div>
            <div class="col-lg-6"
                style="margin-top:270px; margin-bottom:229px; padding: 30px;
    border: 1px solid #4CAF50; border-radius: 1%; box-shadow: 5px 7px #888888;">
                <h4 class="text-center" style="color:#4CAF50;">Your Merchant account registration is successful.</h4>
                <h4 class="text-center" style="color:#4CAF50;">Wait for account verification.</h4>
            </div>
        @elseif($merchant == null)
            @if (Auth::user()->role === 13)
                <div class="row">
                    <div class="col-lg-12">
                        <div
                            style="margin-top:270px; margin-bottom:229px; padding: 30px;
                border: 1px solid #f50000; border-radius: 1%; box-shadow: 5px 7px #ff0202;">

                            <form action="{{ route('merchant.user.infoadd') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="name">Business Name</label>
                                            <input type="text" class="form-control" name="business_name"
                                                id="business_name" aria-describedby="business_name"
                                                placeholder="Business Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="area">Branch</label>
                                            <select class="form-control" name="area" id="area">
                                                <option> --- select branch --- </option>
                                                @foreach ($zones as $branch)
                                                    <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="district">District</label>
                                            <select class="form-control" name="district" id="district">
                                                <option> --- select District --- </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h4> user info </h4>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">User Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                aria-describedby="name" placeholder="User Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">User Address</label>
                                            <input type="text" class="form-control" name="address" id="address"
                                                aria-describedby="address" placeholder="User Address">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @else --}}
        <div>



            @if ($merchant)
                <div class="col-lg-3"></div>
                <div class="col-lg-6"
                    style="margin-top:270px; margin-bottom:229px; padding: 30px;
    border: 1px solid #4CAF50; border-radius: 1%; box-shadow: 5px 7px #888888;">
                    {{-- <h2 class="text-center" style="color:#4CAF50;"><b>Inactive Account</b></h2> --}}
                    <h4 class="text-center" style="color:#4CAF50;">Thank You! Your Merchant Account Registration is successful. We will manually
                    </h4>
                    <h4 class="text-center" style="color:#4CAF50;">Check and Activate your account within 24 hours.</h4>
                </div>
            @elseif($merchant == null)
                @if (Auth::user()->role === 13)
                    <div class="row">
                        <div class="col-lg-12">
                            <div
                                style="margin-top:270px; margin-bottom:229px; padding: 30px;
                border: 1px solid #f50000; border-radius: 1%; box-shadow: 5px 7px #ff0202;">

                                <form action="{{ route('merchant.user.infoadd') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="name">Business Name</label>
                                                <input type="text" class="form-control" name="business_name"
                                                    id="business_name" aria-describedby="business_name"
                                                    placeholder="Business Name">
                                            </div>
                                        </div>
                                        <p class="col-lg-6">
                                            <label>Hub</label>
                                            <select name="area" id="area" class="form-control" required>
                                                <option value="">--- Select Hub ---</option>
                                                @foreach ($zones as $zone)
                                                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                        <p class="col-lg-6">
                                            <label>District</label>
                                            <select name="district" class="select picker form-control" id="district"
                                                data-style="btn-info" data-live-search="true" required>
                                                <option value=""> ---Select District ---</option>

                                            </select>
                                        </p>
                                    </div>
                                    <hr>
                                    <h4> user info </h4>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">User Name</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    aria-describedby="name" placeholder="User Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">User Address</label>
                                                <input type="text" class="form-control" name="address" id="address"
                                                    aria-describedby="address" placeholder="User Address">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="col-lg-3"></div>
                <div class="col-lg-6"
                    style="margin-top:270px; margin-bottom:229px; padding: 30px;
        border: 1px solid #4CAF50; border-radius: 1%; box-shadow: 5px 7px #888888;">
                    {{-- <h2 class="text-center" style="color:#4CAF50;"><b>Inactive Account</b></h2> --}}
                    <h4 class="text-center" style="color:#4CAF50;">Your Merchant account registration is successful.
                    </h4>
                    <h4 class="text-center" style="color:#4CAF50;">Wait for account verification.</h4>
                </div>
            @endif
        </div>








    </section>
    <script>
        $('#area').change(function() {

            $('#district').empty();
            $('#district').append($('<option>', {
                value: '',
                text: ' --- select District --- '
            }));

            var zone_id = $('#area :selected').val();

            // alert(zone_id);
            $.ajax({
                url: "{{ route('ajaxdata.dist') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    zone_id: zone_id
                },
                cache: false,
                dataType: 'json',
                success: function(dataResult) {

                    var resultData = dataResult.data;

                    $.each(resultData, function(index, row) {

                        $('#district').append($('<option>', {
                            value: row.id,
                            text: row.name
                        }));

                    })


                }
            });

        });
    </script>
@endsection
