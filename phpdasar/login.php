<?php 
session_start();

require 'functions.php';

// cek cookie
if ( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
	$id = $_COOKIE['id'];
	$key = $_COOKIE['key'];

	$sql = "SELECT username FROM user WHERE id = $id ";
	$query = mysqli_query($db, $sql);
	$result = mysqli_fetch_assoc($query);

	if ( $key === hash('sha256', $result['username']) ) {
		$_SESSION['login'] = true;
	}
}


// cek session
if ( isset($_SESSION["login"]) ) {
	
	header("Location: ../index.php");

}

if ( isset($_POST["submit"]) ) {
	
	$username = $_POST["username"];
	$password = $_POST["password"];

// cek username
	$query   = "SELECT * FROM user WHERE username='$username' ";
	$result  = mysqli_query($db,$query);

	if ( mysqli_num_rows($result) === 1 ) {
		
		// cek password

		$user = mysqli_fetch_assoc($result);
		if ( password_verify($password, $user["password"] ) ) {

		// set session

		$_SESSION["login"] = true;

		// cek apakah 'remember me' diceklis

		if ( isset($_POST['remember']) ) {
			setcookie( 'id', $user['id'], time() + 60 );
			setcookie( 'key', hash('sha256', $user['username']), time() + 60 );
		}


		// alihkan ke index/halaman utama
			header("Location: index.php");

		}


	}

	$error = true;

}



?>		


<!DOCTYPE html>
<html>
<head>
	<title>Halaman Login</title>
</head>
<body>

	<h1>Halaman Login</h1>

	<?php if( isset($error) ) :  ?>
		
		<p style="color: red;font-style: italic;">Username / Password Salah</p>

	<?php endif ?>

	<form action="" method="post">
		
	<label for="username">Username</label> <br>
	<input type="text" name="username" id="username" required> <br>

	<label for="password">Password</label> <br>
	<input type="password" name="password" id="password" required> <br>

	<input type="checkbox" name="remember" id="remember" required> 
	<label for="remember">Remember me</label> <br>

	<button type="submit" name="submit">Login</button>

	</form>

	<p>Belum memiliki akun?</p> <a href="register.php">Daftar di sini</a>

</body>
</html>