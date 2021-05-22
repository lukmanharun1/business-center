<?php
// cek session admin atau staff
session_start();
require_once 'functions.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Cetak Nota.xls");
// cek session admin atau staff
if (!middleware('staff')) {
  redirect('login');
} 
if (isset($_GET['nosp'])) {
  // ambil cari data divisi berdasarkan nosp
  $noSp = filter($_GET['nosp']);
  $detailsPesananDivisi = detailsPesananDivisi($noSp)[0];
  // ambil data jasa berdasarkan nosp
  $detailsPesananJasa = detailsPesananJasa($noSp);
} else {
  redirect('login');
}
$tanggalNota = date('Y-m-d');

$totalHarga = 0;
foreach ($detailsPesananJasa as $jasa) {
  $totalHarga += $jasa['Jumlah_Harga'];
}
?>

<?= startHTML('Cetak Excel'); ?>
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
        <td><?= $tanggalNota; ?></td>
        <td></td>
        <td>Nama Divisi</td>
        <td>:</td>
        <td><strong><?= $detailsPesananDivisi['1819123_NmDivisi']; ?></strong></td>
      </tr>

      <tr>
        <td>Jumlah Bayar</td>
        <td>:</td>
        <td><strong>Rp.<?= formatRp($totalHarga); ?></strong></td>
        <td></td>
        <td>Alamat</td>
        <td>:</td>
        <td><strong><?= $detailsPesananDivisi['1819123_Alamat']; ?></strong></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Telp</td>
        <td>:</td>
        <td>
          <strong><?= $detailsPesananDivisi['1819123_NoTelp']; ?></strong>
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
      <?php foreach($detailsPesananJasa as $jasa) : ?>
        <tr>
          <td><?= $jasa['1819123_NmJasa']; ?></td>
          <td><?= $jasa['1819123_JmlPesan']; ?></td>
          <td>Rp.<?= formatRp($jasa['1819123_HrgPesan']); ?></td>
          <td>Rp.<?= formatRp($jasa['Jumlah_Harga']); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="2"></td>
          <td>Total Harga</td>
          <td>
            <strong>Rp.<?= formatRp($totalHarga); ?></strong>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<?php endHTML(); ?>
 