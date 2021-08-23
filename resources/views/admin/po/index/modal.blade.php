<div class="modal fade modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('po.store') }}">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-capitalize">
                        Buat Purchase Order
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label>No Tiket PR</label>
                            </div>
                            <div class="col-md-10">
                                <select title="Masukan nomor tiket" data-live-search="true" name="pr"
                                    class="selectpicker form-control pr">
                                    @foreach ($pr as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label>Supplier</label>
                            </div>
                            <div class="col-md-10">
                                <select title="Pilih supplier" data-live-search="true" name="supplier"
                                    class="selectpicker form-control supplier">
                                    @foreach ($suppliers as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center d-flex btn-submit btn-row">
                            <div class="col-md-4">
                                <button type="button" value="Batal" data-dismiss="modal"
                                    class="text-uppercase btn btn-danger">
                                    Batal
                                </button>
                                <button class="btn btn-primary btn-save" type="submit">
                                    <span class="btn-text text-uppercase">Buat PO</span>
                                    <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>