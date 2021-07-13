<div class="modal fade modal-form animate__animated animate__rotateInUpRight animate__faster" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <form id="form-update">
          @csrf
          @method('patch')
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
                      <div class="col-md-2 pt-3">
                          <label>Nama Produk</label>
                      </div>
                      <div class="col-md-10 form-group">
                          <input type="text" name="nama_produk" autocomplete="off" autofocus
                              class="nama_produk form-control" placeholder="Masukkan nama produk">
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-2 pt-3">
                          <label>Kategori</label>
                      </div>
                      <div class="col-md-10 form-group">
                          <select title="Pilih kategori" data-live-search="true" name="kategori_id" class="selectpicker form-control kategori_id">
                              @foreach ($daftar_kategori as $kategori)
                                  <option value="{{ $kategori->id }}">{{ $kategori->kategori }}
                                  </option>
                              @endforeach
                          </select>
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-2 pt-3">
                          <label>Letak Barang</label>
                      </div>
                      <div class="col-md-10 form-group">
                          <select title="Pilih gudang" data-live-search="true" name="gudang_id" class="form-control selectpicker gudang_id">
                              @foreach ($daftar_gudang as $gudang)
                                  <option value="{{ $gudang->id }}">{{ $gudang->nama }}
                                  </option>
                              @endforeach
                          </select>
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-2 pt-3">
                          <label>Merek</label>
                      </div>
                      <div class="col-md-10 form-group">
                          <input type="text" name="merek" autocomplete="off" autofocus
                              class="merek form-control" placeholder="Masukkan nama merek">
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-2 pt-3">
                          <label>Satuan Produk</label>
                      </div>
                      <div class="col-md-10 form-group">
                          <select title="Pilih satuan produk" data-live-search="true" name="satuan" class="form-control selectpicker satuan">
                              <option value="Pcs">Pcs</option>
                              <option value="Box">Box</option>
                              <option value="Kg">Kg</option>
                              <option value="Karton">Karton</option>
                              <option value="Liter">Liter</option>
                              <option value="Jerigen">Jerigen</option>
                              <option value="Rim">Rim</option>
                          </select>
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-2 pt-3">
                          <label>Minimal Stok</label>
                      </div>
                      <div class="col-md-10 form-group">
                          <input type="number" name="minimal_stok" autocomplete="off" autofocus
                              class="minimal_stok form-control"
                              placeholder="Masukkan minimal stok digudang">
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-2 pt-3">
                          <label>Stok</label>
                      </div>
                      <div class="col-md-10 form-group">
                          <input type="number" name="stok" autocomplete="off" autofocus
                              class="stok form-control" placeholder="Masukkan stok yang masuk ke gudang">
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-2 pt-3">
                          <label for="gambar">Gambar</label>
                      </div>
                      <div class="col-md-10 form-group">
                          <input type="file" name="gambar" class="input-fa file"
                              data-preview-file-type="text" data-browse-on-zone-click="true">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-2 pt-3">
                          <label>Keterangan</label>
                      </div>
                      <div class="col-md-10 form-group">
                          <textarea name="keterangan" class="form-control keterangan" cols="30"
                              rows="10"></textarea>
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>
                </div>  
              </div>
              <div class="modal-footer row justify-content-center">
                <button type="button" class="text-uppercase btn btn-danger"
                data-dismiss="modal">Batal</button>
                <button type="submit"
                    class="none btn-save text-uppercase btn d-flex btn-success">Update</button>
                <img class="loader d-none" src="{{ asset('/images/loader.gif') }}" alt="">
              </div>
          </div>
      </form>
  </div>
</div>
