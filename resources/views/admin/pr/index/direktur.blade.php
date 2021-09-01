@role('super-admin|direktur')
@if ($direktur == 'on process')
    <a href="{{ route('pr.show', $data->id) }}" data-toggle="tooltip" data-placement="top"
        title="Lihat detail permintaan" class="badge badge-warning text-capitalize">{{ $direktur }}</a>
@elseif ($direktur == 'rejected')
    <a href="{{ route('pr.show', $data->id) }}" data-toggle="tooltip" data-placement="top"
        title="Lihat detail permintaan" class="badge badge-danger text-capitalize">{{ $direktur }}</a>
@else
    <a href="{{ route('pr.show', $data->id) }}" data-toggle="tooltip" data-placement="top"
        title="Lihat detail permintaan" class="badge badge-success text-capitalize">Approved</a>
@endif

@else

@if ($direktur == 'on process')
    <span class="badge badge-warning text-capitalize">{{ $direktur }}</span>
@elseif ($direktur == 'rejected')
    <span class="badge badge-danger text-capitalize">{{ $direktur }}</span>
@else
    <span class="badge badge-success text-capitalize">Approved</span>
    @endrole
@endif
