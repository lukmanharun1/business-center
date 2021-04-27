// inisialisasi
const cariJasa = document.getElementById('cari-jasa');
const cariDivisi = document.getElementById('cari-divisi');
const table = document.getElementsByTagName('table')[0];
const tbody = document.getElementsByTagName('tbody')[0];

// cari jasa saat keyboard ditekan
cariJasa.addEventListener('keyup', function () {
  
  const valueCari = cariJasa.value;
  fetch(`cari-jasa-pesanan.php?cari=${valueCari}`)
    .then(response => response.text())
    .then(success => {
      table.innerHTML = success;
    });
});

// cari data divisi
// tambahkan event keyup saat keyboard diketik
cariDivisi.addEventListener('keyup', function () {
  
  const valueCari = cariDivisi.value;
  fetch(`cari-divisi-pesanan.php?cari=${valueCari}`)
    .then(response => response.text())
    .then(success => {
      table.innerHTML = success;
    });
});


// inisialisasi
const hargaJasa = document.getElementById('harga-jasa');
const jumlahPesan = document.getElementById('jumlah-pesan');
const hargaPesan = document.querySelectorAll('.harga-pesan');

jumlahPesan.addEventListener('keyup', function () {
  const valueJumlahPesan = parseInt(jumlahPesan.value);
  const valuePesan = valueJumlahPesan * parseInt(hargaJasa.value);
  hargaPesan[0].setAttribute('value', valuePesan);
  hargaPesan[1].setAttribute('value', valuePesan);
});

tbody.addEventListener('click', function (e) {
  if (e.target.classList.contains('tombol-hapus')) {
    e.preventDefault();
    
    swal({
      title: "Konfirmasi",
      text: "Apakah anda yakin?",
      icon: "warning",
      buttons: ['Tidak Jadi', 'Hapus Sekarang']
    });

    // ambil tomobl hapus sekarang 
    const tombolHapusSekarang = document.querySelector('.swal-button--confirm');
    tombolHapusSekarang.addEventListener('click', () => {
      const kdJasa = e.target.dataset.kdjasa;
      // pindahkan kehalaman hapus jasa
      document.location.href = `hapus-pesanan.php?kd-jasa=${kdJasa}`;
    });

  }
});