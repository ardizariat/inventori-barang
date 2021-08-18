@if ($dept_head == 'on process')
    <span class="badge badge-warning text-capitalize">{{ $dept_head }}</span>
@elseif ($dept_head == 'rejected')
    <span class="badge badge-danger text-capitalize">{{ $dept_head }}</span>
@else
    <span class="badge badge-success text-capitalize">Approved</span>
@endif
