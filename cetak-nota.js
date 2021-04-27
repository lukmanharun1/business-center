// inisialisasi
const cariNota = document.getElementById('cari-nota');
const table = document.getElementsByTagName('table')[0];

// cari data divisi
// tambahkan event keyup saat keyboard diketik
cariDivisi.addEventListener('keyup', function () {
  
  const valueCari = cariNota.value;
  fetch(`cari-cetak-nota.php?cari=${valueCari}`)
    .then(response => response.text())
    .then(success => {
      table.innerHTML = success;
    });
});
