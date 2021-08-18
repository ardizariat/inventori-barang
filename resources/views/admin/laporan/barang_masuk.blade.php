@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/js/plugin/file-input/css/fileinput.min.css') }}">
    <link href="{{ asset('admin/js/plugin/date-time-pickers/css/flatpicker-airbnb.css') }}" rel="stylesheet"
        type="text/css" />
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
                        <div class="card-body">
                            <form target="_blank" action="{{ route('laporan.barang-masuk.pdf') }}" method="post">
                                @csrf
                                <div class="row my-4">
                                    <div class="col-md-4">
                                        <input type="text" value="{{ old('awal') }}" placeholder="Tanggal Awal"
                                            name="awal" class="max-date @error('awal') is-invalid @enderror form-control">
                                        @error('awal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input value="{{ old('akhir') }}" type="text" placeholder="Tanggal Akhir"
                                            name="akhir" class="date @error('akhir') is-invalid @enderror form-control">
                                        @error('akhir')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
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
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/flatpickr.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/date-time-picker-script.js') }}"></script>
    <script>
        $(".date").flatpickr();
    </script>
@endpush
