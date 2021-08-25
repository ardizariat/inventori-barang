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
                        <a href="{{ $url }}">Permintaan pembelian barang PR</a>
                    </li>
                </ul>
            </div>
            <div class="card shadow animate__animated animate__zoomInDown">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <table>
                                <tr>
                                    <th>No. PR</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $pr->no_dokumen }}</td>
                                </tr>
                                <tr>
                                    <th>Request By</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $pr->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <th class="pl-5 pr-2">:</th>
                                    <td>{{ $pr->created_at->format('d-m-Y') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4 ml-auto">
                            <div class="float-right">
                                <form class="form-produk">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="pr_id" value="{{ $pr->id }}"
                                            class="form-control" />
                                        <input type="hidden" name="produk_id" id="produk_id" class="form-control" />
                                        <div class="input-group mb-3">
                                            <button onclick="showModal()" data-toggle="tooltip" data-placement="top"
                                                title="Tambah produk" class="btn btn-rounded btn-outline-primary">
                                                <i class="fa fa-plus" aria-hidden="true"></i> Tambah Produk
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table pr-detail-table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="18%">Nama</th>
                                        <th width="18%">Qty</th>
                                        <th width="18%">Satuan</th>
                                        <th width="18%">Harga</th>
                                        <th width="18%">Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot class="bg-light" align="center">
                                    <tr>
                                        <td colspan="2" class="text-bold">
                                            <h2 class="font-weight-bold text-uppercase">Total</h2>
                                        </td>
                                        <td colspan="2" class="font-weight-bold total_item">
                                        </td>
                                        <td colspan="3" class="font-weight-bold total_harga">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center d-flex">
                        <div class="col-md-4">
                            <button data-toggle="tooltip" data-placement="top" title="Batal"
                                onclick="batal(`{{ route('pr.cancel', $pr_id) }}`,`{{ route('pr.index') }}` )"
                                class="btn btn-danger btn-flat">
                                Batal <i class="fas fa-times"></i>
                            </button>
                            <button data-toggle="tooltip" data-placement="top" title="Ajukan permintaan pembelian barang"
                                onclick="submitForm('{{ route('pr.index') }}')" class="btn btn-dark btn-flat">
                                Ajukan PR <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @includeIf('admin.pr.create.modal_produk')
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
    <script>
        load_data_pr_detail();

        function load_data_pr_detail() {
            $('.pr-detail-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('pr-detail.show', $pr_id) }}",
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
                            data: "harga",
                            name: "harga"
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

                })
                .on('draw.dt', function() {
                    loadForm();
                });
        }

        function refresh_data() {
            $('.pr-detail-table').DataTable().destroy();
            load_data_pr_detail();
        }

        function showModal() {
            event.preventDefault();
            $('.modal-produk').modal('show');
            $('.modal-produk form')[0].reset();
            let form = $('.modal-produk form');
            form.find('.invalid-feedback').remove();
            form.find('.form-control').removeClass('is-invalid');
        }

        function hideModal() {
            $('.modal-produk form')[0].reset();
            let form = $('.modal-produk form');
            form.find('.invalid-feedback').remove();
            form.find('.form-control').removeClass('is-invalid');
            $('.modal-produk').modal('hide');
        }

        // store produk
        $(function() {
            $('form').on('click', '.btn-save', function(e) {
                e.preventDefault();
                let form = $('.modal-produk form'),
                    url = form.attr('action'),
                    method = form.attr('method');
                form.find('.invalid-feedback').remove();
                form.find('.form-control').removeClass('is-invalid');

                $.ajax({
                        url: url,
                        type: method,
                        beforeSend: function() {
                            loading();
                        },
                        complete: function() {
                            hideLoader();
                        },
                        data: new FormData($(form)[0]),
                        async: false,
                        processData: false,
                        contentType: false,
                    })
                    .done(response => {
                        hideModal()
                        form[0].reset();
                        $('.show-image').addClass('d-none');
                        $('.selectpicker').val(null).trigger('change');
                        alert_success('success', response.text);
                        refresh_data();
                    })
                    .fail(errors => {
                        if (errors.status == 422) {
                            loopErrors(errors.responseJSON.errors);
                        } else {
                            alert_error('error', 'Gagal!');
                            return;
                        }
                    });
            });

            $('.pr-detail-table').on('change', '.qty', function() {
                let qty = parseInt($(this).val()),
                    id = $(this).data('id');

                if (qty <= 0) {
                    alert_error('error', 'Jumlah quantity minimal 1!');
                    $(this).val(1);
                    return;
                }
                if (qty >= 100000) {
                    alert_error('error', 'Jumlah quantity maksimal 100.000!');
                    $(this).val(1);
                    return;
                }

                $.ajax({
                        url: `{{ url('/admin/pr-detail') }}/${id}`,
                        type: `post`,
                        data: {
                            '_token': $(`meta[name=csrf-token]`).attr(`content`),
                            '_method': `put`,
                            'qty': qty
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
        });

        function loadForm() {
            var total_item = $(".qty").data('total_item'),
                total_harga = $(".qty").data('total_harga');
            if (total_item == undefined) {
                $(".total_item").html(`<h1 class="font-weight-bold">0</h1>`);
                return;
            }
            if (total_harga == undefined) {
                $(".total_harga").html(`<h1 class="font-weight-bold">0</h1>`);
                return;
            }
            $(".total_item").html(`<h1 class="text-center font-weight-bold">` + total_item + ` item </h1>`);
            $(".total_harga").html(`<h1 class="text-center font-weight-bold">Rp ` + total_harga + `</h1>`);
        }

        function deleteItem(url) {
            event.preventDefault();
            $.ajax({
                    url: url,
                    type: `post`,
                    data: {
                        '_token': $(`meta[name=csrf-token]`).attr(`content`),
                        '_method': `delete`,
                    }
                })
                .done(response => {
                    refresh_data();
                })
                .fail(errors => {
                    alert_error('error', 'Gagal update data!');
                    return;
                })
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
                        confirmButtonText: `Lihat status PR`,
                        showCancelButton: true,
                        cancelButtonText: `Tetap dihalaman ini`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = url
                        }
                    })
                }
            })
        }

        function batal(url, urlIndex) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah kamu yakin membatalkan request PR ini?',
                text: "Jika anda membatalkan, maka semua form yang anda isi akan terhapus semua!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin!',
                cancelButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: url,
                            type: `post`,
                            data: {
                                '_token': $(`meta[name=csrf-token]`).attr(`content`),
                                '_method': `delete`,
                            }
                        })
                        .done(response => {
                            location.href = urlIndex;
                        })
                        .fail(errors => {
                            alert_error('error', 'Ada yang error!');
                            return;
                        });
                }
            });
        }
    </script>
@endpush
