<?php
session_start();
require_once 'functions.php';

// cek session admin
if (empty($_SESSION['admin'])) {
  redirect('login');
} else if (isset($_GET['1819123_IdDivisi'])) {
  // ambil idDivisi
  $idDivisi = filter($_GET['1819123_IdDivisi']);
  // hapus data berdasarkan idDivisi
  $hapusDivisi = hapusDivisiById($idDivisi);
  // cek apakah berhasil dihapus
  if ($hapusDivisi) {
    $_SESSION['berhasil'] = 'Data Divisi Berhasil Dihapus';
    redirect('form-admin');
  } else {
    $_SESSION['status'] = 'Data Divisi Gagal Dihapus';
    redirect('form-admin');
  }
} else {
  redirect('form-admin');
}
