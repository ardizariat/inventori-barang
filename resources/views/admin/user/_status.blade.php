@if ($data->status == 'aktif')
<span class="badge badge-pill badge-success">Aktif</span>
@elseif($data->status == 'ditangguhkan')
<span class="badge badge-pill badge-info">Ditangguhkan</span>
@else
<span class="badge badge-pill badge-danger">Tidak Aktif</span>
@endif