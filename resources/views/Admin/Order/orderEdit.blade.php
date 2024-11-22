@extends('Master.main')
@section('title')
    Edit Order
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h4 class="mt-3">Edit Order</h4>
            </div>

        </div>
        <hr>
        <div class="container">
            <form name="payment-form" id="order_place" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Tracking ID. *</label><br>
                            <input id="tracking_id" value="{{ Session::get('track') }}" type="text" class="form-control"
                                readonly>
                        </div>
                        <div class="mb-3">
                            @cannot('activeEmployee')
                                <label for="formGroupExampleInput" class="form-label">Select Shop*</label>
                                <div class="form-group">
                                    <select id="shop" class="form-control" title="Select Shop" required>
                                        @foreach ($shop as $data)
                                            <option value="{{ $data->shop_name }}">{{ $data->shop_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endcannot
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Customer name*</label><br>
                            <input id="name" type="text" class="form-control" value="{{ Session::get('c_name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Address*</label>
                            <textarea id="address" name="address" class="form-control" required placeholder="Address" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Partial Delivery?</label>
                            <input type="checkbox" class="form-check-input" id="is_partial" name="is_partial" value="1"
                                {{ Session::get('is_partial') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="check1"> On </label>
                        </div>

                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Delivery Type</label>
                            <select name="imp" class="imp form-control" required>
                                <option value="Regular">Regular</option>
                                <option value="Urgent">One Hour</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Select Area*</label>
                            <select id="area" name="area" class="chosen-select" title="Select Area" required>
                                <option value=""> Select Area </option>
                                @foreach ($area as $data)
                                    <option value="{{ $data->area }}">{{ $data->area }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Select Chategory*</label>
                            <select id="category" class="chosen-select" name="category" title="Select Category" required>
                                <option value=""> Select Category </option>
                                @foreach ($category as $data)
                                    <option value="{{ $data->name }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Product Title</label>
                            <input class="form-control" id="pro_title" type="text" title="Product Title" name="product"
                                placeholder="Product Title" value="{{ Session::get('product') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Weight(KG)</label>
                            <select class="chosen-select" name="weight" id="weight" required>
                                <option value=""> --- select weight --- </option>
                                @foreach ($weights as $weight)
                                    {{-- <option value="{{ $weight->title }}" {{ Session::get('weight')=$weight->title?'selected'  : ''}}>{{ $weight->title }}</option> --}}
                                    <option value="{{ $weight->title }}">{{ $weight->title }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Invoice Value(TK)</label>
                            <input class="form-control" id="collection" type="text" name="collection"
                                title="Collection Amount" placeholder="Collection Amount" required
                                value="{{ Session::get('collection') }}">
                        </div>
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Pickup Date*</label>
                            <input id="pickup_date" class="form-control" name="p_date" type="date"
                                title="Select Pickup Date" value="{{ Session::get('pickup_date') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Pickup Time*</label>
                            <select id="pickup_time" class="form-control" name="p_time" title="Select Pickup Time"
                                required>
                                @foreach ($pickup as $data)
                                    <option value="{{ $data->pick_up }}">{{ $data->pick_up }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="validationTooltip01" class="form-label">Delivery Note</label>
                            <textarea id="remarks" name="remarks" class="form-control" placeholder="Delivery Note" rows="2" required></textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div style="text-align: center;" class="mb-3">

                    <button type="submit" class=" btn btn-success">Preview</button>
                </div>

        </div>


    </div>

    {{-- <div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 class="col-lg-12">Edit Order</h1>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <form name="payment-form" id="order_place" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="col-lg-4">Tracking ID. *</label>
                                        <div class="form-group col-lg-8">
                                            <input id="tracking_id" value="{{ Session::get('track') }}" 
                                                class="form-control" readonly 
                                                style="border:hidden;">
                                        </div>
                                       
                                        <label class="col-lg-4">Select Shop *</label>
                                        <div class="form-group col-lg-8">
                                            <select id="shop" name="shop" class="form-control" 
                                                title="Select Shop" required>
                                                @foreach ($shop as $data)
                                                <option value="{{ $data->shop_name }}">{{ $data->shop_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-lg-4">Customer Name *</label>
                                        <div class="form-group col-lg-8">
                                            <input id="name" type="text" value="{{ Session::get('c_name') }}"
                                                class="form-control" required
                                                placeholder="Customer Name">
                                        </div>
                                        <label class="col-lg-4">Customer Email</label>
                                        <div class="form-group col-lg-8">
                                            <input id="email" type="email" 
                                                class="form-control" value="{{ Session::get('c_email') }}"
                                                placeholder="Customer Email">
                                        </div>
                                        <label class="col-lg-4">Customer Phone *</label>
                                        <div class="form-group col-lg-8">
                                            <input id="phone" type="number" class="form-control"
                                                value="{{ Session::get('c_phone') }}" required
                                                placeholder="Customer Phone">
                                        </div>
                                        <label class="col-lg-4">Address *</label>
                                        <div class="form-group col-lg-8">
                                            <textarea id="address" name="address" class="form-control" 
                                                 placeholder="Address"></textarea>
                                        </div>
                                        <label class="col-lg-4">Remarks </label>
                                        <div class="form-group col-lg-8">
                                            <textarea id="remarks" class="form-control"
                                                placeholder="Remarks"></textarea>
                                        </div>
                                        <label class="col-lg-4"> Partial Delivery?</label>
                                        <div class="form-group col-lg-8">
                                            <input type="checkbox" class="form-check-input" id="is_partial" name="is_partial" value="1" {{ Session::get('is_partial')==1 ? 'checked' :'' }} >
                                            <label class="form-check-label" for="check1"> On </label>
                                        </div>
                                        
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-lg-4">Delivery Type</label> --}}
    {{-- <div class="col-lg-3 text-right">
                                            <input type="radio" name="imp" class="imp" required 
                                                value="Regular"/>Regular
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <input type="radio" name="imp" class="imp" required 
                                                value="Urgent"/>Urgent 
                                        </div> --}}
    {{-- <div class="form-group col-lg-8">
                                            <select name="imp" class="imp form-control" required>
                                                <option value="Regular">Regular</option>
                                                <option value="Urgent">Express</option>
                                            </select>
                                        </div>

                                        <label class="col-lg-4">Select Area *</label>
                                        <div class="form-group col-lg-8">
                                            <select id="area" name="area" class="chosen-select" 
                                                    title="Select Area" required>
                                                <option value=""> Select Area </option>
                                                @foreach ($area as $data)
                                                <option value="{{ $data->area }}">{{ $data->area }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-lg-4">Select Category *</label>
                                        <div class="form-group col-lg-8">
                                            <select id="category" class="chosen-select" 
                                                    name="category" title="Select Category" required>
                                                <option value=""> Select Category </option>
                                                @foreach ($category as $data)
                                                <option value="{{ $data->name }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-lg-4">Product Title *</label>
                                        <div class="form-group col-lg-8">
                                            <input class="form-control" id="pro_title" 
                                                type="text" title="Product Title" name="product"
                                                placeholder="Product Title" 
                                                value="{{ Session::get('product') }}" required>
                                        </div>
                                        <label class="col-lg-4">Weight *</label>
                                        <div class="form-group col-lg-8"> --}}
    {{-- <input class="form-control" id="weight" type="number" 
                                                title="Weight" placeholder="Weight" required> --}}

    {{-- <select  class="chosen-select" name="weight" id="weight" required>
                                                    <option value=""> --- select weight --- </option>
                                                    @foreach ($weights as $weight)

                                                    {{-- <option value="{{ $weight->title }}" {{ Session::get('weight')=$weight->title?'selected'  : ''}}>{{ $weight->title }}</option> --}}
    {{-- <option value="{{ $weight->title }}">{{ $weight->title }}</option>
                                                    @endforeach
                                                </select> --}}
    {{--  <select id="weight" name="weight" class="form-control" 
                                                title="Select Weight" required>
                                                <option value="">Select Weight</option>
                                                <option value="500 gm">500 gm</option>
                                                <option value="1 kg">1 kg</option>
                                                <option value="2 kg">2 kg</option>
                                                <option value="3 kg">3 kg</option>
                                            </select>  --}}
    {{-- </div>
                                        <label class="col-lg-4">Collection Amount *</label>
                                        <div class="form-group col-lg-8">
                                            <input class="form-control" id="collection" type="text" 
                                                name="collection" title="Collection Amount"
                                                placeholder="Collection Amount" required
                                                value="{{ Session::get('collection') }}">
                                        </div>
                                        <label class="col-lg-4">Pickup Date *</label>
                                        <div class="form-group col-lg-8">
                                            <input id="pickup_date" class="form-control"
                                                name="p_date" type="date" title="Select Pickup Date"
                                                value="{{ Session::get('pickup_date') }}" required>
                                        </div>
                                        <label class="col-lg-4">Pickup Time *</label>
                                        <div class="form-group col-lg-8">
                                            <select id="pickup_time" class="form-control" 
                                                name="p_time" title="Select Pickup Time" required>
                                                @foreach ($pickup as $data)
                                                <option value="{{ $data->pick_up }}">{{ $data->pick_up }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                       
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center credit-card-custom"> --}}
    {{--  <button type="reset" class="btn btn-warning">
                                        Clear <i class="fa fa-refresh"></i>
                                    </button>  --}}
    {{-- <button type="submit" class="btn btn-success">
                                        Preview <i class="fa fa-check-circle"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}


    <script>
        $('#order_place').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('order.update') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'tracking_id': $("#tracking_id").val(),
                    'order_id': $("#order_id").val(),
                    'customer_name': $("#name").val(),
                    'customer_email': $("#email").val(),
                    'customer_phone': $("#phone").val(),
                    'customer_address': $("#address").val(),
                    'shop': $("#shop").val(),
                    'area': $("#area").val(),
                    'pickup_date': $("#pickup_date").val(),
                    'pickup_time': $("#pickup_time").val(),
                    'remarks': $("#remarks").val(),
                    'category': $("#category").val(),
                    'product': $("#pro_title").val(),
                    'weight': $("#weight").val(),
                    'collection': $("#collection").val(),
                    'is_partial': $('#is_partial').is(':checked') == true ? 1 : 0,
                    'imp': $(".imp").val(),
                },
                success: function() {
                    location.href = "{{ route('order.preview') }}";
                },
                error: function(error) {
                    console.log(error);
                    alert('Order Not Updated');
                }
            });
        });
    </script>
    <script>
        document.forms['payment-form'].elements['shop'].value = '{{ Session::get('shop') }}';
        document.forms['payment-form'].elements['address'].value = '{{ Session::get('address') }}';
        document.forms['payment-form'].elements['area'].value = '{{ Session::get('area') }}';
        document.forms['payment-form'].elements['category'].value = '{{ Session::get('category') }}';
        document.forms['payment-form'].elements['weight'].value = '{{ Session::get('weight') }}';
        document.forms['payment-form'].elements['p_date'].value = '{{ Session::get('p_date') }}';
        document.forms['payment-form'].elements['p_time'].value = '{{ Session::get('p_time') }}';
        document.forms['payment-form'].elements['imp'].value = '{{ Session::get('imp') }}';
        document.forms['payment-form'].elements['remarks'].value = '{{ Session::get('remarks') }}';
    </script>

@endsection
