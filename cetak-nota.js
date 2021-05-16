// inisialisasi
const tablePesanan = document.getElementById("table-pesanan");

const detailsPesan = document.getElementById("details-pesan");
const cariDataPesanan = document.getElementById("cari-data-pesanan");

tablePesanan.addEventListener("click", async function (e) {
  const noSp = e.target.dataset.nosp;

  if (noSp && e.target.classList.contains("details-pesan")) {
    // saat tombol details pesan di click
    await fetch(`details-pesanan.php?nosp=${noSp}`)
      .then((response) => response.text())
      .then((success) => {
        detailsPesan.innerHTML = success;
      });
  } else if (noSp && e.target.classList.contains("tambah-lagi")) {
    const nospHTMLS = document.querySelectorAll(".nosp");
    nospHTMLS.forEach((nospHTML) => {
      nospHTML.value = noSp;
    });
  }
});

// cari data pesanan
cariDataPesanan.addEventListener("keyup", async function () {
  // saat keyboard di ketik lalu cari data pesanan

  await fetch(
    `cari-data-pesanan.php?cari-data-pesanan=${cariDataPesanan.value}`
  )
    .then((response) => response.text())
    .then((success) => {
      tablePesanan.innerHTML = success;
    })
    .catch((error) => console.log(error));
});

document.addEventListener("click", function (e) {
  // tombol hapus details pesan saat di click
  if (e.target.classList.contains("tombol-hapus-details-pesanan")) {
    // cegah aksi default
    e.preventDefault();
    swal({
      title: "Konfirmasi",
      text: "Apakah anda yakin?",
      icon: "warning",
      buttons: ["Tidak Jadi", "Hapus Sekarang"],
    });
    // ambil tombol hapus sekarang
    const tombolHapusSekarang = document.querySelector(".swal-button--confirm");
    tombolHapusSekarang.addEventListener("click", () => {
      const id = e.target.dataset.id;
      // pindahkan kehalaman hapus details pesan
      document.location.href = `hapus-details-pesanan.php?id=${id}`;
    });
  }
});
