@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
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
                        <a href="#">Data Barang Masuk</a>
                    </li>
                </ul>
            </div>
            <div class="card shadow animate__animated animate__jackInTheBox">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="">
                                <h4><i class="fas fa-filter"></i> Filter</h4>
                                <div class="row">
                                    <div class="col-md-3 my-2">
                                        <input name="from_date" type="text" autocomplete="off"
                                            class="from_date form-control max-date">
                                    </div>
                                    <div class="col-md-3 my-2">
                                        <input name="to_date" type="text" autocomplete="off"
                                            class="to_date form-control max-date">
                                    </div>
                                    <div class="col-md-3 mt-1 my-2">
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
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="barangmasuk-table" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Dokumen</th>
                                            <th>Total Item</th>
                                            <th>Total Harga</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
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
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/flatpickr.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/date-time-picker-script.js') }}"></script>

    <script>
        $('.selectpicker').selectpicker();

        // Datatables load data
        load_data();

        // Function datatables
        function load_data(from_date = '', to_date = '') {
            $('#barangmasuk-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('barang-masuk.index') }}",
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
                        data: 'no_dokumen',
                        name: 'no_dokumen'
                    },
                    {
                        data: 'total_item',
                        name: 'total_item'
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
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

        // Filter data berdasarkan tanggal
        $('form').on('click', '.filter', function(e) {
            e.preventDefault();
            var from_date = $('form .from_date').val(),
                to_date = $('form .to_date').val();

            if (from_date != '' && to_date != '') {
                $('#barangmasuk-table').DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                Swal.fire('Oops...', 'Filter tanggal harus diisi semua!', 'error')
                return;
            }
        });

        // Refresh Datatables
        $('form').on('click', '.refresh', function(e) {
            e.preventDefault();
            var from_date = $('form .from_date').val(''),
                to_date = $('form .to_date').val('');
            $('#barangmasuk-table').DataTable().destroy();
            load_data();
        });

        // Refresh data
        function refresh_data() {
            $('#barangmasuk-table').DataTable().destroy();
            load_data();
        }
    </script>


@endpush
