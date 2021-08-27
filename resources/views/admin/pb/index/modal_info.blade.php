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
                <div class="alert alert-info">
                    <p>Identitas dibawah akan dimasukan ke dalam sistem pengajuan permintaan barang PB</p>
                    <p>Jika sesuai, silahkan tekan lanjutkan!</p>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>:</th>
                            <td>{{ auth()->user()->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th>:</th>
                            <td>{{ auth()->user()->email ?? '' }}</td>
                        </tr>
                    </thead>
                </table>
                <div class="row justify-content-center">
                    <button type="button" class="btn-flat btn btn-danger mx-1" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <a href="{{ route('pb.create') }}" class="btn-flat btn btn-info">
                        Lanjutkan <i class="fas fa-sign-in-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
