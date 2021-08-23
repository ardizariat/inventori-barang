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
                        <a href="{{ route('barang-keluar.index') }}">Barang Keluar</a>
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
                                <h3>{{ $pb->created_at->format('d-m-Y') }}</h3>
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
                                <h3 class="total_item">{{ formatAngka($pb->total_item) }}</h3>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 info">
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
                            <th>Status Section</th>
                            <th class="pl-5 pr-2">:</th>
                            <td>{{ $pb->sect_head }}</td>
                        </tr>
                        <tr>
                            <th>Status Dept Head</th>
                            <th class="pl-5 pr-2">:</th>
                            <td>{{ $pb->dept_head }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <th class="pl-5 pr-2">:</th>
                            <td class="text-capitalize status">{{ $pb->status }} Pemohon</td>
                        </tr>
                    </table>
                    @if ($pb->status == 'belum diterima' && $pb->sect_head == 'approved' && $pb->dept_head == 'approved')
                        <div class="btn-group my-2">
                            <button onclick="serahTerima(`{{ route('barang-keluar.serah-terima-pb', $id) }}`)"
                                class="btn btn-flat btn-success" data-toggle="tooltip" data-placement="top"
                                title="Serah terima barang">
                                <i class="fas fa-user-check"></i>Konfirmasi Serah Terima
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card my-2 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="barang-keluar-pb-table table table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="35%">Nama Barang</th>
                                        <th width="35%">Kategori</th>
                                        <th width="25%">Qty</th>
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
            $('.barang-keluar-pb-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: "{{ route('barang-keluar.pb', $id) }}",
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
                        data: "kategori",
                        name: "kategori"
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

        function refresh_data() {
            $('.barang-keluar-pb-table').DataTable().destroy();
            load_data();
        }

        function serahTerima(url) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah barang sudah diterima pemohon?',
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
                            $('.info .status').text('Sudah Diterima Pemohon');
                            $('.info .btn-group').fadeOut();
                            refresh_data();
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
