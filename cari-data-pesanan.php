<?php
session_start();
require_once 'functions.php';

// cek session admin atau staff
if (!middleware('staff')) {
  redirect('login');
}
if (isset($_GET['cari-data-pesanan'])) {
  // ambil cari data pesanan
  $cari = filter($_GET['cari-data-pesanan']);
  $cariDataPesanan = cariDataPesanan($cari);
} else {
  redirect('divisi');
}

?>

<?php foreach ($cariDataPesanan as $i => $pesanan) : ?>
  <tr>
    <td><?= ++$i; ?></td>
    <td><?= $pesanan['1819123_NmDivisi']; ?></td>
    <td><?= $pesanan['1819123_Alamat']; ?></td>
    <td><?= $pesanan['1819123_NoTelp']; ?></td>
    <td><?= $pesanan['1819123_TglSP']; ?></td>
    <td>
      <!-- Button trigger modal -->

      <!-- tombol details pesanan -->
      <button type="button" data-nosp="<?= $pesanan['1819123_NoSP']; ?>" class="btn btn-success btn-sm details-pesan" data-toggle="modal" data-target="#detailsPesan">
        <svg xmlns="http://www.w3.org/2000/svg" class="details-pesan" data-nosp="<?= $pesanan['1819123_NoSP']; ?>" height="24" viewBox="0 0 24 24" width="24" fill="#fff">
          <path d="M0 0h24v24H0z" fill="none"data-nosp="<?= $pesanan['1819123_NoSP']; ?>" class="details-pesan" />
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" data-nosp="<?= $pesanan['1819123_NoSP']; ?>" class="details-pesan" />
        </svg> Details Pesanan
      </button>
      <br>
      <!-- tombol tambah lagi data jasa -->
      <button type="button" data-nosp="<?= $pesanan['1819123_NoSP']; ?>" class="btn btn-success btn-sm mt-2 tambah-lagi" data-toggle="modal" data-target="#tambahDataJasa">
        <svg xmlns="http://www.w3.org/2000/svg" class="tambah-lagi" data-nosp="<?= $pesanan['1819123_NoSP']; ?>" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
          <path d="M0 0h24v24H0V0z" fill="none" data-nosp="<?= $pesanan['1819123_NoSP']; ?>" class="tambah-lagi" />
          <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" class="tambah-lagi" data-nosp="<?= $pesanan['1819123_NoSP']; ?>" />
        </svg>Lagi Data Jasa
      </button>
    </td>
  </tr>
<?php endforeach; ?>