<?php 
session_start();

if ( !isset($_SESSION["login"]) ) {
	
	header("Location: login.php");

}

require 'functions.php';

	$id = $_GET["id"];

	$animes = query("SELECT * FROM daftar WHERE id=$id")[0];

if ( isset($_POST["submit"]) ) {	

	
	if ( update($_POST) > 0 ) {
		
		echo "Data berhasil diubah | <a href='index.php'>Lihat data</a> ";
	}

	else {

		echo "Data gagal diubah";

	}

}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Data</title>
</head>
<body>

	<form action="" method="post" enctype="multipart/form-data">
		
		<input type="hidden" name="gambarlama" value="<?= $animes["gambar"] ?>" >
		<input type="hidden" name="id" value="<?= $animes["id"] ?>" >

		<label for="judul">Judul :</label> <br>
		<input type="text" name="judul" id="judul" value="<?= $animes["judul"] ?>" required > <br>

		<label for="episode">episode :</label> <br>
		<input type="text" name="episode" id="episode" value="<?= $animes["episode"] ?>"  required> <br>

		<label for="genre">genre :</label> <br>
		<input type="text" name="genre" id="genre" value="<?= $animes["genre"] ?>" required> <br>

		<label for="studio">studio :</label> <br>
		<input type="text" name="studio" id="studio" value="<?= $animes["studio"] ?>" required> <br>

		<label for="gambar">gambar :</label> <br> 
		<img src="img/<?= $animes["gambar"] ?>" width="40" > <br>
		<input type="file" name="gambar" id="gambar"> <br>

		<button type="submit" name="submit">Update</button>

	</form>

</body>
</html>