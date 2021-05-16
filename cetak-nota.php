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
$tanggalPesanan = date('Y-m-d');


// ambil seluruh data pesanan nenampilkan divisi
$getAllSuratPesanan = getAllSuratPesanan();
?>

<?= startHTML('Cetak Nota', '<script src="sweetalert.min.js"></script>'); ?>

<style>
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
  .table-responsive {
    max-height: 450px;
    overflow-y: scroll;
  }

  .tombol-logout:hover {
    color: #28a745 !important;
    background-color: #ededed;
  }

  .tombol-hapus:hover {
    background-color: #dc3545;
    border-color: #dc3545;
  }

  .tombol-hapus-details-pesanan:hover {
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
      <a class="nav-link " href="pesanan.php">Pesanan</a>
      <a class="nav-link active" href="#">Cetak Nota</a>
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
  <h1 class="text-center">Form Cetak Nota Pesanan</h1>
    <div class="row">
      <div class="col-lg-5">
        <div class="form-group position-relative">
          <!-- icon cari -->
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="icon-cari">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
          </svg>
          <input type="text" class="form-control" id="cari-data-pesanan" placeholder="cari nama divisi | alamat divisi | no telp | tanggal pesanan" autofocus />
        </div>
      </div>
    </div>
    <!-- data pesanan -->
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col" >Nama Divisi</th>
            <th scope="col" style="width: 500px;">Alamat Divisi</th>
            <th scope="col">Nomor Telp</th>
            <th scope="col">Tanggal Pesanan</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody id="table-pesanan">
          <?php foreach ($getAllSuratPesanan as $i => $pesanan) : ?>
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
                <!-- tombol cetak pdf -->
                <a href="cetak-pdf.php?nosp=<?= $pesanan['1819123_NoSP']; ?>" target="_blank" class="btn btn-success btn-sm mt-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24">
                    <path fill="currentColor" d="M181.9 256.1c-5-16-4.9-46.9-2-46.9 8.4 0 7.6 36.9 2 46.9zm-1.7 47.2c-7.7 20.2-17.3 43.3-28.4 62.7 18.3-7 39-17.2 62.9-21.9-12.7-9.6-24.9-23.4-34.5-40.8zM86.1 428.1c0 .8 13.2-5.4 34.9-40.2-6.7 6.3-29.1 24.5-34.9 40.2zM248 160h136v328c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V24C0 10.7 10.7 0 24 0h200v136c0 13.2 10.8 24 24 24zm-8 171.8c-20-12.2-33.3-29-42.7-53.8 4.5-18.5 11.6-46.6 6.2-64.2-4.7-29.4-42.4-26.5-47.8-6.8-5 18.3-.4 44.1 8.1 77-11.6 27.6-28.7 64.6-40.8 85.8-.1 0-.1.1-.2.1-27.1 13.9-73.6 44.5-54.5 68 5.6 6.9 16 10 21.5 10 17.9 0 35.7-18 61.1-61.8 25.8-8.5 54.1-19.1 79-23.2 21.7 11.8 47.1 19.5 64 19.5 29.2 0 31.2-32 19.7-43.4-13.9-13.6-54.3-9.7-73.6-7.2zM377 105L279 7c-4.5-4.5-10.6-7-17-7h-6v128h128v-6.1c0-6.3-2.5-12.4-7-16.9zm-74.1 255.3c4.1-2.7-2.5-11.9-42.8-9 37.1 15.8 42.8 9 42.8 9z" />
                  </svg>
                </a>
                <!-- tombol cetak excel -->
                <a href="cetak-excel.php?nosp=<?= $pesanan['1819123_NoSP']; ?>" target="_blank" class="btn btn-success btn-sm mt-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24">
                    <path fill="currentColor" d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm60.1 106.5L224 336l60.1 93.5c5.1 8-.6 18.5-10.1 18.5h-34.9c-4.4 0-8.5-2.4-10.6-6.3C208.9 405.5 192 373 192 373c-6.4 14.8-10 20-36.6 68.8-2.1 3.9-6.1 6.3-10.5 6.3H110c-9.5 0-15.2-10.5-10.1-18.5l60.3-93.5-60.3-93.5c-5.2-8 .6-18.5 10.1-18.5h34.8c4.4 0 8.5 2.4 10.6 6.3 26.1 48.8 20 33.6 36.6 68.5 0 0 6.1-11.7 36.6-68.5 2.1-3.9 6.2-6.3 10.6-6.3H274c9.5-.1 15.2 10.4 10.1 18.4zM384 121.9v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z" />
                  </svg>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal details pesanan -->
<div class="modal fade" id="detailsPesan">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="detailsPesanLabel">Details Data Pesanan</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
      <div class="modal-body" id="details-pesan">
        <!-- diubah dengan javascript -->
      </div>
    </div>
  </div>
</div>


<?php require_once 'footer.php'; ?>
<?= endHTML('<script src="cetak-nota.js"></script>'); ?>