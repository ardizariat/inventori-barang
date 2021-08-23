@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
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
                        <a href="#">Data Gudang</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__bounce">
                        <div class="card-header">
                            <button onclick="" type="submit"
                                class="animate__animated animate__zoomInDown d-none btn btn-hapus-multiple  btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                            <h4 class="card-title float-right">
                                <button class="btn btn-rounded btn-outline-primary"
                                    onclick="addForm('{{ route('gudang.store') }}')">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Tambah Gudang
                                </button>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="" class="form-kategori">
                                    <table id="gudang-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Lokasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('admin.gudang._modal')

@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>

    <script>
        load_data();

        // Datatables
        function load_data() {
            $('#gudang-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('gudang.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: "kode",
                        name: "kode"
                    },
                    {
                        data: "nama",
                        name: "nama"
                    },
                    {
                        data: "lokasi",
                        name: "lokasi"
                    },
                    {
                        data: "aksi",
                        name: "aksi",
                        searchable: false,
                        sortable: false
                    },
                ],
                pageLength: 15,
                "lengthMenu": [15, 25, 50, 75, 100],
                "language": {
                    "emptyTable": "Data tidak ada"
                },
            });
        }

        // Refresh data
        function refresh_data() {
            $('#gudang-table').DataTable().destroy();
            load_data();
        }

        // Store dan update data
        $(function() {
            $('.modal-form').on('submit', function(e) {
                if (!e.preventDefault()) {

                    var form = $('.modal-form form');
                    form.find('.invalid-feedback').remove();
                    form.find('.form-control').removeClass('is-invalid');

                    $.ajax({
                            url: $('.modal-form form').attr('action'),
                            type: $('.modal-form input[name=_method]').val(),
                            beforeSend: function() {
                                loading();
                            },
                            complete: function() {
                                hideLoader("Simpan");
                            },
                            data: $('.modal-form form').serialize()
                        })
                        .done(response => {
                            $('.modal-form').modal('hide');
                            refresh_data();
                            alert_success('success', response.text);
                        })
                        .fail(errors => {
                            if (errors.status == 422) {
                                loopErrors(errors.responseJSON.errors);
                            } else {
                                return;
                            }
                        });
                }
            });
        });

        // Show modal create
        function addForm(url) {
            event.preventDefault();
            $('.modal-form').modal('show');
            $('.modal-form .modal-title').text('Tambah Gudang');
            $('.modal-form form')[0].reset();
            $('.modal-form form').attr('action', url);
            $('.modal-form [name=_method]').val('post');
        }

        // Show modal edit
        function editForm(url) {
            event.preventDefault();
            $('.modal-form').modal('show');
            $('.modal-form .modal-title').text('Ubah Gudang');
            $('.modal-form form').attr('action', url);
            $('.modal-form [name=_method]').val('put');
            $.get(url)
                .done((response) => {
                    let nama = response.data.nama;
                    let lokasi = response.data.lokasi;
                    let status = response.data.status;
                    $('.modal-form .nama').val(nama);
                    $('.modal-form .lokasi').val(lokasi);
                    $('.modal-form .status').val(status).prop('checked', true);
                })
                .fail((errors) => {
                    Swal.fire('Oops...', 'Ada yang salah!', 'error')
                    return;
                })
        }

        // Delete data
        function hapus(url) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah kamu yakin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: url,
                            type: `post`,
                            data: {
                                '_token': $(`meta[name=csrf-token]`).attr(`content`),
                                '_method': `delete`,
                            }
                        })
                        .done(response => {
                            alert_success('success', response.text);
                            refresh_data();
                        })
                        .fail(errors => {
                            alert_error('error', 'Gagal update data!');
                            return;
                        })
                }
            });
        }
    </script>

@endpush
