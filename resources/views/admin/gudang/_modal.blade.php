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
                                <label>Kode</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <input type="text" value="{{ $kode }}" name="kode" autocomplete="off" autofocus
                                    class="kode form-control" readonly>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 pt-2">
                                <label>Nama Gudang</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <input type="text" name="nama" autocomplete="off" autofocus class="nama form-control"
                                    placeholder="Masukkan nama gudang">
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
                        <div class="row">
                            <div class="col-md-2 pt-2">
                                <label>Lokasi</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <textarea name="lokasi" class="form-control lokasi" cols="30" rows="10"></textarea>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="text-uppercase btn btn-sm btn-danger"
                        data-dismiss="modal">Batal</button>
                    <button type="submit"
                        class="none btn-save text-uppercase btn d-flex btn-sm btn-primary">Simpan</button>
                    <img class="loader d-none" src="{{ asset('/images/loader.gif') }}" alt="">
                </div>
            </div>
        </form>
    </div>
</div>
