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
          <h5 class="text-white op-7 mb-2">Free Bootstrap 4 Admin Dashboard</h5>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
          <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
          <a href="#" class="btn btn-secondary btn-round">Add Customer</a>
        </div>
      </div>
    </div>
  </div>
  <div class="page-inner mt--5">
    <div class="row mt--2">
      <div class="col-md-6">
        <div class="card full-height">
          <div class="card-body">
            <div class="card-title">Overall statistics</div>
            <div class="card-category">Daily information about statistics in system</div>
            <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
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
      <div class="col-md-6">
        <div class="card full-height">
          <div class="card-body">
            <div class="card-title">Total income & spend statistics</div>
            <div class="row py-3">
              <div class="col-md-4 d-flex flex-column justify-content-around">
                <div>
                  <h6 class="fw-bold text-uppercase text-success op-8">Total Income</h6>
                  <h3 class="fw-bold">$9.782</h3>
                </div>
                <div>
                  <h6 class="fw-bold text-uppercase text-danger op-8">Total Spend</h6>
                  <h3 class="fw-bold">$1,248</h3>
                </div>
              </div>
              <div class="col-md-8">
                <div id="chart-container">
                  <canvas id="totalIncomeChart"></canvas>
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
            <div id="stok"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="{{ asset('admin/js/plugin/chart-circle/circles.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/highcharts/highcharts.js') }}"></script>
<script>
  Circles.create({
    id:'circles-1',
    radius:45,
    value:60,
    maxValue:100,
    width:7,
    text: {!! $countProduk !!},
    colors:['#f1f1f1', '#FF9E27'],
    duration:400,
    wrpClass:'circles-wrp',
    textClass:'circles-text',
    styleWrapper:true,
    styleText:true
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
    styleText:true
  })

  Highcharts.chart('stok', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Average Rainfall'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: {
        categories: {!! json_encode($bulan) !!},
        crosshair: true,
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Rainfall (mm)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Barang Masuk',
        data: {!! json_encode($total) !!},
    }]
  });
</script>
@endpush
