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
                        <a href="#">Data Barang Keluar</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card  shadow animate__animated animate__zoomInRight">
                        <div class="card-header">
                            <form>
                                <h4>
                                    <i class="fas fa-filter"></i> Filter
                                </h4>
                                <div class="row">
                                    <div class="col-md-3 my-2">
                                        <input name="from_date" type="text" autocomplete="off"
                                            class="from_date form-control max-date">
                                    </div>
                                    <div class="col-md-3 my-2">
                                        <input name="to_date" type="text" autocomplete="off"
                                            class="to_date form-control date">
                                    </div>
                                    <div class="col-md-3 my-2">
                                        <div class="btn-group">
                                            <button type="submit" data-toggle="tooltip" data-placement="top"
                                                title="Filter data" class="btn btn-sm filter btn-success btn-flat">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>
                                            <button type="submit" data-toggle="tooltip" data-placement="top"
                                                title="Refresh data" class="btn btn-sm refresh btn-danger btn-flat">
                                                <i class="fas fa-sync-alt"></i> Refresh
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-2">
                                        <a data-toggle="tooltip" data-placement="top" title="Tambah data"
                                            class="btn btn-rounded btn-outline-primary" onclick="showModal()">
                                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Barang Keluar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="barangkeluar-table table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="6%">No</th>
                                            <th width="25%">Nama Barang</th>
                                            <th width="25%">Kategori</th>
                                            <th width="22%">Tanggal</th>
                                            <th width="22%">Qty</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('admin.barang_keluar._modal_input')
    @includeIf('admin.barang_keluar._modal_show')

@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/flatpickr.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/date-time-picker-script.js') }}"></script>
    <script>
        $(".date").flatpickr();
        // Datatables load data
        load_data();

        // Function datatables
        function load_data(from_date = '', to_date = '') {
            $('.barangkeluar-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('barang-keluar.index') }}",
                    data: {
                        from_date: from_date,
                        to_date: to_date
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'produk',
                        name: 'produk'
                    },
                    {
                        data: 'kategori',
                        name: 'kategori'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
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
            $('.barangkeluar-table').DataTable().destroy();
            load_data();
        }

        // Filter data berdasarkan tanggal
        $('form').on('click', '.filter', function(e) {
            e.preventDefault();
            var from_date = $('form .from_date').val(),
                to_date = $('form .to_date').val();

            if (from_date != '' && to_date != '') {
                $('.barangkeluar-table').DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                Swal.fire('Oops...', 'Filter tanggal harus diisi semua!', 'error')
                return;
            }
        });

        // Refresh Datatables
        $('form').on('click', '.refresh', function(e) {
            e.preventDefault();
            refresh_data();
        });

        // Hapus Data
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
                            $('#barangkeluar-table').DataTable().destroy();
                            load_data();
                        }
                    });
                }
            });

        });


        function showModal() {
            event.preventDefault();
            $('.modal-form').modal('show');
        }

        function hideModal() {
            event.preventDefault();
            $('.modal-form').modal('hide');
        }

        function pilihPB(url, id) {
            event.preventDefault();
            hideModal();
            tambahBarangKeluar(url);
        }

        function tambahBarangKeluar(url) {
            $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        '_token': $('[name=csrf-token]').attr('content'),
                    }
                })
                .done(response => {
                    location.reload();
                    refresh_data();
                })
                .fail(errors => {
                    alert_error('error', 'Gagal update data!');
                    return;
                });
        }
    </script>


@endpush
