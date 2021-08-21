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
                        <a href="{{ route('po.index') }}">{{ $title }}</a>
                    </li>
                </ul>
            </div>
            {{-- Button Approve --}}
            <form class="my-2 row">
                @role('dept_head|super-admin|sect_head')
                @if ($po->status != 'complete')
                    <div class="col-md-4">
                        <div class="btn-group">
                            <button onclick="reject(`{{ route('po.update', $id) }}`,`pending`)"
                                class="btn btn-flat btn-danger" data-toggle="tooltip" data-placement="top"
                                title="Tolak Permintaan Barang PR">
                                <i class="fas fa-window-close"></i> Reject
                            </button>
                            <button onclick="approve(`{{ route('po.update', $id) }}`,`complete`)"
                                class="btn btn-flat btn-success" data-toggle="tooltip" data-placement="top"
                                title="Approve Permintaan PO">
                                <i class="fas fa-user-check"></i> Approve
                            </button>
                        </div>
                    </div>
                @endif
                @endrole
            </form>
            {{-- Info --}}
            <div class="row my-2">
                <div class="col-md-6">
                    <table>
                        <tr>
                            <th>
                                <h3>No PB</h3>
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
                                <h3>{{ formatAngka($po->total_harga) }}</h3>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table>
                        <tr>
                            <th>Request By</th>
                            <th class="pl-5 pr-2">:</th>
                            <td>{{ $po->pr->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th class="pl-5 pr-2">:</th>
                            <td>{{ $po->pr->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <th class="pl-5 pr-2">:</th>
                            <td>
                                @if ($po->status == 'pending')
                                    <span class="badge badge-warning text-capitalize">{{ $po->status }}</span>
                                @else
                                    <span class="badge badge-success text-capitalize">{{ $po->status }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            {{-- Table --}}
            <div class="card my-2 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="po-detail-table table table-striped">
                                <thead>
                                    <tr>
                                        <th width="2%">No</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                            </table>
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
            $('.po-detail-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: "{{ route('po.show', $id) }}",
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
            });
        }

        function refresh_data() {
            $('.po-detail-table').DataTable().destroy();
            load_data();
        }

        function approve(url, value) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah kamu yakin, menyetujui permintaan ini?',
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
                                'value': value,
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

        function reject(url, value) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah kamu yakin, menolak permintaan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tolak!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                '_token': $('meta[name=csrf-token]').attr('content'),
                                '_method': 'put',
                                'id': id,
                                'value': value,
                                'data': data,
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

        function deleteItem(url) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah kamu yakin menghapus barang ini?',
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
                            refresh_data();
                            alert_success('success', 'Data berhasil dihapus');
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
