<?php

session_start();
require_once 'functions.php';
// cek session login untuk admin
if (!middleware('admin')) {
  redirect('login');
}
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}
// ketika tombol tambah diklik
if (isset($_POST['tambah'])) {
  $namaDivisi = filter($_POST['nama-divisi']);
  $alamatDivisi = filter($_POST['alamat-divisi']);
  $noTelpDivisi = filter($_POST['nomor-telp']);
  // cek validasi nama divisi minimal 3 karakter
  if (strlen($namaDivisi) < 3) {
    $status = 'Nama Divisi Terlalu Pendek!';
  }
  // cek validasi alamat divisi minimal 25 karaketer
  else if (strlen($alamatDivisi) < 25) {
    $status = 'Alamat Divisi Terlalu Pendek!';
  }
  // cek nomor telp harus diawali angka 08

  else if (substr($noTelpDivisi, 0, 2) !== '08') {
    $status = 'Nomor Telp Harus Diawali angka 08';
  }
  // cek validasi nomor telp minimal 11 karakter maksimal 13 karakter

  else if (strlen($noTelpDivisi) < 11 && strlen($namaDivisi) < 13) {

    $status = 'Nomor Telp minimal 11 karakter maksimal 13 karakter';
  } else {
    // berarti lolos validasi
    $tambahDataDivisi = tambahDataDivsi($namaDivisi, $alamatDivisi, $noTelpDivisi);
    // cek apakah data berhasil ditambahkan
    if ($tambahDataDivisi) {
      $berhasil = 'Data Divisi Berhasil Ditambahkan';
    } else {
      $status = 'Data Divisi Gagal Ditambahkan';
    }
  }
}

// ketika tombol update diklik
if (isset($_POST['update'])) {
  $idDivisi = filter($_POST['id-divisi']);
  $namaDivisi = filter($_POST['nama-divisi']);
  $alamatDivisi = filter($_POST['alamat-divisi']);
  $noTelpDivisi = filter($_POST['nomor-telp']);
  // cek validasi nama divisi minimal 3 karakter
  if (strlen($namaDivisi) < 3) {
    $status = 'Nama Divisi Terlalu Pendek!';
  }
  // cek validasi alamat divisi minimal 25 karaketer
  else if (strlen($alamatDivisi) < 25) {
    $status = 'Alamat Divisi Terlalu Pendek!';
  }
  // cek nomor telp

  else if (substr($noTelpDivisi, 0, 1) !== '0') {
    $status = 'Nomor Telp Harus Diawali angka 0';
  }
  // cek validasi nomor telp minimal 11 karakter maksimal 13 karakter

  else if (strlen($noTelpDivisi) < 11 && strlen($namaDivisi) < 13) {

    $status = 'Nomor Telp minimal 11 karakter maksimal 13 karakter';
  } else {
    // berarti lolos validasi
    $updateDataDivisi = updateDataDivsi($namaDivisi, $alamatDivisi, $noTelpDivisi, $idDivisi);
    // cek apakah data berhasil diupdate
    if ($updateDataDivisi) {
      $berhasil = 'Data Divisi Berhasil Diupdate';
    } else {
      $status = 'Data Divisi Gagal Diupdate';
    }
  }
}
$getAllDataDivisi = getAllDataDivisi();


?>
<?= startHTML('Form Admin Data Divisi', '<script src="sweetalert.min.js"></script>'); ?>
<?php
if (isset($_SESSION['message'])) {
  // cek message contoh -> selamat anda berhasil login sebagai admin
  echo '
          <script>
            swal({
              title: "Selamat ..",
              text: " ' . $_SESSION['message'] . ' ",
              icon: "success",
            });
        </script>';
  // hapus session message
  unset($_SESSION['message']);
}
// cek apakah variabel status ada?
// kalau ada tampilkan
if (isset($status)) {
  echo '<script>
							swal({
							title: "Opps ..",
							text: " ' . $status . ' ",
							icon: "error",
						});
					</script>';
  // hapus variabel
  unset($status);
}
// cek apakah variabel berhasil ada?
// kalau ada tampilkan
else if (isset($berhasil)) {
  echo '<script>
						swal({
						title: "Selamat ..",
						text: " ' . $berhasil . ' ",
						icon: "success",
					});
				</script>';
  // hapus variabel
  unset($berhasil);
} else if (isset($_SESSION['berhasil'])) {
  echo '<script>
						swal({
						title: "Selamat ..",
						text: " ' . $_SESSION['berhasil'] . ' ",
						icon: "success",
					});
				</script>';
  // hapus variabel
  unset($_SESSION['berhasil']);
} else if (isset($_SESSION['status'])) {
  echo '<script>
						swal({
						title: "Opps ..",
						text: " ' . $_SESSION['status'] . ' ",
						icon: "error",
					});
				</script>';
  // hapus variabel
  unset($_SESSION['status']);
}
?>
<style>
  .active {
    color: white !important;
  }

  .nav-link:hover {
    color: white !important;
  }

  thead {
    color: white;
    background-color: #28a745;
  }

  table.table thead tr th {
    border: 1px solid #28a745;
  }

  .form-icon {
    left: 5px;
    top: 39px;
    position: absolute;

  }

  .icon-cari {
    left: 5px;
    top: 8px;
    position: absolute;
  }

  .form-control {
    padding-left: 2rem;
  }

  .tombol-logout:hover {
    color: #28a745 !important;
    background-color: #ededed;
  }

  .tombol-hapus:hover {
    background-color: #dc3545;
    border-color: #dc3545;
  }
