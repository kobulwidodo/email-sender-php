<?php 
$db = mysqli_connect("localhost", "root", "", "emailphp"); // server-username-password-namaDB
date_default_timezone_set('Asia/Jakarta');

if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}


?>