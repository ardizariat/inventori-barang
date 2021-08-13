@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
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
                        <a href="#">{{ $title }}</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__slideInDown">
                        <div class="card-header">
                            <form action="">
                                <h4 class="judul">Filter</h4>
                                <div class="row ">
                                    <div class="col-md-5 my-2">
                                        <select title="Pilih status" data-live-search="true" name="status"
                                            class="form-control selectpicker filter-status">
                                            <option value="pending">Pending</option>
                                            <option value="complete">Complete</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <button type="submit" data-toggle="tooltip" data-placement="top"
                                            title="Refresh data" class="btn btn-sm refresh btn-success btn-flat">
                                            <i class="fas fa-sync-alt"></i> Refresh
                                        </button>
                                    </div>
                                    <div class="col-md-3 my-2 float-right">
                                        <button onclick="addForm('{{ route('purchase-order.store') }}')"
                                            data-toggle="tooltip" data-placement="top" title="Tambah data"
                                            class="btn btn-rounded btn-outline-primary">
                                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah PO
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <form action="" class="form-kategori">
                                <table id="purchase-order-table" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Dokumen</th>
                                            <th>Supplier</th>
                                            <th>Total Item</th>
                                            <th>Total Nilai</th>
                                            <th>Status</th>
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

    @includeIf('admin.purchase_order._modal_supplier')
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
    <script>
        // Datatables load data
        load_data_purchase_order();
        load_data_supplier();

        // Function datatables
        function load_data_purchase_order(status = '') {
            $('#purchase-order-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('purchase-order.index') }}",
                    data: {
                        status: status
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: "no_dokumen",
                        name: "no_dokumen"
                    },
                    {
                        data: "supplier",
                        name: "supplier"
                    },
                    {
                        data: "total_item",
                        name: "total_item"
                    },
                    {
                        data: "total_harga",
                        name: "total_harga"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                    {
                        data: "aksi",
                        name: "aksi"
                    },
                ],
                pageLength: 15,
                "lengthMenu": [15, 25, 50, 75, 100],
                "language": {
                    "emptyTable": "Data tidak ada"
                },
            });
        }

        function load_data_supplier() {
            $('.supplier-table').DataTable();
        }

        // Refresh data
        function refresh_data() {
            $('#purchase-order-table').DataTable().destroy();
            load_data_purchase_order();
        }

        // Filter data berdasarkan option
        $('form').on('change', '.filter-status', function(e) {
            e.preventDefault();
            var status = $('form .filter-status [name=status]').val();

            if (status != '') {
                $('#purchase-order-table').DataTable().destroy();
                load_data_purchase_order(status);
                $('.card-header .judul').text('Filter data berdasarkan status order');
            } else {
                Swal.fire('Oops...', 'Opsi status harus dipilih!', 'error')
                return;
            }
        });

        // Refresh Datatables
        $('form').on('click', '.refresh', function(e) {
            e.preventDefault();
            var status = $('form .filter-status').val('');
            $('#purchase-order-table').DataTable().destroy();
            load_data_purchase_order();
        });

        // Show modal create
        function addForm(url) {
            event.preventDefault();
            $('.modal-form').modal('show');
            $('.modal-form .modal-title').text('Pilih supplier');
            $('.modal-form form').attr('action', url);
            $('.modal-form [name=_method]').val('post');
        }

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
                            alert_success('success', 'Data berhasil dihapus')
                            refresh_data();
                        },
                        error: function(xhr) {
                            Swal.fire('Oops...',
                                'Data ini tidak bisa dihapus, karena produk ini terdapat data di barang masuk dan barang keluar',
                                'error')
                            return;
                        }
                    });
                }
            });
        });
    </script>

@endpush
