@php
    $badge = collect([
      'danger',
      'success',
      'info',
      'dark'
    ]);
@endphp
<div class="badge badge-{{ $badge->random() }}">
  {!! $data->description !!}
</div>