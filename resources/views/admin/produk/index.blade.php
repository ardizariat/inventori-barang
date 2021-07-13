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
     <link rel="stylesheet" href="{{ asset('admin/js/plugin/selectpicker/css/bootstrap-select.min.css') }}">
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
                        <a href="#">Data Barang</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-primary card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-users"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Produk</p>
                                        <h4 class="card-title">{{ countProduk() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-info card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-interface-6"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Kategori</p>
                                        <h4 class="card-title">{{ countKategori() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-success card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-analytics"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Gudang</p>
                                        <h4 class="card-title">{{ countGudang() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__slideInDown">
                        <div class="card-header">
                            <form action="">
                                <h4>Filter</h4>
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <select name="kategori" class="filter-kategori select2 form-control">
                                            <option selected disabled>Pilih Kategori</option>
                                            @foreach ($daftar_kategori as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="gudang" class="filter-gudang select2 form-control">
                                            <option selected disabled>Pilih Gudang</option>
                                            @foreach ($daftar_gudang as $gudang)
                                                <option value="{{ $gudang->id }}">{{ $gudang->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" data-toggle="tooltip" data-placement="top" title="Reset data"
                                            class="btn btn-sm reset btn-danger btn-flat">Reset</button>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="btn-group float-right">
                                            <button data-toggle="tooltip" data-placement="top" title="Ekspor data pdf"
                                                class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i></button>
                                            <button data-toggle="tooltip" data-placement="top" title="Ekspor data excel"
                                                class="btn btn-outline-success"><i class="fas fa-file-excel"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="" class="form-kategori">
                                    {!! $dataTable->table() !!}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('admin.produk._modal')

@endsection

@push('js')
    <!-- Datatables -->
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/file-input/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/file-input/themes/fa/theme.js') }}"></script>

    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function() {
            $(".input-fa").fileinput({
                theme: "fa",
                uploadUrl: "/file-upload-batch/2"
            });
        });
    </script>

    <script>
        const table = $('#produk-table');
        $(function() {
            $('.modal-form').on('submit', function(e) {
                if (!e.preventDefault()) {

                    var form = $('.modal-form form');
                    form.find('.help-block').remove();
                    form.find('.form-group').removeClass('has-error');

                    $.ajax({
                        url: $('.modal-form form').attr('action'),
                        type: $('.modal-form input[name=_method]').val(),
                        beforeSend: function() {
                            $('.modal-footer .btn-save').addClass('d-none');
                            $('.modal-footer .loader').removeClass('d-none');
                        },
                        complete: function() {
                            $('.modal-footer .loader').addClass('d-none');
                            $('.modal-footer .submit').removeClass('d-none');
                        },
                        data: $('.modal-form form').serialize(),
                        success: function(response) {
                            $('.modal-form').modal('hide');
                            $.notify({
                                message: response.text
                            }, {
                                type: 'success'
                            });
                            table.DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            var res = xhr.responseJSON;
                            if ($.isEmptyObject(res) == false) {
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
            var me = $(this),
            id = $('.btn-edit').data('id');
            $('.modal-form').modal('show');
            $('.modal-form .modal-title').text('Ubah Produk');
            $('.modal-form .container-fluid').append(`<div class="row"><input type="hidden" name="id" value="`+id+`"></div>`);
            $('.modal-form form').attr('action', url);
            $('.modal-form [name=_method]').val('put');
            $.get(url+'/edit')
                .done((response) => {
                    var nama = response.data.nama_produk,
                    kategori_id = response.data.kategori_id,
                    gudang_id = response.data.gudang_id,
                    merek = response.data.merek,
                    satuan = response.data.satuan,
                    minimal_stok = response.data.minimal_stok,
                    stok = response.data.stok,
                    keterangan = response.data.keterangan;
                    $('.modal-form .nama_produk').val(nama);
                    $('.modal-form .kategori_id').val(kategori_id).change();
                    $('.modal-form .gudang_id').val(gudang_id).change();
                    $('.modal-form .merek').val(merek);
                    $('.modal-form .satuan').val(satuan).change();
                    $('.modal-form .minimal_stok').val(minimal_stok);
                    $('.modal-form .stok').val(stok);
                    $('.modal-form .keterangan').val(keterangan);
                })
                .fail((errors) => {
                    Swal.fire('Oops...', 'Ada yang salah!', 'error')
                    return;
                })
        }

        function deleteData(url) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "menghapus data ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_token': $('input[name=csrf-token]').attr('content'),
                            '_method': 'delete'
                        })
                        .done((response) => {
                            $.notify({
                                message: response.text
                            }, {
                                type: 'success'
                            });
                            table.DataTable().ajax.reload();
                        })
                        .fail((errors) => {
                            Swal.fire('Oops...', 'Kategori ini tidak dapat dihapus', 'error')
                        })
                }
            })
        }

        table.on('preXhr.dt', function(e, settings, data) {
            data.kategori = $('.filter-kategori').val();
            data.gudang = $('.filter-gudang').val();
        });

        $('form').on('change', '.filter-kategori', function() {
            table.DataTable().ajax.reload();
            return false;
        });

        $('form').on('change', '.filter-gudang', function() {
            table.DataTable().ajax.reload();
            return false;
        });

        $('.reset').on('click', function(e) {
            e.preventDefault();
            table.on('preXhr.dt', function(e, settings, data) {
                data.kategori = '';
                data.gudang = '';
            });
            table.DataTable().ajax.reload();
            return false;
        });
    </script>

@endpush
