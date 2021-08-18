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
                        <a href="{{ route('pb.index') }}">Permintaan Barang PB</a>
                    </li>
                </ul>
            </div>

            <div class="card shadow animate__animated animate__slideInDown">
                <div class="card-header">
                    <div class="row mb-3 ml-2">
                        <div class="col-md-12">
                            <form>
                                @role('sect_head|super-admin')
                                @if ($pb->sect_head != 'approved')
                                    <div class="btn-group">
                                        <button
                                            onclick="rejectSectHead(`{{ $id }}`, `rejected`,`{{ route('pb.update-status', $id) }}`,`sect_head`)"
                                            class="btn btn-flat btn-danger" data-toggle="tooltip" data-placement="top"
                                            title="Tolak Permintaan Barang PB">
                                            Reject PB
                                        </button>
                                        <button
                                            onclick="approveSectHead(`{{ $id }}`, `approved`,`{{ route('pb.update-status', $id) }}`,`sect_head`)"
                                            class="btn btn-flat btn-success" data-toggle="tooltip" data-placement="top"
                                            title="Approve Permintaan Barang PB">
                                            Approve PB
                                        </button>
                                    </div>
                                @endif
                                @endrole
                                @if ($pb->dept_head != 'approved')
                                    <div class="btn-group">
                                        @role('dept_head|super-admin')
                                        <button
                                            onclick="rejectDeptHead(`{{ $id }}`, `rejected`,`{{ route('pb.update-status', $id) }}`,`dept_head`)"
                                            class="btn btn-flat btn-danger" data-toggle="tooltip" data-placement="top"
                                            title="Tolak Permintaan Barang PB">
                                            Reject PB
                                        </button>
                                        <button
                                            onclick="approveDeptHead(`{{ $id }}`, `approved`,`{{ route('pb.update-status', $id) }}`,`dept_head`)"
                                            class="btn btn-flat btn-success" data-toggle="tooltip" data-placement="top"
                                            title="Approve Permintaan Barang PB">
                                            Approve PB
                                        </button>
                                    </div>
                                @endif
                                @endrole
                            </form>
                        </div>
                    </div>
                    <div class="row ml-2">
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
                                        <h3>{{ $pb->no_dokumen }}</h3>
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
                                        <h3>{{ formatAngka($pb->total_item) }}</h3>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th>Request By</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $pb->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $pb->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Status Section Head</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>
                                        @if ($pb->sect_head == 'on process')
                                            <span class="badge badge-warning text-capitalize">{{ $pb->sect_head }}</span>
                                        @elseif ($pb->sect_head == 'rejected')
                                            <span class="badge badge-danger text-capitalize">{{ $pb->sect_head }}</span>
                                        @else
                                            <span class="badge badge-success text-capitalize">Approved</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Departemen Head</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>
                                        @if ($pb->dept_head == 'on process')
                                            <span class="badge badge-warning text-capitalize">{{ $pb->dept_head }}</span>
                                        @elseif ($pb->dept_head == 'rejected')
                                            <span class="badge badge-danger text-capitalize">{{ $pb->dept_head }}</span>
                                        @else
                                            <span class="badge badge-success text-capitalize">Approved</span>
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
                            <table class="pb-detail-table table table-striped">
                                <thead>
                                    <tr>
                                        <th width="2%">No</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
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
            $('.pb-detail-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: "{{ route('pb.show', $id) }}",
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
                ],
                pageLength: 15,
                "lengthMenu": [15, 25, 50, 75, 100],
                "language": {
                    "emptyTable": "Data tidak ada"
                },
                bSort: false,
            });
        }

        function rejectSectHead(id, value, url, data) {
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

        function approveSectHead(id, value, url, data) {
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

        function rejectDeptHead(id, value, url, data) {
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

        function approveDeptHead(id, value, url, data) {
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
    </script>

@endpush
