<?php
// cek session admin atau staff
session_start();
require_once 'functions.php';
// cek session login untuk admin
if (empty($_SESSION['hak-akses']) == 'admin' || empty($_SESSION['hak-akses']) == 'staff') {
  redirect('login');
} else if (isset($_GET['no-sp'])) {
  $noSp = filter($_GET['no-sp']);
  $getNotaByNoSp = getNotaByNoSP($noSp);
} else {
  redirect('cetak-nota');
}
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

$dataDivisi = [];
foreach ($getNotaByNoSp as $i => $divisi) {

  $dataDivisi = [
    $i => [
      '1819123_NmDivisi' => $divisi['1819123_NmDivisi'],
      '1819123_Alamat' => $divisi['1819123_Alamat'],
      '1819123_NoTelp' => $divisi['1819123_NoTelp']
    ]
  ];
}
// mengetahui total harga
$totalHarga = 0;
foreach ($getNotaByNoSp as $hargaPesan) {
  $totalHarga += $hargaPesan['Jumlah_Harga'];
}
?>

<?= startHTML('Cetak PDF'); ?>
<style>
  hr {
    border: 4px solid black;
  }
</style>
<div class="container-fluid mt-2">
  <img src="logo.png" alt="logo" width="100" height="100" />
  <div class="text-center" style="margin-top: -100px;">
    <h2>SMK MEDIA INFORMATIKA</h2>
    <p>
      Jl. Papan I/Pisangan Kretek No.99, Petukangan Selatan, Pesanggrahan, Jakarta 12270 <br>
      Telepon/Fax : (021) 2270 4966 Website : www.smkmediainformatika.sch.id
    </p>
    <hr>
    <h4>Nota</h4>
    <table class="table">
      <tr>
        <td>Tanggal Nota</td>
        <td>:</td>
        <td><?= $viewTanggalNota; ?></td>
        <td></td>
        <td>Nama Divisi</td>
        <td>:</td>
        <td><strong><?= $dataDivisi[0]['1819123_NmDivisi']; ?></strong></td>
      </tr>

      <tr>
        <td>Jumlah Bayar</td>
        <td>:</td>
        <td><strong>Rp.<?= $totalHarga; ?></strong></td>
        <td></td>
        <td>Alamat</td>
        <td>:</td>
        <td><strong><?= $dataDivisi[0]['1819123_Alamat']; ?></strong></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Telp</td>
        <td>:</td>
        <td>
          <strong><?= $dataDivisi[0]['1819123_NoTelp']; ?></strong>
        </td>
      </tr>
    </table>
  </div>
  <div class="mx-3">
    <table class="table table-bordered text-center">
      <thead>
       
          <tr>
            <th>Nama Jasa</th>
            <th>Jumlah Pesan</th>
            <th>Harga Pesan</th>
            <th>Jumlah Harga</th>
          </tr>
        
      </thead>
      <tbody>
      <?php foreach($getNotaByNoSp as $jasa) : ?>
        <tr>
          <td><?= $jasa['1819123_NmJasa']; ?></td>
          <td><?= $jasa['1819123_JmlPesan']; ?></td>
          <td>Rp.<?= $jasa['1819123_HrgPesan']; ?></td>
          <td>Rp.<?= $jasa['Jumlah_Harga']; ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="2"></td>
          <td>Total Harga</td>
          <td>
            <strong>Rp.<?= $totalHarga; ?></strong>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<script>window.print();</script>
<?php endHTML(); ?>
 