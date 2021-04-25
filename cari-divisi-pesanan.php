<?php
session_start();
require_once 'functions.php';

// cek session admin || staff
if (empty($_SESSION['hak-akses']) == 'admin' || empty($_SESSION['hak-akses']) == 'admin') {
  redirect('login');
} else if (isset($_GET['cari'])) {
  // ambil cari data
  $cari = filter($_GET['cari']);
  $cariDivisi = cariDivisi($cari);
} else {
  redirect('form-admin');
}

?>

<thead>
  <tr>
    <th>Nama Divisi</th>
    <th>Alamat Divisi</th>
    <th>Nomor Telp</th>

  </tr>
</thead>
<tbody>
  <?php foreach ($cariDivisi as $i => $divisi) : ?>
    <tr>
      <td><?= $divisi['1819123_NmDivisi']; ?></td>
      <td><?= $divisi['1819123_Alamat']; ?></td>
      <td><?= $divisi['1819123_NoTelp']; ?>
        <!-- tambahkan data divisi -->
        <button type="submit" class="btn btn-success btn-sm">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
          </svg>
          Data Divisi
        </button>
      </td>
    </tr>
  <?php endforeach; ?>
</tbody>