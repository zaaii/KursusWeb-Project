<?php
require("koneksi.php");

//fungsi untuk menampilkan data
function getData($tabel)
{
    //digunakan untuk mengacu atau merujuk ke global variable
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM $tabel");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function insertDataKursus($data)
{
    // Digunakan untuk mengacu atau merujuk ke global variable
    global $koneksi;

    // Mengambil data dari tiap elemen dalam form
    $id = rand(1,9999);
    $title = htmlspecialchars($data["title"]);
    $short_description = htmlspecialchars($data["short_description"]);
    $full_description = htmlspecialchars($data["full_description"]);
    $duration = htmlspecialchars($data["duration"]);
    $image_url = isset($_FILES["image_url"]["name"]) ? $_FILES["image_url"]["name"] : "";

    // Cek apakah ada file gambar_buku yang diunggah
    if (!empty($image_url)) {
        $target_dir = "/images/courses/"; // Directory where you want to store the uploaded photos
        $target_file = $target_dir . basename($_FILES["image_url"]["name"]);
        move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file);
    } else {
        $image_url = '';
    }

    // Query insert data
    $query = "INSERT INTO courses VALUES 
    ('$id', '$title', '$short_description', '$full_description', '$duration', '$image_url')";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function insertDataMateri($data)
{
    // Digunakan untuk mengacu atau merujuk ke global variable
    global $koneksi;

    // Mengambil data dari tiap elemen dalam form
    $id = rand(1,9999);
    $title = htmlspecialchars($data["title"]);
    $description = htmlspecialchars($data["description"]);
    $course_id = htmlspecialchars($data["course_id"]);
    $embed_link = htmlspecialchars($data["embed_link"]);


    // Query insert data
    $query = "INSERT INTO materials VALUES 
    ('$id', '$course_id', '$title', '$description', '$embed_link')";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function updateDataMateri($data)
{
    // Mengambil koneksi ke database
    global $koneksi;

    $material_id = $data["material_id"];
    $title = htmlspecialchars($data["title"]);
    $description = htmlspecialchars($data["description"]);
    $embed_link = htmlspecialchars($data["embed_link"]);


    // Query update data

$query = "UPDATE Materials SET title = '$title', description = '$description', embed_link = '$embed_link' WHERE material_id = '$material_id';";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}


//fungsi untuk mengedit data buku
function updateDataKursus($data)
{
    // Mengambil koneksi ke database
    global $koneksi;

    $course_id = $data["course_id"];
    $title = htmlspecialchars($data["title"]);
    $short_description = htmlspecialchars($data["short_description"]);
    $full_description = htmlspecialchars($data["full_description"]);
    $duration = htmlspecialchars($data["duration"]);
    $image_url = isset($_FILES["image_url"]["name"]) ? $_FILES["image_url"]["name"] : "";

    // Cek apakah ada file gambar_buku yang diunggah
    if (!empty($image_url)) {
        $target_dir = "/images/courses/"; // Directory where you want to store the uploaded photos
        $target_file = $target_dir . basename($_FILES["image_url"]["name"]);
        move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file);
    } else {
        $image_url = '';
    }

    // Query update data

$query = "UPDATE Courses SET title = '$title', short_description = '$short_description', full_description = '$full_description', duration = '$duration' WHERE course_id = '$course_id';";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}


function deleteDataKursus($course_id)
{
    //digunakan untuk mengacu atau merujuk ke global variable
    global $koneksi;
    //delete cover book from folder
    mysqli_query($koneksi, "DELETE FROM courses WHERE course_id = $course_id");
    return mysqli_affected_rows($koneksi);
}

function deleteDataMateri($material_id)
{
    //digunakan untuk mengacu atau merujuk ke global variable
    global $koneksi;
    //delete cover book from folder
    mysqli_query($koneksi, "DELETE FROM materials WHERE material_id = $material_id");
    return mysqli_affected_rows($koneksi);
}



/*
    Fungsi Auth
*/

// Fungsi Register

function register($data)
{
    global $koneksi;

    $full_name = htmlspecialchars($data["full_name"]);
    $email = htmlspecialchars($data["email"]);
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $date_created = date("Y-m-d");

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $id_user = rand(1111, 9999);

    // Tambahkan user baru ke database
    $query = "INSERT INTO users (id_user, full_name, email, password, date_created, role) VALUES('$id_user', '$full_name', '$email', '$password', '$date_created', 'member')";
    $result = mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function isEmailExist($email)
{
    global $koneksi;
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);
    return mysqli_num_rows($result) > 0;
}

// Fungsi Login

function login($data)
{
    global $koneksi;

    $email = $data["email"];
    $password = $data["password"];

    // Cek apakah email ada di database
    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($result) === 1) {
        // Cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // Set session
            $_SESSION["login"] = true;
            $_SESSION["id_user"] = $row["id_user"];
            $_SESSION["full_name"] = $row["full_name"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["password"] = $row["password"];
            $_SESSION["role"] = $row["role"];

            // Cek apakah remember me dicentang
            if (isset($data["remember"])) {
                // Buat cookie
                setcookie("id_user", $row["id_user"], time() + 60);
                setcookie("key", hash("sha256", $row["email"]), time() + 60);
            }

            return true;
        }
    }

    return false;
}

// Fungsi Logout

function logout()
{
    // Hapus session
    $_SESSION = [];
    session_destroy();

    // Hapus cookie
    setcookie("id_user", "", time() - 60);
    setcookie("key", "", time() - 60);

    header("Location: index.php");
    exit;
}


// Fungsi Check apakah User yang adap ada sesion masih ada di database
function isSessionStillAlive($session)
{

    // Mengambil Informasi Dari Session Aktif
    $id = $session['id_user'];
    $email = $session['email'];

    // Mengambil Informasi user dari database
    global $koneksi;
    $query = "SELECT * FROM users WHERE id_user = '$id' AND email = '$email'";
    $result = mysqli_query($koneksi, $query);
    $result = mysqli_fetch_assoc($result);

    if ($id == $result['id_user'] && $email == $result['email']) {
        return true;
    } else {
        return false;
    }
}

function checkRole($session)
{
    $role = $session['role'];
    if ($role != 'admin') {
        return header("Location:index.php");
    }
    return true;
}