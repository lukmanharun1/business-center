document.addEventListener("keyup", function (e) {
  // saat mengtik jumlah pesan
  if (e.target.classList.contains("jumlah_pesan")) {
    // ambil tombol aksi nya
    e.target.parentElement.nextElementSibling.classList.remove("d-none");
  }
});
