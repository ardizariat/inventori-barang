@if ($data->status == 'pending')
    <span class="badge badge-warning">{{ $data->status }}</span>
@else
    <span class="badge badge-success">{{ $data->status }}</span>
@endif
