<?php
//Koneksi database prosedural mysqli
$koneksi = mysqli_connect('localhost', 'root', '', 'kursus');

//Memeriksa koneksi
if(!$koneksi){
    echo 'Connection error: '. mysqli_connect_error();
}
?>