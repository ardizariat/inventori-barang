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
                        <a href="{{ route('user.index') }}">Data User</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow animate__animated animate__zoomInDown">
                        <div class="card-body">
                            <form class="form-user">
                                @csrf
                                @method('post')
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-2 pt-3">
                                            <label>Nama User</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <input type="text" name="name" autocomplete="off" autofocus
                                                class="name form-control" placeholder="Masukkan nama user">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 pt-3">
                                            <label>Role</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <select title="Pilih role" data-live-search="true" name="role"
                                                class="selectpicker form-control role">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 pt-3">
                                            <label>Permission</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <select title="Pilih permission" data-live-search="true" name="permission[]"
                                                multiple="true" class="form-control selectpicker permission">
                                                @foreach ($permissions as $permission)
                                                    <option value="{{ $permission->name }}">{{ $permission->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 pt-3">
                                            <label>Email</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <input type="email" name="email" autocomplete="off" autofocus
                                                class="email form-control" placeholder="Masukkan email">
                                            <span class="help-block with-errors"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 pt-3">
                                            <label>Username</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <input type="text" name="username" autocomplete="off" autofocus
                                                class="username form-control" placeholder="Masukkan username">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center d-flex btn-submit btn-row">
                                    <div class="col-md-4">
                                        <button type="reset" value="Reset" class="text-uppercase btn btn-danger">
                                            Batal
                                        </button>
                                        <button onclick="simpan(`{{ route('user.store') }}`)"
                                            class="btn btn-primary btn-save" type="submit">
                                            <span class="btn-text text-uppercase">Simpan</span>
                                            <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
    <script>
        function simpan(url) {
            event.preventDefault();
            let form = $('.card-body form');
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
                    form[0].reset();
                    $('.selectpicker').val(null).trigger('change');
                    alert_success('success', response.text)
                })
                .fail(errors => {
                    if (errors.status == 422) {
                        loopErrors(errors.responseJSON.errors);
                    } else {
                        alert_error('error', 'Gagal ubah pengaturan');
                        return;
                    }
                })
        }
    </script>

@endpush
