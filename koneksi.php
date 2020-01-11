<?php
date_default_timezone_set('Asia/Jakarta');
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "cv_db";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_error()){
	echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error();
}

//untuk menyimpan data registrasi
function daftar($data){
	global $koneksi;
	$password = htmlspecialchars($data["password"]);
	$email = htmlspecialchars($data["email"]);
	$firstname = htmlspecialchars($data["firstname"]);
	$lastname = htmlspecialchars($data["lastname"]);
	//query insert data
	$query = "INSERT INTO cutomers values ('','$firstname','$password','$email','$firstname','$lastname')";
	mysqli_query($koneksi,$query);
	return mysqli_affected_rows($koneksi);
}
?>
