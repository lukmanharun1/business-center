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

?>

<?= startHTML('Cari Anime', '<script src="sweetalert.min.js"></script>'); ?>
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

 

  .tombol-logout:hover {
    color: #28a745 !important;
    background-color: #ededed;
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
      <a class="nav-link" href="pesanan.php">Pesanan</a>
      <a class="nav-link" href="cetak-nota.php">Cetak Nota</a>
      <a href="#" class="nav-link active">Anime</a>
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

<h1 class="text-center mt-3">Halaman Pencarian Anime</h1>

<div class="container mt-3">
  <div class="row justify-content-center">
    <!-- cari anime -->
    <div class="col-md-5">
      <div class="form-group position-relative">
        <!-- icon cari -->
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="icon-cari">
          <path d="M0 0h24v24H0V0z" fill="none" />
          <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
        </svg>
        <input type="text" class="form-control" id="cari-anime" placeholder="cari Judul Anime" />
      </div>
    </div>
  </div>
</div>

<div class="container-fluid mt-3">
  <!-- generate -->
  <div class="row" id="hasil-anime">
   <!-- diubah di javascript -->

  </div>
</div>

<?= endHTML('<script src="anime.js"></script>'); ?>
