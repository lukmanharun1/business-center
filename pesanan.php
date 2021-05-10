<?php

session_start();
require_once 'functions.php';
// cek session admin atau staff
if (!middleware('staff')) {
  redirect('login');
}
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}
// ini untuk dimasukan pesanan di database
$tanggalPesanan = date('Y-m-d');
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
$viewTanggalPesanan = date("Y-") . $bulan . date("-d");




// ambil seluruh data divisi
$getAllDataDivisi = getAllDataDivisi();
// ambil seluruh data jasa
$getAllDataJasa = getAllDataJasa();


?>

<?= startHTML('Form Entry Data Pesanan', '<script src="sweetalert.min.js"></script>'); ?>
<?php
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


} else if (isset($_SESSION['message'])) {
  // cek message contoh -> selamat anda berhasil login sebagai staff
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
?>
<style>
  .form-icon {
    left: 15px;
    top: 19px;
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
  <a class="navbar-brand" href="#">
    <img src="logo.png" alt="logo metik" width="60" height="50" />
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
    <!-- START: khusus halaman admin -->
    <?php if (middleware('admin')) : ?>
      <a class="nav-link" href="divisi.php">Divisi <span class="sr-only">(current)</span></a>
      <a class="nav-link" href="jasa.php">Jasa</a>
      <a class="nav-link" href="add-user.php">Add User</a>
    <?php endif; ?>
    <!-- END: khusus halaman admin -->
      <a class="nav-link active" href="#">Pesanan</a>
      <a class="nav-link" href="cetak-nota.php">Cetak Nota</a>
      <a href="menu.php" class="nav-link">Menu</a>
      <a href="anime.php" class="nav-link">Anime</a>
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


<div class="container-fluid mt-3">
  <h1 class="text-center mb-3">Form Data Divisi</h1>
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
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
              </svg>Tambahkan Data Jasa
            </button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h2 class="text-center my-3">Form Data Pemesanan</h2>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambahkan Data Jasa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Jasa</th>
              <th scope="col">Lama Jasa</th>
              <th scope="col">Harga Jasa</th>
              <th scope="col">Jumlah Pesan</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($getAllDataJasa as $i => $jasa) : ?>
              <tr>
                <td><?= ++$i; ?></td>
                <td><?= $jasa['1819123_NmJasa']; ?></td>
                <td><?= $jasa['1819123_LamaJasa']; ?> Hari</td>
                <td>Rp. <?= $jasa['1819123_HrgJasa']; ?></td>
                <form action="" method="post">
                  <td class="position-relative" style="max-width: 50px;">
                    <svg width="24" height="24" viewBox="0 0 100 125" class="form-icon" fill="#28a745">
                      <path d="M45,25c0-11-9-20-20-20S5,14,5,25s9,20,20,20S45,36,45,25z M25,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S33.3,40,25,40z"/>
                      <polygon points="27.5,15 22.5,15 22.5,22.5 15,22.5 15,27.5 22.5,27.5 22.5,35 27.5,35 27.5,27.5 35,27.5 35,22.5 27.5,22.5 "/>
                        <path d="M75,5c-11,0-20,9-20,20s9,20,20,20s20-9,20-20S86,5,75,5z M75,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S83.3,40,75,40z"/>
                        <rect x="65" y="22.5" width="20" height="5"/>
                        <path d="M72.5,53.8c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.4,0-0.8,0-1.3,0.1  v-7c0-3.4-2.8-6.3-6.3-6.3s-6.3,2.8-6.3,6.3V54L37,60.7c-0.5,0.5-0.7,1.1-0.7,1.8V80c0,0.7,0.3,1.3,0.7,1.8l6.8,6.8v4  c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-5c0-0.7-0.3-1.3-0.7-1.8L41.3,79V63.5l2.5-2.5v11.5c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5  V39.4c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v23.1c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-10c0-0.7,0.6-1.3,1.3-1.3  s1.3,0.6,1.3,1.3v10c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-6.3c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v6.3c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5V60c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v19.6l-2.4,7.1c-0.1,0.3-0.1,0.5-0.1,0.8v3.2v1.8c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5v-4.6l2.4-7.1c0.1-0.3,0.1-0.5,0.1-0.8V60C78.8,56.6,75.9,53.8,72.5,53.8z"/>
                    </svg>
                    <input type="number" required name="jumlah_pesan" class="form-control jumlah_pesan" />
                  </td>
                  <td class="d-none">
                    <button type="submit" class="btn btn-success">
                      <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="#fff">
                        <path d="M0 0h24v24H0z" fill="none"/>
                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                      </svg>
                      Simpan Pemesanan
                    </button>
                  </td>
                </form>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
</div>

<?php require_once 'footer.php'; ?>
<?= endHTML('<script src="pesanan.js"></script>'); ?>