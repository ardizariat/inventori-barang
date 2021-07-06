@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
    <style>
        .none {
            display: none;
        }

        .error {
            color: red;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('admin/js/plugin/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/js/plugin/file-input/css/fileinput.min.css') }}">
@endpush

@section('admin-content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">{{ $title }}</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ $url }}">Data Barang</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__zoomInDown">
                        <div class="card-body">
                            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('post')
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
                                            <select name="kategori_id" class="form-control select2 kategori">
                                                <option selected disabled>Pilih Kategori</option>
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
                                            <select name="gudang_id" class="form-control select2 gudang">
                                                <option selected disabled>Pilih Gudang</option>
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
                                            <select name="satuan" class="form-control select2 satuan">
                                                <option selected disabled>Pilih Satuan Produk</option>
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
                                <div class="row justify-content-center btn-submit btn-row">
                                    <div class="col-md-2">
                                        <button class="btn text-uppercase btn-block btn-outline-danger mr-1" type="reset"
                                            value="Reset">Reset</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit"
                                            class="d-flex text-uppercase btn btn-block btn-save mr-1 btn-success">Simpan
                                            <img class=" ml-3 d-none loader" src="{{ asset('/images/loader.gif') }}">
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Datatables -->
    <script src="{{ asset('admin/js/plugin/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/file-input/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/file-input/themes/fa/theme.js') }}"></script>


    <script>
        // Select2
        $('.select2').select2();

        // File input images
        $(".input-fa").fileinput({
            theme: "fa",
            uploadUrl: "/file-upload-batch/2"
        });

        $(function() {
            $('.card-body').on('submit', 'form', function(e) {
                if (!e.preventDefault()) {

                    var form = $('.card-body form');
                    form.find('.help-block').remove();
                    form.find('.form-group').removeClass('has-error');

                    $.ajax({
                        url: $('.card-body form').attr('action'),
                        type: $('.card-body input[name=_method]').val(),
                        data: new FormData(this),
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('.btn-submit .btn-save').addClass('d-none');
                            $('.btn-submit .loader').removeClass('d-none');
                        },
                        complete: function() {
                            $('.btn-submit .loader').addClass('d-none');
                            $('.btn-submit .btn-save').removeClass('d-none');
                        },
                        success: function(response) {
                            $.notify({
                                message: response.text
                            }, {
                                type: 'success'
                            });
                            $('.card-body form')[0].reset();
                            $('.select2').val(null).trigger('change');
                        },
                        error: function(xhr) {
                            var res = xhr.responseJSON;
                            if ($.isEmptyObject(res) == false) {
                                Swal.fire('Oops...', 'Data yang anda masukan ada yang salah!',
                                    'error')
                                $.each(res.errors, function(key, value) {
                                    console.log(res);
                                    $('.' + key)
                                        .closest('.form-group')
                                        .addClass('has-error')
                                        .append(`<span class="help-block">` + value +
                                            `</span>`)
                                });
                            }
                        }
                    });
                }
            });
        });

        function editForm(url) {
            event.preventDefault();
            $('.modal-form').modal('show');
            $('.modal-form .modal-title').text('Ubah Gudang');
            $('.modal-form form').attr('action', url);
            $('.modal-form [name=_method]').val('put');
            $.get(url)
                .done((response) => {
                    let nama = response.data.nama;
                    let kode = response.data.kode;
                    let lokasi = response.data.lokasi;
                    $('.modal-form .nama').val(nama);
                    $('.modal-form .kode').val(kode);
                    $('.modal-form .lokasi').val(lokasi);
                })
                .fail((errors) => {
                    Swal.fire('Oops...', 'Kategori ini tidak dapat dihapus', 'error')
                    return;
                })
        }
    </script>

@endpush
