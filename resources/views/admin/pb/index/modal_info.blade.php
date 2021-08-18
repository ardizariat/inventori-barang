<div class="modal fade modal-pb-info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    PB adalah permintaan barang yang ada di stok room, apabila barang yang anda cari tidak ada atau
                    kosong. Silahkan ajukan pembelian barang dimenu Buat PR.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <a href="{{ route('pb.create') }}" class="btn btn-primary">Ya, Ajukan permintaan barang PB</a>
            </div>
        </div>
    </div>
</div>
