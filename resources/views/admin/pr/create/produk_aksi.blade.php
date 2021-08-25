    <button onclick="pilihProduk('{{ $data->id }}')" data-toggle="tooltip" data-placement="top"
        title="Tambah produk" class="btn btn-sm btn-primary" @isset($pr_detail) @foreach ($pr_detail as $pb)
        @if ($pr->produk_id == $data->id)
            disabled
        @endif
        @endforeach
    @endisset
    >
    <i class="fas fa-check-circle"></i> Tambah
</button>
