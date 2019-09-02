<?php

$localhost = "localhost";
$username  = "root";
$password  = "";
$database  = "anime";

// Koneksi ke database
$db = mysqli_connect($localhost, $username, $password, $database );

if ( !$db ) {
	
	die("Gagal terhubung dengan database: " . mysqli_connect_error());
}

// menampilkan data dari database
function query($query) {

	global $db;

	$result = mysqli_query($db,$query);	
	$rows = [];
	
	while ( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	
	return $rows;

}

// menambahkan data ke database
function insert($data) {

	global $db;

	$judul   = htmlspecialchars($data["judul"]);
	$episode = htmlspecialchars($data["episode"]);
	$genre   = htmlspecialchars($data["genre"]);
	$studio  = htmlspecialchars($data["studio"]);
	$gambar  = upload();
	if( !$gambar ) {
		return false;
	}

	$query = "INSERT INTO daftar VALUES 
				('', '$judul', '$episode', '$genre', '$studio', '$gambar')";

	mysqli_query($db, $query);

	return mysqli_affected_rows($db);
}

// Upload  gambar ke database

function upload() {
	$namafile   = $_FILES["gambar"]["name"];
	$ukuranfile = $_FILES["gambar"]["size"];
	$error      = $_FILES["gambar"]["error"];
	$tmpname 	= $_FILES["gambar"]["tmp_name"];

	// cek apakah ada file yang diupload
	if( $error === 4 ) {

		echo "<script> alert('pilih gambar terlebih dahulu!') </script>";
		return false;

	}

	// cek ekstensi file yang diupload
	$ekstensivalid = ["jpg","jpeg","png"];
	$ekstensifile  = explode(".", $namafile);
	$ekstensifile  = strtolower(end($ekstensifile));

	if ( !in_array($ekstensifile, $ekstensivalid) ) {
		echo "<script> alert('Upload file gambar dengan format jpg,jpeg, atau png') </script>";

		return false;
	}

	// cek ukuran gambar
	if ( $ukuranfile > 100000 ) {
		echo "<script> alert('ukuran gambar terlalu besar') </script>";

		return false;
	}

	// generate nama file baru
	$namafilebaru	 = uniqid();
	$namafilebaru	.=  ".";
	$namafilebaru	.= $ekstensifile;

	move_uploaded_file($tmpname, "img/". $namafilebaru);

	return $namafilebaru;


}

// menghapus data dari database

function delete($id) {

	global $db;

	$query = "DELETE FROM daftar WHERE id = $id";

	mysqli_query($db, $query);

	return mysqli_affected_rows($db);
}

// mengubah data pada database
function update($data) {

	global $db;

	$id 		= $data["id"];
	$judul   	= htmlspecialchars($data["judul"]);
	$episode 	= htmlspecialchars($data["episode"]);
	$genre   	= htmlspecialchars($data["genre"]);
	$studio  	= htmlspecialchars($data["studio"]);
	$gambarlama = $data["gambarlama"];
	
	// cek apakah user pilih gambar baru atau tidak
	if ( $_FILES["gambar"]["error"] === 4 ) {
		$gambar = $gambarlama;
	}
	else {
		$gambar  = upload();
	}

	$query = "UPDATE daftar SET judul='$judul', episode='$episode', genre='$genre', studio='$studio', gambar='$gambar' WHERE id=$id ";

	mysqli_query($db, $query);

	return mysqli_affected_rows($db);
}

function search($keyword) {

	$query = "SELECT * FROM daftar WHERE judul LIKE '%$keyword%' OR genre LIKE '%$keyword%' ";

	return query($query);

}

function register($data) {

	global $db;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($db,$data["password"]);
	$password2 = mysqli_real_escape_string($db,$data["password2"]);

	// cek apakah ada username yg sama di database

	$cekuser = "SELECT username FROM user WHERE username='$username' ";
	$resuser = mysqli_query($db,$cekuser);

	if ( mysqli_fetch_assoc($resuser) ) {
		
		echo "<script> alert('Username sudah digunakan!') </script>";

		return false;

	}

	// cek apakah password sama dengan konfirmasi password

	if ( $password !== $password2 ) {

		echo "<script> alert('password dengan konfirmasi password tidak cocok') </script>";
		
		return false;
	}

	// enkripsi password

	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan user ke database

	$query  = "INSERT INTO user VALUES ('', '$username', '$password') ";
	$result = mysqli_query($db, $query);

	return mysqli_affected_rows($db);

}

?>