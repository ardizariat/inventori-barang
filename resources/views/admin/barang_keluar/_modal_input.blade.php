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
                            <div class="col-md-3 pt-3">
                                <label>Nama Barang</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select onchange="changeData('{{ route('barang-masuk.change-data') }}')" title="Pilih barang" name="produk_id" data-live-search="true" class="selectpicker form-control produk_id">
                                    @foreach ($products as $produk)
                                        <option value="{{ $produk->id }}">{{ $produk->nama_produk }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="row stok">
                            <div class="col-md-3 pt-3">
                                <label>Stok Saat Ini</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="stok" autocomplete="off" autofocus
                                    class="stok form-control" readonly>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 pt-3">
                                <label>Jumlah Barang Keluar</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="jumlah" autocomplete="off" autofocus
                                    class="jumlah form-control" placeholder="Masukkan jumlah barang keluar">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 pt-3">
                                <label>Tanggal</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" autocomplete="off" name="tanggal" value="{{ date('Y-m-d') }}" class="form-control tanggal max-date">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 pt-3">
                                <label>Penerima Barang</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="penerima" autocomplete="off"
                                    class="penerima form-control">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3 pt-2">
                              <label>Keterangan</label>
                          </div>
                          <div class="col-md-9 form-group">
                              <textarea name="keterangan" class="form-control keterangan" cols="15" rows="7"></textarea>
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