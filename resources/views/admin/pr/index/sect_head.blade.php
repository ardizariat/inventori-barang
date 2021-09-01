@role('super-admin|sect_head')
@if ($sect_head == 'on process')
    <a href="{{ route('pr.show', $data->id) }}" data-toggle="tooltip" data-placement="top"
        title="Lihat detail permintaan" class="badge badge-warning text-capitalize">{{ $sect_head }}</a>
@elseif ($sect_head == 'rejected')
    <a href="{{ route('pr.show', $data->id) }}" data-toggle="tooltip" data-placement="top"
        title="Lihat detail permintaan" class="badge badge-danger text-capitalize">{{ $sect_head }}</a>
@else
    <a href="{{ route('pr.show', $data->id) }}" data-toggle="tooltip" data-placement="top"
        title="Lihat detail permintaan" class="badge badge-success text-capitalize">Approved</a>
@endif

@else

@if ($sect_head == 'on process')
    <span class="badge badge-warning text-capitalize">{{ $sect_head }}</span>
@elseif ($sect_head == 'rejected')
    <span class="badge badge-danger text-capitalize">{{ $sect_head }}</span>
@else
    <span class="badge badge-success text-capitalize">Approved</span>
@endif
@endrole