</style>

<!-- START: navbar -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #28a745;">
  <a class="navbar-brand" href="divisi.php">
    <img src="logo.png" alt="logo metik" width="60" height="50" />
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
    <?php if (middleware('admin')) : ?>
      <a class="nav-link active" href="#">Divisi <span class="sr-only">(current)</span></a>
      <a class="nav-link" href="jasa.php">Jasa</a>
    <?php endif; ?>
      <a class="nav-link" href="pesanan.php">Pesanan</a>
      <a class="nav-link" href="cetak-nota.php">Cetak Nota</a>
    </div>
  </div>
  <span class="navbar-text text-white mr-5">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
      <path d="M0 0h24v24H0V0z" fill="none" />
      <path d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
    </svg> <?= $username; ?>
    <a href="logout.php" class="text-white ml-2 btn btn-outline-light tombol-logout">Logout</a>
  </span>
</nav>
<!-- END: navbar -->

<h1 class="text-center mt-3">Form Entry Data Divisi</h1>

<div class="container mt-3">
  <!-- Button trigger modal -->
  <!-- tombol tambah -->
  <div class="row">
    <button type="button" class="btn btn-success mb-3 ml-3" id="tombol-tambah" data-toggle="modal" data-target="#exampleModal">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
        <path d="M0 0h24v24H0V0z" fill="none" />
        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
      </svg> Tambah Entry Data Divisi
    </button>
    <!-- cari data divisi -->
    <div class="col-md-5">
      <div class="form-group position-relative">
        <!-- icon cari -->
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="icon-cari">
          <path d="M0 0h24v24H0V0z" fill="none" />
          <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
        </svg>
        <input type="text" class="form-control" id="cari-divisi" placeholder="cari nama divisi | alamat divisi | no telp" />
      </div>
    </div>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Divisi</th>
        <th scope="col">Alamat Divisi</th>
        <th scope="col">Nomor Telp</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($getAllDataDivisi as $i => $divisi) : ?>
        <tr>
          <td><?= ++$i; ?></td>
          <td><?= $divisi['1819123_NmDivisi']; ?></td>
          <td><?= $divisi['1819123_Alamat']; ?></td>
          <td><?= $divisi['1819123_NoTelp']; ?></td>
          <td>
            <!-- tombol update -->
            <button type="button" class="btn btn-success btn-sm tombol-update" data-toggle="modal" data-target="#exampleModal" data-divisi="<?= $divisi['1819123_IdDivisi']; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="#fff" width="24" height="24" data-divisi="<?= $divisi['1819123_IdDivisi']; ?>" class="tombol-update">
                <path d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z" data-divisi="<?= $divisi['1819123_IdDivisi']; ?>" class="tombol-update" />
              </svg>
            </button>
            <!-- tombol hapus -->
            <a href="#" class="btn btn-success btn-sm tombol-hapus" data-divisi="<?= $divisi['1819123_IdDivisi']; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff" data-divisi="<?= $divisi['1819123_IdDivisi']; ?>" class="tombol-hapus">
                <path d="M0 0h24v24H0V0z" fill="none" data-divisi="<?= $divisi['1819123_IdDivisi']; ?>" class="tombol-hapus" />
                <path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-3.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z" data-divisi="<?= $divisi['1819123_IdDivisi']; ?>" class="tombol-hapus" />
              </svg>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
    <div class="modal-content" id="modal-content">
      <!-- diubah dengan javascript -->
    </div>
  </div>
</div>
<?php require_once 'footer.php'; ?>
<?= endHTML('<script src="divisi.js"></script>'); ?>