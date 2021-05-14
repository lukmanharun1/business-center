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



if (isset($_POST['simpan-pesan'])) {
  // inisialisasi terlebih dahulu
  $noSp = 'sp-' . uniqid($tanggalPesanan);
  $idDivisi = filter($_POST['id-divisi']);
  $kdJasa =  filter($_POST['kd-jasa']);
  $hargaPesan = filter($_POST['harga_pesan']);
  $jumlahPesan = filter($_POST['jumlah_pesan']);

  // insert data di table 1819123_detail_pesan
  $tambahDetailPesan = tambahDetailPesan($noSp, $kdJasa, $jumlahPesan, $hargaPesan);
  // selanjutnya kita insert data di table 1819123_sp
  $tambahSuratPesanan = tambahSuratPesan($noSp, $idDivisi, $tanggalPesanan);

  // cek apakah 22 nya berhasil  di insert ?
  if ($tambahDetailPesan && $tambahSuratPesanan) {
    $berhasil = 'Data pesanan Berhasil Disimpan!';
  } else {
    $status = 'Data pesanan Gagal Disimpan!';
  }
} else if (isset($_POST['simpan-data-jasa'])) {
  $noSp = filter($_POST['nosp']);
  $kdJasa =  filter($_POST['kd-jasa']);
  $hargaPesan = filter($_POST['harga_pesan']);
  $jumlahPesan = filter($_POST['jumlah_pesan']);

  // insert data di table 1819123_detail_pesan
  $tambahDetailPesan = tambahDetailPesan($noSp, $kdJasa, $jumlahPesan, $hargaPesan);

  // cek apakah berhasil  di insert ?
  if ($tambahDetailPesan) {
    $berhasil = 'Data Jasa Berhasil Disimpan!';
  } else {
    $status = 'Data Jasa Gagal Disimpan!';
  }
}

// ambil seluruh data pesanan nenampilkan divisi
$getAllSuratPesanan = getAllSuratPesanan();

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
  <h1 class="text-center my-3">Form Data Pesanan</h1>
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
            <!-- tombol tambah lagi data jasa -->
            <button type="button" data-nosp="<?= $pesanan['1819123_NoSP']; ?>" class="btn btn-success btn-sm mt-2 tambah-lagi" data-toggle="modal" data-target="#tambahDataJasa">
              <svg xmlns="http://www.w3.org/2000/svg" class="tambah-lagi" data-nosp="<?= $pesanan['1819123_NoSP']; ?>" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
                <path d="M0 0h24v24H0V0z" fill="none" data-nosp="<?= $pesanan['1819123_NoSP']; ?>" class="tambah-lagi" />
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" class="tambah-lagi" data-nosp="<?= $pesanan['1819123_NoSP']; ?>" />
              </svg>Lagi Data Jasa
            </button>
          </td>
        </tr>
      <?php endforeach; ?>

      
    </tbody>
  </table>
  
  <!-- data divisi pesanan -->
  <h2 class="text-center mb-3">Form Data Divisi Pesanan</h2>
  <div class="row">
    <div class="col-lg-4">
      <div class="form-group position-relative">
        <!-- icon cari -->
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="icon-cari">
          <path d="M0 0h24v24H0V0z" fill="none" />
          <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
        </svg>
        <input type="text" class="form-control" id="cari-divisi-pesanan" placeholder="cari nama divisi | alamat divisi | no telp" />
      </div>
    </div>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Divisi</th>
        <th scope="col" style="width: 650px;">Alamat Divisi</th>
        <th scope="col">Nomor Telp</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody id="table-divisi">
      <?php foreach ($getAllDataDivisi as $i => $divisi) : ?>
        <tr>
          <td><?= ++$i; ?></td>
          <td><?= $divisi['1819123_NmDivisi']; ?></td>
          <td><?= $divisi['1819123_Alamat']; ?></td>
          <td><?= $divisi['1819123_NoTelp']; ?></td>
          <td>
            <!-- Button trigger modal data jasa divisi -->
            <button type="button" data-iddivisi="<?= $divisi['1819123_IdDivisi']; ?>" class="btn btn-success btn-sm" data-toggle="modal" data-target="#dataJasaPesanan">
              <svg xmlns="http://www.w3.org/2000/svg" data-iddivisi="<?= $divisi['1819123_IdDivisi']; ?>" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
                <path d="M0 0h24v24H0V0z" fill="none" data-iddivisi="<?= $divisi['1819123_IdDivisi']; ?>" />
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" data-iddivisi="<?= $divisi['1819123_IdDivisi']; ?>" />
              </svg>Data Jasa
            </button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

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

