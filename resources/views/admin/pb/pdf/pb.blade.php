<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <title>{{ $title }}</title>
</head>

<body class="bg-white">
    <div class="container-fluid">
        <header class="mb-3">
            <h1 class="text-bold text-center">{{ $title }}</h1>
            <div class="row mt-2 d-flex justify-content-center">
                <table class="float-left mx-2">
                    <tr>
                        <th>No Dokumen</th>
                        <th>:</th>
                        <td> {{ $pb->no_dokumen }}</td>
                    </tr>
                    <tr>
                        <th>Request By</th>
                        <th>:</th>
                        <td> {{ $pb->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <th>:</th>
                        <td> {{ $pb->user->email }}</td>
                    </tr>
                </table>
                <table class="float-right mx-2">
                    <tr>
                        <th>Tanggal</th>
                        <th>:</th>
                        <td> {{ $pb->created_at->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <th>:</th>
                        <td class="text-capitalize"> {{ $pb->status_confirm_barang_keluar }} diterima</td>
                    </tr>
                    <tr>
                        <th>Total Item</th>
                        <th>:</th>
                        <td> {{ formatAngka($pb->total_item) }}</td>
                    </tr>
                </table>
            </div>
        </header>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pb_detail as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->nama_produk }}</td>
                                <td>{{ $item->product->category->kategori }}</td>
                                <td>{{ formatAngka($item->qty) }}</td>
                                <td>{{ $item->product->satuan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
