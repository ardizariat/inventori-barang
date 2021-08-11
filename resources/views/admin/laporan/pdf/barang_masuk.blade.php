<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/atlantis.min.css') }}">
    <script>
        function subst() {
            var vars = {};
            var query_strings_from_url = document.location.search.substring(1).split('&');
            for (var query_string in query_strings_from_url) {
                if (query_strings_from_url.hasOwnProperty(query_string)) {
                    var temp_var = query_strings_from_url[query_string].split('=', 2);
                    vars[temp_var[0]] = decodeURI(temp_var[1]);
                }
            }
            var css_selector_classes = ['page', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate',
                'time', 'title', 'doctitle', 'sitepage', 'sitepages'
            ];
            for (var css_class in css_selector_classes) {
                if (css_selector_classes.hasOwnProperty(css_class)) {
                    var element = document.getElementsByClassName(css_selector_classes[css_class]);
                    for (var j = 0; j < element.length; ++j) {
                        element[j].textContent = vars[css_selector_classes[css_class]];
                    }
                }
            }
        }
    </script>
    <title>Laporan</title>
</head>

<body class="bg-white">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h1 class="text-center">
                    <strong>Laporan Barang Masuk</strong>
                </h1>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <table>
                        <tr>
                            <th>Tanggal Ekspor Data</th>
                            <th>:</th>
                            <td>{{ $now }}</td>
                        </tr>
                        <tr>
                            <th>Periode</th>
                            <th>:</th>
                            <td>{{ tanggal($awal) . ' - ' . tanggal($akhir) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 ml-auto">
                    <table>
                        <tr>
                            <th>Total Item Produk</th>
                            <th>:</th>
                            <td> {{ $totalItemProduk }} Item</td>
                        </tr>
                        <tr>
                            <th>Total Produk Masuk</th>
                            <th>:</th>
                            <td> {{ $totalProdukMasuk }} Item</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row my-2">
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
            <div class="row my-3 mx-3">
                <p class="mb-5">Pembuat</p>
                <ins class="mt-5">( {{ auth()->user()->name }} )</ins>
            </div>
        </div>
    </div>
</body>

</html>
