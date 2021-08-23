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
                        <a href="#">Data Kategori</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__bounceInUp">
                        <div class="card-header">
                            <button onclick="" type="submit"
                                class="animate__animated animate__zoomInDown d-none btn btn-hapus-multiple  btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                            <h4 class="card-title float-right">
                                <button class="btn btn-rounded btn-outline-primary"
                                    onclick="addForm('{{ route('kategori.store') }}')">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Tambah Kategori
                                </button>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="" class="form-kategori">
                                    <table class="table kategori-table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                                <th>Dibuat</th>
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

    @includeIf('admin.kategori._modal')

@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>

    <script>
        load_data();

        // Datatables
        function load_data() {
            $('.kategori-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kategori.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: "kategori",
                        name: "kategori"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                    {
                        data: "dibuat",
                        name: "dibuat"
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

        function refresh_data() {
            $('.kategori-table').DataTable().destroy();
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
                                hideLoader();
                            },
                            data: $('.modal-form form').serialize()
                        })
                        .done(response => {
                            hideModal();
                            form[0].reset();
                            alert_success('success', response.text);
                            refresh_data();
                        })
                        .fail(errors => {
                            if (errors.status == 422) {
                                loopErrors(errors.responseJSON.errors);
                            } else {
                                alert_error('error', 'Gagal');
                                return;
                            }
                        });
                }
            });
        });

        function hideModal() {
            $('.modal-form').modal('hide');
        }

        // Show modal create
        function addForm(url) {
            event.preventDefault();
            $('.modal-form').modal('show');
            $('.modal-form .modal-title').text('Tambah Kategori');
            $('.modal-form form')[0].reset();
            $('.modal-form form').attr('action', url);
            $('.modal-form [name=_method]').val('post');
        }

        // Show modal edit
        function editForm(url) {
            event.preventDefault();
            $('.modal-form').modal('show');
            $('.modal-form .modal-title').text('Ubah Kategori');
            $('.modal-form form').attr('action', url);
            $('.modal-form [name=_method]').val('put');
            $.get(url)
                .done((response) => {
                    let kategori = response.data.kategori;
                    let status = response.data.status;
                    $('.modal-form .kategori').val(kategori);
                })
                .fail((errors) => {
                    Swal.fire('Oops...', 'Kategori ini tidak dapat dihapus', 'error')
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
