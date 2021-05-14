<?php
session_start();
require_once 'functions.php';

// cek session admin atau staff
if (!middleware('staff')) {
  redirect('login');
}
if (isset($_GET['cari-divisi-pesanan'])) {
  // ambil cari data
  $cari = filter($_GET['cari-divisi-pesanan']);
  $cariDivisiPesanan = cariDataPesanan($cari);
} else {
  redirect('divisi');
}

?>

<?php foreach ($cariDivisiPesanan as $i => $divisi) : ?>
  <tr>
    <td><?= ++$i; ?></td>
    <td><?= $divisi['1819123_NmDivisi']; ?></td>
    <td><?= $divisi['1819123_Alamat']; ?></td>
    <td><?= $divisi['1819123_NoTelp']; ?></td>
    <td>
      <!-- Button trigger modal data jasa divisi -->
      <button type="button" data-iddivisi="<?= $divisi['1819123_IdDivisi']; ?>" class="btn btn-success btn-sm" data-toggle="modal" data-target="#dataJasaPesanan">
        <svg xmlns="http://www.w3.org/2000/svg" data-iddivisi="<?= $divisi['1819123_IdDivisi']; ?>" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
          <path d="M0 0h24v24H0V0z" fill="none" data-iddivisi="<?= $divisi['1819123_IdDivisi']; ?>" />
          <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" data-iddivisi="<?= $divisi['1819123_IdDivisi']; ?>" />
        </svg>Data Jasa
      </button>
    </td>
  </tr>
<?php endforeach; ?>