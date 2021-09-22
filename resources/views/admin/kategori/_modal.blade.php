<div class="modal fade modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form>
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-2 pt-2">
                                <label>Kategori</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <input type="text" name="kategori" autocomplete="off" autofocus
                                    class="kategori form-control" placeholder="Masukkan kategori">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2 pt-2">
                                <label>Status</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <div class="form-check form-check-inline">
                                    <input class="status  form-check-input" type="radio" name="status" value="aktif">
                                    <label class="form-check-label" for="inlineRadio1">Aktif</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="status  form-check-input" type="radio" name="status"
                                        value="tidak aktif">
                                    <label class="form-check-label">Tidak Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="text-uppercase btn btn-sm btn-danger"
                        data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary btn-save btn-sm" type="submit">
                        <span class="btn-text text-uppercase">Simpan</span>
                        <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
