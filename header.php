<header class="header clearfix">
    <button type="button" id="toggleMenu" class="toggle_menu">
        <i class='uil uil-bars'></i>
    </button>
    <button id="collapse_menu" class="collapse_menu">
        <i class="uil uil-bars collapse_menu--icon "></i>
        <span class="collapse_menu--label"></span>
    </button>
    <div class="main_logo" id="logo">
        <a href="index.php"><img src="images/logo.svg" alt=""></a>
        <a href="index.php"><img class="logo-inverse" src="images/ct_logo.svg" alt=""></a>
    </div>
    <div class="header_right">
        <ul>
            <?php
            // Checking User Role
            $role = $_SESSION['role'];
            if ($role == 'admin') {
            ?>
                <li>
                    <a href="tambahKursus.php" class="upload_btn" title="Create New Course">Tambah Kursus Baru</a>
                </li>
            <?php
            }
            ?>
            <li class="ui dropdown">
                <a href="#" class="option_links" title="Notifications"><i class='uil uil-bell'></i><span class="noti_count">1</span></a>
                <div class="menu dropdown_mn">
                    <a href="#" class="channel_my item">
                        <div class="profile_link">
                            <img src="images/left-imgs/img-2.jpg" alt="">
                            <div class="pd_content">
                                <h6>Admin Kursus</h6>
                                <p>Selamat Datang di <strong>Kursus</strong>.</p>
                                <span class="nm_time">now</span>
                            </div>
                        </div>
                    </a>
                </div>
            </li>
            <li class="ui dropdown">
                <a href="#" class="opts_account" title="Account">
                    <img src="images/hd_dp.jpg" alt="">
                </a>
                <div class="menu dropdown_account">
                    <div class="channel_my">
                        <div class="profile_link">
                            <img src="images/hd_dp.jpg" alt="">
                            <div class="pd_content">
                                <div class="rhte85">
                                    <h6><?= $_SESSION["full_name"]; ?></h6>
                                    <div class="mef78" title="Verify">
                                        <i class='uil uil-check-circle'></i>
                                    </div>
                                </div>
                                <span><?= $_SESSION["email"]; ?></span>
                            </div>
                        </div>
                    </div>
                    <a href="logout.php" class="item channel_item">Sign Out</a>
                </div>
            </li>
        </ul>
    </div>
</header>