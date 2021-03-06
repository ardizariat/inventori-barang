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
            <a href="{{ $url }}">Permintaan barang PB</a>
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
                    <input type="text" class="form-control" placeholder="Cari produk" aria-describedby="basic-addon2"
                      onclick="tampilModalProduk()">
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
          <div class="table-responsive">
              <table class="table pb-detail-table">
                <thead>
                  <tr>
                    <th width="3%">No</th>
                    <th>Nama</th>
                    <th width="10%">Harga</th>
                    <th scope="col" width="50%">Qty</th>
                    <th>Satuan</th>
                    <th>Subtotal</th>
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
          <div class="row justify-content-center mt-3 d-flex">
            <div class="col-md-4">
              <button data-toggle="tooltip" data-placement="top" title="Ajukan permintaan barang"
                onclick="submitForm('{{ route('pb.index') }}')" class="btn btn-block btn-round btn-dark btn-flat">
                Ajukan PB <i class="fas fa-save"></i>
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
    load_data_produk();

    function load_data_produk() {
      $('.produk-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('pb-detail.produk', $pb->id) }}",
        columns: [{
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            searchable: false,
            sortable: false
          },
          {
            data: "kode",
            name: "kode"
          },
          {
            data: "nama_produk",
            name: "nama_produk"
          },
          {
            data: "stok",
            name: "stok"
          },
          {
            data: "aksi",
            name: "aksi",
            searchable: false,
            sortable: false
          },
        ],
        pageLength: 15,
        "lengthMenu": [15, 25, 50, 75, 100],
        "language": {
          "emptyTable": "Data tidak ada"
        },
      })
    }

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
      $('.produk-table').DataTable().ajax.reload();
      $('.modal-produk').modal('show');
    }

    function pilihProduk(id) {
      event.preventDefault();
      var produk_id = document.getElementById("produk_id").value = id;
      $('.produk-table').DataTable().ajax.reload();
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
              $.ajax({
                  url: url,
                  type: 'get',
                })
                .done(response => {
                  location.href = url
                })
                .fail(errors => {
                  alert_error('error', errors);
                  return;
                });
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
  </script>
@endpush
