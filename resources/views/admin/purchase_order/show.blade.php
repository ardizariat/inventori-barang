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
                        <a href="{{ route('purchase-order.index') }}">Purchase Order</a>
                    </li>
                </ul>
            </div>

            <div class="card shadow animate__animated animate__slideInDown">
                <div class="card-header">
                    <div class="row mb-3 ml-2">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="{{ route('purchase-order.index') }}" class="btn btn-flat btn-danger">Kembali</a>
                                @if ($po->status == 'pending')
                                    <button
                                        onclick="approve(`{{ route('purchase-order.approved', $id) }}`,`{{ $id }}`,`{{ $url }}`)"
                                        class="btn btn-flat btn-success" data-toggle="tooltip" data-placement="top"
                                        title="Approve Purchase Order">
                                        Approve PO
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row ml-2">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th>
                                        <h3>No PO</h3>
                                    </th>
                                    <th class="pl-5 pr-2">
                                        <h3>:</h3>
                                    </th>
                                    <td>
                                        <h3>{{ $po->no_dokumen }}</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h3>Tanggal</h3>
                                    </th>
                                    <th class="pl-5 pr-2">
                                        <h3>:</h3>
                                    </th>
                                    <td>
                                        <h3>{{ $tanggal }}</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h3>Total Item</h3>
                                    </th>
                                    <th class="pl-5 pr-2">
                                        <h3>:</h3>
                                    </th>
                                    <td>
                                        <h3>{{ formatAngka($po->total_item) }}</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h3>Total Harga</h3>
                                    </th>
                                    <th class="pl-5 pr-2">
                                        <h3>:</h3>
                                    </th>
                                    <td>
                                        <h3>Rp. {{ formatAngka($po->total_harga) }}</h3>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th>Supplier</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $po->supplier->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $po->supplier->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telpon</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $po->supplier->telpon }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $po->supplier->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>
                                        @if ($po->status == 'pending')
                                            <span class="badge badge-warning">
                                                Menunggu diapprove
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                Sudah diapprove
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" class="form-po">
                                <table class="purchase-order-detail-table table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="2%">No</th>
                                            <th>Nama Barang</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Sub Total</th>
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
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script>
        load_data();

        function load_data() {
            $('.purchase-order-detail-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: "{{ route('purchase-order.show', $id) }}",
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
                        data: "subtotal",
                        name: "subtotal"
                    },
                ],
                pageLength: 15,
                "lengthMenu": [15, 25, 50, 75, 100],
                "language": {
                    "emptyTable": "Data tidak ada"
                },
                bSort: false,
                dom: 'Brt',
            });
        }

        function approve(url, id, back) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah kamu yakin, approve PO ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Approve!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                '_token': $('meta[name=csrf-token]').attr('content'),
                                '_method': 'put',
                                'id': id
                            }
                        })
                        .done(response => {
                            alert_success('success', response.text);
                            location.href = back;
                        })
                        .fail(errors => {
                            alert_error('error', 'gagal');
                            return;
                        });
                }
            });
        }
    </script>

@endpush
