<div class="btn-group">
    <a href="{{ $edit }}" data-toggle="tooltip" data-placement="top" title="Ubah data {{ $query->nama }}"
        class="btn btn-sm btn-outline-success">
        <i class="fas fa-edit"></i>
    </a>

    <a href="{{ $show }}" data-toggle="tooltip" data-placement="top" title="Ubah data {{ $query->nama }}"
        class="btn btn-sm btn-outline-info">
        <i class="fas fa-eye"></i>
    </a>

    <button onclick="deleteData('{{ $delete }}')" data-toggle="tooltip" data-placement="top"
        title="Hapus data {{ $query->nama }}" class="btn btn-sm btn-outline-danger">
        <i class="fas fa-trash"></i>
    </button>
</div>
