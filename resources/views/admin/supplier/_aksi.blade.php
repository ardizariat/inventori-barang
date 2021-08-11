<div class="btn-group">
    <button onclick="editForm('{{ $update }}')" data-toggle="tooltip" data-placement="top"
        title="Ubah data {{ $data->nama }}" class="btn btn-sm btn-outline-success">
        <i class="fas fa-edit"></i>
    </button>
    <a onclick="showData('{{ $show }}')" data-toggle="tooltip" data-placement="top" title="Detail data"
        class="btn btn-sm btn-outline-info">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ $delete }}" data-toggle="tooltip" data-placement="top" title="Hapus data {{ $data->nama }}"
        class="btn-delete btn btn-sm btn-outline-danger">
        <i class="fas fa-trash"></i>
    </a>

</div>
