<?php
session_start();
require("model.php");

$course_id = !empty($_GET['course_id']) ? $_GET['course_id'] : '';
$materilist = getData("materials");

//cek apakah user sudah login
if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

// Call the addTask function
if (isset($_POST["submit"])) {
	if (insertDataMateri($_POST) > 0) {
		echo "
		  <script>
			alert('Materi successfully added!');
		window.location.href = 'detail_kursus.php?course_id=$course_id';
		  </script>
		";
	} else {
		echo "
		  <script>
			alert('Materi failed to added!');
		window.location.href = 'detail_kursus.php?course_id=$course_id';
		  </script>
		";
	}
}

// Call the addTask function
if (isset($_POST["edit"])) {
	if (updateDataMateri($_POST) > 0) {
		echo "
		  <script>
			alert('Materi successfully Edited!');
			window.location.href = 'detail_kursus.php?course_id=$course_id';
		  </script>
		";
	} else {
		echo "
		  <script>
			alert('Materi failed to Edited!');
			window.location.href = 'detail_kursus.php?course_id=$course_id';
		  </script>
		";
	}
}

if (isset($_GET['material_id'])) {
	$material_id = $_GET['material_id'];
	if (deleteDataMateri($material_id) > 0) {
		echo "
		  <script>
			alert('Materi successfully deleted!');
		window.reload();
		  </script>
		";
	} else {
		echo "
		  <script>
			alert('Materi failed deleted!');
		window.reload();
		  </script>
		";
	}
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
	<title>Kursus - Detail Kursus</title>

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
	<!-- Left Sidebar Start -->
	<?php include("sidebar.php"); ?>
	<!-- Body Start -->
	<?php $kursus = getData("courses WHERE course_id = $course_id")[0]; ?>
	<div class="wrapper _bg4586">
		<div class="_215b01">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="section3125">
							<div class="row justify-content-center">
								<div class="col-xl-4 col-lg-5 col-md-6">
									<div class="preview_video">
										<a class="fcrse_img" data-toggle="modal" data-target="#videoModal">
											<img src="images/courses/img-2.jpg" alt="">
										</a>
									</div>
								</div>
								<div class="col-xl-8 col-lg-7 col-md-6">
									<div class="_215b03">
										<h2><?= $kursus["title"] ?></h2>
									</div>
									<div class="_215b06">
										<div class="_215b07">
											<span><i class='uil-clock-eight'></i></span>
											Durasi Belajar
											<strong><?= $kursus["duration"] ?> Jam</strong>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="_215b15 _byt1458">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="user_dt5">
							<div class="user_dt_right">
								<button class="subscribe-btn" data-toggle="modal" data-target="#exampleModal-03" fdprocessedid="lmb1tq">Tambah Materi</button>
							</div>
						</div>
						<div class="course_tabs">
							<nav>
								<div class="nav nav-tabs tab_crse justify-content-center" id="nav-tab" role="tablist">
									<a class="nav-item nav-link active" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-selected="true">Tentang Kursus</a>
									<a class="nav-item nav-link" id="nav-courses-tab" data-toggle="tab" href="#nav-courses" role="tab" aria-selected="false">Materi</a>
								</div>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="_215b17">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="course_tab_content">
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-about" role="tabpanel">
									<div class="_htg451">
										<div class="_htg452 mt-35">
											<h3>Deskripsi</h3>
											<p><?= $kursus["full_description"] ?></p>
										</div>
									</div>
									<div class="tab-pane fade" id="nav-courses" role="tabpanel">
										<div class="crse_content">
											<h3>Materi</h3>
											<div id="accordion" class="ui-accordion ui-widget ui-helper-reset">
												<?php foreach ($materilist as $materi) : ?>
													<?php if ($materi["course_id"] == $course_id) : ?>
														<a class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all">
															<div class="section-header-left">
																<span class="section-title-wrapper">
																	<i class='uil uil-presentation-play crse_icon'></i>
																	<span class="section-title-text"><?= $materi["title"] ?></span>
																</span>
															</div>
															<div class="section-header-right">
																<span onclick="window.location.href='<?= $materi['embed_link'] ?>'" class="btn btn-primary">Lihat Materi</span>
																<span data-toggle="modal" data-target="#modalEdit" data-task-id="<?= $materi["material_id"]; ?>" title="Edit" class="btn btn-danger"><i class="uil uil-edit-alt"></i></span>
																<span onclick="window.location.href='?material_id=<?= $materi['material_id'] ?>'" title="Delete" class="btn btn-danger"><i class="uil uil-trash-alt"></i></span>
															</div>
														</a>
														<div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
															<div class="lecture-container">
																<div class="left-content">
																	<div class="top">
																		<div class="title"><?= $materi["description"] ?></div>
																	</div>
																</div>
															</div>
														<?php endif; ?>
													<?php endforeach; ?>
														</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php include("footer.php"); ?>
			</div>

			<div class="modal fade" id="exampleModal-03" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Tambah Materi Baru</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body p-5">
							<form method="post">
								<div class="form-group">
									<input type="text" class="form-control" name="course_id" value="<?= $course_id ?>" placeholder="" hidden>
								</div>
								<div class="form-group">
									<label for="title">Judul Materi</label>
									<input type="text" class="form-control" name="title" placeholder="Enter Course Title" required>
								</div>
								<div class="form-group">
									<label for="description">Deskripsi</label>
									<textarea class="form-control" name="description" placeholder="Enter Short Description" required></textarea>
								</div>
								<div class="form-group">
									<label for="link">Embed Link</label>
									<textarea class="form-control" name="embed_link" placeholder="Enter Embed Link" required></textarea>
								</div>
								<button type="submit" name="submit" class="btn btn-primary">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit Materi</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body p-5">
							<form method="post">
								<div class="form-group">
									<input type="text" class="form-control" name="material_id" value="<?= $materi["material_id"] ?>" placeholder="" hidden>
								</div>
								<div class="form-group">
									<label for="title">Judul Materi</label>
									<input type="text" class="form-control" name="title" value="<?= $materi["title"] ?>" placeholder="Enter Course Title" required>
								</div>
								<div class="form-group">
									<label for="description">Deskripsi</label>
									<textarea class="form-control" name="description" placeholder="Enter Short Description" required><?= $materi["description"] ?></textarea>
								</div>
								<div class="form-group">
									<label for="link">Embed Link</label>
									<textarea class="form-control" name="embed_link" placeholder="Enter Embed Link" required><?= $materi["embed_link"] ?></textarea>
								</div>
								<button type="submit" name="edit" class="btn btn-primary">Ubah</button>
							</form>
						</div>
					</div>
				</div>
			</div>

			<!-- Body End -->

			<script src="js/vertical-responsive-menu.min.js"></script>
			<script src="js/jquery-3.3.1.min.js"></script>
			<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
			<script src="vendor/OwlCarousel/owl.carousel.js"></script>
			<!-- <script src="vendor/semantic/semantic.min.js"></script> -->
			<script src="js/custom.js"></script>
			<script src="js/night-mode.js"></script>

</body>

</html>