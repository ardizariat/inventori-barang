@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/js/plugin/selectpicker/css/bootstrap-select.min.css') }}">
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
                        <a href="#">Data Pengguna</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__slideInDown">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="">
                                        <h4 class="judul">Filter</h4>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <select title="Pilih status user" data-live-search="true" name="status"
                                                    class="form-control selectpicker filter-status">
                                                    <option value="aktif">Aktif</option>
                                                    <option value="ditangguhkan">Ditangguhkan</option>
                                                    <option value="tidak Aktif">Tidak Aktif</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mt-1">
                                                <button type="submit" data-toggle="tooltip" data-placement="top"
                                                    title="Refresh data" class="btn btn-sm refresh btn-success btn-flat">
                                                    <i class="fas fa-sync-alt"></i> Refresh
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('user.create') }}"
                                        class="float-right btn btn-rounded btn-primary"><i class="fas fa-plus"></i>
                                        Tambah
                                        User</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" class="form-user">
                                <div class="table-responsive">
                                    <table id="user-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('admin.user._modal')

@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
    <script>
        // Function datatables
        function load_data(status = '') {
            $('#user-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('user.index') }}",
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
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "username",
                        name: "username"
                    },
                    {
                        data: "email",
                        name: "email"
                    },
                    {
                        data: "role",
                        name: "role"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                ],
                pageLength: 15,
                "lengthMenu": [15, 25, 50, 75, 100],
                "language": {
                    "emptyTable": "Data tidak ada"
                },
            });
        }

        // Datatables load data
        load_data();

        // Refresh data
        function refresh_data() {
            $('#user-table').DataTable().destroy();
            load_data();
        }

        // Filter data berdasarkan option
        $('form').on('change', '.filter-status', function(e) {
            e.preventDefault();
            var status = $('form .filter-status [name=status]').val();
            console.log(status);

            if (status != '') {
                $('#user-table').DataTable().destroy();
                load_data(status);
                $('.card-header .judul').text('Filter data berdasarkan status');
            } else {
                Swal.fire('Oops...', 'Opsi status harus dipilih!', 'error')
                return;
            }
        });

        // Refresh Datatables
        $('form').on('click', '.refresh', function(e) {
            e.preventDefault();
            refresh_data();
        });
    </script>

@endpush
