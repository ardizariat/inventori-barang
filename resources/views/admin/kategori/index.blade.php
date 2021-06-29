@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
    <style>
        .none {
            display: none;
        }

        .error {
            color: red;
        }

    </style>
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
                        <a href="#">Data Kategori</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__slideInDown">
                        <div class="card-header">
                            <button onclick="" type="submit"
                                class="animate__animated animate__zoomInDown d-none btn btn-hapus-multiple  btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                            <h4 class="card-title float-right">
                                <button class="btn btn-rounded btn-outline-primary"
                                    onclick="addForm('{{ route('kategori.store') }}')">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Tambah Kategori
                                </button>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="" class="form-kategori">
                                    {!! $dataTable->table() !!}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('admin.kategori._modal')

@endsection

@push('js')
    <!-- Datatables -->
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/validator-js/validator.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script> --}}
    {!! $dataTable->scripts() !!}

    <script>
        const table = $('#kategori-table');
        $(function() {
            $('.modal-form').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                            url: $('.modal-form form').attr('action'),
                            type: $('.modal-form [name=_method]').val(),
                            beforeSend: function() {
                                $('.modal-footer .btn-save').addClass('d-none');
                                $('.modal-footer .loader').removeClass('d-none');
                            },
                            complete: function() {
                                $('.modal-footer .loader').addClass('d-none');
                                $('.modal-footer .submit').removeClass('d-none');
                            },
                            data: $('.modal-form form').serialize(),
                        })
                        .done((response) => {
                            $('.modal-form').modal('hide');
                            $.notify({
                                message: response.text
                            }, {
                                type: 'success'
                            });
                            table.DataTable().ajax.reload();
                        })
                        .fail((errors) => {
                            console.log(errors);
                        })
                }
            });
        });

        function addForm(url) {
            console.log(url);
            event.preventDefault();
            $('.modal-form').modal('show');
            $('.modal-form .modal-title').text('Tambah Kategori');
            $('.modal-form form')[0].reset();
            $('.modal-form form').attr('action', url);
            $('.modal-form [name=_method]').val('post');
        }
    </script>

@endpush
