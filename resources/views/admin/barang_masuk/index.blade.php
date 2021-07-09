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
     <link rel="stylesheet" href="{{ asset('admin/js/plugin/selectpicker/css/bootstrap-select.min.css') }}">
     <link rel="stylesheet" href="{{ asset('admin/js/plugin/file-input/css/fileinput.min.css') }}">
     <link href="{{ asset('admin/js/plugin/date-time-pickers/css/flatpicker-airbnb.css')}}" rel="stylesheet" type="text/css" />
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
            <div class="card shadow animate__animated animate__jackInTheBox">
              <div class="card-header">
                  <form action="">
                      <h4>Filter</h4>
                      <div class="row">
                          <div class="col-md-3">
                              <input type="text" autocomplete="off" name="awal" value="{{ date('Y-m-d') }}" class="form-control filter-awal max-date">
                          </div>
                          <div class="col-md-3">
                              <input type="text" autocomplete="off" name="end" value="{{ date('Y-m-d') }}" class="form-control filter-akhir max-date">
                          </div>
                          <div class="col-md-2 mt-1">
                              <button type="submit" data-toggle="tooltip" data-placement="top" title="Refresh data"
                                  class="btn btn-sm reset btn-danger btn-flat">
                                  Reset
                              </button>
                          </div>
                          <div class="col-md-4">
                              <a class="btn btn-rounded btn-outline-primary"
                          onclick="addForm('{{ route('barang-masuk.store') }}')">
                          <i class="fa fa-plus" aria-hidden="true"></i> Tambah Barang Masuk
                              </a>
                          </div>
                      </div>
                      <div class="row my-2 justify-content-center">
                          <div class="col-md-8">
                              
                          </div>
                      </div>
                  </form>
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

@includeIf('admin.barang_masuk._modal')

@endsection

@push('js')
<script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
{!! $dataTable->scripts() !!}
<script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/file-input/js/fileinput.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/file-input/themes/fa/theme.js') }}"></script>
<script src="{{ asset('admin/js/plugin/date-time-pickers/js/flatpickr.js') }}"></script>
<script src="{{ asset('admin/js/plugin/date-time-pickers/js/date-time-picker-script.js') }}"></script>

<script>
    // Select2
    // $('.select2').select2();
    $('.selectpicker').selectpicker();

    // File input images
    $(".input-fa").fileinput({
        theme: "fa",
        uploadUrl: "/file-upload-batch/2"
    });

    const table = $('#barangmasuk-table');
    $(function() {

        $('.modal-form').on('submit', function(e) {
            if (!e.preventDefault()) {

                var form = $('.modal-form form');
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');

                $.ajax({
                    url: $('.modal-form form').attr('action'),
                    type: $('.modal-form input[name=_method]').val(),
                    beforeSend: function() {
                        $('.modal-footer .btn-save').addClass('d-none');
                        $('.modal-footer .loader').removeClass('d-none');
                    },
                    complete: function() {
                        $('.modal-footer .loader').addClass('d-none');
                        $('.modal-footer .submit').removeClass('d-none');
                    },
                    data: $('.modal-form form').serialize(),
                    success: function(response) {
                        $('.modal-form').modal('hide');
                        $.notify({
                            message: response.text
                        }, {
                            type: 'success'
                        });
                        table.DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        var res = xhr.responseJSON;
                        if ($.isEmptyObject(res) == false) {
                            $.each(res.errors, function(key, value) {
                                console.log(res);
                                $('.' + key)
                                    .closest('.form-group')
                                    .addClass('has-error')
                                    .append(`<span class="help-block">` + value +
                                        `</span>`)
                            });
                        }
                    }
                });
            }
        });
    });
    
    function addForm(url) {
        event.preventDefault();
        $('.modal-form').modal('show');
        $('.modal-form .modal-title').text('Tambah Barang Masuk');
        $('.modal-form form')[0].reset();
        $('.modal-form form').attr('action', url);
        $('.modal-form [name=_method]').val('post');
    }

    function editForm(url) {
        event.preventDefault();
        $('.modal-form').modal('show');
        $('.modal-form .modal-title').text('Ubah Barang Masuk');
        $('.modal-form form').attr('action', url);
        $('.modal-form [name=_method]').val('put');
        $.get(url)
            .done((response) => {
                let produk = response.data.produk_id;
                let jumlah = response.data.jumlah;
                let tanggal = response.data.tanggal;
                let satuan = response.data.satuan;
                let keterangan = response.data.keterangan;
                $('.modal-form .produk_id').val(produk);
                $('.modal-form .jumlah').val(jumlah);
                $('.modal-form .tanggal').val(tanggal);
                $('.modal-form .satuan').val(satuan).change();
                $('.modal-form .keterangan').val(keterangan);
            })
            .fail((errors) => {
                Swal.fire('Oops...', 'Kategori ini tidak dapat dihapus', 'error')
                return;
            })
    }

    function deleteData(url) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "menghapus data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, {
                        '_token': $('input[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        $.notify({
                            message: response.text
                        }, {
                            type: 'success'
                        });
                        table.DataTable().ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire('Oops...', 'Kategori ini tidak dapat dihapus', 'error')
                    })
            }
        })
    }

    function changeData(url){
        var id = $('.produk_id select[name=produk_id]').val();
        $.ajax({
            url : url,
            type : 'post',
            dataType : 'json',
            data : {
                '_token' : '{{ csrf_token() }}',
                'id' : id
            },
            success : function(res){
                var stok = parseInt(res.stok);
                $('.stok').val(stok); 
                $('.modal-form').on('keyup','.jumlah', function(){
                    var me = $(this),
                    jumlah = parseInt(me.val());
                    total = stok + jumlah;
                    $('.stok').val(total); 
                });                   
            },
            error: function(message){
                console.log('error');
            }
        })
    }

    table.on('preXhr.dt', function(e, settings, data) {
            data.awal = $('.filter-awal').val();
            data.akhir = $('.filter-akhir').val();
        });

        $('form').on('click', '.generate', function(e) {
            e.preventDefault();
            table.DataTable().ajax.reload();
            return false;
        });

        $('.reset').on('click', function(e) {
            e.preventDefault();
            table.on('preXhr.dt', function(e, settings, data) {
                data.awal = '';
                data.akhir = '';
            });
            table.DataTable().ajax.reload();
            return false;
        });    
</script>

@endpush
