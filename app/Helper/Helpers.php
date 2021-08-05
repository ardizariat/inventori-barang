<?php

use Carbon\Carbon;
use App\Models\Gudang;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

function kode($value, $threshold = null)
{
  return sprintf("%0" . $threshold . "s", $value);
}

function formatAngka($angka)
{
  return number_format($angka, 0, ',', '.');
}

function countProduk()
{
  $produk = Produk::count();
  return formatAngka($produk);
}

function countKategori()
{
  $kategori = Kategori::count();
  return formatAngka($kategori);
}

function countGudang()
{
  $gudang = Gudang::count();
  return formatAngka($gudang);
}

function stok()
{
  $produk = DB::table('produk')->whereColumn('stok', '<=', 'minimal_stok')->count();

  return $produk;
}

function messageStok()
{
  $products = DB::table('produk')->whereColumn('stok', '<=', 'minimal_stok')->get();
  return $products;
}

function tanggal($tanggal)
{
  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);

  return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function hari_ini()
{
  date_default_timezone_set('Asia/Jakarta');
  $hari = date("D");

  switch ($hari) {
    case 'Sun':
      $hari_ini = "Minggu";
      break;

    case 'Mon':
      $hari_ini = "Senin";
      break;

    case 'Tue':
      $hari_ini = "Selasa";
      break;

    case 'Wed':
      $hari_ini = "Rabu";
      break;

    case 'Thu':
      $hari_ini = "Kamis";
      break;

    case 'Fri':
      $hari_ini = "Jumat";
      break;

    case 'Sat':
      $hari_ini = "Sabtu";
      break;

    default:
      $hari_ini = "Tidak di ketahui";
      break;
  }

  $tanggal = date('Y-m-d');

  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);

  return $hari_ini . ', ' . $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function bulan($tanggal)
{
  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);

  return  $bulan[(int)$pecahkan[1]];
}