<!-- Modal tambah data jasa -->
<div class="modal fade" id="tambahDataJasa">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahDataJasaLabel">Tambah Lagi Data Jasa</h5>
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
              <th scope="col">Harga Pesan</th>
              <th scope="col">Jumlah Pesan</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody id="tambahDataJasaPesanan">
          
          <?php foreach ($getAllDataJasa as $i => $jasa) : ?>
            <tr>
              <td><?= ++$i; ?></td>
              <td><?= $jasa['1819123_NmJasa']; ?></td>
              <td><?= $jasa['1819123_LamaJasa']; ?> Hari</td>
              <td>Rp.<?= formatRp($jasa['1819123_HrgJasa']); ?></td>
              <form action="" method="POST">
                <td class="position-relative">
                <!-- value dari javascript dikirimkan saat tombol + lagi data jasa di click -->
                <input type="hidden" name="nosp" value="" class="nosp" />
                <!-- ambil kd jasa -->
                <input type="hidden" name="kd-jasa" value="<?= $jasa['1819123_KdJasa']; ?>" />
                  <!-- inputan harga pesan -->
                  <span class="form-icon text-success">Rp.</span>
                  <input type="number" required name="harga_pesan" class="form-control harga_pesan" style="width: 150px;" />
                </td>
                <td class="position-relative" style="width: 135px;">
                  <!-- inputan jumlah pesan -->
                  <svg width="24" height="24" viewBox="0 0 100 125" class="form-icon" fill="#28a745">
                    <path d="M45,25c0-11-9-20-20-20S5,14,5,25s9,20,20,20S45,36,45,25z M25,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S33.3,40,25,40z"/>
                    <polygon points="27.5,15 22.5,15 22.5,22.5 15,22.5 15,27.5 22.5,27.5 22.5,35 27.5,35 27.5,27.5 35,27.5 35,22.5 27.5,22.5 "/>
                      <path d="M75,5c-11,0-20,9-20,20s9,20,20,20s20-9,20-20S86,5,75,5z M75,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S83.3,40,75,40z"/>
                      <rect x="65" y="22.5" width="20" height="5"/>
                      <path d="M72.5,53.8c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.4,0-0.8,0-1.3,0.1  v-7c0-3.4-2.8-6.3-6.3-6.3s-6.3,2.8-6.3,6.3V54L37,60.7c-0.5,0.5-0.7,1.1-0.7,1.8V80c0,0.7,0.3,1.3,0.7,1.8l6.8,6.8v4  c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-5c0-0.7-0.3-1.3-0.7-1.8L41.3,79V63.5l2.5-2.5v11.5c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5  V39.4c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v23.1c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-10c0-0.7,0.6-1.3,1.3-1.3  s1.3,0.6,1.3,1.3v10c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-6.3c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v6.3c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5V60c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v19.6l-2.4,7.1c-0.1,0.3-0.1,0.5-0.1,0.8v3.2v1.8c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5v-4.6l2.4-7.1c0.1-0.3,0.1-0.5,0.1-0.8V60C78.8,56.6,75.9,53.8,72.5,53.8z"/>
                    </svg>
                  <input type="number" required name="jumlah_pesan" class="form-control jumlah_pesan" />
                </td>
                <td class="position-relative">
                  <button type="submit" class="btn btn-success btn-sm" name="simpan-data-jasa">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="#fff">
                      <path d="M0 0h24v24H0z" fill="none"/>
                      <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                    </svg>
                    Simpan Data Jasa
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

