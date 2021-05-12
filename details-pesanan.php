<?php
session_start();
require_once 'functions.php';

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
  redirect('divisi');
}
?>


  <ul class="list-group">
    <!-- nama divisi -->
    <li class="list-group-item">
      Nama Divisi : <strong><?= $detailsPesananDivisi['1819123_NmDivisi']; ?></strong>
    </li>
    <!-- alamat divisi -->
    <li class="list-group-item">
      Alamat Divsi : <strong><?= $detailsPesananDivisi['1819123_Alamat']; ?></strong>
    </li>
    <!-- nomor telp -->
    <li class="list-group-item">
      Nomor Telp : <strong><?= $detailsPesananDivisi['1819123_NoTelp']; ?></strong>
    </li>
    <!-- tanggal pesanan -->
    <li class="list-group-item">
      Tanggal Pesanan : <strong><?= $detailsPesananDivisi['1819123_TglSP']; ?></strong>
    </li>
  </ul>
  <br>

  <!-- data jasa -->
  <table class="table">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Aksi</th>
        <th scope="col">Nama Jasa</th>
        <th scope="col">Lama Jasa</th>
        <th scope="col">Jumlah Pesan</th>
        <th scope="col">Harga Pesan</th>
        <th scope="col">Jumlah Harga</th>
      </tr>
    </thead>
    <tbody>
      <?php $totalHarga = 0; ?>
      <?php foreach ($detailsPesananJasa as $i => $jasa) : ?>
        <tr>
          <td><?= ++$i; ?></td>
          <td>
            <!-- tombol hapus details pesan -->
            <a href="#" class="btn btn-success btn-sm tombol-hapus-details-pesanan" data-id="<?= $jasa['id']; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff" data-id="<?= $jasa['id']; ?>" class="tombol-hapus-details-pesanan">
                <path d="M0 0h24v24H0V0z" fill="none" data-id="<?= $jasa['id']; ?>" class="tombol-hapus-details-pesanan" />
                <path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-3.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z" data-id="<?= $jasa['id']; ?>" class="tombol-hapus-details-pesanan" />
              </svg>
            </a>
          </td>
          <td><?= $jasa['1819123_NmJasa']; ?></td>
          <td><?= $jasa['1819123_LamaJasa']; ?> Hari</td>
          <td><?= $jasa['1819123_JmlPesan']; ?></td>
          <td>Rp.<?= formatRp($jasa['1819123_HrgPesan']); ?></td>
          <td>Rp.<?= formatRp($jasa['Jumlah_Harga']); ?></td>
        </tr>
        <?php $totalHarga += $jasa['Jumlah_Harga']; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
  <!-- total harga -->
  <h6 class="text-right mr-5">Total Harga : Rp.<b class="text-success"><?= formatRp($totalHarga); ?></b></h6>
