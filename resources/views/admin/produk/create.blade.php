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
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__slideInDown">
                        <div class="card-body">
                            <form action="" method="" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-2 pt-2">
                                            <label>Nama Gudang</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <input type="text" name="nama" autocomplete="off" autofocus
                                                class="nama form-control" placeholder="Masukkan nama gudang">
                                            <span class="help-block with-errors"></span>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-2 pt-2">
                                            <label>Status</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="status  form-check-input" type="radio" name="status"
                                                    value="aktif">
                                                <label class="form-check-label" for="inlineRadio1">Aktif</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="status  form-check-input" type="radio" name="status"
                                                    value="tidak aktif">
                                                <label class="form-check-label">Tidak Aktif</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 pt-2">
                                            <label>Lokasi</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <textarea name="lokasi" class="form-control lokasi" cols="30"
                                                rows="10"></textarea>
                                            <span class="help-block with-errors"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center btn-row">
                                    <button class="btn btn-outline-danger mr-1" type="reset" value="Reset">Reset</button>
                                    <button type="submit" class="btn btn-save mr-1 btn-success">Simpan <img
                                            class="loader d-none" src="{{ asset('/images/loader.gif') }}"></button>
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
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/select2/js/select2.min.js') }}"></script>


    <script>
        const table = $('#produk-table');
        $('.select2').select2();
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
                            window.location.reload();
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

            $('form').on('click', '.btn-save', function(e) {
                e.preventDefault();
                $(this).text('').removeClass('d-none');
            })
        });

        function addForm(url) {
            event.preventDefault();
            $('.modal-form').modal('show');
            $('.modal-form .modal-title').text('Tambah Gudang');
            $('.modal-form form')[0].reset();
            $('.modal-form form').attr('action', url);
            $('.modal-form [name=_method]').val('post');
        }

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
