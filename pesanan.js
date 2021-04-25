// inisialisasi
const cariJasa = document.getElementById('cari-jasa');
const cariDivisi = document.getElementById('cari-divisi');
const table = document.getElementsByTagName('table')[0];

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
