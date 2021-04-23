// tombol tambah
const modalContent = document.getElementById('modal-content');
const tombolTambah = document.getElementById('tombol-tambah');
tombolTambah.addEventListener('click', function () {
  modalContent.innerHTML = `
  <div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Divisi</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <form action="" method="POST">
    <!-- nama divisi -->
    <div class="form-group position-relative">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="form-icon">
        <path d="M0 0h24v24H0V0z" fill="none" />
        <path d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
      </svg>
      <label for="nama-divisi">Nama Divisi</label>
      <input type="text" class="form-control" name="nama-divisi" id="nama-divisi" placeholder="contoh: penjualan" required />
    </div>
    <!-- alamat divisi -->
    <div class="form-group position-relative">
      <label for="alamat-divisi">Alamat Divisi</label>
      <svg height="24" viewBox="0 0 512 512" width="24" xmlns="http://www.w3.org/2000/svg" fill="#28a745" class="form-icon">
        <path d="m256 0c-108.81 0-197.333 88.523-197.333 197.333 0 61.198 31.665 132.275 94.116 211.257 45.697 57.794 90.736 97.735 92.631 99.407 6.048 5.336 15.123 5.337 21.172 0 1.895-1.672 46.934-41.613 92.631-99.407 62.451-78.982 94.116-150.059 94.116-211.257 0-108.81-88.523-197.333-197.333-197.333zm0 474.171c-38.025-36.238-165.333-165.875-165.333-276.838 0-91.165 74.168-165.333 165.333-165.333s165.333 74.168 165.333 165.333c0 110.963-127.31 240.602-165.333 276.838z" />
        <path d="m378.413 187.852-112-96c-5.992-5.136-14.833-5.136-20.825 0l-112 96c-6.709 5.75-7.486 15.852-1.735 22.561s15.852 7.486 22.561 1.735l13.586-11.646v79.498c0 8.836 7.164 16 16 16h144c8.836 0 16-7.164 16-16v-79.498l13.587 11.646c6.739 5.777 16.836 4.944 22.561-1.735 5.751-6.709 4.974-16.81-1.735-22.561zm-66.413 76.148h-112v-90.927l56-48 56 48z" />
      </svg>
      <textarea name="alamat-divisi" class="form-control" id="alamat-divisi" cols="5" rows="3" placeholder="minimal 25 karakter" minlength="25" required></textarea>
    </div>
    <!-- nomor telp -->
    <div class="form-group position-relative">
      <svg height="24" viewBox="0 0 512.021 512.021" width="24" xmlns="http://www.w3.org/2000/svg" fill="#28a745" class="form-icon">
        <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.838-3.837 9.361-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.866 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z" />
      </svg>
      <label for="nomor-telp">Nomor Telp</label>
      <input type="number" class="form-control" name="nomor-telp" id="nomor-telp" placeholder="contoh: 08123456789" required />
    </div>
    <!-- tombol tambah -->
    <button type="submit" class="btn btn-success" name="tambah">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
        <path d="M0 0h24v24H0V0z" fill="none" />
        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
      </svg>
      Tambahkan Data Divisi
    </button>
  </form>

</div>`;
});

const tbody = document.getElementsByTagName('tbody')[0];
tbody.addEventListener('click', function (e) {
  if (e.target.classList.contains('tombol-hapus')) {
    // tombol hapus data
    // cegah aksi default
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
      const idDivisi = e.target.dataset.divisi;
      // pindahkan kehalaman hapus divisi
      document.location.href = `hapus-divisi.php?1819123_IdDivisi=${idDivisi}`;
    });

  
  } else if (e.target.classList.contains('tombol-update')) {
    // tombol update data   
    const idDivisi = e.target.dataset.divisi;
      fetch(`update-divisi.php?1819123_IdDivisi=${idDivisi}`)
        .then(response => response.text())
        .then(success => {
          modalContent.innerHTML = success;
        });
    
  }
});





// cari data divisi
const cariDivisi = document.getElementById('cari-divisi');
// tambahkan event keyup saat keyboard diketik
cariDivisi.addEventListener('keyup', function () {
  
  const valueCari = cariDivisi.value;
  fetch(`cari-divisi.php?cari=${valueCari}`)
    .then(response => response.text())
    .then(success => {
      tbody.innerHTML = success;
    });
});