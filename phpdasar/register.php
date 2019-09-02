<?php

require 'functions.php'; 

if ( isset($_POST["submit"]) ) {
	
	// cek apakah registrasi berhasil dilakukan
	if ( register($_POST) > 0 ) {
		
		echo "Data berhasil ditambahkan | <a href='index.php'>Lihat data</a> ";

	}

	// jika gagal ditambahkan maka keluarkan pesan error
	else {

		mysqli_error($db);

	}
}



?>


<!DOCTYPE html>
<html>
<head>
	<title>Registrasi User Baru</title>
</head>
<body>

	<h1>Halaman Registrasi</h1>

	<form action="" method="post">
		
	<label for="username">Username</label> <br>
	<input type="text" name="username" id="username" required> <br>

	<label for="password">password</label> <br>
	<input type="password" name="password" id="password" required> <br>

	<label for="password2">password</label> <br>
	<input type="password" name="password2" id="password2" required> <br>

	<button type="submit" name="submit">Registrasi</button>

	</form>

</body>
</html>