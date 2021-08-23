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
                        <a href="#">Data Barang Masuk</a>
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
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="barangmasuk-table table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="20%">Supplier</th>
                                            <th width="20%">Nama Barang</th>
                                            <th width="20%">Kategori</th>
                                            <th width="20%">Tanggal</th>
                                            <th width="15%">Qty</th>
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
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/flatpickr.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/date-time-pickers/js/date-time-picker-script.js') }}"></script>
    <script>
        // Datatables load data
        load_data();

        // Function datatables
        function load_data(from_date = '', to_date = '') {
            $('.barangmasuk-table').DataTable({
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
                        data: 'supplier',
                        name: 'supplier'
                    },
                    {
                        data: 'nama_produk',
                        name: 'nama_produk'
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

        // Filter data berdasarkan tanggal
        $('form').on('click', '.filter', function(e) {
            e.preventDefault();
            var from_date = $('form .from_date').val(),
                to_date = $('form .to_date').val();

            if (from_date != '' && to_date != '') {
                $('.barangmasuk-table').DataTable().destroy();
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
            $('.barangmasuk-table').DataTable().destroy();
            load_data();
        }

        function pilihBarangMasuk(url) {
            var id = $('.no_dokumen select[name=no_dokumen]').val();
            $('.po').fadeOut('fast');
            $('.btn-none').fadeOut('fast');
            $.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    }
                })
                .done(response => {
                    let pemohon = response.pemohon,
                        url = response.url,
                        tanggal = response.tanggal,
                        supplier = response.supplier,
                        total_item = response.data.total_item,
                        status = response.data.status;
                    $('.modal-barang-masuk .pemohon').text(pemohon);
                    $('.modal-barang-masuk .supplier').text(supplier);
                    $('.modal-barang-masuk .status').text(status);
                    $('.modal-barang-masuk .tanggal').text(tanggal);
                    $('.modal-barang-masuk .total_item').text(total_item);
                    $('.modal-barang-masuk .btn-detail').attr("href", url);
                    $('.modal-barang-masuk .po').show();
                    $('.modal-barang-masuk .btn-none').show();
                })
        }
    </script>


@endpush
