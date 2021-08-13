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
                                    <th>Supplier</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $supplier->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $supplier->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telpon</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $supplier->telpon }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $supplier->alamat }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <form class="form-produk">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="purchase_order_id" value="{{ $purchase_order_id }}" />
                                    <input type="hidden" name="produk_id" class="form-control" id="produk_id" />
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Cari produk"
                                            aria-describedby="basic-addon2" onclick="tampilModalProduk()">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">
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
                            <table class="table" id="purchase-order-detail-table">
                                <thead align="center">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th width="22%">Qty</th>
                                        <th>Satuan</th>
                                        <th width="23%">Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot align="center">
                                    <tr>
                                        <td colspan="2" class="text-bold">
                                            <h2 class="font-weight-bold text-uppercase">Total</h2>
                                        </td>
                                        <td></td>
                                        <td class="font-weight-bold total_item">
                                        </td>
                                        <td colspan="3" width="50%" class="font-weight-bold total_harga">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center d-flex">
                        <div class="col-md-4">
                            <button onclick="submitForm('{{ $url }}')"
                                class="btn btn-outline-info btn-block btn-round btn-flat">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('admin.purchase_order.purchase_order_detail._modal_produk')
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>

    <script>
        load_data_purchase_order_detail();
        load_data_produk();

        function load_data_produk() {
            $('.produk-table').DataTable().destroy();
            $('.produk-table').DataTable();
        }

        function load_data_purchase_order_detail() {
            $('#purchase-order-detail-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('purchase-order-detail.data', $purchase_order_id) }}",
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
                        data: "harga",
                        name: "harga"
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
                        data: "subtotal",
                        name: "subtotal"
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

            }).on('draw.dt', function() {
                loadForm();
            });
        }

        function refresh_data() {
            $('#purchase-order-detail-table').DataTable().destroy();
            load_data_purchase_order_detail();
        }

        // Ubah qty
        $('table').on('keyup', '.qty', function() {
            var qty = parseInt($(this).val()),
                id = $(this).data('id');

            if (qty > 100000) {
                alert_error('error', 'Jumlah quantity tidak boleh lebih besar dari 100000!');
                $(this).val(100000);
                return;
            }
            if (qty < 1) {
                alert_error('error', 'Jumlah quantity minimal 1!');
                $(this).val(1);
                return;
            }
            $.post(`{{ url('/admin/purchase-order-detail') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'qty': qty
                })
                .done(response => {
                    refresh_data();
                })
                .fail(errors => {
                    alert_error('error', 'Gagal update data!');
                    return;
                });
        });

        function pilihProduk(id, kode) {
            event.preventDefault();
            var produk_id = document.getElementById("produk_id").value = id;
            hideModalProduk();
            tambahProduk();
        }

        function tampilModalProduk() {
            event.preventDefault();
            $('.modal-produk').modal('show');
        }

        function submitForm(url) {
            event.preventDefault();
            let timerInterval;
            Swal.fire({
                html: 'Menyimpan dalam <b></b>.',
                timer: 500,
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
                        text: 'PO berhasil dibuat!',
                        confirmButtonText: `Kembali ke daftar PO`,
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

        function hideModalProduk() {
            $('.modal-produk').modal('hide');
        }

        function tambahProduk() {
            $.ajax({
                    url: "{{ route('purchase-order-detail.store') }}",
                    type: "post",
                    data: $(".form-produk").serialize(),
                })
                .done(response => {
                    hideModalProduk();
                    alert_success('success', 'Data berhasil ditambahkan!');
                    refresh_data();
                })
                .fail(errors => {
                    alert_error('error', errors);
                    return;
                });
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
                    alert_success('success', response.text)
                    refresh_data();
                }
            });
        });

        function loadForm() {
            var total_item = $(".qty").data('total_item');
            var total_harga = $(".qty").data('total_harga');
            if (total_harga == undefined && total_item == undefined) {
                $(".total_harga").html(`<h1 class="font-weight-bold">Rp. 0</h1>`);
                $(".total_item").html(`<h1 class="font-weight-bold">0</h1>`);
                return;
            }
            $(".total_item").html(`<h1 class="text-center font-weight-bold">` + total_item + `</h1>`);
            $(".total_harga").html(`<h1 class="text-center font-weight-bold">Rp. ` + total_harga + `</h1>`);
        }
    </script>
@endpush
