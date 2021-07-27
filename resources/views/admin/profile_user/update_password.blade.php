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
          <a href="">Ubah Password</a>
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
        <form class="form-setting" action="{{ route('profile-user.update_password') }}" method="post">
          @csrf
          <div class="row my-3  form-group">
            <div class="col-md-3">
              <label>Password Lama</label>
            </div>
            <div class="col-md-9">
              <input type="password" name="old_password" placeholder="Masukkan password lama"
                class="form-control old_password">
            </div>
          </div>
          <div class="row my-3  form-group">
            <div class="col-md-3">
              <label>Password Baru</label>
            </div>
            <div class="col-md-9">
              <input type="password" name="password" placeholder="Masukkan password baru" class="password form-control">
            </div>
          </div>
          <div class="row my-3  form-group">
            <div class="col-md-3">
              <label>Konfirmasi Password</label>
            </div>
            <div class="col-md-9">
              <input type="password" name="password_confirmation" placeholder="Konfirmasi password"
                class="password_confirmation form-control">
            </div>
          </div>
          <div class="row my-3 d-flex justify-content-center">
            <button class="btn btn-dark btn-update mx-3" id="submit" type="submit">
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
        data  : $('.form-setting').serialize(),
      })
      .done(response => {
        window.location.reload();
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
</script>
@endpush