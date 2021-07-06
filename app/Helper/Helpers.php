<?php

use App\Models\Gudang;
use App\Models\Produk;
use App\Models\Kategori;

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
