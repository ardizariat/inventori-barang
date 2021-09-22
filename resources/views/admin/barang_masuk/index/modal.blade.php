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
                                <input type="hidden" name="pr" class="pr">
                                <input type="text" autocomplete="off" name="po_id"
                                    onkeyup="cariData('{{ route('barang-masuk.po') }}')" class="form-control">
                                <div class="po-hide d-none">
                                </div>
                            </div>
                        </div>
                        <div class="row po">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No Dokumen PO</th>
                                        <th>:</th>
                                        <th class="no_dokumen"></th>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>:</th>
                                        <th class="tanggal"></th>
                                    </tr>
                                    <tr>
                                        <th>Supplier</th>
                                        <th>:</th>
                                        <th class="text-capitalize supplier"></th>
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
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center btn-none">
                    <button type="button" class="text-capitalize btn btn-danger"
                        data-dismiss="modal">Tutup</button>
                    <a type="submit" data-toggle="tooltip" data-placement="top"
                        title="Lihat detail permintaan barang"
                        class="btn-detail text-white text-capitalize btn btn-info">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
