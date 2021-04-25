<?php
session_start();
require_once 'functions.php';

// cek session admin || staff
if (empty($_SESSION['hak-akses']) == 'admin' || empty($_SESSION['hak-akses']) == 'staff') {
  redirect('login');
} else if (isset($_GET['cari'])) {
  // ambil cari data
  $cari = filter($_GET['cari']);
  $cariJasa = cariJasa($cari);
} else {
  redirect('form-admin');
}

?>

<thead>
  <tr>
    <th>Nama Jasa</th>
    <th>Lama Jasa</th>
    <th>Harga Jasa</th>
  </tr>
</thead>
<tbody>
  <?php foreach ($cariJasa as $i => $cari) : ?>
    <tr>
      <td><?= $cari['1819123_NmJasa']; ?></td>
      <td><?= $cari['1819123_LamaJasa']; ?> Hari</td>
      <td>Rp. <?= $cari['1819123_HrgJasa']; ?>
        <!-- tambahkan data pesanan -->
        <form action="" method="POST" class="ml-2 d-inline-block">
          <input type="hidden" name="kd-jasa" value="<?= $cari['1819123_KdJasa']; ?>" />
          <button type="submit" name="tambahkan-jasa" class="btn btn-success btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
            </svg>
            Data Jasa
          </button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</tbody>