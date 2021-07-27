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
          <a href="">Ubah Profile</a>
        </li>
        <li class="separator">
          <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
        </li>
      </ul>
    </div>

    <div class="card card-post card-round">
      <div class="card-body">
        <form class="form-setting" enctype="multipart/form-data" action="{{ route('profile-user.update') }}"
          method="post">
          @csrf
          <div class="row my-3  form-group">
            <div class="col-md-3">
              <label>Nama</label>
            </div>
            <div class="col-md-9">
              <input type="text" name="name" class="form-control name">
            </div>
          </div>
          <div class="row my-3  form-group">
            <div class="col-md-3">
              <label>Username</label>
            </div>
            <div class="col-md-9">
              <input type="text" name="username" class="username form-control">
            </div>
          </div>
          <div class="row my-3  form-group">
            <div class="col-md-3">
              <label>Email</label>
            </div>
            <div class="col-md-9">
              <input type="email" name="email" class="email form-control">
            </div>
          </div>
          <div class="row my-3  form-group">
            <div class="col-md-3">
              <label>Foto Profil</label>
            </div>
            <div class="col-md-9">
              <input type="file" onchange="preview('.show-image', this.files[0])" class="form-control-file" name="foto">
              <br>
              <div class="show-image"></div>
            </div>
          </div>
          <div class="row my-3 d-flex justify-content-center">
            <button class="btn btn-dark btn-update mx-3" type="submit">
              <span class="btn-text">Update</span>
              <i class="fas fa-spinner fa-spin" style="display:none;"></i>
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@push('js')
<script>
  $(function(){
    showData();
    $('form').on('click','.btn-update', function (e) {
      e.preventDefault();
      let form  = $('.card-body .form-setting');

      form.find('.invalid-feedback').remove();
      form.find('.form-control').removeClass('is-invalid');

      $.ajax({
        url   : $('.form-setting').attr('action'),
        type   : $('.form-setting').attr('method'),
        beforeSend : function(){
          loading();
        },  
        complete : function(){
          hideLoader();
        },  
        data  : new FormData($('.form-setting')[0]),
        async : false,
        processData: false,
        contentType : false,
      })
      .done(response => {
        showData();
        alert_success('success', response.text);
      })
      .fail(errors => {
        if(errors.status == 422){
          loopErrors(errors.responseJSON.errors);
        }else{
        alert_error('error', 'Gagal ubah pengaturan');
        return;
      }
      });

    })
  });

  function showData() {
    $.get(`{{ route('profile-user.edit') }}`)
    .done(response => {
      $('[name=name]').val(response.name);
      $('[name=username]').val(response.username);
      $('[name=email]').val(response.email);

      $('.user-foto').attr('src',`{{ asset('/storage/user') }}/${response.foto}`);
    })
    .fail(errors => {
      alert_error('error', message.errors.message);
      return;
    })
  }
</script>
@endpush