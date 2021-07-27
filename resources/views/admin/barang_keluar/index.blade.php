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
                <a href="#">Data Barang Keluar</a>
            </li>
        </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow animate__animated animate__zoomInRight">
          <div class="card-header">
            <form action="">
              <h4><i class="fas fa-filter"></i> Filter</h4>
              <div class="row">
                <div class="col-md-3 my-2">
                    <input name="from_date" type="text" autocomplete="off" class="from_date form-control max-date">
                </div>
                <div class="col-md-3 my-2">
                    <input name="to_date" type="text" autocomplete="off" class="to_date form-control max-date">
                </div>
                <div class="col-md-3 my-2">
                    <div class="btn-group">
                      <button type="submit" data-toggle="tooltip" data-placement="top" title="Filter data"
                      class="btn btn-sm filter btn-success btn-flat">
                      <i class="fas fa-filter"></i> Filter
                      </button>
                      <button type="submit" data-toggle="tooltip" data-placement="top" title="Refresh data"
                      class="btn btn-sm refresh btn-danger btn-flat">
                      <i class="fas fa-sync-alt"></i> Refresh
                      </button>
                    </div>
                </div>
                <div class="col-md-3 my-2">
                    <a data-toggle="tooltip" data-placement="top" title="Tambah data" class="btn btn-rounded btn-outline-primary"
                onclick="addForm('{{ route('barang-keluar.store') }}')">
                <i class="fa fa-plus" aria-hidden="true"></i> Tambah Barang Keluar
                    </a>
                </div>
              </div>
            </form>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <form action="" class="form-kategori">
                <table id="barangkeluar-table" class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Barang</th>
                      <th>Kategori</th>
                      <th>Tanggal</th>
                      <th>Jumlah</th>
                      <th>Option</th>
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
</div>

@includeIf('admin.barang_keluar._modal_input')
@includeIf('admin.barang_keluar._modal_show')

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
  function load_data(from_date = '', to_date = ''){
    $('#barangkeluar-table').DataTable({
      processing  : true,
      serverSide  : true,
      ajax        : {
          url : "{{ route('barang-keluar.index') }}",
          data : { from_date : from_date, to_date : to_date}
      },
      columns     : [
        {
            data : "DT_RowIndex",name : "DT_RowIndex", searchable:false, sortable:false
        },
        {
            data: 'produk', name: 'produk'
        },
        {
            data: 'kategori', name: 'kategori'
        },
        {
            data: 'tanggal', name: 'tanggal'
        },
        {
            data: 'jumlah', name: 'jumlah'
        },
        {
            data: 'aksi', name: 'aksi', searchable:false, sortable:false
        },
      ],
      pageLength : 15,
      "lengthMenu": [ 15, 25, 50, 75, 100 ],
      "language": {
        "emptyTable": "Data tidak ada"
      },
    });
  }

  // Refresh data
  function refresh_data(){
    $('#barangkeluar-table').DataTable().destroy();
    load_data();
  }

  // Filter data berdasarkan tanggal
  $('form').on('click','.filter', function(e){
    e.preventDefault();
    var from_date = $('form .from_date').val(),
    to_date = $('form .to_date').val();

    if(from_date != '' && to_date != ''){
        $('#barangkeluar-table').DataTable().destroy();
        load_data(from_date, to_date);
    }else{
        Swal.fire('Oops...', 'Filter tanggal harus diisi semua!', 'error')
        return;
    }
  });

  // Refresh Datatables
  $('form').on('click','.refresh', function(e){
    e.preventDefault();
    var from_date = $('form .from_date').val(''),
    to_date = $('form .to_date').val('');
    refresh_data();
  });

  // Hapus Data
  $('body').on('click','.btn-delete', function(event){
    event.preventDefault();
    var me = $(this),
    url = me.attr('href'),
    csrf_token = $('meta[name=csrf-token]').attr('content');

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
      $.ajax({
        url : url,
        type : "POST",
        data : {
          '_method' : 'DELETE',
          '_token' : csrf_token
        }, 
        success : function(response){
          alert_success('success',  response.text)
            $('#barangkeluar-table').DataTable().destroy();
            load_data();
        }
      });
    }
    });

  });

  $(function() {
    $('.modal-form').on('click','.btn-save', function (e) {
      e.preventDefault();
      var form = $('.modal-form form');
        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');

        $.ajax({
          url: $('.modal-form form').attr('action'),
          type: $('.modal-form input[name=_method]').val(),
          beforeSend : function(){
              loading();
            },  
            complete : function(){
              hideLoader("Simpan");
            }, 
          data: $('.modal-form form').serialize()
        })
        .done(response => {
          $('.modal-form').modal('hide');
          refresh_data();
          alert_success('success', response.text);
        })
        .fail(errors => {
          if(errors.status == 422){
            loopErrors(errors.responseJSON.errors);
          }else{
            alert_error('error', 'Jumlah barang keluar melebihi stok yang tersedia');
            return;
          }
        });
    });
  });    

  function addForm(url) {
    event.preventDefault();
    $('.modal-form').modal('show');
    $('.modal-form .modal-title').text('Tambah Barang Keluar');
    $('.modal-form form')[0].reset();
    $('.modal-form form').attr('action', url);
    $('.modal-form [name=_method]').val('post');
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
              if(stok <= 0){
                  Swal.fire({
                  icon: 'error',
                  title: 'Stok barang ini kosong!',
                  text: 'Silahkan ajukan pembelian barang!',
                  showCancelButton: false,
                  confirmButtonText: `Oke`,
                  }).then((result) => {
                  if (result.isConfirmed) {
                      return window.location.reload();
                  }
                  })
              }
              $('.modal-form').on('keyup','.jumlah', function(){
                  var me = $(this),
                  jumlah = parseInt(me.val());
                  total = stok - jumlah;
                  $('.stok').val(total); 
              });                   
          },
          error: function(message){
              console.log('error');
          }
      })
  }       

  // menampilkan modal show
  function showData(url) {
      event.preventDefault();
      $('.modal-show').modal('show');      
      $.get(url)
          .done((response) => {
              var nama_produk = response.data.product.nama_produk,
              jumlah = response.data.jumlah,
              penerima = response.data.penerima,
              pemberi = response.data.pemberi,
              keterangan = response.data.keterangan,
              tanggal = response.tanggal,
              foto = response.foto;
              console.log(foto);

              $('.modal-show .modal-title').text('Detail '+nama_produk);

              $('.modal-show .foto').prop("src",foto).width(200).height(130);
              $('.modal-show .nama_produk').text(nama_produk);
              $('.modal-show .jumlah').text(jumlah);
              $('.modal-show .tanggal').text(tanggal);
              $('.modal-show .pemberi').text(pemberi);
              $('.modal-show .keterangan').text(keterangan);
              $('.modal-show .penerima').text(penerima);
          })
          .fail((errors) => {
              Swal.fire('Oops...', 'Data tidak ditemukan!', 'error')
              return;
          })
  }
</script>


@endpush
