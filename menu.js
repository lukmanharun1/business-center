// inisialisasi
const formMieAyamDanBakso = document.getElementsByTagName("form")[0];
const mieAyamSpesial = formMieAyamDanBakso.querySelector("#mie-ayam-spesial");
const baksoSpesial = formMieAyamDanBakso.querySelector("#bakso-spesial");

const uangPembayaran = formMieAyamDanBakso.querySelector("#uang-pembayaran");
const harusBayar = formMieAyamDanBakso.querySelector("#harus-bayar");

// saat jumlah pembelian bakso spesial
baksoSpesial.addEventListener("keyup", hitungTotalBayar);

baksoSpesial.addEventListener("change", hitungTotalBayar);

function hitungTotalBayar() {
  // harga mie ayam & bakso
  const hargaMieAyam =
    formMieAyamDanBakso.querySelector("#harga-mieayam").value;
  const hargaBakso = formMieAyamDanBakso.querySelector("#harga-bakso").value;

  const jumlahBaksoSpesial = baksoSpesial.value;
  // minimal jumlah mie ayam spesial 1
  const jumlahMiAyamSpesial = mieAyamSpesial.value;

  mieAyamSpesial.setAttribute("readonly", "");

  let totalHargaMieAyam = 0;
  let totalHargaBakso = 0;
  // diskon 5% mie ayam pembelian diatas 5
  if (jumlahMiAyamSpesial >= 6 && jumlahMiAyamSpesial <= 10) {
    totalHargaMieAyam =
      hargaMieAyam * jumlahMiAyamSpesial -
      (hargaMieAyam * jumlahMiAyamSpesial * 5) / 100;
    // diskon 10% mie ayam pembelian diatas 10
  } else if (jumlahMiAyamSpesial >= 11) {
    totalHargaMieAyam =
      hargaMieAyam * jumlahMiAyamSpesial -
      (hargaMieAyam * jumlahMiAyamSpesial * 10) / 100;
  } else {
    // harga normal
    totalHargaMieAyam = hargaMieAyam * jumlahMiAyamSpesial;
  }

  // diskon 5% bakso pembelian diatas 5
  if (jumlahBaksoSpesial >= 6 && jumlahBaksoSpesial <= 10) {
    totalHargaBakso =
      hargaBakso * jumlahBaksoSpesial -
      (hargaBakso * jumlahBaksoSpesial * 5) / 100;
    // diskon 10% bakso pembelian diatas 10
  } else if (jumlahBaksoSpesial >= 11) {
    totalHargaBakso =
      hargaBakso * jumlahBaksoSpesial -
      (hargaBakso * jumlahBaksoSpesial * 10) / 100;
  } else {
    // harga normal
    totalHargaBakso = hargaBakso * jumlahBaksoSpesial;
  }

  const totalBayar = totalHargaMieAyam + totalHargaBakso;
  harusBayar.setAttribute("value", totalBayar);
}
