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
                        <a href="{{ $url }}">Purchase Order</a>
                    </li>
                </ul>
            </div>
            <div class="card shadow animate__animated animate__zoomInDown">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th>No. PB</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $pb->no_dokumen }}</td>
                                </tr>
                                <tr>
                                    <th>Request By</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $pb->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $pb->created_at }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <form class="form-produk">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="pb_id" value="{{ $pb->id }}" class="form-control" />
                                    <input type="hidden" name="produk_id" id="produk_id" class="form-control" />
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Cari produk"
                                            aria-describedby="basic-addon2" onclick="tampilModalProduk()">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <button onclick="tampilModalProduk()" class="btn btn-flat btn-primary">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table pb-detail-table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="35%">Nama</th>
                                        <th width="30%">Qty</th>
                                        <th>Satuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot align="center">
                                    <tr>
                                        <td colspan="2" class="text-bold">
                                            <h2 class="font-weight-bold text-uppercase">Total</h2>
                                        </td>
                                        <td colspan="2" class="font-weight-bold total_item">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-end d-flex">
                        <div class="col-md-2">
                            <button onclick="submitForm('{{ $url }}')" class="btn btn-success btn-flat">
                                Simpan <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @includeIf('admin.pb.create.modal_produk')
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>

    <script>
        load_data_pb_detail();

        function load_data_pb_detail() {
            $('.pb-detail-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('pb-detail.show', $pb->id) }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex",
                            searchable: false,
                            sortable: false
                        },
                        {
                            data: "nama_produk",
                            name: "nama_produk"
                        },
                        {
                            data: "qty",
                            name: "qty"
                        },
                        {
                            data: "satuan",
                            name: "satuan"
                        },
                        {
                            data: "aksi",
                            name: "aksi",
                            searchable: false,
                            sortable: false
                        },
                    ],
                    dom: 'Brt',
                    bShort: false,
                    pageLength: 15,
                    "lengthMenu": [15, 25, 50, 75, 100],
                    "language": {
                        "emptyTable": "Data tidak ada"
                    },

                })
                .on('draw.dt', function() {
                    loadForm();
                });
        }

        function refresh_data() {
            $('.pb-detail-table').DataTable().destroy();
            load_data_pb_detail();
        }

        // Ubah qty
        $('table').on('change', '.qty', function() {
            var qty = parseInt($(this).val()),
                stok = parseInt($(this).data('produk')),
                id = $(this).data('id');
            if (qty > stok) {
                alert_error('error', 'Jumlah quantity melebihi stok yang ada, stok yang tersedia adalah ' + stok);
                $(this).val(1);
                return;
            }
            if (qty <= 0) {
                alert_error('error', 'Jumlah quantity minimal 1!');
                $(this).val(1);
                return;
            }
            $.ajax({
                    url: `{{ url('/admin/pb-detail') }}/${id}`,
                    type: 'post',
                    data: {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'put',
                        'qty': qty,
                    }
                })
                .done(response => {
                    refresh_data();
                })
                .fail(errors => {
                    alert_error('error', 'Gagal update data!');
                    return;
                });
        });

        function tampilModalProduk() {
            event.preventDefault();
            $('.modal-produk').modal('show');
        }

        function pilihProduk(id) {
            event.preventDefault();
            var produk_id = document.getElementById("produk_id").value = id;
            tambahProduk();
            hideModalProduk();
        }

        function hideModalProduk() {
            $('.modal-produk').modal('hide');
        }

        function tambahProduk() {
            $.ajax({
                    url: "{{ route('pb-detail.store') }}",
                    type: "post",
                    data: $(".form-produk").serialize(),
                })
                .done(response => {
                    hideModalProduk();
                    alert_success('success', response.text);
                    refresh_data();
                })
                .fail(errors => {
                    alert_error('error', errors);
                    return;
                });
        }

        function submitForm(url) {
            event.preventDefault();
            let timerInterval;
            Swal.fire({
                html: 'Menyimpan dalam <b></b>.',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    Swal.fire({
                        title: 'Sukses',
                        text: 'Permintaan barang berhasil diajukan!',
                        confirmButtonText: `Lihat status PB`,
                        showCancelButton: true,
                        denyButtonText: `Tidak`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            location.href = url
                        }
                    })
                }
            })
        }

        // Delete data
        $('body').on('click', '.btn-delete', function(event) {
            event.preventDefault();
            var me = $(this),
                url = me.attr('href'),
                csrf_token = $('meta[name=csrf-token]').attr('content');
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    '_method': 'DELETE',
                    '_token': csrf_token
                },
                success: function(response) {
                    refresh_data();
                }
            });
        });

        function loadForm() {
            var total_item = $(".qty").data('total_item');
            if (total_item == undefined) {
                $(".total_item").html(`<h1 class="font-weight-bold">0</h1>`);
                return;
            }
            $(".total_item").html(`<h1 class="text-center font-weight-bold">` + total_item + `</h1>`);
        }
    </script>
@endpush
