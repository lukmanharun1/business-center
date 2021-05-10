<?php

function koneksi()
{
    return mysqli_connect('localhost', 'root', '', '1819123_lukman');
}

function middleware($hakAkses = 'admin') 
{
    // hak akses untuk admin
    if ($hakAkses == 'admin') {
        if (empty($_SESSION['hak-akses'])) {
           return false;
        } else if ($_SESSION['hak-akses'] == 'staff') {
           return false;
        } else if ($_SESSION['hak-akses'] == 'admin') {
            return true;
        }
    } else if ($hakAkses == 'staff') {
        // hak akses untuk staff
        if (empty($_SESSION['hak-akses'])) {
           return false;
        } else if ($_SESSION['hak-akses'] == 'admin' || $_SESSION['hak-akses'] == 'staff') {
            return true;
        }
    } 
    return false;
}
function startHTML($title = '', $includeCSS = '')
{
    return '
    <!doctype html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="tabitabi.jpg" type="image/x-icon">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
        ' . $includeCSS . '
        <title>' . $title . '</title>
        <style>
            @font-face {
                font-family: "Montserrat", sans-serif;
                src: url("font/Montserrat-Black.ttf");
                src: url("font/Montserrat-Bold.ttf");
                src: url("font/Montserrat-Light.ttf");
                src: url("font/Montserrat-Medium.ttf");
                src: url("font/Montserrat-Regular.ttf");
            }
            body {
                font-family: "Montserrat", sans-serif;
                // background-image: url(tabitabi.jpg);
                background-repeat: no-repeat;
                background-size: auto;
            }
            .form-control:focus {
                border-color: #28a745 !important;
                box-shadow: 0 0 0 1px #28a745 !important;
            }
        </style>
      </head>
      <body>
    ';
}


function endHTML($includeJs = '')
{
    return ' <script src="bootstrap/js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>    
                ' . $includeJs . '
            </body>
            </html>';
}

function redirect($namaFile)
{
    header("Location: $namaFile.php");
}

function query($query)
{
    return mysqli_query(koneksi(), $query);
}

function filter($filter)
{
    // membersihkan hasil query mencegah sql injection & XSS
    return mysqli_real_escape_string(koneksi(), htmlspecialchars($filter));
}

function fetchAssoc($mysqliQuery)
{
    return mysqli_fetch_all($mysqliQuery, MYSQLI_ASSOC);
}

function getUsername($username)
{
    $query = "SELECT `username` FROM `1819123_akses` WHERE username = '$username'";
    return fetchAssoc(query($query));
}
function getHakAkses($username) {
    $query = "SELECT `hak_akses` FROM `1819123_akses` WHERE username = '$username'";
    return fetchAssoc(query($query));
}

function getDataByUsername($username)
{
    $query = "SELECT `username`, `password`, `hak_akses` FROM `1819123_akses` WHERE username = '$username'";
    return fetchAssoc(query($query));
}

function addUser($username, $password, $hakAkses)
{
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO `1819123_akses`(`username`, `password`, `hak_akses`) VALUES ('$username', '$passwordHash', '$hakAkses')";
    return query($query);
}

function getAllDataDivisi()
{
    // ambil seluruh data divisi
    $query = "SELECT * FROM `1819123_divisi`";
    return fetchAssoc(query($query));
}

// tambah data divisi
function tambahDataDivsi($namaDivisi, $alamatDivisi, $noTelpDivisi)
{
    // contoh hasil nya D001
    $query = "INSERT INTO `1819123_divisi`(`1819123_IdDivisi`, `1819123_NmDivisi`, `1819123_Alamat`, `1819123_NoTelp`) VALUES (NULL, '$namaDivisi', '$alamatDivisi', '$noTelpDivisi')";
    return query($query);
}

// hapus data divisi berdasarkan 1819123_IdDivisi
function hapusDivisiById($idDivisi)
{
    $query = "DELETE FROM `1819123_divisi` WHERE `1819123_IdDivisi` = '$idDivisi'";
    return query($query);
}

