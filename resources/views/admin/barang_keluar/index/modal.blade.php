<div class="modal fade modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form>
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-capitalize">
                        Silahkan masukan no tiket
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label>No Tiket</label>
                            </div>
                            <div class="col-md-10">
                                <select title="Masukan nomor tiket" data-live-search="true" name="no_dokumen"
                                    onchange="changeData(`{{ route('barang-keluar.change-data') }}`)"
                                    class="selectpicker form-control no_dokumen">
                                    @foreach ($pb as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}
                                        </option>
                                    @endforeach
                                    @foreach ($pr as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row pb">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Request By</th>
                                        <th>:</th>
                                        <th class="pemohon"></th>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>:</th>
                                        <th class="tanggal"></th>
                                    </tr>
                                    <tr>
                                        <th>Section Head</th>
                                        <th>:</th>
                                        <th class="text-capitalize sect_head"></th>
                                    </tr>
                                    <tr>
                                        <th>Departemen Head</th>
                                        <th>:</th>
                                        <th class="text-capitalize dept_head"></th>
                                    </tr>
                                    <tr>
                                        <th>Total Item</th>
                                        <th>:</th>
                                        <th class="total_item"></th>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <th>:</th>
                                        <th class="status text-capitalize"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row pr">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Request By</th>
                                        <th>:</th>
                                        <th class="pemohon"></th>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Permintaan</th>
                                        <th>:</th>
                                        <th class="tanggal"></th>
                                    </tr>
                                    <tr>
                                        <th>Section Head</th>
                                        <th>:</th>
                                        <th class="sect_head"></th>
                                    </tr>
                                    <tr>
                                        <th>Departemen Head</th>
                                        <th>:</th>
                                        <th class="sect_head"></th>
                                    </tr>
                                    <tr>
                                        <th>Direktur</th>
                                        <th>:</th>
                                        <th class="sect_head"></th>
                                    </tr>
                                    <tr>
                                        <th>Total Item</th>
                                        <th>:</th>
                                        <th class="total_item"></th>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <th>:</th>
                                        <th class="status text-capitalize"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row justify-content-center btn-none">
                            <div class="col-md-4">
                                <button type="button" class="text-capitalize btn btn-danger"
                                    data-dismiss="modal">Tutup</button>
                                <a type="submit" data-toggle="tooltip" data-placement="top"
                                    title="Lihat detail permintaan barang"
                                    class="btn-detail text-capitalize btn btn-info">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
