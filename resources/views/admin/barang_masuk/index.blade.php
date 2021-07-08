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
                        <a href="#">Data Barang Masuk</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__jackInTheBox">
                        <div class="card-header">
                            <button onclick="" type="submit"
                                class="animate__animated animate__zoomInDown d-none btn btn-hapus-multiple  btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                            <h4 class="card-title float-right">
                                <a class="btn btn-rounded btn-outline-primary"
                                    onclick="addForm('{{ route('barang-masuk.store') }}')">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Tambah Barang Masuk
                                </a>
                            </h4>
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

    @includeIf('admin.barang_masuk._modal')

@endsection

@push('js')
    <!-- Datatables -->
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    {!! $dataTable->scripts() !!}
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

        const table = $('#barangmasuk-table');
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
        });

        function addForm(url) {
            event.preventDefault();
            $('.modal-form').modal('show');
            $('.modal-form .modal-title').text('Tambah Barang Masuk');
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
    </script>

@endpush
