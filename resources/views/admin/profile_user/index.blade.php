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
          <a href="">Data Barang</a>
        </li>
        <li class="separator">
          <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card card-post card-round">
          <img class="card-img-top" src="{{ asset('admin/img/blogpost.jpg') }}" alt="Card image cap">
          <div class="card-body">
            <div class="d-flex">
              <div class="avatar">
                <img src="{{ $user->getFoto() }}" class="avatar-img rounded-circle">
              </div>
              <div class="info-post ml-2">
                <p class="username">{{ $user->name }}</p>
                <p class="date text-muted">20 Jan 18</p>
              </div>
            </div>
            <div class="separator-solid"></div>
            <p class="card-category text-info mb-1"><a href="#">Design</a></p>
            <h3 class="card-title">
              <a href="#">
                Best Design Resources This Week
              </a>
            </h3>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary btn-rounded btn-sm">Read More</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('js')
<script src="{{ asset('admin/js/plugin/zoom/medium-zoom.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
@endpush