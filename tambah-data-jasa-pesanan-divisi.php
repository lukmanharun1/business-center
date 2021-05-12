<?php 


session_start();
require_once 'functions.php';
// cek session admin atau staff
if (!middleware('staff')) {
  redirect('login');
}
if (isset($_GET['iddivisi'])) {
  $idDivisi = filter($_GET['iddivisi']);
} else {
  redirect('pesanan');
}

// ambil seluruh data jasa
$getAllDataJasa = getAllDataJasa();
?>

<?php foreach ($getAllDataJasa as $i => $jasa) : ?>
    <tr>
      <td><?= ++$i; ?></td>
      <td><?= $jasa['1819123_NmJasa']; ?></td>
      <td><?= $jasa['1819123_LamaJasa']; ?> Hari</td>
      <td>Rp. <?= $jasa['1819123_HrgJasa']; ?></td>
      <form action="" method="POST">
        <td class="position-relative">
        <!-- ambil id divisi yang dikirim kan param -->
        <input type="hidden" name="id-divisi" value="<?= $idDivisi; ?>" id="value-id-divisi" />
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
