<?php
session_start();
require_once 'functions.php';
// cek session admin atau staff
if (!middleware('staff')) {
  redirect('login');
} 
if (isset($_GET['kd-jasa'])) {
  $kdJasa = filter($_GET['kd-jasa']);
  $hapusPesanan = hapusPesanan($kdJasa);
  // cek apakah berhasil dihapus
  if ($hapusPesanan) {
    // ambil session kd jasa
    $sessionKdJasa = json_decode($_SESSION['kd-jasa'], true);
    // lalu hapus kd jasa tertentu
    if (($key = array_search($kdJasa, $sessionKdJasa)) !== false) {
      unset($sessionKdJasa[$key]);
    }
    $sessionKdJasa = array_unique($sessionKdJasa);
    // set session kd jasa
    $_SESSION['kd-jasa'] = json_encode($sessionKdJasa);
    $_SESSION['berhasil'] = 'Data Pesanan Berhasil Dihapus';
    redirect('pesanan');
  } else {
    $_SESSION['status'] = 'Data Pesanan Gagal Dihapus';
    redirect('pesanan');
  }
} else {
  redirect('pesanan');
}
