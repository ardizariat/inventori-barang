<div class="modal fade bd-example-modal-lg modal-produk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center">Tambah Produk</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pr.produk.store') }}" method="POST" class="form-produk"
                    enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <input type="hidden" name="pr_id" value="{{ $pr_id }}">
                    <div class="container-fluid">
                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label>Nama Produk</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" name="nama_produk" autocomplete="off" autofocus
                                    class="nama_produk form-control" placeholder="Masukkan nama produk">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label>Kategori</label>
                            </div>
                            <div class="col-md-10">
                                <select title="Pilih kategori" data-live-search="true" name="kategori_id"
                                    class="selectpicker form-control kategori">
                                    @foreach ($categories as $key => $value)
                                        <option value="{{ $value }}">{{ $key }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label>Harga</label>
                            </div>
                            <div class="col-md-10">
                                <input type="number" name="harga" autocomplete="off" class="harga form-control"
                                    placeholder="Masukkan harga">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label>Merek</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" name="merek" autocomplete="off" class="merek form-control" autofocus
                                    placeholder="Masukkan nama merek">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label>Satuan</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" name="satuan" autocomplete="off" class="satuan form-control"
                                    placeholder="Masukkan satuan produk">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label for="gambar">Gambar</label>
                            </div>
                            <div class="col-md-10">
                                <input onchange="preview('.show-image', this.files[0])" type="file" name="gambar"
                                    class="form-control-file">
                                <br>
                                <div class="show-image"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label>Keterangan</label>
                            </div>
                            <div class="col-md-10">
                                <textarea name="keterangan" class="form-control keterangan" cols="30"
                                    rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center d-flex btn-submit btn-row">
                        <div class="col-md-4 col-6">
                            <button type="reset" value="Reset" class="text-uppercase btn btn-sm btn-danger">
                                Reset Form
                            </button>
                            <button class="btn btn-primary btn-save btn-sm" type="submit">
                                <span class="btn-text text-uppercase">Simpan</span>
                                <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
