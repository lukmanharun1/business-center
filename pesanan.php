<?php

session_start();
require_once 'functions.php';
// cek session admin atau staff
if (!middleware('staff')) {
  redirect('login');
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
// cek session login untuk admin & staff
if (empty($_SESSION['hak-akses']) == 'admin' || empty($_SESSION['hak-akses']) == 'staff') {
  redirect('login');
} else if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}
// cek tombol + data jasa
if (isset($_POST['tambahkan-jasa'])) {
  $kdJasa = filter($_POST['kd-jasa']);
  $cariJasaByKdJasa = cariJasaByKdJasa($kdJasa)[0];

  $namaJasa = $cariJasaByKdJasa['1819123_NmJasa'];
  $lamaJasa = $cariJasaByKdJasa['1819123_LamaJasa'];
  $hargaJasa = $cariJasaByKdJasa['1819123_HrgJasa'];
}
// cek tombol + tambahkan pesanan
if (isset($_POST['tambahkan-pesanan'])) {
  $kdJasa = filter($_POST['kd-jasa']);
  $hargaPesan = filter($_POST['harga-pesan']);
  $jumlahPesan = filter($_POST['jumlah-pesan']);

  // set session kd jasa tipe data array
  // cek apakah ada kd jasa?
  if (isset($_SESSION['kd-jasa'])) {
    // ambil kd jasa
    $valueJasa = json_decode($_SESSION['kd-jasa'], true);
    // tambahkan kd jasa
    foreach ($valueJasa as $value) {
      // cegat jika array nya yang sama
      if ($kdJasa == $value) {
        $status = 'Maaf Data duplikasi';
      }
    }

    if (empty($status)) {
      // set session lagi
      $_SESSION['kd-jasa'] = json_encode($valueJasa);
      $tambahDetailPesan = tambahDetailPesan($kdJasa, $jumlahPesan, $hargaPesan);

      // cek apakah berhasil?
      if ($tambahDetailPesan) {
        $berhasil = 'Data Pesanan Berhasil Ditambahkan!';
        array_push($valueJasa, $kdJasa);
        $_SESSION['kd-jasa'] = json_encode($valueJasa);
        // untuk mengaktifkan cari divisi
        $_SESSION['pesanan'] = 'true';
      } else {
        $status = 'Data Pesanan Gagal Ditambahkan / data tidak boleh sama';
      }
    }
  } else {
    // kalau tidak ada tambahkan
    $tambahDetailPesan = tambahDetailPesan($kdJasa, $jumlahPesan, $hargaPesan);

    // cek apakah berhasil?
    if ($tambahDetailPesan) {
      $berhasil = 'Data Pesanan Berhasil Ditambahkan!';
      $_SESSION['kd-jasa'] = json_encode([$kdJasa]);
      // untuk mengaktifkan cari divisi
      $_SESSION['pesanan'] = 'true';
    }
  }
} else if (isset($_POST['tambah-data-divisi'])) {
  $idDivisi = filter($_POST['id-divisi']);
  $namaDivisi = filter($_POST['nama-divisi']);
  $alamatDivisi = filter($_POST['alamat-divisi']);
  $nomorTelp = filter($_POST['nomor-telp']);
} else if (isset($_POST['simpan-pesan'])) {

  $idDivisi = filter($_POST['id-divisi']);
  $tambahSuratPesan = tambahSuratPesan($idDivisi, $tanggalPesanan);
  // cek apakah berhasil ditambah?
  if ($tambahSuratPesan) {
    $berhasil = 'Data Pesanan Berhasil Disimpan!';
    // lalu hapus session kd jasa
    unset($_SESSION['kd-jasa']);
  } else {
    $status = 'Data Pesanan Gagal Disimpan';
  }
}

