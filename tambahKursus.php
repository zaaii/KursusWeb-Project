<?php

session_start();
require("model.php");

$user = getData("users");

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

$course_id = !empty($_GET['course_id']) ? $_GET['course_id'] : '';
//memeriksa apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {
  if (insertDataKursus($_POST) > 0) {
    $message = "Data buku berhasil ditambahkan";
    $alertType = "success";
    $alertIcon = "ri-check-line";
  } else {
    $message = "Data buku gagal ditambahkan";
    $alertType = "danger";
    $alertIcon = "ri-close-line";
  }
}

if (isset($_POST["edit"])) {
  if (updateDataKursus($_POST) > 0) {
     $message = "Data buku berhasil diubah";
     $alertType = "primary";
     $alertIcon = "ri-check-line";
  } else {
     $message = "Data buku gagal diubah";
     $alertType = "danger";
     $alertIcon = "ri-close-line";
  }
}

// Check Role user
checkRole($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, shrink-to-fit=9" />
  <title>Kursus - Tambah Kursus Baru</title>

  <!-- Favicon Icon -->
  <link rel="icon" type="image/png" href="images/fav.png" />

  <!-- Stylesheets -->
  <link href="http://fonts.googleapis.com/css?family=Roboto:400,700,500" rel="stylesheet" />
  <link href="vendor/unicons-2.0.1/css/unicons.css" rel="stylesheet" />
  <link href="css/vertical-responsive-menu1.min.css" rel="stylesheet" />
  <link href="css/instructor-dashboard.css" rel="stylesheet" />
  <link href="css/instructor-responsive.css" rel="stylesheet" />
  <link href="css/night-mode.css" rel="stylesheet" />
  <link href="css/jquery-steps.css" rel="stylesheet" />

  <!-- Vendor Stylesheets -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <link href="vendor/OwlCarousel/assets/owl.carousel.css" rel="stylesheet" />
  <link href="vendor/OwlCarousel/assets/owl.theme.default.min.css" rel="stylesheet" />
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="vendor/semantic/semantic.min.css" />
  <link href="vendor/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" />
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
    <?php if(empty($course_id)) : ?>
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2 class="st_title">
              <i class="uil uil-analysis"></i> Buat Kursus Baru
            </h2>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="course_tabs_1">
              <div class="step-content">
                <div class="step-tab-panel step-tab-info active" id="tab_step1">
                  <div class="tab-from-content">
                    <div class="title-icon">
                      <h3 class="title">
                        <i class="uil uil-info-circle"></i>Informasi Kursus
                      </h3>
                    </div>
                    <form method="POST">
                      <div class="course__form">
                        <div class="general_info10">
                          <?php if (isset($message)) : ?>
                            <div class="alert text-white bg-<?= $alertType ?> mr-2 ml-2 mt-4" role="alert">
                              <div class="iq-alert-icon">
                                <i class="<?= $alertIcon ?>"></i>
                              </div>
                              <div class="iq-alert-text"><?= $message ?></div>
                            </div>
                          <?php endif; ?>
                          <div class="row">
                            <div class="col-lg-12 col-md-12">
                              <div class="ui search focus mt-30 lbel25">
                                <label>Thumbnail Kursus</label>
                                <div class="thumb-dt">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept="image/png, image/jpeg, image/webp" name="image_url" id="image_url" required>
                                    <label class="custom-file-label">Choose file</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                              <div class="ui search focus mt-30 lbel25">
                                <label>Judul Kursus</label>
                                <div class="ui left icon input swdh19">
                                  <input class="prompt srch_explore" type="text" placeholder="Course title here" name="title" data-purpose="edit-course-title" maxlength="60" id="title" required />
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                              <div class="ui search focus mt-30 lbel25">
                                <label>Durasi Kursus</label>
                                <div class="ui left icon input swdh19">
                                  <input class="prompt srch_explore" type="text" placeholder="Course title here" name="duration" data-purpose="edit-course-title" maxlength="60" id="duration" required />
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                              <div class="ui search focus lbel25 mt-30">
                                <label>Deskripsi Singkat</label>
                                <div class="ui form swdh30">
                                  <div class="field">
                                    <textarea rows="3" name="short_description" id="short_description" placeholder="short description here..."></textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                              <div class="course_des_textarea mt-30 lbel25">
                                <label>Deskripsi Lengkap</label>
                                <div class="course_des_bg">
                                  <ul class="course_des_ttle">
                                    <li>
                                      <a href="#"><i class="uil uil-bold"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-italic"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-list-ul"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-left-to-right-text-direction"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-right-to-left-text-direction"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-list-ui-alt"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-link"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-text-size"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-text"></i></a>
                                    </li>
                                  </ul>
                                  <div class="textarea_dt">
                                    <div class="ui form swdh339">
                                      <div class="field">
                                        <textarea rows="5" name="full_description" id="full_description" placeholder="Insert your full course description"></textarea>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <button class="btn btn-default steps_btn data-direction=" name="submit" type="submit">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif ?>
      <?php if(!empty($course_id)) : ?>
        <?php $kursus = getData("courses WHERE course_id = $course_id")[0]; ?>
        <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2 class="st_title">
              <i class="uil uil-analysis"></i> Edit Kursus
            </h2>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="course_tabs_1">
              <div class="step-content">
                <div class="step-tab-panel step-tab-info active" id="tab_step1">
                  <div class="tab-from-content">
                    <div class="title-icon">
                      <h3 class="title">
                        <i class="uil uil-info-circle"></i>Informasi Kursus
                      </h3>
                    </div>
                    <form method="POST">
                      <div class="course__form">
                        <div class="general_info10">
                          <?php if (isset($message)) : ?>
                            <div class="alert text-white bg-<?= $alertType ?> mr-2 ml-2 mt-4" role="alert">
                              <div class="iq-alert-icon">
                                <i class="<?= $alertIcon ?>"></i>
                              </div>
                              <div class="iq-alert-text"><?= $message ?></div>
                            </div>
                          <?php endif; ?>
                          <div class="row">
                            <div class="col-lg-12 col-md-12">
                              <div class="ui search focus mt-30 lbel25">
                                <label>Thumbnail Kursus</label>
                                <div class="thumb-dt">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept="image/png, image/jpeg, image/webp" name="image_url" id="image_url">
                                    <label class="custom-file-label">Choose file</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <input type="hidden" name="course_id" id="course_id" value="<?= $kursus["course_id"] ?>">
                            <div class="col-lg-12 col-md-12">
                              <div class="ui search focus mt-30 lbel25">
                                <label>Judul Kursus</label>
                                <div class="ui left icon input swdh19">
                                  <input class="prompt srch_explore" type="text" placeholder="Course title here" name="title" value="<?= $kursus["title"] ?>" data-purpose="edit-course-title" maxlength="60" id="title" required />
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                              <div class="ui search focus mt-30 lbel25">
                                <label>Durasi Kursus</label>
                                <div class="ui left icon input swdh19">
                                  <input class="prompt srch_explore" type="text" placeholder="Course title here" name="duration" value="<?= $kursus["duration"] ?>" data-purpose="edit-course-title" maxlength="60" id="duration" required />
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                              <div class="ui search focus lbel25 mt-30">
                                <label>Deskripsi Singkat</label>
                                <div class="ui form swdh30">
                                  <div class="field">
                                    <textarea rows="3" name="short_description" id="short_description" placeholder="short description here..."><?= $kursus["short_description"] ?></textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                              <div class="course_des_textarea mt-30 lbel25">
                                <label>Deskripsi Lengkap</label>
                                <div class="course_des_bg">
                                  <ul class="course_des_ttle">
                                    <li>
                                      <a href="#"><i class="uil uil-bold"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-italic"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-list-ul"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-left-to-right-text-direction"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-right-to-left-text-direction"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-list-ui-alt"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-link"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-text-size"></i></a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="uil uil-text"></i></a>
                                    </li>
                                  </ul>
                                  <div class="textarea_dt">
                                    <div class="ui form swdh339">
                                      <div class="field">
                                        <textarea rows="5" name="full_description" id="full_description" placeholder="Insert your full course description"><?= $kursus["full_description"] ?></textarea>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <button class="btn btn-default steps_btn data-direction=" name="edit" type="submit">Ubah</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php include 'footer.php'; ?>
  </div>
  <!-- Body End -->

  <script src="js/vertical-responsive-menu.min.js"></script>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/OwlCarousel/owl.carousel.js"></script>
  <script src="vendor/jquery-ui-1.12.1/jquery-ui.js"></script>
  <script src="js/custom.js"></script>
  <script src="js/night-mode.js"></script>
  <script src="js/jquery-steps.min.js"></script>
  <script>
    $(function() {
      $(".sortable").sortable();
      $(".sortable").disableSelection();
    });
  </script>
</body>

</html>