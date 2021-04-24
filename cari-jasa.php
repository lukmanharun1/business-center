<?php
session_start();
require_once 'functions.php';

// cek session admin
if (empty($_SESSION['admin'])) {
  redirect('login');
} else if (isset($_GET['cari'])) {
  // ambil cari data
  $cari = filter($_GET['cari']);
  $cariJasa = cariJasa($cari);
} else {
  redirect('form-admin');
}

?>

<?php foreach ($cariJasa as $i => $cari) : ?>
  <tr>
    <td><?= ++$i; ?></td>
    <td><?= $cari['1819123_NmJasa']; ?></td>
    <td><?= $cari['1819123_LamaJasa']; ?></td>
    <td><?= $cari['1819123_HrgJasa']; ?></td>
    <td>
      <!-- tombol update -->
      <button type="button" class="btn btn-success btn-sm tombol-update" data-toggle="modal" data-target="#exampleModal" data-divisi="<?= $cari['1819123_IdDivisi']; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="#fff" width="24" height="24" data-divisi="<?= $cari['1819123_IdDivisi']; ?>" class="tombol-update">
          <path d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z" data-divisi="<?= $cari['1819123_IdDivisi']; ?>" class="tombol-update" />
        </svg>
      </button>
      <!-- tombol hapus -->
      <a href="#" class="btn btn-success btn-sm tombol-hapus" data-divisi="<?= $cari['1819123_IdDivisi']; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff" data-divisi="<?= $cari['1819123_IdDivisi']; ?>" class="tombol-hapus">
          <path d="M0 0h24v24H0V0z" fill="none" data-divisi="<?= $cari['1819123_IdDivisi']; ?>" class="tombol-hapus" />
          <path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-3.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z" data-divisi="<?= $cari['1819123_IdDivisi']; ?>" class="tombol-hapus" />
        </svg>
      </a>
    </td>
  </tr>
<?php endforeach; ?>