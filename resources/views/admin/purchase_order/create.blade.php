@extends('layouts.admin.master')
@section('title')

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/js/plugin/selectpicker/css/bootstrap-select.min.css') }}">
@endpush

@section('admin-content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"></h4>
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
                        <a href=""></a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__zoomInDown">
                        <div class="card-header">
                            <table>
                                <tr>
                                    <th>Supplier</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $supplier->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $supplier->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telpon</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $supplier->telpon }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $supplier->alamat }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <form class="form-produk">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-lg-1">Kode</label>
                                    <div class="col-lg-5">
                                        <div class="input-group">
                                            <input type="hidden" name="purchase_order_id"
                                                value="{{ $purchase_order_id }}" />
                                            <input type="hidden" name="produk_id" class="form-control" id="produk_id" />
                                            <input type="text" autocomplete="off" class="form-control" name="kode"
                                                id="kode_produk" />
                                            <span class="input-group-btn">
                                                <button onclick="tampilModalProduk()" class="btn btn-flat btn-primary">
                                                    <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped" id="purchase-order-detail-table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('admin.purchase_order._modal_produk')
@endsection

@push('js')
    {{-- <script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script> --}}
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>

    <script>
        load_data_purchase_order_detail();
        load_data_produk();

        function load_data_produk() {
            $('.produk-table').DataTable();
        }

        function load_data_purchase_order_detail() {
            $('#purchase-order-detail-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('purchase-order-detail.data', $purchase_order_id) }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: "nama_produk",
                        name: "nama_produk"
                    },
                    {
                        data: "qty",
                        name: "qty"
                    },
                    {
                        data: "harga",
                        name: "harga"
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
            $('#purchase-order-detail-table').DataTable().destroy();
            load_data_purchase_order_detail();
        }

        function pilihProduk(id, kode) {
            event.preventDefault();
            var produk_id = document.getElementById("produk_id").value = id;
            var kode_produk = document.getElementById("kode_produk").value = kode;
            hideModalProduk();
            tambahProduk();
        }

        function tampilModalProduk() {
            event.preventDefault();
            $('.modal-produk').modal('show');
        }

        function hideModalProduk() {
            $('.modal-produk').modal('hide');
        }

        function tambahProduk() {
            $.ajax({
                    url: "{{ route('purchase-order-detail.store') }}",
                    type: "post",
                    data: $(".form-produk").serialize(),
                })
                .done(response => {
                    hideModalProduk();
                    refresh_data();
                })
                .fail(errors => {
                    alert_error('error', errors);
                    return;
                });
        }

        // Delete data
        $('body').on('click', '.btn-delete', function(event) {
            event.preventDefault();
            var me = $(this),
                url = me.attr('href'),
                csrf_token = $('meta[name=csrf-token]').attr('content');
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
        });
    </script>
@endpush
