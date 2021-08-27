@if ($status == 'pending')
    <span class="badge badge-warning text-capitalize">Pending</span>
@elseif($status == 'on process')
    <span class="badge badge-info text-capitalize">On Process</span>
@else
    <span class="badge badge-success text-capitalize">Complete</span>
@endif
