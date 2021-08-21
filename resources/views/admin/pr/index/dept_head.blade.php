@role('super-admin|dept_head')
@if ($dept_head == 'on process')
    <a href="{{ route('pr.show', $data->id) }}" data-toggle="tooltip" data-placement="top"
        title="Lihat detail permintaan" class="badge badge-warning text-capitalize">{{ $dept_head }}</a>
@elseif ($dept_head == 'rejected')
    <a href="{{ route('pr.show', $data->id) }}" data-toggle="tooltip" data-placement="top"
        title="Lihat detail permintaan" class="badge badge-danger text-capitalize">{{ $dept_head }}</a>
@else
    <a href="{{ route('pr.show', $data->id) }}" data-toggle="tooltip" data-placement="top"
        title="Lihat detail permintaan" class="badge badge-success text-capitalize">Approved</a>
@endif
@elserole

@if ($dept_head == 'on process')
    <span class="badge badge-warning text-capitalize">{{ $dept_head }}</span>
@elseif ($dept_head == 'rejected')
    <span class="badge badge-danger text-capitalize">{{ $dept_head }}</span>
@else
    <span class="badge badge-success text-capitalize">Approved</span>
@endif
@endrole
