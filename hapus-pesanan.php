<?php
// cek session admin atau staff
session_start();
require_once 'functions.php';
// cek session login untuk admin
if (empty($_SESSION['hak-akses']) == 'admin' || empty($_SESSION['hak-akses']) == 'staff') {
  redirect('login');
} else if (isset($_GET['no-sp'])) {
  $noSp = filter($_GET['no-sp']);
  $hapusPesanan = hapusPesanan($noSp);
  // cek apakah berhasil dihapus
  if ($hapusPesanan) {
    $_SESSION['berhasil'] = 'Data Pesanan Berhasil Dihapus';
    redirect('pesanan');
  } else {
    $_SESSION['status'] = 'Data Pesanan Gagal Dihapus';
    redirect('pesanan');
  }
} else {
  redirect('pesanan');
}