// get data divisi bersarkan 1819123_IdDivisi
function getDataDivisiById($idDivisi)
{
    $query = "SELECT * FROM `1819123_divisi` WHERE `1819123_IdDivisi` = '$idDivisi'";
    return fetchAssoc(query($query));
}

// update data divisi
function updateDataDivsi($namaDivisi, $alamatDivisi, $noTelpDivisi, $idDivisi)
{
    $query = "UPDATE `1819123_divisi` SET `1819123_NmDivisi` = '$namaDivisi', `1819123_Alamat` = '$alamatDivisi', `1819123_NoTelp` = '$noTelpDivisi' WHERE `1819123_IdDivisi` = '$idDivisi'";
    return query($query);
}
// cari data divisi
function cariDivisi($cari)
{
    // ambil seluruh data divisi berdasarkan pencarian
    $query = "SELECT * FROM `1819123_divisi` WHERE `1819123_NmDivisi` LIKE '%$cari%' OR `1819123_Alamat` LIKE '%$cari%' OR `1819123_NoTelp` LIKE '%$cari%'";
    return fetchAssoc(query($query));
}

function getAllDataJasa()
{
    // ambil seluruh data divisi
    $query = "SELECT * FROM `1819123_jasa`";
    return fetchAssoc(query($query));
}

function tambahDataJasa($namaJasa, $lamaJasa, $hargaJasa)
{
    $query = "INSERT INTO `1819123_jasa`(`1819123_KdJasa`, `1819123_NmJasa`, `1819123_LamaJasa`, `1819123_HrgJasa`) VALUES (NULL,  '$namaJasa', '$lamaJasa', '$hargaJasa')";
    return query($query);
}

function getDataJasaById($kdJasa)
{
    $query = "SELECT * FROM `1819123_jasa` WHERE `1819123_KdJasa` = '$kdJasa'";
    return fetchAssoc(query($query));
}

// update data jasa
function updateDataJasa($namaJasa, $lamaJasa, $hargaJasa, $kdJasa)
{
    $query = "UPDATE `1819123_jasa` SET `1819123_NmJasa` = '$namaJasa', `1819123_LamaJasa` = '$lamaJasa',`1819123_HrgJasa` = '$hargaJasa' WHERE `1819123_KdJasa` = '$kdJasa'";
    return query($query);
}

// hapus data jasa berdasarkan 1819123_KdJasa
function hapusJasaById($kdJasa)
{
    $query = "DELETE FROM `1819123_jasa` WHERE `1819123_KdJasa` = '$kdJasa'";
    return query($query);
}

// cari data jasa
function cariJasa($cari)
{
    // ambil seluruh data jasa berdasarkan pencarian
    $query = "SELECT * FROM `1819123_jasa` WHERE `1819123_NmJasa` LIKE '%$cari%' OR `1819123_LamaJasa` LIKE '%$cari%' OR `1819123_HrgJasa` LIKE '%$cari%'";
    return fetchAssoc(query($query));
}

function cariJasaByKdJasa($kdJasa)
{
    $query = "SELECT * FROM `1819123_jasa` WHERE `1819123_KdJasa` = '$kdJasa'";
    return fetchAssoc(query($query));
}

function hitungSuratPesan()
{
    $query = "SELECT `1819123_NoSp` FROM `1819123_sp`";
    return count(fetchAssoc(query($query)));
}
function tambahDetailPesan($kdJasa, $jumlahPesan, $hargaPesan)
{
    // NoSp detail harus sama dengan NoSp di tabel nis
    $noSp = hitungSuratPesan() + 1;
    $query = "INSERT INTO `1819123_detail_pesan`(`1819123_NoSP`, `1819123_KdJasa`, `1819123_JmlPesan`, `1819123_HrgPesan`) VALUES ('$noSp', '$kdJasa', '$jumlahPesan', '$hargaPesan')";
    return query($query);
}

