<div class="btn-group">
    <button onclick="editForm('{{ $edit }}')" data-toggle="tooltip" data-placement="top"
        title="Ubah data {{ $query->nama }}" class="btn btn-sm btn-outline-success">
        <i class="fas fa-edit"></i>
    </button>


    <button onclick="deleteData('{{ $delete }}')" data-toggle="tooltip" data-placement="top"
        title="Hapus data {{ $query->nama }}" class="btn btn-sm btn-outline-danger">
        <i class="fas fa-trash"></i>
    </button>

</div>
