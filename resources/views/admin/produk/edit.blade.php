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
                            <form action="{{ route('produk.update', $data->id) }}" method="POST"
                                enctype="multipart/form-data" class="form-produk">
                                @csrf
                                @method('patch')
                                <div class="container-fluid">
                                    <div class="row form-group">
                                        <div class="col-md-2 ">
                                            <label>Nama Produk</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" value="{{ $data->nama_produk }}" name="nama_produk"
                                                autocomplete="off" class="nama_produk form-control"
                                                placeholder="Masukkan nama produk">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2 ">
                                            <label>Supplier</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select title="Pilih supplier" data-live-search="true" name="supplier_id"
                                                class="selectpicker form-control supplier">
                                                @foreach ($daftar_suppliers as $supplier)
                                                    <option @if ($data->supplier_id == $supplier->id) selected @endif
                                                        value="{{ $supplier->id }}">{{ $supplier->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
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
                                                    <option @if ($data->kategori_id == $kategori->id) selected @endif
                                                        value="{{ $kategori->id }}">{{ $kategori->kategori }}
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
                                                    <option @if ($data->gudang_id == $gudang->id) selected @endif value="{{ $gudang->id }}">
                                                        {{ $gudang->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2 ">
                                            <label>Merek</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" name="merek" autocomplete="off" class="merek form-control"
                                                value="{{ $data->merek }}" placeholder="Masukkan nama merek">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2 ">
                                            <label>Satuan</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" name="satuan" value="{{ $data->satuan }}"
                                                autocomplete="off" class="satuan form-control"
                                                placeholder="Masukkan satuan produk">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2 ">
                                            <label>Minimal Stok</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input value="{{ $data->minimal_stok }}" type="number" name="minimal_stok"
                                                autocomplete="off" class="minimal_stok form-control"
                                                placeholder="Masukkan minimal stok digudang">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2 ">
                                            <label>Stok</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="number" value="{{ $data->stok }}" name="stok" autocomplete="off"
                                                class="stok form-control" placeholder="Masukkan stok yang masuk ke gudang">
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
                                                rows="10">{{ $data->keterangan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center d-flex btn-submit btn-row">
                                        <div class="col-md-4">
                                            <a href="{{ $url }}" class="text-uppercase btn btn-sm btn-danger">
                                                Batal
                                            </a>
                                            <button class="btn btn-success btn-save btn-sm" type="submit">
                                                <span class="btn-text text-uppercase">Simpan</span>
                                                <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                                            </button>
                                        </div>
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
            $('.form-produk').on('click', '.btn-save', function(e) {
                e.preventDefault();
                var form = $('.row .form-produk');
                form.find('.invalid-feedback').remove();
                form.find('.form-control').removeClass('is-invalid');
                $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        beforeSend: function() {
                            loading();
                        },
                        complete: function() {
                            hideLoader("Update");
                        },
                        data: new FormData($(form)[0]),
                        async: false,
                        processData: false,
                        contentType: false,
                    })
                    .done(response => {
                        $('[name=nama_produk]').val(response.data.nama_produk);
                        $('[name=merek]').val(response.data.merek);
                        $('[name=satuan]').val(response.data.satuan);
                        $('[name=stok]').val(response.data.stok);
                        $('[name=minimal_stok]').val(response.data.minimal_stok);
                        $('[name=keterangan]').val(response.data.keterangan);
                        $('[name=kategori_id]').val(response.data.kategori_id).change();
                        $('[name=gudang_id]').val(response.data.gudang_id).change();
                        $('[name=satuan]').val(response.data.satuan).change();
                        alert_success('success', response.text)
                    })
                    .fail(errors => {
                        if (errors.status == 422) {
                            loopErrors(errors.responseJSON.errors);
                        } else {
                            alert_error('error', errors.responseJSON);
                            return;
                        }
                    });
            });
        });
    </script>

@endpush
