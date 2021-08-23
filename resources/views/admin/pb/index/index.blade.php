@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/js/plugin/selectpicker/css/bootstrap-select.min.css') }}">
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
                        <a href="#">{{ $title }}</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__slideInDown">
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
                                            <i class="fa fa-plus" aria-hidden="true"></i> Buat Permintaan Barang PB
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <form action="" class="form-kategori">
                                <table class="pb-table table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Dokumen</th>
                                            <th>Request By</th>
                                            <th>Sect. Head</th>
                                            <th>Dept. Head</th>
                                            <th>Aksi</th>
                                            <th>Unduh</th>
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
    @includeIf('admin.pb.index.modal_info')
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/flatpickr.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/date-time-picker-script.js') }}"></script>
    <script>
        // Datatables load data
        load_data();

        // Function datatables
        function load_data(status = '') {
            $('.pb-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('pb.index') }}",
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
                        data: "pemohon",
                        name: "pemohon"
                    },
                    {
                        data: "sect_head",
                        name: "sect_head"
                    },
                    {
                        data: "dept_head",
                        name: "dept_head"
                    },
                    {
                        data: "aksi",
                        name: "aksi"
                    },
                    {
                        data: "download",
                        name: "download"
                    },
                ],
                pageLength: 15,
                "lengthMenu": [15, 25, 50, 75, 100],
                "language": {
                    "emptyTable": "Data tidak ada"
                },
            });
        }

        // Filter data berdasarkan tanggal
        $('form').on('click', '.filter', function(e) {
            e.preventDefault();
            var from_date = $('form .from_date').val(),
                to_date = $('form .to_date').val();

            if (from_date != '' && to_date != '') {
                $('.pb-table').DataTable().destroy();
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

        // Refresh data
        function refresh_data() {
            $('.pb-table').DataTable().destroy();
            load_data();
        }

        function showModal() {
            event.preventDefault();
            $('.modal-pb-info').modal('show');
        }

        // Hapus Data
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
