<?php
session_start();
require_once 'functions.php';

// cek session admin atau staff
if (!middleware('staff')) {
  redirect('login');
} 
if (isset($_GET['id'])) {
  // ambil id
  $id = filter($_GET['id']);
  $hapusDetailPesan = hapusDetailPesanan($id);

  // cek apakah berhasil dihapus 
  if ($hapusDetailPesan) {
    $_SESSION['berhasil'] = 'Data Details Pesanan Berhasil Dihapus';
    redirect('pesanan');
  } else {
    $_SESSION['status'] = 'Data Details Pesanan Gagal Dihapus';
    redirect('pesanan');
  }

} else {
  redirect('divisi');
}
?>