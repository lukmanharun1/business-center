<?php
session_start();
require_once 'functions.php';

// cek session admin
if (empty($_SESSION['admin'])) {
  redirect('login');
} else if (isset($_GET['1819123_KdJasa'])) {
  // ambil kd jasa
  $kdJasa = filter($_GET['1819123_KdJasa']);
  // hapus data berdasarkan kd jasa
  $hapusJasa = hapusJasaById($kdJasa);
  // cek apakah berhasil dihapus
  if ($hapusJasa) {
    $_SESSION['berhasil'] = 'Data Jasa Berhasil Dihapus';
    redirect('jasa');
  } else {
    $_SESSION['status'] = 'Data Jasa Gagal Dihapus';
    redirect('jasa');
  }
} else {
  redirect('jasa');
}
