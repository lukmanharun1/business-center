<?php

function koneksi()
{
    return mysqli_connect('localhost', 'root', '', '1819123_lukman');
}

function startHTML($title = '', $includeCSS = '')
{
    return '<!doctype html>
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

function getDataByUsername($username)
{
    $query = "SELECT `username`, `password`, `hak_akses` FROM `1819123_akses` WHERE username = '$username'";
    return fetchAssoc(query($query));
}

function addUser($username, $password, $hakAkses)
{
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO `1819123_akses`(`id`, `username`, `password`, `hak_akses`) VALUES ('', '$username', '$passwordHash', '$hakAkses')";
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
    $query = "INSERT INTO `1819123_divisi`(`1819123_IdDivisi`, `1819123_NmDivisi`, `1819123_Alamat`, `1819123_NoTelp`) VALUES ('', '$namaDivisi', '$alamatDivisi', '$noTelpDivisi')";
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
    $query = "INSERT INTO `1819123_jasa`(`1819123_KdJasa`, `1819123_NmJasa`, `1819123_LamaJasa`, `1819123_HrgJasa`) VALUES ('',  '$namaJasa', '$lamaJasa', '$hargaJasa')";
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
    // ambil seluruh data divisi berdasarkan pencarian
    $query = "SELECT * FROM `1819123_jasa` WHERE `1819123_NmJasa` LIKE '%$cari%' OR `1819123_LamaJasa` LIKE '%$cari%' OR `1819123_HrgJasa` LIKE '%$cari%'";
    return fetchAssoc(query($query));
}

function cariJasaByKdJasa($kdJasa)
{
    $query = "SELECT * FROM `1819123_jasa` WHERE `1819123_KdJasa` = '$kdJasa'";
    return fetchAssoc(query($query));
}

function tambahDetailPesan($kdJasa, $jumlahPesan, $hargaPesan)
{
    $query = "INSERT INTO `1819123_detail_pesan`(`1819123_NoSP`, `1819123_KdJasa`, `1819123_JmlPesan`, `1819123_HrgPesan`) VALUES ('', '$kdJasa', '$jumlahPesan', '$hargaPesan')";
    return query($query);
}

function cetakPesanan()
{
    // join table 1819123_jasa sama 1819123_detail_pesan -> ON kd jasa
    $query = "SELECT `1819123_detail_pesan`.`1819123_NoSP`, `1819123_jasa`.`1819123_NmJasa`, `1819123_jasa`.`1819123_LamaJasa`, `1819123_detail_pesan`.`1819123_JmlPesan`, `1819123_detail_pesan`.`1819123_HrgPesan`, `1819123_detail_pesan`.`1819123_JmlPesan` * `1819123_detail_pesan`.`1819123_HrgPesan` AS 'Jumlah_Harga' FROM `1819123_detail_pesan` INNER JOIN `1819123_jasa` ON `1819123_detail_pesan`.`1819123_KdJasa` = `1819123_jasa`.`1819123_KdJasa`";
    return fetchAssoc(query($query));
}

function hapusPesanan($noSp)
{
    $query = "DELETE FROM `1819123_detail_pesan` WHERE `1819123_NoSP` = '$noSp'";
    return query($query);
}
