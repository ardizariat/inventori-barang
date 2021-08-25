    <button onclick="pilihProduk('{{ $data->id }}')" data-toggle="tooltip" data-placement="top"
        title="Tambah produk" class="btn btn-sm btn-primary" @isset($pb_detail) @foreach ($pb_detail as $pb)
        @if ($pb->produk_id == $data->id)
            disabled
        @endif
        @endforeach
    @endisset
    >
    <i class="fas fa-check-circle"></i> Tambah
</button>
