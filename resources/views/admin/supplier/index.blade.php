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
                        <a href="#">Data Supplier</a>
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
                                    onclick="addForm('{{ route('supplier.store') }}')">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Tambah supplier
                                </button>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="" class="form-supplier">
                                    <table id="supplier-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Supplier</th>
                                                <th>Telpon</th>
                                                <th>Email</th>
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

    @includeIf('admin.supplier._modal_input')
    @includeIf('admin.supplier._modal_show')

@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>

    <script>
        load_data();

        // Datatables
        function load_data() {
            $('#supplier-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('supplier.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: "nama",
                        name: "nama"
                    },
                    {
                        data: "telpon",
                        name: "telpon"
                    },
                    {
                        data: "email",
                        name: "email"
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
            $('#supplier-table').DataTable().destroy();
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
            $('.modal-form .modal-title').text('Tambah Supplier');
            $('.modal-form form')[0].reset();
            $('.modal-form form').attr('action', url);
            $('.modal-form [name=_method]').val('post');
        }

        // Show modal edit
        function editForm(url) {
            event.preventDefault();
            $('.modal-form').modal('show');
            $('.modal-form .modal-title').text('Ubah Supplier');
            $('.modal-form .btn-text').text('Update');
            $('.modal-form form').attr('action', url);
            $('.modal-form [name=_method]').val('put');
            $.get(url)
                .done((response) => {
                    var nama = response.data.nama,
                        email = response.data.email,
                        telpon = response.data.telpon,
                        alamat = response.data.alamat;
                    $('.modal-form .nama').val(nama);
                    $('.modal-form .email').val(email);
                    $('.modal-form .telpon').val(telpon);
                    $('.modal-form .alamat').val(alamat);
                })
                .fail((errors) => {
                    Swal.fire('Oops...', 'Ada yang salah!', 'error')
                    return;
                })
        }

        // Delete data
        $('body').on('click', '.btn-delete', function(event) {
            event.preventDefault();
            var me = $(this),
                url = me.attr('href'),
                csrf_token = $('meta[name=csrf-token]').attr('content');

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
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            '_method': 'DELETE',
                            '_token': csrf_token
                        },
                        success: function(response) {
                            alert_success('success', response.text)
                            refresh_data();
                        }
                    });
                }
            });

        });

        // menampilkan modal show
        function showData(url) {
            event.preventDefault();
            $('.modal-show').modal('show');
            $.get(url)
                .done((response) => {
                    var nama = response.data.nama,
                        email = response.data.email,
                        telpon = response.data.telpon,
                        alamat = response.data.alamat;

                    $('.modal-show .modal-title').text('Detail ' + nama);

                    $('.modal-show .nama').text(nama);
                    $('.modal-show .email').text(email);
                    $('.modal-show .telpon').text(telpon);
                    $('.modal-show .alamat').text(alamat);
                })
                .fail((errors) => {
                    Swal.fire('Oops...', 'Data tidak ditemukan!', 'error')
                    return;
                })
        }
    </script>

@endpush
