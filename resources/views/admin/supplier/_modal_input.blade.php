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
                                <label>Nama Supplier</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <input type="text" name="nama" autocomplete="off" autofocus class="nama form-control"
                                    placeholder="Masukkan nama supplier">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 pt-2">
                                <label>Nomor Telpon</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <input type="text" name="telpon" autocomplete="off" class="telpon form-control"
                                    placeholder="Masukkan nomor telpon supplier">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 pt-2">
                                <label>Email</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <input type="text" name="email" autocomplete="off" class="email form-control"
                                    placeholder="Masukkan email supplier">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 pt-2">
                                <label>Alamat</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <textarea name="alamat" autocomplete="off" class="email form-control"
                                    placeholder="Masukkan alamat supplier" cols="30" rows="10"></textarea>
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
