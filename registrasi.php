<?php
require("model.php");
session_start();
//cek login atau tidak
if (isset($_SESSION["login"])) {
	header("Location: index.php");
	exit;
}


if (isset($_POST["submit"])) {
	if (isEmailExist($_POST['email'])) {
		$message = "This <strong>email is already registered</strong>. Please try again with a different email.";
		$alertType = "warning";
		$alertIcon = "ri-alert-line";
	} else {
		if (register($_POST) > 0) {
			$message = "Your account has been <strong>successfully created</strong>. Please login to continue.";
			$alertType = "success";
			$alertIcon = "ri-check-line";
		} else {
			$message = "Your account <strong>failed to be created</strong>. Please try again.";
			$alertType = "danger";
			$alertIcon = "ri-close-line";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, shrink-to-fit=9">
	<title>Kursus - Registrasi</title>

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
						<h2>Selamat Datang di Kursus</h2>
						<p>Daftar dan Mulai Belajar 😁</p>
						<?php if (isset($message)) : ?>
							<div class="alert text-white bg-<?= $alertType ?> mr-0 ml-0" role="alert">
								<div class="iq-alert-icon">
									<i class="<?= $alertIcon ?>"></i>
								</div>
								<div class="iq-alert-text"><?= $message ?></div>
							</div>
						<?php endif; ?>
						<form method="POST">
							<div class="ui search focus">
								<div class="ui left icon input swdh11 swdh19">
									<input class="prompt srch_explore" type="text" name="full_name" id="fullname" maxlength="64" placeholder="Full Name">
								</div>
							</div>
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh11 swdh19">
									<input class="prompt srch_explore" type="email" name="email" id="email" maxlength="64" placeholder="Email Address">
								</div>
							</div>
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh11 swdh19">
									<input class="prompt srch_explore" type="password" name="password" id="password" maxlength="64" placeholder="Password">
								</div>
							</div>
							<button class="login-btn" type="submit" name="submit">Daftar</button>
						</form>
						<p class="mb-0 mt-30">Sudah mempunyai akun ? <a href="login.php">Masuk</a></p>
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
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>