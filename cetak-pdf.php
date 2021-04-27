<?php
// cek session admin atau staff
session_start();
require_once 'functions.php';
// ini untuk dimasukan pesanan di database
$tanggalPesanan = date('d-m-Y');
// ini untuk view
$namaBulan = [
  '01' => 'januari',
  '02' => 'februari',
  '03' => 'Maret',
  '04' => 'April',
  '05' => 'Mei',
  '06' => 'Juni',
  '07' => 'Juli',
  '08' => 'Agustus',
  '09' => 'September',
  '10' => 'Oktober',
  '11' => 'November',
  '12' => 'Desember'
];

$bulan = $namaBulan[date('m')];
$viewTanggalNota = date("d-") . $bulan . date('-Y');

// cek session login untuk admin
if (empty($_SESSION['hak-akses']) == 'admin' || empty($_SESSION['hak-akses']) == 'staff') {
  redirect('login');
} else if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}

?>

<?= startHTML('Cetak PDF'); ?>
<div class="container-fluid mt-2">
  <img src="logo.png" alt="logo" width="100" height="100" />
  <div class="text-center" style="margin-top: -100px;">
    <h2>SMK MEDIA INFORMATIKA</h2>
    <p>
      Jl. Papan I/Pisangan Kretek No.99, Petukangan Selatan, Pesanggrahan, Jakarta 12270 <br>
      Telepon/Fax : (021) 2270 4966 Website : www.smkmediainformatika.sch.id
    </p>
    <hr>
    <p>Nota</p>
    <table class="table">
      <tr>
        <td>Tanggal Nota</td>
        <td>:</td>
        <td>value tanggal</td>
        <td></td>
        <td>Nama Divisi</td>
        <td>:</td>
        <td>value divisi</td>
      </tr>

      <tr>
        <td>Jumlah Bayar</td>
        <td>:</td>
        <td>value bayar</td>
        <td></td>
        <td>Alamat</td>
        <td>:</td>
        <td>value Alamat</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Telp</td>
        <td>:</td>
        <td>value telpon</td>
      </tr>
    </table>
  </div>
</div>
<?php endHTML(); ?>