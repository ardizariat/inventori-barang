@if ($data->sect_head != 'approved' && $data->dept_head != 'approved')
  @if ($user->id == $data->pemohon || $user->hasRole('super-admin'))
    <button onclick="hapus(`{{ $destroy }}`)" data-toggle="tooltip" data-placement="top" title="Hapus data"
      class="btn btn-sm btn-delete btn-outline-danger">
      <i class="fas fa-trash"></i>
    </button>
  @endif
@endif
