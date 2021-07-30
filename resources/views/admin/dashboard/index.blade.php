@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')

@endpush

@section('admin-content')
<div class="content">
  <div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
          <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
        </div>
      </div>
    </div>
  </div>
  <div class="page-inner mt--5">
    <div class="row">
      <div class="col-sm-6 col-md-3">
        <div class="card shadow card-stats card-primary card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="la flaticon-technology-1"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Total Produk</p>
                  <h4 class="card-title">{!! number_format($countProduk,0,',','.') !!}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card shadow card-stats card-info card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="la flaticon-list"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Total Kategori</p>
                  <h4 class="card-title">{!! number_format($countKategori,0,',','.') !!}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card shadow card-stats card-success card-round">
          <div class="card-body ">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="la flaticon-box-3"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Rata2 Stok In</p>
                  <h4 class="card-title">{!! number_format($rata2_barang_masuk_sebulan,0,',','.') !!}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card shadow card-stats card-secondary card-round">
          <div class="card-body ">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="la flaticon-delivery-truck"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Rata2 Stok Out</p>
                  <h4 class="card-title">{!! number_format($rata2_barang_keluar_sebulan,0,',','.') !!}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card full-height">
          <div class="card-body">
            <canvas id="barang-masuk"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card full-height">
          <div class="card-body">
            <canvas id="barang-keluar"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="{{ asset('admin/js/plugin/chart-circle/circles.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/chart.js/chart.min.js') }}"></script>
<script>
  Circles.create({
    id:'circles-1',
    radius:45,
    value:60,
    maxValue:100,
    width:7,
    text: {!! $countProduk !!},
    colors:['#f1f1f1', '#FF9E27'],
    duration:300,
    wrpClass:'circles-wrp',
    textClass:'circles-text',
    styleWrapper:true,
    styleText:false
  })

  Circles.create({
    id:'circles-2',
    radius:45,
    value:50,
    maxValue:100,
    width:7,
    text: {!! $countKategori !!},
    colors:['#f1f1f1', '#2BB930'],
    duration:400,
    wrpClass:'circles-wrp',
    textClass:'circles-text',
    styleWrapper:true,
    styleText:false
  })
</script>
<script>
  var ctx = document.getElementById("barang-masuk").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: {!! json_encode($bulan_barang_masuk) !!},
      datasets: [{
        label: 'Jumlah Barang Masuk {!! $tahun !!}',
        data: {!! json_encode($barang_masuk) !!},
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
      borderWidth: 1
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true
          }
        }]
      }
    }
  });

  var ctx = document.getElementById("barang-keluar").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! json_encode($bulan_barang_keluar) !!},
      datasets: [{
        label: `Jumlah Barang Keluar {!! $tahun !!}`,
        data: {!! json_encode($barang_keluar) !!},
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
      borderWidth: 1
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true
          }
        }]
      }
    }
  });
</script>
@endpush
