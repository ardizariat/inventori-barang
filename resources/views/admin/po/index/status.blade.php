@role('super-admin|dept_head|sect_head')
@if ($status == 'pending')
    <a href="{{ route('po.show', $data->id) }}" data-toggle="tooltip" data-placement="top" title="Lihat detail po"
        class="badge badge-warning text-capitalize">On Process</a>
@elseif($status == 'on process')
    <a href="{{ route('po.show', $data->id) }}" data-toggle="tooltip" data-placement="top"
        title="Lihat detail permintaan" class="badge badge-info text-capitalize">On Process</a>
@else
    <a href="{{ route('po.show', $data->id) }}" data-toggle="tooltip" data-placement="top"
        title="Lihat detail permintaan" class="badge badge-success text-capitalize">Complete</a>
@endif
@elserole

@if ($status == 'pending')
    <span class="badge badge-warning text-capitalize">Pending</span>
@elseif($status == 'on process')
    <span class="badge badge-info text-capitalize">On Process</span>
@else
    <span class="badge badge-success text-capitalize">Complete</span>
@endif
@endrole
