@if ($sect_head == 'on process')
    <span class="badge badge-warning text-capitalize">{{ $sect_head }}</span>
@elseif ($sect_head == 'rejected')
    <span class="badge badge-danger text-capitalize">{{ $sect_head }}</span>
@else
    <span class="badge badge-success text-capitalize">Approved</span>
@endif
