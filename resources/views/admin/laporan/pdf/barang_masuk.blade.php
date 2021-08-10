@extends('admin.laporan.pdf.layouts')

@section('content-pdf')

    <header>
        <h1 class="text-bold text-center">Laporan Barang Masuk</h1>
    </header>
    <div class="card">
        <div class="card-header">
            Invoice
            <strong>01/01/01/2018</strong>
            <span class="float-right"> <strong>Status:</strong> Pending</span>

        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h6 class="mb-3">From:</h6>
                    <div>
                        <strong>Webz Poland</strong>
                    </div>
                    <div>Madalinskiego 8</div>
                    <div>71-101 Szczecin, Poland</div>
                    <div>Email: info@webz.com.pl</div>
                    <div>Phone: +48 444 666 3333</div>
                </div>

                <div class="col-sm-6">
                    <h6 class="mb-3">To:</h6>
                    <div>
                        <strong>Bob Mart</strong>
                    </div>
                    <div>Attn: Daniel Marek</div>
                    <div>43-190 Mikolow, Poland</div>
                    <div>Email: marek@daniel.com</div>
                    <div>Phone: +48 123 456 789</div>
                </div>
            </div>
            <hr class="bg-dark">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Penerima</th>
                                <th>Pemberi</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $in)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $in->product->nama_produk }}</td>
                                    <td>{{ $in->product->category->kategori }}</td>
                                    <td>{{ tanggal($in->tanggal) }}</td>
                                    <td>{{ $in->penerima }}</td>
                                    <td>{{ $in->pemberi }}</td>
                                    <td>{{ $in->jumlah }} {{ $in->product->satuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