function cetakPesanan($kdJasa)
{
    // join table 1819123_jasa sama 1819123_detail_pesan -> ON kd jasa
    $query = "SELECT `1819123_detail_pesan`.`1819123_NoSP`, `1819123_jasa`.`1819123_NmJasa`, `1819123_jasa`.`1819123_LamaJasa`, `1819123_detail_pesan`.`1819123_JmlPesan`, `1819123_detail_pesan`.`1819123_HrgPesan`, `1819123_detail_pesan`.`1819123_KdJasa`, `1819123_detail_pesan`.`1819123_JmlPesan` * `1819123_detail_pesan`.`1819123_HrgPesan` AS 'Jumlah_Harga' FROM `1819123_detail_pesan` INNER JOIN `1819123_jasa` ON `1819123_detail_pesan`.`1819123_KdJasa` = `1819123_jasa`.`1819123_KdJasa` WHERE `1819123_detail_pesan`.`1819123_KdJasa` IN($kdJasa)";
    return fetchAssoc(query($query));
}

function hapusPesanan($kdJasa)
{
    $query = "DELETE FROM `1819123_detail_pesan` WHERE `1819123_KdJasa` = '$kdJasa'";
    return query($query);
}
function getNoSpDetailPesan()
{
    // ambil data terkahir no sp
    $query = "SELECT `1819123_NoSP` FROM `1819123_detail_pesan` ORDER BY `1819123_NoSp` DESC LIMIT 1";
    return fetchAssoc(query($query));
}
function tambahSuratPesan($idDivisi, $tanggalPesanan)
{
    // ambil data terakhir no surat pesanan di tabel detail pesan
    $noSp = getNoSpDetailPesan()[0]['1819123_NoSP'];
    $query = "INSERT INTO `1819123_sp`(`1819123_NoSP`, `1819123_IdDivisi`, `1819123_TglSP`) VALUES ('$noSp', '$idDivisi', '$tanggalPesanan')";

    return query($query);
}

function getAllNota()
{
    $query = "SELECT `1819123_sp`.`1819123_NoSP`, `1819123_sp`.`1819123_TglSP`, `1819123_divisi`.`1819123_NmDivisi`, `1819123_divisi`.`1819123_Alamat`, `1819123_divisi`.`1819123_NoTelp`, `1819123_jasa`.`1819123_NmJasa`, `1819123_jasa`.`1819123_LamaJasa`, `1819123_jasa`.`1819123_HrgJasa`, `1819123_detail_pesan`.`1819123_JmlPesan`, `1819123_detail_pesan`.`1819123_HrgPesan`, `1819123_detail_pesan`.`1819123_JmlPesan` * `1819123_detail_pesan`.`1819123_HrgPesan` AS 'Jumlah_Harga' FROM `1819123_divisi` INNER JOIN `1819123_sp` ON `1819123_divisi`.`1819123_IdDivisi` = `1819123_sp`.`1819123_IdDivisi` JOIN  `1819123_detail_pesan` ON `1819123_detail_pesan`.`1819123_NoSP` = `1819123_sp`.`1819123_NoSP` JOIN `1819123_jasa` ON `1819123_detail_pesan`.`1819123_KdJasa` = `1819123_jasa`.`1819123_KdJasa`";

    return fetchAssoc(query($query));
}

