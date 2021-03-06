<?php
session_start();
require_once 'functions.php';
// ketika tombol login dipencet
if (isset($_POST['login'])) {
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
	} 
	else {
		$getData = getDataByUsername($username);
		// cek kalau ada data
		if ($getData) {
			// cek password
			$passwordDiDatabase = $getData[0]['password'];
			$hakAksesDiDatabase = $getData[0]['hak_akses'];
			if (password_verify($password, $passwordDiDatabase)) {
				$_SESSION['pesan-login'] = 'Login Berhasil!';
				// cek hak akses nya
				if ($hakAksesDiDatabase == 'admin' && $hakAkses == 'admin') {
					//buat session hak akses admin
					$_SESSION['hak-akses'] = 'admin';
					$_SESSION['message'] = "$username Anda Berhasil Login Sebagai Admin";
					$_SESSION['username'] = $username;
					redirect('divisi');
				} else if ($hakAksesDiDatabase == 'staff' && $hakAkses == 'staff') {
					//buat session hak akses staff
					$_SESSION['hak-akses'] = 'staff';
					$_SESSION['message'] = "$username Anda Berhasil Login Sebagai Staff";
					$_SESSION['username'] = $username;
					redirect('pesanan');
				} else {
					$status = 'Username atau password salah!';
				}
			}
		} else {
			$status = 'Username atau password salah!';
		}
	}
}


?>

<?= startHTML('Form Login admib / staff', '<script src="sweetalert.min.js"></script>'); ?>
<style>
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


<h1 class="text-center mt-3">Form Login Admin / Staff</h1>
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
			<div class="row">
				<!-- button login -->
				<button type="submit" class="btn btn-success ml-3" name="login">
					<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff">
						<g>
							<rect fill="none" height="24" width="24" />
						</g>
						<g>
							<path d="M11,7L9.6,8.4l2.6,2.6H2v2h10.2l-2.6,2.6L11,17l5-5L11,7z M20,19h-8v2h8c1.1,0,2-0.9,2-2V5c0-1.1-0.9-2-2-2h-8v2h8V19z" />
						</g>
					</svg> Login Sekarang
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