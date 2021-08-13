@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/js/plugin/selectpicker/css/bootstrap-select.min.css') }}">
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
                                                @foreach ($daftar_kategori as $kategori)
                                                    <option value="{{ $kategori->id }}">{{ $kategori->kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2 ">
                                            <label>Letak Barang</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select title="Pilih gudang" data-live-search="true" name="gudang_id"
                                                class="form-control selectpicker gudang">
                                                @foreach ($daftar_gudang as $gudang)
                                                    <option value="{{ $gudang->id }}">{{ $gudang->nama }}
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
                                            <input type="text" name="harga" autocomplete="off" class="harga form-control"
                                                placeholder="Masukkan harga">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2 ">
                                            <label>Merek</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" name="merek" autocomplete="off" class="merek form-control"
                                                autofocus placeholder="Masukkan nama merek">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2 ">
                                            <label>Minimal Stok</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="number" name="minimal_stok" autocomplete="off" autofocus
                                                class="minimal_stok form-control"
                                                placeholder="Masukkan minimal stok digudang">
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
                                            <input onchange="preview('.show-image', this.files[0])" type="file"
                                                name="gambar" class="form-control-file">
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
                                    <div class="col-md-4">
                                        <button type="reset" value="Reset" class="text-uppercase btn btn-sm btn-danger">
                                            Batal
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
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
    <script>
        $(function() {
            $('.card-body').on('submit', 'form', function(e) {
                if (!e.preventDefault()) {

                    var form = $('.card-body form');
                    form.find('.invalid-feedback').remove();
                    form.find('.form-control').removeClass('is-invalid');
                    $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            beforeSend: function() {
                                loading();
                            },
                            complete: function() {
                                hideLoader();
                            },
                            data: new FormData($(form)[0]),
                            async: false,
                            processData: false,
                            contentType: false,
                        })
                        .done(response => {
                            form[0].reset();
                            $('.show-image').addClass('d-none');
                            $('.selectpicker').val(null).trigger('change');
                            alert_success('success', response.text)
                        })
                        .fail(errors => {
                            if (errors.status == 422) {
                                loopErrors(errors.responseJSON.errors);
                            } else {
                                alert_error('error', 'Gagal ubah pengaturan');
                                return;
                            }
                        });

                }
            });
        });
    </script>

@endpush