function getNotaByNoSP($noSp)
{
    $query = "SELECT `1819123_sp`.`1819123_NoSP`, `1819123_sp`.`1819123_TglSP`, `1819123_divisi`.`1819123_NmDivisi`, `1819123_divisi`.`1819123_Alamat`, `1819123_divisi`.`1819123_NoTelp`, `1819123_jasa`.`1819123_NmJasa`, `1819123_jasa`.`1819123_LamaJasa`, `1819123_jasa`.`1819123_HrgJasa`, `1819123_detail_pesan`.`1819123_JmlPesan`, `1819123_detail_pesan`.`1819123_HrgPesan`, `1819123_detail_pesan`.`1819123_JmlPesan` * `1819123_detail_pesan`.`1819123_HrgPesan` AS 'Jumlah_Harga' FROM `1819123_divisi` INNER JOIN `1819123_sp` ON `1819123_divisi`.`1819123_IdDivisi` = `1819123_sp`.`1819123_IdDivisi` JOIN  `1819123_detail_pesan` ON `1819123_detail_pesan`.`1819123_NoSP` = `1819123_sp`.`1819123_NoSP` JOIN `1819123_jasa` ON `1819123_detail_pesan`.`1819123_KdJasa` = `1819123_jasa`.`1819123_KdJasa` WHERE `1819123_sp`.`1819123_NoSP` = '$noSp'";

    return fetchAssoc(query($query));
}

function cariNota($cari)
{
    $query = "SELECT `1819123_sp`.`1819123_TglSP`, `1819123_divisi`.`1819123_NmDivisi`, `1819123_divisi`.`1819123_Alamat`, `1819123_divisi`.`1819123_NoTelp`, `1819123_jasa`.`1819123_NmJasa`, `1819123_jasa`.`1819123_LamaJasa`, `1819123_jasa`.`1819123_HrgJasa`, `1819123_detail_pesan`.`1819123_JmlPesan`, `1819123_detail_pesan`.`1819123_HrgPesan`, `1819123_detail_pesan`.`1819123_JmlPesan` * `1819123_detail_pesan`.`1819123_HrgPesan` AS 'Jumlah_Harga' FROM `1819123_divisi` INNER JOIN `1819123_sp` ON `1819123_divisi`.`1819123_IdDivisi` = `1819123_sp`.`1819123_IdDivisi` JOIN  `1819123_detail_pesan` ON `1819123_detail_pesan`.`1819123_NoSP` = `1819123_sp`.`1819123_NoSP` JOIN `1819123_jasa` ON `1819123_detail_pesan`.`1819123_KdJasa` = `1819123_jasa`.`1819123_KdJasa` WHERE `1819123_sp`.`1819123_TglSP` LIKE '%$cari%' OR `1819123_divisi`.`1819123_NmDivisi` LIKE '%$cari%'  OR `1819123_jasa`.`1819123_NmJasa` LIKE '%$cari%' OR `1819123_divisi`.`1819123_NoTelp` LIKE '%$cari%'";

    return fetchAssoc(query($query));
}

// tambah data mie ayam & bakso
function tambahDataMieAyamBakso($jumlahMieAyam, $jumlahBakso, $totalBayar, $uangPembayaran)
{
    $query = "INSERT INTO `1819123_mieayam_bakso`(`1819123_id`, `1819123_jumlah_mieayam`, `1819123_jumlah_bakso`, `181923_total_harga`, `1819123_uang_pembayaran`) VALUES (NULL, '$jumlahMieAyam', '$jumlahBakso', '$totalBayar', '$uangPembayaran')";
    return query($query);
}
function getDataMieAyamBakso($jumlahMieAyam, $jumlahBakso, $totalBayar, $uangPembayaran)
{
    $query = "SELECT * FROM `1819123_mieayam_bakso` WHERE `1819123_jumlah_mieayam` = '$jumlahMieAyam' AND `1819123_jumlah_bakso` = '$jumlahBakso' AND `181923_total_harga` = '$totalBayar' AND `1819123_uang_pembayaran` = '$uangPembayaran'";
    return fetchAssoc(query($query));
}

function getDataMieAyamBaksoById($idMieAyamBakso)
{
    $query = "SELECT `1819123_jumlah_mieayam`, `1819123_jumlah_bakso`, `181923_total_harga`, `1819123_uang_pembayaran`, `1819123_uang_pembayaran` - `181923_total_harga` AS `uang_kembalian` FROM `1819123_mieayam_bakso` WHERE `1819123_id` = '$idMieAyamBakso'";
    return fetchAssoc(query($query));
}