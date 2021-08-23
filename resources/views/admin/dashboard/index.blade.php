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
                    <div class="col-md-6">
                        <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                    </div>
                    <div class="col-md-6">
                        <h2 id="timestamp" class="float-right text-white pb-2 fw-bold"></h2>
                        <h2 class="float-right text-white pb-2 fw-bold mr-3">{{ hari_ini() }}</h2>
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
                                        <h4 class="card-title">{{ number_format($countProduk, 0, ',', '.') }}</h4>
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
                                        <h4 class="card-title">{{ number_format($countKategori, 0, ',', '.') }}</h4>
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
                                        <h4 class="card-title">{!! formatAngka($rata2_barang_masuk_sebulan) !!}</h4>
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
                                        <h4 class="card-title">{!! formatAngka($rata2_barang_keluar_sebulan) !!}</h4>
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
                            <canvas id="barang_masuk"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card full-height">
                        <div class="card-body">
                            <canvas id="barang_keluar"></canvas>
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
        // Function ini dijalankan ketika Halaman ini dibuka pada browser
        $(function() {
            setInterval(timestamp, 1000); //fungsi yang dijalan setiap detik, 1000 = 1 detik
        });

        function timestamp() {
            $.ajax({
                url: "{{ route('dashboard.date') }}",
                success: function(data) {
                    $('#timestamp').html(data.timestamp);
                }
            });
        }
    </script>
    <script>
        var barang_masuk = document.getElementById('barang_masuk').getContext('2d');

        var data_barang_masuk = new Chart(barang_masuk, {
            type: 'line',
            data: {
                labels: {!! json_encode($bulan_barang_masuk) !!},
                datasets: [{
                    label: "Barang Masuk",
                    backgroundColor: 'rgb(23, 125, 255)',
                    borderColor: 'rgb(23, 125, 255)',
                    data: {!! json_encode($barang_masuk) !!},
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
            }
        });

        var barang_keluar = document.getElementById('barang_keluar').getContext('2d');

        var data_barang_keluar = new Chart(barang_keluar, {
            type: 'line',
            data: {
                labels: {!! json_encode($bulan_barang_keluar) !!},
                datasets: [{
                    label: "Barang Keluar",
                    backgroundColor: 'rgb(23, 125, 255)',
                    borderColor: 'rgb(23, 125, 255)',
                    data: {!! json_encode($barang_keluar) !!},
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
            }
        });
    </script>
@endpush
