<div class="btn-group">
    <button onclick="editForm('{{$update}}')" data-toggle="tooltip" data-placement="top" title="Ubah data {{ $query->nama_produk }}"
        data-id="{{ $query->id }}" class="btn btn-sm btn-edit btn-outline-success">
        <i class="fas fa-edit"></i>
    </button>

    <a href="{{ $show }}" data-toggle="tooltip" data-placement="top" title="Ubah data {{ $query->nama_produk }}"
        class="btn btn-sm btn-outline-info">
        <i class="fas fa-eye"></i>
    </a>

    <button onclick="deleteData('{{ $delete }}')" data-toggle="tooltip" data-placement="top"
        title="Hapus data {{ $query->nama_produk }}" class="btn btn-sm btn-outline-danger">
        <i class="fas fa-trash"></i>
    </button>
</div>
