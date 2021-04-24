<?php
session_start();
if (isset($_SESSION['username'])) {
  // ambil username
  $username = $_SESSION['username'];
  // hapus sesluruh session
  session_destroy();
  // set cookie lagi untuk message 
  setcookie('logout', $username . ' Kamu Berhasil Logout!');
  header('Location: login.php');
} else {
  session_destroy();
  header('Location: login.php');
}
