<?php
session_start();
require("model.php");

$kursuslist = getData("courses");

//cek apakah user sudah login
if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

if (isset($_GET['course_id'])) {
	$course_id = $_GET['course_id'];
	if (deleteDataKursus($course_id) > 0) {
		$message = "Data berhasil dihapus";
		$alertType = "primary";
		$alertIcon = "ri-check-line";
		echo "<script>location.reload()</script>";
	} else {
		$message = "Data gagal dihapus";
		$alertType = "danger";
		$alertIcon = "ri-close-line";
		echo "<script>location.reload()</script>";
	}
}

// Check if sesion user still exists
if (isSessionStillAlive($_SESSION) == false) {
	// jika session is already not exist in database delete existing session
	$_SESSION = [];
	header("Location:login.php");
}

// Check Role user
checkRole($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, shrink-to-fit=9">
	<title>Kursus - Kursus Manajemen</title>

	<!-- Favicon Icon -->
	<link rel="icon" type="image/png" href="images/fav.png">

	<!-- Stylesheets -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
	<link href='vendor/unicons-2.0.1/css/unicons.css' rel='stylesheet'>
	<link href="css/vertical-responsive-menu1.min.css" rel="stylesheet">
	<link href="css/instructor-dashboard.css" rel="stylesheet">
	<link href="css/instructor-responsive.css" rel="stylesheet">
	<link href="css/night-mode.css" rel="stylesheet">
	<link href="css/datepicker.min.css" rel="stylesheet">

	<!-- Vendor Stylesheets -->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
	<link href="vendor/OwlCarousel/assets/owl.carousel.css" rel="stylesheet">
	<link href="vendor/OwlCarousel/assets/owl.theme.default.min.css" rel="stylesheet">
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="vendor/semantic/semantic.min.css">

</head>

<body>
	<!-- Header Start -->
	<?php include("header.php") ?>
	<!-- Header End -->
	<!-- Left Sidebar Start -->
	<?php include("sidebar.php") ?>
	<!-- Left Sidebar End -->
	<!-- Body Start -->
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h2 class="st_title"><i class="uil uil-book-alt"></i>Kursus</h2>
					</div>
					<div class="col-md-12">
						<div class="card_dash1">
							<div class="card_dash_left1">
								<i class="uil uil-book-alt"></i>
								<h1>Pergi membuat kursus baru</h1>
							</div>
							<div class="card_dash_right1">
								<button class="create_btn_dash" onclick="window.location.href = 'tambahKursus.php';">Buat Kursus Baru</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="my_courses_tabs">
							<?php if (isset($message)) : ?>
								<div class="alert text-white bg-<?= $alertType ?> mr-2 ml-2 mt-4" role="alert">
									<div class="iq-alert-icon">
										<i class="<?= $alertIcon ?>"></i>
									</div>
									<div class="iq-alert-text"><?= $message ?></div>
								</div>
							<?php endif; ?>
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-my-courses" role="tabpanel">
									<div class="table-responsive mt-30">
										<table class="table ucp-table">
											<thead class="thead-s">
												<tr>
													<th>Title</th>
													<th class="text-center" scope="col">Deskripsi</th>
													<th class="text-center" scope="col">Durasi</th>
													<th class="text-center" scope="col">Action</th>
												</tr>
											</thead>
											<?php foreach ($kursuslist as $kursus) : ?>
												<tbody>
													<tr>
														<td><?= $kursus["title"] ?></td>
														<td class="text-center"><?= $kursus["short_description"] ?></td>
														<td class="text-center"><?= $kursus["duration"] ?> Jam</td>
														<td class="text-center">
															<a href="tambahKursus.php?course_id=<?= $kursus["course_id"]; ?>" title="Edit" class="gray-s"><i class="uil uil-edit-alt"></i></a>
															<a href="?course_id=<?= $kursus["course_id"] ?>" title="Delete" class="gray-s"><i class="uil uil-trash-alt"></i></a>
														</td>
													</tr>
												</tbody>
											<?php endforeach; ?>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include("footer.php") ?>
	</div>
	<!-- Body End -->

	<script src="js/vertical-responsive-menu.min.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/OwlCarousel/owl.carousel.js"></script>
	<script src="vendor/semantic/semantic.min.js"></script>
	<script src="js/custom1.js"></script>
	<script src="js/night-mode.js"></script>
	<script src="js/datepicker.min.js"></script>
	<script src="js/i18n/datepicker.en.js"></script>

</body>

</html>