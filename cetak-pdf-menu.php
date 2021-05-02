<?php 
session_start();

require_once 'functions.php';
// cek session admin atau staff
if (!middleware('staff')) {
  redirect('login');
}
// jika tidak ada id pindah kehalaman menu
if (!isset($_GET['id'])) {
  redirect('menu');
}

$idMieAyamBakso = filter($_GET['id']);

// get data mie ayam bakso berdasarkan id
$getDataMieAyamBaksoById = getDataMieAyamBaksoById($idMieAyamBakso)[0];

// kalau tidak ada data nya pindah halaman menu
if (!$getDataMieAyamBaksoById) {
  redirect('menu');
}

?>
<?= startHTML('Menu Pembayaran'); ?>
<style>
hr.header {
    border: 4px solid black;
  }

  hr.pembayaran {
    border: 1px solid black;
  }
  .colom-5 {
    flex: 0 0 50%;
    max-width: 45%;
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
  <hr class="header">
</div>

<!-- menu mie ayam spesial & bakso spesial -->
<div class="container mt-3">
    <h4 class="text-center mb-3">Menu Mie Ayam spesial + Es Teh & Menu Bakso spesial + Es Teh</h4>
    <div class="row">
      <div class="col-md-4"></div>
      <?php if (isset($getDataMieAyamBaksoById)) : ?>
        <div class="colom-5 mt-3">
          <!-- harga mie ayam -->
          <h5 class="d-inline">Harga Mie Ayam spesial : </h5>
          <strong>Rp.20.000</strong>
          <br><br>
          <!-- harga bakso -->
          <h5 class="d-inline">Harga Bakso spesial : </h5>
          <strong>Rp.14.000</strong>
          <hr class="pembayaran">
          <!-- jumlah mie ayam -->
          <h5 class="d-inline">Jumlah Pembelian Mie Ayam spesial : </h5>
          <strong><?= $getDataMieAyamBaksoById['1819123_jumlah_mieayam']; ?></strong>
          <?php 
            if ($getDataMieAyamBaksoById['1819123_jumlah_mieayam'] >= 5 && $getDataMieAyamBaksoById['1819123_jumlah_mieayam'] < 10) {
              echo '<small class="text-secondary">diskon 5%</small>';
            } else if ($getDataMieAyamBaksoById['1819123_jumlah_mieayam'] >= 10) {
              echo '<small class="text-secondary">diskon 10%</small>';
            }
          ?>
          <!-- jumlah bakso -->
          <br><br>
          <h5 class="d-inline">Jumlah Pembelian Bakso spesial : </h5>
          <strong><?= $getDataMieAyamBaksoById['1819123_jumlah_bakso']; ?></strong>
          <?php 
            if ($getDataMieAyamBaksoById['1819123_jumlah_bakso'] >= 5 && $getDataMieAyamBaksoById['1819123_jumlah_bakso'] < 10) {
              echo '<small class="text-secondary">diskon 5%</small>';
            } else if ($getDataMieAyamBaksoById['1819123_jumlah_bakso'] >= 10) {
              echo '<small class="text-secondary">diskon 10%</small>';
            }
          ?>

          <!-- total pembayaran -->
          <hr class="pembayaran">
          <h5 class="d-inline">Total Pembayaran : </h5>
          <strong>Rp.<?= $getDataMieAyamBaksoById['181923_total_harga']; ?></strong>

          <!-- uang pembayaran -->
          <br><br>
          <h5 class="d-inline">Uang Pembayaran : </h5>
          <strong>Rp.<?= $getDataMieAyamBaksoById['1819123_uang_pembayaran']; ?></strong>

          <!-- uang kembalian -->
          <br><br>
          <h5 class="d-inline">Uang Kembalian : </h5>
          <strong>Rp.<?= $getDataMieAyamBaksoById['uang_kembalian']; ?></strong>
        </div>
      <?php endif; ?>
  </div>
</div>

<script>
  window.print();
</script>
<?= endHTML(''); ?>
