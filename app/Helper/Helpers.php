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

function tangga($tanggal)
{
  $tanggal = Carbon::parse($tanggal)->format('d F Y');
  return $tanggal;
}
