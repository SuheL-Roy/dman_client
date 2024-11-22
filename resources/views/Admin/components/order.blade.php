<?php $i = 1;?>
@foreach ($data as $key => $data)
<tr>
    <td></td>
    <td>{{ $key+1 }}</td>
    <td>{{ $data->tracking_id }}</td>
    <td>{{ $data->order_id }}</td>
    <td>{{ $data->area }}</td>
    <td>{{ $data->collection }}</td>
    <td>{{ $data->pickup_date }}</td>
    <td>{{ $data->pickup_time }}</td>
    <td>
        <button class="addOrder btn btn-primary btn-xs" type="button"
            value="{{ $data->tracking_id }}">
            <i class="fa fa-arrow-circle-right"></i>
        </button>
    </td>
</tr>
@endforeach
