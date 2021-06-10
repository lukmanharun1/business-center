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
// saat tombol bayar sekrang diklik
if (isset($_POST['bayar-sekarang'])) {
  $jumlahMieAyam = (int) filter($_POST['mie-ayam-spesial']);
  $jumlahBakso = (int) filter($_POST['bakso-spesial']);
  $hargaMieAyam = (int) filter($_POST['harga-mieayam']);
  $hargaBakso = (int) filter($_POST['harga-bakso']);
  $uangPembayaran = (int) filter($_POST['uang-pembayaran']);
  $totalBayar = (int) filter($_POST['harus-bayar']);
  // validasi uang pembayaran harus lebih besar dari total bayar
  if ($totalBayar > $uangPembayaran) {
    echo "<script>
            alert('Uang Pembayaran Tidak Cukup');
          </script>";
  } else {
    $uangKembalian = $uangPembayaran - $totalBayar;

    // insert data mie ayam & bakso
    $data = [
      'jumlah_mieayam' => $jumlahMieAyam,
      'jumlah_bakso' => $jumlahBakso,
      'harga_mieayam' => $hargaMieAyam,
      'harga_bakso' => $hargaBakso,
      'uang_pembayaran' => $uangPembayaran
    ];

    $tambahDataMieAyamBakso = tambahDataMieAyamBakso($data);
    // cek apakah berhasil insert data mie ayam & bakso
    if ($tambahDataMieAyamBakso) {
      $getDataMieAyamBakso = getDataMieAyamBakso($data);
    } else {
      $status = 'Input Data yang benar';
    }
  }
}

?>

<?= startHTML('Menu', '<script src="sweetalert.min.js"></script>'); ?>
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
}

?>


<style>

