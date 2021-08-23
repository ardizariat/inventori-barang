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
                        <a href="#">{{ $title }}</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__slideInDown">
                        <div class="card-header">
                            <form action="">
                                <h4 class="judul">Filter</h4>
                                <div class="row ">
                                    <div class="col-md-5 my-2">
                                        <select title="Pilih status" data-live-search="true" name="status"
                                            class="form-control selectpicker filter-status">
                                            <option value="on process">on process</option>
                                            <option value="rejected">Rejected</option>
                                            <option value="approved">Approved</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <button type="submit" data-toggle="tooltip" data-placement="top"
                                            title="Refresh data" class="btn btn-sm refresh btn-success btn-flat">
                                            <i class="fas fa-sync-alt"></i> Refresh
                                        </button>
                                    </div>
                                    <div class="col-md-3 my-2 float-right">
                                        <button onclick="showModal()" data-toggle="tooltip" data-placement="top"
                                            title="Buat PO" class="btn btn-rounded btn-outline-primary">
                                            <i class="fa fa-plus" aria-hidden="true"></i> Buat PO
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <form action="" class="form-kategori">
                                <table class="po-table table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Dokumen</th>
                                            <th>Supplier</th>
                                            <th>Request By</th>
                                            <th>Item</th>
                                            <th>Total Harga</th>
                                            <th>Status</th>
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
    @includeIf('admin.po.index.modal')
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
    <script>
        // Datatables load data
        load_data_po();

        // Function datatables
        function load_data_po(status = '') {
            $('.po-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('po.index') }}",
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
                        data: "supplier",
                        name: "supplier"
                    },
                    {
                        data: "pemohon",
                        name: "pemohon"
                    },
                    {
                        data: "total_item",
                        name: "total_item"
                    },
                    {
                        data: "total_harga",
                        name: "total_harga"
                    },
                    {
                        data: "status",
                        name: "status"
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
            $('.po-table').DataTable().destroy();
            load_data_po();
        }

        function showModal() {
            event.preventDefault();
            $('.modal-form').modal('show');
        }

        function hideModal() {
            event.preventDefault();
            $('.modal-form').modal('hide');
        }

        $(function() {
            $('.modal-form').on('click', '.btn-save', function(e) {
                e.preventDefault();
                let form = $('.modal-form form'),
                    url = form.attr('action');
                form.find('.invalid-feedback').remove();
                form.find('.form-control').removeClass('is-invalid');

                $.ajax({
                        url: url,
                        type: 'post',
                        beforeSend: function() {
                            loading();
                        },
                        complete: function() {
                            hideLoader();
                        },
                        data: form.serialize()
                    })
                    .done(response => {
                        hideModal();
                        form[0].reset();
                        $('.selectpicker').val(null).trigger('change');
                        refresh_data();
                        alert_success('success', response.text);
                    })
                    .fail(errors => {
                        if (errors.status == 422) {
                            loopErrors(errors.responseJSON.errors);
                        } else {
                            alert_error('error', 'Gagal');
                            return;
                        }
                    });
            });
        });

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
