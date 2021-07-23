<div class="btn-group">
    <button onclick="editForm('{{$update}}')" data-toggle="tooltip" data-placement="top" title="Ubah data {{ $data->nama_produk }}"
        data-id="{{ $data->id }}" class="btn btn-sm btn-edit btn-outline-success">
        <i class="fas fa-edit"></i>
    </button>

    <a href="{{ $show }}" data-toggle="tooltip" data-placement="top" title="Detail data {{ $data->nama_produk }}"
        class="btn btn-sm btn-outline-info">
        <i class="fas fa-eye"></i>
    </a>

    <a href="{{ $delete }}" data-toggle="tooltip" data-placement="top"
    title="Hapus data" class="btn btn-sm btn-delete btn-outline-danger">
    <i class="fas fa-trash"></i>
    </a>
</div>