.form-icon {
    left: 5px;
    top: 39px;
    position: absolute;

  }
  
  .form-control {
    padding-left: 2rem;
  }

  hr.header {
    border: 4px solid black;
  }

  hr.pembayaran {
    border: 1px solid black;
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
      <a href="#" class="nav-link active">Menu</a>
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

<div class="container-fluid mt-2">
  <img src="logo.png" alt="logo" width="100" height="100" />
    <div class="text-center" style="margin-top: -100px;">
      <h2>SMK MEDIA INFORMATIKA</h2>
      <p>
        Jl. Papan I/Pisangan Kretek No.99, Petukangan Selatan, Pesanggrahan, Jakarta 12270 <br>
        Telepon/Fax : (021) 2270 4966 Website : www.smkmediainformatika.sch.id
      </p>
  <hr class="header">
</div>

<!-- menu mie ayam spesial & bakso spesial -->
<div class="container mt-3">
    <h4 class="text-center mb-3">Menu Mie Ayam spesial + Es Teh & Menu Bakso spesial + Es Teh</h4>
    <div class="row">
      
      <div class="col-md-4 ml-5">
        <form action="" method="post">
          <!-- harga Mie ayam spesial -->
          <div class="form-group position-relative">
            <span class="form-icon text-success">Rp.</span>
            <label for="harga-mieayam">Harga Mie Ayam spesial</label>
            <input type="number" class="form-control" id="harga-mieayam" name="harga-mieayam" />
          </div>

         <!-- jumlah mie pembelian menu mie ayam spesial -->
          <div class="form-group position-relative">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 100 125" width="24" height="24" class="form-icon" fill="#28a745">
                <path d="M45,25c0-11-9-20-20-20S5,14,5,25s9,20,20,20S45,36,45,25z M25,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S33.3,40,25,40z" />
                <polygon points="27.5,15 22.5,15 22.5,22.5 15,22.5 15,27.5 22.5,27.5 22.5,35 27.5,35 27.5,27.5 35,27.5 35,22.5 27.5,22.5 " />
                <path d="M75,5c-11,0-20,9-20,20s9,20,20,20s20-9,20-20S86,5,75,5z M75,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S83.3,40,75,40z" />
                <rect x="65" y="22.5" width="20" height="5" />
                <path d="M72.5,53.8c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.4,0-0.8,0-1.3,0.1  v-7c0-3.4-2.8-6.3-6.3-6.3s-6.3,2.8-6.3,6.3V54L37,60.7c-0.5,0.5-0.7,1.1-0.7,1.8V80c0,0.7,0.3,1.3,0.7,1.8l6.8,6.8v4  c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-5c0-0.7-0.3-1.3-0.7-1.8L41.3,79V63.5l2.5-2.5v11.5c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5  V39.4c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v23.1c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-10c0-0.7,0.6-1.3,1.3-1.3  s1.3,0.6,1.3,1.3v10c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-6.3c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v6.3c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5V60c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v19.6l-2.4,7.1c-0.1,0.3-0.1,0.5-0.1,0.8v3.2v1.8c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5v-4.6l2.4-7.1c0.1-0.3,0.1-0.5,0.1-0.8V60C78.8,56.6,75.9,53.8,72.5,53.8z" />
              </svg>
            <label for="mie-ayam-spesial">Masukan Jumlah Pembelian Mie Ayam spesial</label>
            <input type="number" class="form-control" id="mie-ayam-spesial" name="mie-ayam-spesial" required />
          </div>

          <!-- harga Bakso spesial -->
        <div class="form-group position-relative">
          <span class="form-icon text-success">Rp.</span>
          <label for="harga-bakso">Harga Bakso spesial</label>
          <input type="number" class="form-control"  id="harga-bakso" name="harga-bakso" />
        </div>

         <!-- jumlah mie pembelian menu Bakso spesial -->
          <div class="form-group position-relative">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 100 125" width="24" height="24" class="form-icon" fill="#28a745">
                <path d="M45,25c0-11-9-20-20-20S5,14,5,25s9,20,20,20S45,36,45,25z M25,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S33.3,40,25,40z" />
                <polygon points="27.5,15 22.5,15 22.5,22.5 15,22.5 15,27.5 22.5,27.5 22.5,35 27.5,35 27.5,27.5 35,27.5 35,22.5 27.5,22.5 " />
                <path d="M75,5c-11,0-20,9-20,20s9,20,20,20s20-9,20-20S86,5,75,5z M75,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S83.3,40,75,40z" />
                <rect x="65" y="22.5" width="20" height="5" />
                <path d="M72.5,53.8c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.4,0-0.8,0-1.3,0.1  v-7c0-3.4-2.8-6.3-6.3-6.3s-6.3,2.8-6.3,6.3V54L37,60.7c-0.5,0.5-0.7,1.1-0.7,1.8V80c0,0.7,0.3,1.3,0.7,1.8l6.8,6.8v4  c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-5c0-0.7-0.3-1.3-0.7-1.8L41.3,79V63.5l2.5-2.5v11.5c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5  V39.4c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v23.1c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-10c0-0.7,0.6-1.3,1.3-1.3  s1.3,0.6,1.3,1.3v10c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-6.3c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v6.3c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5V60c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v19.6l-2.4,7.1c-0.1,0.3-0.1,0.5-0.1,0.8v3.2v1.8c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5v-4.6l2.4-7.1c0.1-0.3,0.1-0.5,0.1-0.8V60C78.8,56.6,75.9,53.8,72.5,53.8z" />
              </svg>
            <label for="bakso-spesial">Masukan Jumlah Pembelian Bakso spesial</label>
            <input type="number" class="form-control" id="bakso-spesial" name="bakso-spesial" required />
          </div>

        <!-- Total yang Harus Dibayar -->
        <div class="form-group position-relative">
          <span class="form-icon text-success">Rp.</span>
          <label for="harus-bayar">Total yang Harus Dibayar</label>
          <input type="number" class="form-control" name="harus-bayar" id="harus-bayar" value="" readonly required />
        </div>

        <!-- Uang Pembayaran -->
        <div class="form-group position-relative">
          <span class="form-icon text-success">Rp.</span>
          <label for="uang-pembayaran">Uang Pembayaran</label>
          <input type="number" class="form-control" name="uang-pembayaran" id="uang-pembayaran" required />
        </div>

        <!-- bayar sekarang -->
        <button type="submit" name="bayar-sekarang" id="bayar-sekarang" class="btn btn-success">Bayar Sekarang</button>
        </form>
      </div>
      <div class="col-md-1"></div>
      <?php if (isset($getDataMieAyamBakso)) : ?>
        <div class="col-md-5 mt-3">
          <!-- harga mie ayam -->
          <h5 class="d-inline">Harga Mie Ayam spesial : </h5>
          <strong>Rp.<?= formatRp($getDataMieAyamBakso['1819123_harga_mieayam']); ?></strong>
          <br><br>
          <!-- harga bakso -->
          <h5 class="d-inline">Harga Bakso spesial : </h5>
          <strong>Rp.<?= formatRp($getDataMieAyamBakso['1819123_harga_bakso']); ?></strong>
          <hr class="pembayaran">
          <!-- jumlah mie ayam -->
          <h5 class="d-inline">Jumlah Pembelian Mie Ayam spesial : </h5>
          <strong><?= $getDataMieAyamBakso['1819123_jumlah_mieayam']; ?></strong>
          <?php 
            if ($getDataMieAyamBakso['1819123_jumlah_mieayam'] >= 6 && $getDataMieAyamBakso['1819123_jumlah_mieayam'] < 11) {
              echo '<small class="text-secondary">diskon 5%</small>';
            } else if ($getDataMieAyamBakso['1819123_jumlah_mieayam'] >= 11) {
              echo '<small class="text-secondary">diskon 10%</small>';
            }
          ?>
          <!-- jumlah bakso -->
          <br><br>
          <h5 class="d-inline">Jumlah Pembelian Bakso spesial : </h5>
          <strong><?= $getDataMieAyamBakso['1819123_jumlah_bakso']; ?></strong>
          <?php 
            if ($getDataMieAyamBakso['1819123_jumlah_bakso'] >= 6 && $getDataMieAyamBakso['1819123_jumlah_bakso'] < 11) {
              echo '<small class="text-secondary">diskon 5%</small>';
            } else if ($getDataMieAyamBakso['1819123_jumlah_bakso'] >= 11) {
              echo '<small class="text-secondary">diskon 10%</small>';
            }
          ?>

          <!-- total pembayaran -->
          <hr class="pembayaran">
          <h5 class="d-inline">Total Pembayaran : </h5>
          <strong>Rp.<?= formatRp($getDataMieAyamBakso['total_pembayaran']); ?></strong>

          <!-- uang pembayaran -->
          <br><br>
          <h5 class="d-inline">Uang Pembayaran : </h5>
          <strong>Rp.<?= formatRp($getDataMieAyamBakso['1819123_uang_pembayaran']); ?></strong>

          <!-- uang kembalian -->
          <br><br>
          <h5 class="d-inline">Uang Kembalian : </h5>
          <strong>Rp.<?= formatRp($uangKembalian); ?></strong>
          <hr class="pembayaran">
          <button type="button" class="btn btn-sm btn-success">
            <!-- cetak excel -->
            <a href="cetak-excel-menu.php?id=<?= $getDataMieAyamBakso['1819123_id']; ?>" target="_blank">
              <svg viewBox="0 0 384 512" width="24" height="24" fill="#fff">
                <path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm212-240h-28.8c-4.4 0-8.4 2.4-10.5 6.3-18 33.1-22.2 42.4-28.6 57.7-13.9-29.1-6.9-17.3-28.6-57.7-2.1-3.9-6.2-6.3-10.6-6.3H124c-9.3 0-15 10-10.4 18l46.3 78-46.3 78c-4.7 8 1.1 18 10.4 18h28.9c4.4 0 8.4-2.4 10.5-6.3 21.7-40 23-45 28.6-57.7 14.9 30.2 5.9 15.9 28.6 57.7 2.1 3.9 6.2 6.3 10.6 6.3H260c9.3 0 15-10 10.4-18L224 320c.7-1.1 30.3-50.5 46.3-78 4.7-8-1.1-18-10.3-18z">
                </path>
              </svg>
            </a>
          </button>
          <button type="button" class="btn btn-sm btn-success">
            <!-- cetak pdf -->
            <a href="cetak-pdf-menu.php?id=<?= $getDataMieAyamBakso['1819123_id']; ?>" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="#fff">
                <path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm250.2-143.7c-12.2-12-47-8.7-64.4-6.5-17.2-10.5-28.7-25-36.8-46.3 3.9-16.1 10.1-40.6 5.4-56-4.2-26.2-37.8-23.6-42.6-5.9-4.4 16.1-.4 38.5 7 67.1-10 23.9-24.9 56-35.4 74.4-20 10.3-47 26.2-51 46.2-3.3 15.8 26 55.2 76.1-31.2 22.4-7.4 46.8-16.5 68.4-20.1 18.9 10.2 41 17 55.8 17 25.5 0 28-28.2 17.5-38.7zm-198.1 77.8c5.1-13.7 24.5-29.5 30.4-35-19 30.3-30.4 35.7-30.4 35zm81.6-190.6c7.4 0 6.7 32.1 1.8 40.8-4.4-13.9-4.3-40.8-1.8-40.8zm-24.4 136.6c9.7-16.9 18-37 24.7-54.7 8.3 15.1 18.9 27.2 30.1 35.5-20.8 4.3-38.9 13.1-54.8 19.2zm131.6-5s-5 6-37.3-7.8c35.1-2.6 40.9 5.4 37.3 7.8z"></path>
              </svg>
            </a>
          </button>
        </div>
      <?php endif; ?>
  </div>
</div>

<?php require_once 'footer.php'; ?>
<?= endHTML('<script src="menu.js"></script>'); ?>
