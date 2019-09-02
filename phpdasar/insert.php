<?php 
session_start();

if ( !isset($_SESSION["login"]) ) {
	
	header("Location: login.php");

}

require 'functions.php';

if ( isset($_POST["submit"]) ) {	
	
	if ( insert($_POST) > 0 ) {
		
		echo "Data berhasil ditambahkan | <a href='index.php'>Lihat data</a> ";
	}

	else {

		echo "Data gagal ditambahkan";

	}

}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Tambahkan Data</title>
</head>
<body>

	<form action="" method="post" enctype="multipart/form-data">

		<label for="judul">Judul :</label> <br>
		<input type="text" name="judul" id="judul" required > <br>

		<label for="episode">episode :</label> <br>
		<input type="text" name="episode" id="episode" required> <br>

		<label for="genre">genre :</label> <br>
		<input type="text" name="genre" id="genre" required> <br>

		<label for="studio">studio :</label> <br>
		<input type="text" name="studio" id="studio" required> <br>

		<label for="gambar">gambar :</label> <br> 
		<input type="file" name="gambar" id="gambar"> <br>

		<button type="submit" name="submit">Tambah</button>

	</form>

</body>
</html>