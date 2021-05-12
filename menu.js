// inisialisasi
const mieAyamSpesial = document.getElementById("mie-ayam-spesial");
const baksoSpesial = document.getElementById("bakso-spesial");

const uangPembayaran = document.getElementById("uang-pembayaran");
const harusBayar = document.getElementById("harus-bayar");

// harga mie ayam & bakso
const hargaMieAyam = 20000;
const hargaBakso = 18000;

// saat jumlah pembelian bakso spesial
baksoSpesial.addEventListener("keyup", hitungTotalBayar);

baksoSpesial.addEventListener("change", hitungTotalBayar);

function hitungTotalBayar() {
  const jumlahBaksoSpesial = baksoSpesial.value;
  // minimal jumlah mie ayam spesial 1
  const jumlahMiAyamSpesial = mieAyamSpesial.value;
  if (jumlahMiAyamSpesial < 1) {
    alert("Masukan Jumlah Pembelian Mie Ayam spesial Minimal 1");
  }
  // minimal jumlah bakso spesial 1
  else if (jumlahBaksoSpesial < 1) {
    alert("Masukan Jumlah Pembelian Bakso spesial Minimal 1");
  } else {
    mieAyamSpesial.setAttribute("readonly", "");

    let totalHargaMieAyam = 0;
    let totalHargaBakso = 0;
    // diskon 5% mie ayam pembelian 5 ke atas
    if (jumlahMiAyamSpesial >= 5 && jumlahMiAyamSpesial < 10) {
      totalHargaMieAyam =
        hargaMieAyam * jumlahMiAyamSpesial -
        (hargaMieAyam * jumlahMiAyamSpesial * 5) / 100;
      // diskon 10% mie ayam pembelian 10 ke atas
    } else if (jumlahMiAyamSpesial >= 10) {
      totalHargaMieAyam =
        hargaMieAyam * jumlahMiAyamSpesial -
        (hargaMieAyam * jumlahMiAyamSpesial * 10) / 100;
    } else {
      // harga normal
      totalHargaMieAyam = hargaMieAyam * jumlahMiAyamSpesial;
    }

    // diskon 5% bakso pembelian 5 ke atas
    if (jumlahBaksoSpesial >= 5 && jumlahBaksoSpesial < 10) {
      totalHargaBakso =
        hargaBakso * jumlahBaksoSpesial -
        (hargaBakso * jumlahBaksoSpesial * 5) / 100;
      // diskon 10% bakso pembelian 10 ke atas
    } else if (jumlahBaksoSpesial >= 10) {
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
}
