<?php
// cek session admin atau staff
session_start();
require_once 'functions.php';
// cek session admin atau staff
if (!middleware('staff')) {
  redirect('login');
}
// ini untuk dimasukan pesanan di database
$tanggalPesanan = date('d-m-Y');
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
$viewTanggalNota = date("d-") . $bulan . date('-Y');

// cek session login untuk admin
if (empty($_SESSION['hak-akses']) == 'admin' || empty($_SESSION['hak-akses']) == 'staff') {
  redirect('login');
} else if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}

$getAllNota = getAllNota();
$dataDivisi = [];
foreach ($getAllNota as $i => $divisi) {

  // array_push($dataDivisi, $divisi['1819123_NmDivisi']);
  // array_push($dataDivisi, $divisi['1819123_Alamat']);
  // array_push($dataDivisi, $divisi['1819123_NoTelp']);
  $dataDivisi = [
    $i => [
      '1819123_NoSP' => $divisi['1819123_NoSP'],
      '1819123_TglSP' => $divisi['1819123_TglSP'],
      '1819123_NmDivisi' => $divisi['1819123_NmDivisi'],
      '1819123_Alamat' => $divisi['1819123_Alamat'],
      '1819123_NoTelp' => $divisi['1819123_NoTelp']
    ]
  ];
}
?>

