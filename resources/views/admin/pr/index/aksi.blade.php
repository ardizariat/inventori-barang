@empty($data->po->pr_id)
    <div class="btn-group">
        <button onclick="hapus(`{{ $destroy }}`)" data-toggle="tooltip" data-placement="top" title="Hapus data"
            class="btn btn-sm btn-outline-danger">
            <i class="fas fa-trash"></i>
        </button>
    </div>
@endempty
