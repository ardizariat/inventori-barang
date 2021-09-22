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
                        <a href="#">{{ $title }}</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__slideInDown">
                        <div class="card-header">
                            <button onclick="showModal()" data-toggle="tooltip" data-placement="top"
                                title="Buat Permintaan Barang PR" class="btn btn-rounded btn-outline-primary">
                                <i class="fa fa-plus" aria-hidden="true"></i> Buat Permintaan Barang PR
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="pr-table table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Dokumen</th>
                                            <th>Request By</th>
                                            <th>Sect. Head</th>
                                            <th>Dept. Head</th>
                                            <th>Direktur</th>
                                            <th>Aksi</th>
                                            <th>Unduh</th>
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
    @includeIf('admin.pr.index.modal_info')
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script>
        // Datatables load data
        load_data_pr();

        // Function datatables
        function load_data_pr(status = '') {
            $('.pr-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('pr.index') }}",
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
                        data: "direktur",
                        name: "direktur"
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

        // Refresh data
        function refresh_data() {
            $('.pr-table').DataTable().destroy();
            load_data_pr();
        }

        // Filter data berdasarkan option
        $('form').on('change', '.filter-status', function(e) {
            e.preventDefault();
            var status = $('form .filter-status [name=status]').val();

            if (status != '') {
                $('.pr-table').DataTable().destroy();
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
            $('.pr-table').DataTable().destroy();
            load_data_purchase_order();
        });

        function showModal() {
            event.preventDefault();
            $('.modal-pr-info').modal('show');
        }

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
