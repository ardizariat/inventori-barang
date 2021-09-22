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
                        <a href="{{ route('barang-masuk.index') }}">Barang masuk</a>
                    </li>
                </ul>
            </div>
            <div class="row my-2">
                <div class="col-md-6">
                    <table>
                        <tr>
                            <th>
                                <h3>No Tiket</h3>
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
                                <h3>{{ $po->created_at->format('d-m-Y') }}</h3>
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
                                <h3 class="total_item">{{ formatAngka($po->total_item) }}</h3>
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
                                <h3 class="total_harga">Rp. {{ formatAngka($po->total_harga) }}</h3>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 info">
                    <table>
                        <tr>
                            <th>Request By</th>
                            <th class="pl-5 pr-2">:</th>
                            <td>{{ $po->pr->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <th class="pl-5 pr-2">:</th>
                            <td>{{ $po->supplier->nama }}</td>
                        </tr>
                        <tr>
                            <th>Email Supplier</th>
                            <th class="pl-5 pr-2">:</th>
                            <td>{{ $po->supplier->email }}</td>
                        </tr>
                        <tr>
                            <th>Status Barang</th>
                            <th class="pl-5 pr-2">:</th>
                            @if ($po->status == 'complete')
                                <td class="text-capitalize">Sudah Diterima</td>
                            @elseif(($po->status == 'on process'))
                                <td class="text-capitalize">Dalam Perjalanan</td>
                            @else
                                <td class="text-capitalize">Belum Diproses</td>
                            @endif
                        </tr>
                    </table>
                    @if ($po->status != 'complete')
                        <div class="btn-group my-2">
                            <button onclick="konfirmasi(`{{ route('barang-masuk.terima-barang.po', $id) }}`)"
                                class="btn btn-flat btn-success" data-toggle="tooltip" data-placement="top"
                                title="Serah terima barang">
                                <i class="fas fa-user-check"></i>Konfirmasi Barang Diterima
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card my-2 shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="barang-masuk-po-table table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Nama Barang</th>
                                    <th width="20%">Harga Satuan</th>
                                    <th width="15%">Qty</th>
                                    <th width="20%">Subtotal</th>
                                </tr>
                            </thead>
                        </table>
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
            $('.barang-masuk-po-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: "{{ route('barang-masuk.po-show', $id) }}",
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
                        data: "harga",
                        name: "harga"
                    },
                    {
                        data: "qty",
                        name: "qty"
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
            });
        }

        function refresh_data() {
            $('.barang-masuk-po-table').DataTable().destroy();
            load_data();
        }

        function konfirmasi(url) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah barang sudah dicek dengan baik?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Sudah!',
                cancelButtonText: 'Belum',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                '_token': $('meta[name=csrf-token]').attr('content'),
                                '_method': 'put',
                            }
                        })
                        .done(response => {
                            alert_success('success', response.text);
                            location.reload();
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
