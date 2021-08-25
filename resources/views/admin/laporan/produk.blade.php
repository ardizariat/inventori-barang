@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/js/plugin/file-input/css/fileinput.min.css') }}">
    <link href="{{ asset('admin/js/plugin/date-time-pickers/css/flatpicker-airbnb.css') }}" rel="stylesheet"
        type="text/css" />
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
                        <a href="#">Laporan Data Barang Masuk</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__bounceInRight">
                        <div class="card-header">
                            <h4 class="text-center">Pilih ekspor data berdasarkan yang dipilih</h4>
                        </div>
                        <div class="card-body">
                            <form target="_blank" action="{{ route('laporan.produk.pdf') }}" method="post">
                                @csrf
                                <div class="container">
                                    <div class="form-check">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-radio-label">
                                                    <input class="form-radio-input all type" type="radio" name="type"
                                                        value="all">
                                                    <span class="form-radio-sign">Semua Produk</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-radio-label ml-3">
                                                    <input class="form-radio-input tanggal type" type="radio" name="type"
                                                        value="tanggal">
                                                    <span class="form-radio-sign">Berdasarkan Tanggal Beli</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-radio-label ml-3">
                                                    <input class="form-radio-input category type" type="radio" name="type"
                                                        value="category">
                                                    <span class="form-radio-sign">Berdasarkan Kategori</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-4 form-tanggal d-none">
                                        <div class="col-md-6 mb-2">
                                            <label for="awal">Tanggal Awal</label>
                                            <input type="text" placeholder="Tanggal Awal" name="awal"
                                                class="max-date form-control awal">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="akhir">Tanggal Akhir</label>
                                            <input type="text" placeholder="Tanggal Akhir" name="akhir"
                                                class="date form-control akhir">
                                        </div>
                                    </div>
                                    <div class="row my-4 form-kategori d-none">
                                        <select title="Pilih kategori" data-live-search="true" name="kategori"
                                            class="selectpicker form-control @error('kategori') is-invalid @enderror kategori">
                                            @foreach ($daftar_kategori as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->kategori }}
                                                </option>
                                                @error('kategori')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            @endforeach
                                        </select>
                                    </div>
                                    <div
                                        class="justify-content-center d-none btn-ekspor row my-2 animate__animated animate__bounceInUp">
                                        <button type="submit" data-toggle="tooltip" data-placement="top"
                                            title="Download file" class="btn btn-danger">
                                            <i class="fas fa-file-pdf"></i> Ekpor
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
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/flatpickr.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/date-time-picker-script.js') }}"></script>

    <script>
        $(".date").flatpickr();
        $(document).ready(function() {

            $('form').on('change', '.type', function(e) {
                e.preventDefault();

                let val = $(this).val();

                if (val == "all") {
                    $('.btn-ekspor').removeClass('d-none');
                    $('.form-kategori').addClass('d-none');
                    $('.form-tanggal').addClass('d-none');
                }
                if (val == "tanggal") {
                    $('.btn-ekspor').removeClass('d-none');
                    $('.form-kategori').addClass('d-none');
                    $('.form-tanggal').removeClass('d-none');
                }
                if (val == "category") {
                    $('.btn-ekspor').removeClass('d-none');
                    $('.form-kategori').removeClass('d-none');
                    $('.form-tanggal').addClass('d-none');
                }
            });
        });
    </script>
@endpush