<?= startHTML('Cetak Nota', '<script src="sweetalert.min.js"></script>'); ?>
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
}
?>
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
      <a class="nav-link" href="pesanan.php">Pesanan</a>
      <a class="nav-link active" href="#">Cetak Nota</a>
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
  <h1 class="text-center">Form Cetak Nota</h1>
  <div class="row mt-3 ml-5">
    <div class="col-lg-4">
      <!-- data Nota -->
      <h5>Data Nota</h5>
      <p>Tanggal Nota, <b> <?= $viewTanggalNota; ?></b></p>
      <!-- data pesanan  -->
      <h5>Data Pesanan</h5>
      <div class="form-group position-relative">
        <!-- icon cari -->
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="icon-cari">
          <path d="M0 0h24v24H0V0z" fill="none" />
          <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
        </svg>
        <input type="text" class="form-control mb-4" id="cari-nota" placeholder="cari tanggal pesanan | nama divisi | nama jasa | no telp" autofocus />
      </div>
      <!-- tanggal pesanan -->
      <?php foreach ($dataDivisi as $divisi) : ?>
        <div class="form-group position-relative">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="form-icon">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
          </svg>
          <label for="nama-divisi">Tanggal Pesanan</label>
          <input type="text" class="form-control" id="nama-divisi" value="<?= $divisi['1819123_TglSP']; ?>" disabled required />
        </div>
        <br>
        <h5>Data Divisi</h5>
        <!-- nama divisi -->
        <div class="form-group position-relative">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="form-icon">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
          </svg>
          <label for="nama-divisi">Nama Divisi</label>
          <input type="text" class="form-control" id="nama-divisi" value="<?= $divisi['1819123_NmDivisi']; ?>" disabled required />
        </div>
        <!-- alamat divisi -->
        <div class="form-group position-relative">
          <label for="alamat-divisi">Alamat Divisi</label>
          <svg height="24" viewBox="0 0 512 512" width="24" xmlns="http://www.w3.org/2000/svg" fill="#28a745" class="form-icon">
            <path d="m256 0c-108.81 0-197.333 88.523-197.333 197.333 0 61.198 31.665 132.275 94.116 211.257 45.697 57.794 90.736 97.735 92.631 99.407 6.048 5.336 15.123 5.337 21.172 0 1.895-1.672 46.934-41.613 92.631-99.407 62.451-78.982 94.116-150.059 94.116-211.257 0-108.81-88.523-197.333-197.333-197.333zm0 474.171c-38.025-36.238-165.333-165.875-165.333-276.838 0-91.165 74.168-165.333 165.333-165.333s165.333 74.168 165.333 165.333c0 110.963-127.31 240.602-165.333 276.838z" />
            <path d="m378.413 187.852-112-96c-5.992-5.136-14.833-5.136-20.825 0l-112 96c-6.709 5.75-7.486 15.852-1.735 22.561s15.852 7.486 22.561 1.735l13.586-11.646v79.498c0 8.836 7.164 16 16 16h144c8.836 0 16-7.164 16-16v-79.498l13.587 11.646c6.739 5.777 16.836 4.944 22.561-1.735 5.751-6.709 4.974-16.81-1.735-22.561zm-66.413 76.148h-112v-90.927l56-48 56 48z" />
          </svg>
          <textarea class="form-control" id="alamat-divisi" cols="5" rows="3" disabled minlength="25" required><?= $divisi['1819123_Alamat']; ?></textarea>
        </div>
        <!-- nomor telp -->
        <div class="form-group position-relative">
          <svg height="24" viewBox="0 0 512.021 512.021" width="24" xmlns="http://www.w3.org/2000/svg" fill="#28a745" class="form-icon">
            <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.838-3.837 9.361-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.866 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z" />
          </svg>
          <label for="nomor-telp">Nomor Telp</label>
          <input type="number" class="form-control" name="nomor-telp" value="<?= $divisi['1819123_NoTelp']; ?>" id="nomor-telp" disabled required />
        </div>

    </div>


    <div class="col-lg-8 mt-5">
      <table class="table">

      </table>
    </div>
  </div>

  <!-- tabel jasa & pesan -->
  <table class="table">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Jasa</th>
        <th scope="col">Lama Jasa</th>
        <th scope="col">Jumlah Pesan</th>
        <th scope="col">Harga Pesan</th>
        <th scope="col">Jumlah Harga</th>
      </tr>
    </thead>
    <tbody>
      <?php $totalHarga = 0; ?>
      <?php foreach ($getAllNota as $i => $jasa) : ?>
        <tr>
          <td><?= ++$i; ?></td>
          <td><?= $jasa['1819123_NmJasa']; ?></td>
          <td><?= $jasa['1819123_LamaJasa']; ?></td>
          <td><?= $jasa['1819123_JmlPesan']; ?></td>
          <td><?= $jasa['1819123_HrgPesan']; ?></td>
          <td><?= $jasa['Jumlah_Harga']; ?></td>
        </tr>
        <?php $totalHarga += $jasa['Jumlah_Harga']; ?>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h6 class="text-right mr-5">Total Harga : Rp. <b class="text-success"><?= $totalHarga; ?></b></h6>

  <div class="cetak text-center my-4">
    <strong>Cetak</strong> <br>
    <button type="button" class="btn btn-sm btn-success">
      <!-- cetak excel -->
      <a href="cetak-excel.php?no-sp=<?= $divisi['1819123_NoSP']; ?>" target="_blank">
        <svg viewBox="0 0 384 512" width="24" height="24" fill="#fff">
          <path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm212-240h-28.8c-4.4 0-8.4 2.4-10.5 6.3-18 33.1-22.2 42.4-28.6 57.7-13.9-29.1-6.9-17.3-28.6-57.7-2.1-3.9-6.2-6.3-10.6-6.3H124c-9.3 0-15 10-10.4 18l46.3 78-46.3 78c-4.7 8 1.1 18 10.4 18h28.9c4.4 0 8.4-2.4 10.5-6.3 21.7-40 23-45 28.6-57.7 14.9 30.2 5.9 15.9 28.6 57.7 2.1 3.9 6.2 6.3 10.6 6.3H260c9.3 0 15-10 10.4-18L224 320c.7-1.1 30.3-50.5 46.3-78 4.7-8-1.1-18-10.3-18z">
          </path>
        </svg>
      </a>
    </button>
    <button type="button" class="btn btn-sm btn-success">
      <!-- cetak pdf -->
      <a href="cetak-pdf.php?no-sp=<?= $divisi['1819123_NoSP']; ?>" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="#fff">
          <path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm250.2-143.7c-12.2-12-47-8.7-64.4-6.5-17.2-10.5-28.7-25-36.8-46.3 3.9-16.1 10.1-40.6 5.4-56-4.2-26.2-37.8-23.6-42.6-5.9-4.4 16.1-.4 38.5 7 67.1-10 23.9-24.9 56-35.4 74.4-20 10.3-47 26.2-51 46.2-3.3 15.8 26 55.2 76.1-31.2 22.4-7.4 46.8-16.5 68.4-20.1 18.9 10.2 41 17 55.8 17 25.5 0 28-28.2 17.5-38.7zm-198.1 77.8c5.1-13.7 24.5-29.5 30.4-35-19 30.3-30.4 35.7-30.4 35zm81.6-190.6c7.4 0 6.7 32.1 1.8 40.8-4.4-13.9-4.3-40.8-1.8-40.8zm-24.4 136.6c9.7-16.9 18-37 24.7-54.7 8.3 15.1 18.9 27.2 30.1 35.5-20.8 4.3-38.9 13.1-54.8 19.2zm131.6-5s-5 6-37.3-7.8c35.1-2.6 40.9 5.4 37.3 7.8z"></path>
        </svg>
      </a>
    </button>
  </div>
<?php endforeach; ?>
</div>

<?php require_once 'footer.php'; ?>
<?= endHTML('<script src="cetak-nota.js"></script>'); ?>