<!-- Modal + data jasa di data divisi -->
<div class="modal fade" id="dataJasaPesanan">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="dataJasaPesananLabel">Form Tambah Data Jasa Untuk Membuat Pemesanan</h5>
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
              <th scope="col">Harga Pesan</th>
              <th scope="col">Jumlah Pesan</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody id="tambahDataJasaPesanan">
          
          <?php foreach ($getAllDataJasa as $i => $jasa) : ?>
            <tr>
              <td><?= ++$i; ?></td>
              <td><?= $jasa['1819123_NmJasa']; ?></td>
              <td><?= $jasa['1819123_LamaJasa']; ?> Hari</td>
              <td>Rp.<?= formatRp($jasa['1819123_HrgJasa']); ?></td>
              <form action="" method="POST">
                <td class="position-relative">
                <!-- value dari javascript dikirimkan atau hasil dari pencarian -->
                <input type="hidden" name="id-divisi" value="" class="value-id-divisi" />
                <!-- ambil kd jasa -->
                <input type="hidden" name="kd-jasa" value="<?= $jasa['1819123_KdJasa']; ?>" />
                  <!-- inputan harga pesan -->
                  <span class="form-icon text-success">Rp.</span>
                  <input type="number" required name="harga_pesan" class="form-control harga_pesan" style="width: 150px;" />
                </td>
                <td class="position-relative" style="width: 135px;">
                  <!-- inputan jumlah pesan -->
                  <svg width="24" height="24" viewBox="0 0 100 125" class="form-icon" fill="#28a745">
                    <path d="M45,25c0-11-9-20-20-20S5,14,5,25s9,20,20,20S45,36,45,25z M25,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S33.3,40,25,40z"/>
                    <polygon points="27.5,15 22.5,15 22.5,22.5 15,22.5 15,27.5 22.5,27.5 22.5,35 27.5,35 27.5,27.5 35,27.5 35,22.5 27.5,22.5 "/>
                      <path d="M75,5c-11,0-20,9-20,20s9,20,20,20s20-9,20-20S86,5,75,5z M75,40c-8.3,0-15-6.7-15-15s6.7-15,15-15s15,6.7,15,15  S83.3,40,75,40z"/>
                      <rect x="65" y="22.5" width="20" height="5"/>
                      <path d="M72.5,53.8c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.6,0-1.1,0.1-1.7,0.2c-0.9-2.3-3.2-4-5.8-4c-0.4,0-0.8,0-1.3,0.1  v-7c0-3.4-2.8-6.3-6.3-6.3s-6.3,2.8-6.3,6.3V54L37,60.7c-0.5,0.5-0.7,1.1-0.7,1.8V80c0,0.7,0.3,1.3,0.7,1.8l6.8,6.8v4  c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-5c0-0.7-0.3-1.3-0.7-1.8L41.3,79V63.5l2.5-2.5v11.5c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5  V39.4c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v23.1c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-10c0-0.7,0.6-1.3,1.3-1.3  s1.3,0.6,1.3,1.3v10c0,1.4,1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5v-6.3c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v6.3c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5V60c0-0.7,0.6-1.3,1.3-1.3s1.3,0.6,1.3,1.3v19.6l-2.4,7.1c-0.1,0.3-0.1,0.5-0.1,0.8v3.2v1.8c0,1.4,1.1,2.5,2.5,2.5  s2.5-1.1,2.5-2.5v-4.6l2.4-7.1c0.1-0.3,0.1-0.5,0.1-0.8V60C78.8,56.6,75.9,53.8,72.5,53.8z"/>
                    </svg>
                  <input type="number" required name="jumlah_pesan" class="form-control jumlah_pesan" />
                </td>
                <td class="position-relative">
                  <button type="submit" class="btn btn-success btn-sm" name="simpan-pesan">
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