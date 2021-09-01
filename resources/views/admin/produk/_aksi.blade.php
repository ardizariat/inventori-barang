<div class="btn-group">
    @role('super-admin|admin')
    <a href="{{ $edit }}" data-toggle="tooltip" data-placement="top"
        title="Detail data {{ $data->nama_produk }}" class="btn btn-sm btn-outline-success">
        <i class="fas fa-edit"></i>
    </a>
    <a href="{{ $delete }}" data-toggle="tooltip" data-placement="top" title="Hapus data"
        class="btn btn-sm btn-delete btn-outline-danger">
        <i class="fas fa-trash"></i>
    </a>
    @endrole
    <a href="{{ $show }}" data-toggle="tooltip" data-placement="top"
        title="Detail data {{ $data->nama_produk }}" class="btn btn-sm btn-outline-info">
        <i class="fas fa-eye"></i>
    </a>
</div>
