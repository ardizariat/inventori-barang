<div class="modal fade bd-example-modal-lg modal-produk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table produk-table table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th width="10%" align="center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $item)
                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="15%">
                                    <span class="badge badge-success">{{ $item->kode }}</span>
                                </td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ formatAngka($item->harga) }}</td>
                                <td width="10%" align="center">
                                    <button onclick="pilihProduk('{{ $item->id }}', '{{ $item->kode }}')"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-check-circle"></i> Pilih
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