if (isset($_SESSION['kd-jasa'])) {
  // ambil value kd jasa di session
  $valueJasa = json_decode($_SESSION['kd-jasa'], true);
  $inKdJasa = implode(',', $valueJasa);
  if ($inKdJasa !== '') {
    $cetakPesanan = cetakPesanan($inKdJasa);
  } else {
    $cetakPesanan = [];
  }
  $totalHarga = 0;

  if (count($cetakPesanan) != 0) {
    foreach ($cetakPesanan as $pesan) {
      $totalHarga += $pesan['Jumlah_Harga'];
    }
  }
}




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
  <a class="navbar-brand" href="divisi.php">
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
    <?php endif; ?>
    <!-- END: khusus halaman admin -->
      <a class="nav-link active" href="#">Pesanan</a>
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


<div class="container-fluid mt-3">
  <h1 class="text-center">Form Entry Data Pesanan</h1>
  <div class="row mt-3">
    <div class="col-lg-3">
      <!-- data pesanan -->
      <h5>Data Pesanan</h5>
      <p>Tanggal Pesanan, <b> <?= $viewTanggalPesanan; ?></b></p>
      <!-- data jasa  -->
      <h5>Data Jasa</h5>
      <div class="form-group position-relative">
        <!-- icon cari -->
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="icon-cari">
          <path d="M0 0h24v24H0V0z" fill="none" />
          <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
        </svg>
        <input type="text" class="form-control mb-4" id="cari-jasa" placeholder="cari nama | lama | harga jasa" autofocus />
      </div>
      <form action="" method="POST">
        <!-- nama jasa -->
        <div class="form-group position-relative">
          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 512 512" width="24" height="24" class="form-icon" fill="#28a745">
            <path d="M366,396c-5.52,0-10,4.48-10,10c0,5.52,4.48,10,10,10c5.52,0,10-4.48,10-10C376,400.48,371.52,396,366,396z" />
            <path d="M390.622,363.663l-47.53-15.84l-17.063-34.127c15.372-15.646,26.045-36.348,29.644-57.941L357.801,243H376
                c16.542,0,30-13.458,30-30v-63C406,67.29,338.71,0,256,0c-82.922,0-150,67.097-150,150v63c0,13.036,8.361,24.152,20,28.28V253
                c0,16.542,13.458,30,30,30h8.782c4.335,9.417,9.946,18.139,16.774,25.974c1.416,1.628,2.893,3.206,4.406,4.741l-17.054,34.108
                l-47.531,15.841C66.112,382.092,26,440.271,26,502c0,5.523,4.477,10,10,10h440c5.522,0,10-4.477,10-10
                C486,440.271,445.889,382.092,390.622,363.663z M386,213c0,5.514-4.486,10-10,10h-15.262c2.542-19.69,4.236-40.643,4.917-61.28
                c0.02-0.582,0.036-1.148,0.054-1.72H386V213z M136,223c-5.514,0-10-4.486-10-10v-53h20.298c0.033,1.043,0.068,2.091,0.107,3.146
                c0.001,0.036,0.003,0.071,0.004,0.107c0,0.003,0,0.006,0,0.009c0.7,20.072,2.372,40.481,4.856,59.737H136V223z M156,263
                c-5.514,0-10-4.486-10-10v-10h8.198l2.128,12.759c0.406,2.425,0.905,4.841,1.482,7.241H156z M146.017,140H126.38
                C131.445,72.979,187.377,20,256,20c68.318,0,124.496,52.972,129.619,120h-19.635c-0.72-55.227-45.693-100-101.033-100h-17.9
                C191.712,40,146.736,84.773,146.017,140z M247.05,60h17.9c44.809,0,81.076,36.651,81.05,81.41c0,3.147-0.025,5.887-0.078,8.38
                c0,0.032-0.001,0.065-0.001,0.098l-12.508-1.787c-33.98-4.852-66.064-20.894-90.342-45.172C241.195,101.054,238.652,100,236,100
                c-26.856,0-52.564,12.236-69.558,32.908C170.63,92.189,205.053,60,247.05,60z M178.54,263c-5.006-16.653-10.734-65.653-12-97.053
                l13.459-17.946c12.361-16.476,31.592-26.713,52.049-27.888c26.917,25.616,61.739,42.532,98.537,47.786l14.722,2.104
                c-0.984,20.885-2.995,41.843-5.876,61.118c-0.001,0.006-0.002,0.013-0.003,0.02c-0.916,6.197-1.638,10.185-3.482,21.324
                c-5.296,31.765-28.998,60.49-60.287,68.313c-12.877,3.215-26.443,3.214-39.313,0c-19.537-4.884-37.451-18.402-49.012-37.778
                h20.386c4.128,11.639,15.243,20,28.28,20h20c16.575,0,30-13.424,30-30c0-16.542-13.458-30-30-30h-20
                c-13.327,0-24.278,8.608-28.297,20H178.54z M235.159,341.016c6.859,1.445,13.852,2.184,20.841,2.184
                c5.471,0,10.943-0.458,16.353-1.346l-17.67,18.687L235.159,341.016z M240.935,375.079l-31.718,33.542
                c-8.732-16.714-16.235-34.109-22.389-51.917l11.911-23.822L240.935,375.079z M311.566,329.494l13.604,27.209
                c-6.164,17.838-13.669,35.239-22.392,51.933l-33.948-33.948L311.566,329.494z M226,273c0-5.521,4.478-10,10-10h20
                c5.514,0,10,4.486,10,10c0,5.522-4.479,10-10,10h-20C230.486,283,226,278.514,226,273z M46.4,492
                c3.963-49.539,36.932-94.567,81.302-109.363l42.094-14.028c7.712,21.325,17.266,42.052,28.463,61.74
                c0.019,0.034,0.037,0.068,0.056,0.101c0,0.001,0.001,0.001,0.001,0.002c8.181,14.389,17.389,28.45,27.372,41.799L237.99,492H46.4z
                 M256,483.086l-13.562-21.773c-0.152-0.244-0.314-0.481-0.486-0.711c-8.098-10.802-15.652-22.099-22.532-33.662l35.663-37.714
                l37.578,37.578c-6.926,11.647-14.506,22.991-22.611,33.796C269.56,461.253,270.255,460.224,256,483.086z M274.01,492
                l12.301-19.748c10.027-13.4,19.301-27.574,27.564-42.132c0.05-0.088,0.097-0.178,0.147-0.266c0.006-0.011,0.012-0.021,0.018-0.032
                c11.055-19.5,20.509-40.047,28.164-61.213l42.093,14.028c44.371,14.796,77.34,59.824,81.303,109.363H274.01z" />
            <path d="M435.546,451.531c-6.683-13.377-16.472-25.261-28.309-34.367c-4.378-3.369-10.656-2.55-14.023,1.828
                c-3.368,4.378-2.549,10.656,1.828,14.024c9.454,7.273,17.272,16.766,22.611,27.453c2.473,4.949,8.483,6.941,13.415,4.477
                C436.008,462.478,438.013,456.472,435.546,451.531z" />
          </svg>

          <label for="nama-jasa">Nama jasa</label>
          <input type="text" class="form-control" name="nama-jasa" id="nama-jasa" <?= isset($namaJasa) ? "value='$namaJasa'" : ''; ?> disabled required />
        </div>
        <!-- lama jasa -->
        <div class="form-group position-relative">
          <label for="lama-jasa">Lama Jasa</label>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" class="form-icon" fill="#28a745">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
          </svg>
          <input name="lama-jasa" class="form-control" id="lama-jasa" <?= isset($lamaJasa) ? "value='$lamaJasa'" : ''; ?> disabled required />
        </div>
        <!-- harga jasa -->
        <div class="form-group position-relative">
          <span class="form-icon text-success">Rp.</span>
          <label for="harga-jasa">Harga Jasa</label>
          <input type="number" class="form-control" name="harga-jasa" id="harga-jasa" <?= isset($hargaJasa) ? "value='$hargaJasa'" : ''; ?> disabled required />
        </div>


        <!-- kd jasa -->
        <input type="hidden" name="kd-jasa" value="<?= isset($kdJasa) ? $kdJasa : ''; ?>" />
        <!--  jumlah pesan -->
        <div class="form-group position-relative">
          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 100 125" width="24" height="24" class="form-icon" fill="#28a745">
            <path d="M45,25c0-11-9-20-20-20S5,14,5,25s9,20,20,20S45,36,45,25z M25,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S33.3,40,25,40z" />
            <polygon points="27.5,15 22.5,15 22.5,22.5 15,22.5 15,27.5 22.5,27.5 22.5,35 27.5,35 27.5,27.5 35,27.5 35,22.5 27.5,22.5 " />
            <path d="M75,5c-11,0-20,9-20,20s9,20,20,20s20-9,20-20S86,5,75,5z M75,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S83.3,40,75,40z" />
            <rect x="65" y="22.5" width="20" height="5" />
            <path d="M72.5,53.8c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.4,0-0.8,0-1.3,0.1  v-7c0-3.4-2.8-6.3-6.3-6.3s-6.3,2.8-6.3,6.3V54L37,60.7c-0.5,0.5-0.7,1.1-0.7,1.8V80c0,0.7,0.3,1.3,0.7,1.8l6.8,6.8v4  c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-5c0-0.7-0.3-1.3-0.7-1.8L41.3,79V63.5l2.5-2.5v11.5c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5  V39.4c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v23.1c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-10c0-0.7,0.6-1.3,1.3-1.3  s1.3,0.6,1.3,1.3v10c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-6.3c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v6.3c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5V60c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v19.6l-2.4,7.1c-0.1,0.3-0.1,0.5-0.1,0.8v3.2v1.8c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5v-4.6l2.4-7.1c0.1-0.3,0.1-0.5,0.1-0.8V60C78.8,56.6,75.9,53.8,72.5,53.8z" />
          </svg>
          <label for="jumlah-pesan">Jumlah Pesan</label>
          <input type="number" class="form-control" name="jumlah-pesan" id="jumlah-pesan" <?= isset($hargaJasa) ? '' : 'disabled'; ?> required placeholder="contoh: 5" />
        </div>
        <!-- harga pesan -->
        <div class="form-group position-relative">
          <span class="form-icon text-success">Rp.</span>
          <label for="harga-pesan">Harga Pesan</label>
          <!-- via javascript -->
          <input type="hidden" name="harga-pesan" class="harga-pesan" />
          <input type="number" class="form-control harga-pesan" disabled required />
        </div>
        <!-- button tambah pesanan -->
        <button type="submit" class="btn btn-success btn-sm my-3" <?= isset($namaJasa) ? '' : 'disabled'; ?> name="tambahkan-pesanan">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
          </svg>
          Tambahkan Pesanan
        </button>


      </form>

    </div>

    <div class="col-lg-3 mt-5">
      <br>
      <h5>Data Divisi</h5>
      <div class="form-group position-relative">
        <!-- icon cari -->
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="icon-cari">
          <path d="M0 0h24v24H0V0z" fill="none" />
          <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
        </svg>
        <input type="text" class="form-control mb-4" id="cari-divisi" placeholder="cari nama | alamat | telpon divisi" <?= (!isset($_SESSION['pesanan'])) ? 'disabled' : '' ?> />
      </div>
      <form action="" method="POST">
        <!-- no sp -->

        <!-- id divisi -->
        <input type="hidden" name="id-divisi" value="<?= isset($idDivisi) ? $idDivisi : ''; ?>">
        <!-- nama divisi -->
        <div class="form-group position-relative">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="form-icon">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
          </svg>
          <label for="nama-divisi">Nama Divisi</label>
          <input type="text" class="form-control" id="nama-divisi" value="<?= isset($namaDivisi) ? $namaDivisi : ''; ?>" disabled required />
        </div>
        <!-- alamat divisi -->
        <div class="form-group position-relative">
          <label for="alamat-divisi">Alamat Divisi</label>
          <svg height="24" viewBox="0 0 512 512" width="24" xmlns="http://www.w3.org/2000/svg" fill="#28a745" class="form-icon">
            <path d="m256 0c-108.81 0-197.333 88.523-197.333 197.333 0 61.198 31.665 132.275 94.116 211.257 45.697 57.794 90.736 97.735 92.631 99.407 6.048 5.336 15.123 5.337 21.172 0 1.895-1.672 46.934-41.613 92.631-99.407 62.451-78.982 94.116-150.059 94.116-211.257 0-108.81-88.523-197.333-197.333-197.333zm0 474.171c-38.025-36.238-165.333-165.875-165.333-276.838 0-91.165 74.168-165.333 165.333-165.333s165.333 74.168 165.333 165.333c0 110.963-127.31 240.602-165.333 276.838z" />
            <path d="m378.413 187.852-112-96c-5.992-5.136-14.833-5.136-20.825 0l-112 96c-6.709 5.75-7.486 15.852-1.735 22.561s15.852 7.486 22.561 1.735l13.586-11.646v79.498c0 8.836 7.164 16 16 16h144c8.836 0 16-7.164 16-16v-79.498l13.587 11.646c6.739 5.777 16.836 4.944 22.561-1.735 5.751-6.709 4.974-16.81-1.735-22.561zm-66.413 76.148h-112v-90.927l56-48 56 48z" />
          </svg>
          <textarea class="form-control" id="alamat-divisi" cols="5" rows="3" disabled minlength="25" required><?= isset($alamatDivisi) ? $alamatDivisi : ''; ?></textarea>
        </div>
        <!-- nomor telp -->
        <div class="form-group position-relative">
          <svg height="24" viewBox="0 0 512.021 512.021" width="24" xmlns="http://www.w3.org/2000/svg" fill="#28a745" class="form-icon">
            <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.838-3.837 9.361-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.866 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z" />
          </svg>
          <label for="nomor-telp">Nomor Telp</label>
          <input type="number" class="form-control" name="nomor-telp" value="<?= isset($nomorTelp) ? $nomorTelp : ''; ?>" id="nomor-telp" disabled required />
        </div>
        <button type="submit" name="simpan-pesan" class="btn btn-success btn-sm my-3" <?= isset($namaDivisi) ? '' : 'disabled'; ?>>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z" />
          </svg>
          Simpan Pesanan
        </button>
      </form>
    </div>
    <div class="col-lg-6 mt-5">
      <table class="table">

      </table>
    </div>
  </div>

  <!-- tabel jasa & pesan -->
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
      <?php if (isset($_SESSION['kd-jasa'])) : ?>
        <?php foreach ($cetakPesanan as $i => $pesan) : ?>

          <tr>
            <td><?= ++$i; ?></td>
            <td>
              <a data-kdjasa="<?= $pesan['1819123_KdJasa']; ?>" class="btn btn-success btn-sm tombol-hapus">
                <svg xmlns="http://www.w3.org/2000/svg" data-kdjasa="<?= $pesan['1819123_KdJasa']; ?>" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff" class="tombol-hapus">
                  <path d="M0 0h24v24H0V0z" fill="none" data-kdjasa="<?= $pesan['1819123_KdJasa']; ?>" class="tombol-hapus" />
                  <path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-3.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z" class="tombol-hapus" data-kdjasa="<?= $pesan['1819123_KdJasa']; ?>" />
                </svg>
              </a>
            </td>
            <td><?= $pesan['1819123_NmJasa']; ?></td>
            <td><?= $pesan['1819123_LamaJasa']; ?> Hari</td>
            <td><?= $pesan['1819123_JmlPesan']; ?></td>
            <td>Rp. <?= $pesan['1819123_HrgPesan']; ?></td>
            <td>Rp. <?= $pesan['Jumlah_Harga']; ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
  <h6 class="text-right mr-5">Total Harga : Rp. <b class="text-success"><?= isset($totalHarga) ? $totalHarga : '0'; ?></b></h6>
</div>

<?php require_once 'footer.php'; ?>
<?= endHTML('<script src="pesanan.js"></script>'); ?>