<?php
session_start();
require_once 'functions.php';
// cek session login untuk admin
if (!middleware('admin')) {
  redirect('login');
}
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}

if (isset($_POST['add-user'])) {
	$username = filter($_POST['username']);
	$password = filter($_POST['password']);
	$hakAkses = filter($_POST['hak-akses']);
	// username harus 6 karakter atau lebih
	if (strlen($username) < 6) {
		$status = 'username terlalu pendek!';
	}
	// password harus 6 karakter atau lebih
	else if (strlen($password) < 6) {
		$status = 'password terlalu pendek!';
	}
	// cek hak akses hanya admin atau staff
	else if (!$hakAkses == 'admin' || !$hakAkses == 'staff') {
		$status = 'maaf hak akses hanya ada admin atau staff';
	} else {
		// cek username (username harus unik)
		$cekUsername = getUsername($username);
		if ($cekUsername) {
			// jika ada username maka tampilkan pesan error
			$status = 'Maaf username sudah ada yang punya';
		} else {
			// tambahkan username beserta password dan hak ases nya
			$addUser = addUser($username, $password, $hakAkses);
			// cek apakah data berhasil ditambahkan?
			if ($addUser) {
				$berhasil = 'Data user berhasil ditambahkan!';
			} else {
				$status = 'Data user gagal ditambahkan!';
			}
		}
	}
}

?>

<?= startHTML('Form Add User Admin & Staff', '<script src="sweetalert.min.js"></script>'); ?>
<style>
.active {
    color: white !important;
  }

	.form-icon {
		left: 5px;
		top: 39px;
		position: absolute;
	}

	.form-control {
		padding-left: 2rem;
	}

	body {
		overflow-x: hidden;
	}

	.tombol-logout:hover {
    color: #28a745 !important;
    background-color: #ededed;
  }
</style>
<?php
// cek apakah variabel status ada?
// kalau ada tampilkan
if (isset($status)) {
	echo '<script>
							swal({
							title: "Opps ..",
							text: " ' . $status . ' ",
							icon: "error",
						});
					</script>';
	// hapus variabel
	unset($status);
}
// cek apakah variabel berhasil ada?
// kalau ada tampilkan
else if (isset($berhasil)) {
	echo '<script>
						swal({
						title: "Selamat ..",
						text: " ' . $berhasil . ' ",
						icon: "success",
					});
				</script>';
	// hapus variabel
	unset($berhasil);
}
// logout
// cek apakah variabel berhasil ada?
// kalau ada tampilkan
else if (isset($_COOKIE['logout'])) {
	echo '<script>
						swal({
						title: "Selamat ..",
						text: " ' . $_COOKIE['logout'] . ' ",
						icon: "success",
					});
				</script>';
	// hapus variabel
	setcookie('logout', '');
}

?>

<!-- START: navbar -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #28a745;">
  <a class="navbar-brand" href="divisi.php">
    <img src="logo.png" alt="logo metik" width="60" height="50" />
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
    <?php if (middleware('admin')) : ?>
      <a class="nav-link" href="divisi.php">Divisi <span class="sr-only">(current)</span></a>
      <a class="nav-link" href="jasa.php">Jasa</a>
      <a class="nav-link active" href="#">Add User</a>
    <?php endif; ?>
      <a class="nav-link" href="pesanan.php">Pesanan</a>
      <a class="nav-link" href="cetak-nota.php">Cetak Nota</a>
    </div>
  </div>
  <span class="navbar-text text-white mr-5">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
      <path d="M0 0h24v24H0V0z" fill="none" />
      <path d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
    </svg> <?= $username; ?>
    <a href="logout.php" class="text-white ml-2 btn btn-outline-light tombol-logout">Logout</a>
  </span>
</nav>
<!-- END: navbar -->

<h1 class="text-center mt-3">Form Add User Admin & Staff</h1>
<!-- logo -->
<div class="container mx-auto text-center">
	<img src="logo.png" alt="logo metik" width="150" height="150" class="mt-5" />
</div>
<!-- form login -->
<div class="row justify-content-center">
	<div class="col-3">
		<form action="" method="POST">
			<!-- username -->
			<div class="form-group position-relative">
				<label for="username">Username</label>
				<!-- icon username -->
				<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="form-icon">
					<path d="M0 0h24v24H0V0z" fill="none" />
					<path d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
				</svg>
				<input type="username" name="username" class="form-control" id="username" required placeholder="Minimal 6 karakter" />
			</div>
			<!-- password -->
			<div class="form-group position-relative">
				<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="form-icon">
					<g fill="none">
						<path d="M0 0h24v24H0V0z" />
						<path d="M0 0h24v24H0V0z" opacity=".87" />
					</g>
					<path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
				</svg>
				<label for="password">Password</label>
				<input type="password" class="form-control" name="password" id="password" required placeholder="Minimal 6 karakter" />
			</div>
			<!-- hak akses -->
			<div class="form-group position-relative">
				<label for="hakAkses">Hak Akses</label>
				<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#28a745" class="form-icon">
					<path d="M0 0h24v24H0V0z" fill="none" />
					<path d="M20.5 6c-2.61.7-5.67 1-8.5 1s-5.89-.3-8.5-1L3 8c1.86.5 4 .83 6 1v13h2v-6h2v6h2V9c2-.17 4.14-.5 6-1l-.5-2zM12 6c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
				</svg>
				<select class="form-control" id="hakAkses" name="hak-akses" required>
					<option value="admin">Admin</option>
					<option value="staff">Staff</option>
				</select>
			</div>
			<div class="row ml-1">
				<!-- button add user -->
				<button type="submit" class="btn btn-success" name="add-user">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
					</svg>Add User
				</button>
			</div>

			<!-- button keluar -->
			<!-- <button type="submit" class="btn btn-danger ml-4" name="keluar">Keluar</button> -->
		</form>
	</div>
</div>
<br>
<?php require_once 'footer.php'; ?>
<?= endHTML(); ?>