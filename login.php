<?php
require("model.php");
session_start();
//cek login atau tidak
if (isset($_SESSION["login"])) {
	header("Location: index.php");
	exit;
}

if (isset($_POST["submit"])) {
	$email = $_POST["email"];
	$password = $_POST["password"];
	$result = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
	//cek email
	if (mysqli_num_rows($result) === 1) {
		//cek password
		$row = mysqli_fetch_assoc($result);
		if (password_verify($password, $row["password"])) {
			//set session
			$_SESSION["login"] = true;
			$_SESSION["id_user"] = $row["id_user"];
			$_SESSION["full_name"] = $row["full_name"];
			$_SESSION["email"] = $row["email"];
			$_SESSION["password"] = $row["password"];
			$_SESSION["user_photo"] = $row["user_photo"];
			$_SESSION["role"] = $row["role"];
			$_SESSION["date_created"] = $row["date_created"];

			setcookie("id_user", $row["id_user"], time() + 60);
			header("Location: index.php");
			exit;
		} else {
			$message = "Email Atau Password Salah";
			$alertType = "danger";
			$alertIcon = "ri-close-line";
		}
	}

	if (isset($_POST["rememberme"])) {
		//buat cookie
		setcookie("login", "true", time() + 60);
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, shrink-to-fit=9">
	<title>Kursus - Login</title>

	<!-- Favicon Icon -->
	<link rel="icon" type="image/png" href="images/fav.png">

	<!-- Stylesheets -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
	<link href='vendor/unicons-2.0.1/css/unicons.css' rel='stylesheet'>
	<link href="css/vertical-responsive-menu.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<link href="css/night-mode.css" rel="stylesheet">

	<!-- Vendor Stylesheets -->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
	<link href="vendor/OwlCarousel/assets/owl.carousel.css" rel="stylesheet">
	<link href="vendor/OwlCarousel/assets/owl.theme.default.min.css" rel="stylesheet">
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="vendor/semantic/semantic.min.css">

</head>

<body>
	<!-- Signup Start -->
	<div class="sign_in_up_bg">
		<div class="container">
			<div class="row justify-content-lg-center justify-content-md-center">
				<div class="col-lg-12">
					<div class="main_logo25" id="logo">
						<a href="index.php"><img src="images/logo.svg" alt=""></a>
						<a href="index.php"><img class="logo-inverse" src="images/ct_logo.svg" alt=""></a>
					</div>
				</div>

				<div class="col-lg-6 col-md-8">
					<div class="sign_form">
						<h2>Selamat Datang ~</h2>
						<p>Masuk menggunakan akun Kursus</p>
						<?php if (isset($message)) : ?>
							<div class="alert text-white bg-<?= $alertType ?> mr-0 ml-0" role="alert">
								<div class="iq-alert-icon">
									<i class="<?= $alertIcon ?>"></i>
								</div>
								<div class="iq-alert-text"><?= $message ?></div>
							</div>
						<?php endif; ?>
						<form method="POST">
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh95">
									<input class="prompt srch_explore" type="email" name="email" id="email" maxlength="64" placeholder="Email Address">
									<i class="uil uil-envelope icon icon2"></i>
								</div>
							</div>
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh95">
									<input class="prompt srch_explore" type="password" name="password" id="password" maxlength="64" placeholder="Password">
									<i class="uil uil-key-skeleton-alt icon icon2"></i>
								</div>
							</div>
							<div class="ui form mt-30 checkbox_sign">
								<div class="inline field">
									<div class="ui checkbox mncheck">
										<input type="checkbox" tabindex="0" name="rememberme" class="hidden">
										<label>Remember Me</label>
									</div>
								</div>
							</div>
							<button class="login-btn" type="submit" name="submit">Masuk</button>
						</form>
						<p class="mb-0 mt-30 hvsng145">Belum Punya Akun ? <a href="registrasi.php">Daftar</a></p>
					</div>
					<div class="sign_footer">© 2023 <strong>Kursus</strong>. All Rights Reserved.</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Signup End -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/OwlCarousel/owl.carousel.js"></script>
	<script src="vendor/semantic/semantic.min.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/night-mode.js"></script>

</body>

</html>