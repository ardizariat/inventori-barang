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
        {{-- <div class="ml-md-auto py-2 py-md-0">
          <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
          <a href="#" class="btn btn-secondary btn-round">Add Customer</a>
        </div> --}}
      </div>
    </div>
  </div>
  <div class="page-inner mt--5">
    <div class="row mt--2">
      <div class="col-md-8">
        <div class="card full-height">
          <div class="card-body">
            <div class="card-title">Statistik</div>
            {{-- <div class="card-category">Daily information about statistics in system</div> --}}
            <div class="d-flex flex-wrap justify-content-around pb-2 pt-2">
              <div class="px-2 pb-2 pb-md-0 text-center">
                <div id="circles-1"></div>
                <h6 class="fw-bold mt-3 mb-0">Produk</h6>
              </div>
              <div class="px-2 pb-2 pb-md-0 text-center">
                <div id="circles-2"></div>
                <h6 class="fw-bold mt-3 mb-0">Kategori</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card full-height">
          <div class="card-body">
            <div class="card-title">Data Barang</div>
            <div class="row py-3">
              <div class="col-md-12 d-flex flex-column justify-content-around">
                <div>
                  <h6 class="fw-bold text-uppercase text-success op-8">Total Barang Tersedia</h6>
                  <h3 class="fw-bold">{!! number_format($tersedia,0,',','.') !!}</h3>
                </div>
                <div>
                  <h6 class="fw-bold text-uppercase text-danger op-8">Total Barang Yang Mau Habis</h6>
                  <h3 class="fw-bold">{!! number_format($hampir_habis,0,',','.') !!}</h3>
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
<script src="{{ asset('admin/js/plugin/chart.js/Chart.min.js') }}"></script>
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
</script>
<script>
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
