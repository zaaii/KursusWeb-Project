<?php
session_start();
require("model.php");

   $courses = getData("courses");

//cek apakah user sudah login
if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

// Check if sesion user still exists
if (isSessionStillAlive($_SESSION) == false) {
	// jika session is already not exist in database delete existing session
	$_SESSION = [];
	header("Location:login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, shrink-to-fit=9">
	<title>Kursus - Beranda</title>

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
	<!-- Header Start -->
	<?php include("header.php"); ?>
	<!-- Header End -->
	<!-- Left Sidebar Start -->
	<?php include("sidebar.php"); ?>
	<!-- Left Sidebar End -->
	<!-- Body Start -->
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h4 class="item_title">Daftar Kursus</h4>
						<div class="_14d25">
							<div class="row">
							<?php foreach ($courses as $kursus) : ?>
								<div class="col-lg-3 col-md-4">
									<div class="fcrse_1 mt-30">
										<a href="detail_kursus.php?course_id=<?= $kursus["course_id"]; ?>" class="fcrse_img">
											<img src="images/courses/img-1.jpg" alt="">
											<div class="course-overlay">
												<div class="crse_timer">
													<?= $kursus["duration"] ?> Jam
												</div>
											</div>
										</a>
										<div class="fcrse_content">
											<a href="detail_kursus.php?course_id=<?= $kursus["course_id"]; ?>" class="crse14s"><?= $kursus["title"] ?></a>
											<a class="crse-cate"><?= $kursus["short_description"] ?></a>
										</div>
									</div>
								</div>
								<?php endforeach ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include("footer.php"); ?>
	</div>
	<!-- Body End -->

	<script src="js/vertical-responsive-menu.min.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/OwlCarousel/owl.carousel.js"></script>
	<script src="vendor/semantic/semantic.min.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/night-mode.js"></script>

</body>

</html>